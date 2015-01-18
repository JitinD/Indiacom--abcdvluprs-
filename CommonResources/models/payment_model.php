<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 1/17/15
 * Time: 1:06 PM
 */
class Payment_model extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        if(isset($_SESSION['sudo']))
        {
            $this->dbCon = $this->load->database(DBGROUP, TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $this->load->database();
            $this->dbCon = $this->db;
        }
    }

    //Use this function to elevate privilege if $_SESSION['sudo'] method doesn't work
    public function sudo()
    {
        $this->dbCon->close();
        $this->dbCon = $this->load->database(DBGROUP, TRUE);
    }

    //Function to get the organizations under bulk registration
    public function getBulkRegistration()
    {
        $this -> dbCon -> select('member_organization_id');
        $this -> dbCon -> from('paper_latest_version');
        $this -> dbCon -> join('submission_master','paper_latest_version.paper_id=submission_master.submission_paper_id');
        $this -> dbCon -> join('member_master','submission_master.submission_member_id=member_master.member_id');
        $this -> dbCon-> where('review_result_type_name','Accepted');
        $this ->dbCon ->  group_by('member_organization_id');
        $this -> dbCon -> having('count(member_organization_id)=3');
        $this -> dbCon -> or_having('count(member_organization_id)>3');
        $query = $this -> dbCon -> get();
             return $query -> result_array();
    }


    //Check if one basic registration paid under a member registration
    public function  checkBRPaid($memberID)
    {
        $this -> dbCon -> select ('*');
        $this -> dbCon -> from ('payment_master');
        $this -> dbCon -> join ('payment_head_master','payment_master.payment_head=payment_head_master.payment_head_id');
        $this -> dbCon -> where('payment_member_id',$memberID);
        $this -> dbCon -> where('payment_head_name','BR');
        $query = $this -> dbCon -> get();
        if($query -> num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }

    //Check if extra paper charges paid
    public function checkEPPaid($memberID,$paperID)
    {
        $this -> dbCon -> select ('*');
        $this -> dbCon -> from ('payment_master');
        $this -> dbCon -> join ('payment_head_master','payment_master.payment_head=payment_head_master.payment_head_id');
        $this -> dbCon -> where('payment_member_id',$memberID);
        $this -> dbCon -> where('payment_paper_id',$paperID);
        $this -> dbCon -> where('payment_head_name','EP');
        $query = $this -> dbCon -> get();
        if($query -> num_rows() > 0)
            return true;
        else
            return false;
    }

    //Check if paper has been registered
    public function checkPaperRegistered($paperID)
    {
        $this -> dbCon -> select ('payment_member_id');
        $this -> dbCon -> from ('payment_master');
        $this -> dbCon -> join ('payment_head_master','payment_master.payment_head=payment_head_master.payment_head_id');
        $this -> dbCon -> where('payment_paper_id',$paperID);
        $this -> dbCon -> where('payment_head_name','BR');
        $query = $this -> dbCon -> get();
        if($query -> num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }

    //Check if extra Pages charges is valid for the paper
    public function  checkOLPCValid($paperID)
    {
        $this->dbCon->select('extra_pages');
        $this->dbCon->from('olpc_master');
        $this->dbCon->where('overlength_paper_id',$paperID);
        $query=$this->dbCon->get();
        if($query->num_rows>0)
            return true;
        else
            return false;
    }

    //Check if extra pages charges has been paid
    public function checkOLPCPaid($paperID)
    {
        if($this->checkOLPCValid($paperID))
        {
            $this -> dbCon -> select ('*');
            $this -> dbCon -> from ('payment_master');
            $this -> dbCon -> join ('payment_head_master','payment_master.payment_head=payment_head_master.payment_head_id');
            $this -> dbCon -> where('payment_member_id',$paperID);
            $this -> dbCon -> where('payment_head_name','OLPC');
            $query = $this -> dbCon -> get();
            if($query -> num_rows() > 0)
                return true;
            else
                return false;
        }
        return true;
    }

    //Check if co-author discount is valid
    public function isCoauthorDiscountValid($memberID,$paperID)
    {
        $this->load->model('paper_model');
        if($this->paper_model->checkMainAuthor($memberID))
            return false;
        if($this->checkPaperRegistered($paperID))
            return true;
        else
            return false;
    }

    //Check if the author is an alumni
    public function isAlumni($memberID)
    {

    }

    //check if bulk registration discount is valid
    public function isBulkRegistration($memberID)
    {
        $this->load->model('member_model');
        $bulkRegistrations=$this->getBulkRegistration();
        foreach($bulkRegistrations as $bulkRegistration)
        {
            if($bulkRegistration->member_organization_id==$this->member_model->getMemberOrganization($memberID))
            {
                return true;
            }
        }
        return false;
    }

    //Get the payable BR for a paper
    public function getBRCharges($member_id,$nationality,$memberCategory)
    {
        $this->load->model('member_model');
        $isGeneral=$this->member_model->calculateIsGeneral($member_id);
        $isGeneral=0;
        $current_date=date('y-m-d');
        $this->dbCon->select('payable_class_amount');
        $this->dbCon->from('payable_class');
        $this->dbCon->join('payment_head_master','payable_class.payable_class_payhead_id=payment_head_master.payment_head_id');
        $this->dbCon->where('payment_head_name','BR');
        $this->dbCon->where('payable_class_registration_category',$memberCategory);
        $this->dbCon->where('payable_class_nationality',$nationality);
        $this->dbCon->where('start_date <=',$current_date);
        $this->dbCon->where('end_date >=',$current_date);
        $this->dbCon->where('is_general',$isGeneral);
        $query=$this->dbCon->get();
        if($query->num_rows()==0)
            return null;
        $row = $query->row();
        return $row->payable_class_amount;
    }

    //Get the payable EP for a paper
    public function getEPCharges()
    {
        $this->dbCon->select('payable_class_amount');
        $this->dbCon->from('payable_class');
        $this->dbCon->join('payment_head_master','payable_class.payable_class_payhead_id=payment_head_master.payment_head_id');
        $this->dbCon->where('payment_head_name','EP');
        $this->dbCon->where('payable_class_nationality',1);
        $query=$this->dbCon->get();
        if($query->num_rows()>0)
            return $query->result_array();

    }

    //Get the payable OLPC charges for a paper
    public function getOLPCCharges()
    {
        $this->dbCon->select('payable_class_amount');
        $this->dbCon->from('payable_class');
        $this->dbCon->join('payment_head_master','payable_class.payable_class_payhead_id=payment_head_master.payment_head_id');
        $this->dbCon->where('payment_head_name','OLPC');
        $query=$this->dbCon->get();
            if($query->num_rows()>0)
                return $query->row_array();
    }



    //Calculate the payable ep for a paper
    public function calculateEPPayable()
    {

    }

    //Calculate the payable OLPC for a paper
    public function calculateOLPCPayable($memberID,$paperID)
    {

    }




}