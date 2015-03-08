<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 2/2/15
 * Time: 9:17 PM
 */

class Discount_model extends CI_Model
{
    public $error = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllDiscounts()
    {
        $sql = "Select * From discount_type_master Where discount_type_dirty = 0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getAllDiscountsAsAssocArray()
    {
        $discounts = $this->getAllDiscounts();
        $arr = array();
        foreach($discounts as $discount)
        {
            $arr[$discount->discount_type_id] = $discount;
        }
        return $arr;
    }

    public function getDiscountDetails($discountId)
    {
        $sql = "Select * From discount_type_master Where discount_type_id=?";
        $query = $this->db->query($sql, array($discountId));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function isAlumniDiscountValid($memberId)
    {
        /*
         * Co-Authors (provided the main author has registered) of accepted papers
         * and Alumni of BVICAM will get 20% discount on base rate in the respective category.
         */
        return false;
    }

    public function isBulkRegistrationDiscountValid($organisationId, &$noofRegistrations)
    {
        /*
         * 10% discount will be given on three or more registrations from one organization in General Category only.
         */
        $sql = "Select
                  member_organization_id,
                  Count(submission_member_id) as number_of_registrations
                From
                    (
                        Select
                            submission_member_id,
                            SUM(payment_amount_paid) as total_amount_paid,
                            Case
                                When discount_type_amount is Null
                                Then 0
                                Else floor(discount_type_amount * payable_class_amount)
                            End As discount_amount,
                            payable_class_amount
                        From payment_master
                            Join payable_class
                                On payment_payable_class = payable_class_id
                            Join submission_master
                                On submission_master.submission_id = payment_master.payment_submission_id
                            Left Join discount_type_master
		                        On discount_type_id = payment_discount_type
                            Join transaction_master
		                        On transaction_id = payment_trans_id And is_verified = 1
                        Where
                            payable_class_payhead_id = 1 And
                            is_general = 1
                        Group By payment_submission_id
                    ) as table1
                        Join
                    member_master
                        On submission_member_id = member_id
                Where
                    total_amount_paid >= 0/*(payable_class_amount - discount_amount)*/ And
                    member_organization_id = ?
                Group By member_organization_id";
        $query = $this->db->query($sql, array($organisationId));
        $noofRegistrations = 0;
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            $noofRegistrations = $row->number_of_registrations;
            if($row->number_of_registrations >= (BULK_REGISTRATION_MIN_REGISTRATION_VALUE - 1))
                return true;
        }
        return false;
    }

    public function setBulkRegistrationDiscount($organizationId)
    {
        $sql = "Select
                    payment_master.payment_id
                From
                    payment_master
                        Join
                    submission_master
                        On payment_submission_id = submission_id And
                            payment_discount_type Is Null
                        Join
                    member_master
                        On member_id = submission_member_id And
                            member_organization_id = ?
                        Join
                    payable_class
                        On payable_class_id = payment_payable_class And
                            payable_class_payhead_id = 1";
        $query = $this->db->query($sql, array($organizationId));
        if($query->num_rows() == 0)
            return;
        $result = $query->result();
        foreach($result as $row)
        {
            $bulkDiscountTypeId = 3;
            $sql = "Update payment_master
                    Set payment_discount_type = $bulkDiscountTypeId
                    Where payment_id = ?";
            $this->db->query($sql, array($row->payment_id));
        }
    }

    public function isCoAuthorDiscountValid($memberId, $paperId)
    {
        /*
         * Co-Authors (provided the main author has registered) of accepted papers
         * and Alumni of BVICAM will get 20% discount on base rate in the respective category.
         */
        //$this->load->model('paper_model');
        $this->load->model('payment_model');
        /*$mainAuthor = $this->paper_model->getMainAuthor($paperId);
        if($mainAuthor == $memberId)
            return false;*/
        if($this->payment_model->isPaperRegistered($paperId))
        {
            return true;
        }
        return false;
    }

    public function getMemberEligibleDiscounts($memberId, $papers = array())
    {
        $discounts = array();
        $discountTypes = $this->getAllDiscounts();
        foreach($discountTypes as $discountType)
        {
            switch($discountType->discount_type_name)
            {
                case "Alumni":
                    if($this->isAlumniDiscountValid($memberId))
                    {
                        $discounts[$discountType->discount_type_id] = $discountType;
                    }
                    break;
                case "Co - Author":
                    foreach($papers as $paper)
                    {
                        if($this->isCoAuthorDiscountValid($memberId, $paper->paper_id))
                        {
                            $discounts[$discountType->discount_type_id][$paper->paper_id] = $discountType;
                        }
                    }
                    break;
                case "Bulk Registration":
                    $this->load->model('member_model');
                    $memberInfo = $this->member_model->getMemberInfo($memberId);
                    if(!$this->member_model->isProfBodyMember($memberId) && $this->isBulkRegistrationDiscountValid($memberInfo['member_organization_id'], $noofRegistrations))
                    {
                        $discounts[$discountType->discount_type_id] = $discountType;
                    }
                    break;
                default:
                    $this->error = "Unknown Discount Type in db";
                    break;
            }
        }
        return $discounts;
    }
}