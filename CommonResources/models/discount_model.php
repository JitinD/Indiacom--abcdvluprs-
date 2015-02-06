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

    public function isAlumniDiscountValid($memberId)
    {
        /*
         * Co-Authors (provided the main author has registered) of accepted papers
         * and Alumni of BVICAM will get 20% discount on base rate in the respective category.
         */
        return false;
    }

    public function isBulkRegistrationDiscountValid($memberId)
    {
        /*
         * 10% discount will be given on three or more registrations from one organization in General Category only.
         */
        $this->load->model('member_model');
        $memberInfo = $this->member_model->getMemberInfo($memberId);
        $sql = "Select
                  member_organization_id,
                  Count(submission_member_id) as number_of_registrations
                From
                    (
                        Select
                            submission_member_id,
                            SUM(payment_amount_paid) as total_amount_paid,
                            payable_class_amount
                        From payment_master
                            Join payable_class
                                On payment_payable_class = payable_class_id
                            Join submission_master
                                On submission_master.submission_id = payment_master.payment_submission_id
                        Where
                            payable_class_payhead_id = 1 And
                            is_general = 1
                        Group By payment_submission_id
                    ) as table1
                        Join
                    member_master
                        On submission_member_id = member_id
                Where
                    total_amount_paid >= payable_class_amount And
                    member_organization_id = ?
                Group By member_organization_id";
        $query = $this->db->query($sql, array($memberInfo['member_organization_id']));
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            if($row->number_of_registrations >= BULK_REGISTRATION_MIN_REGISTRATION_VALUE)
                return true;
        }
        return false;
    }

    public function isCoAuthorDiscountValid($memberId, $paperId)
    {
        /*
         * Co-Authors (provided the main author has registered) of accepted papers
         * and Alumni of BVICAM will get 20% discount on base rate in the respective category.
         */
        $this->load->model('paper_model');
        $this->load->model('payment_model');
        $mainAuthor = $this->paper_model->getMainAuthor($paperId);
        if($mainAuthor == $memberId)
            return false;
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
                    if($this->isBulkRegistrationDiscountValid($memberId))
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