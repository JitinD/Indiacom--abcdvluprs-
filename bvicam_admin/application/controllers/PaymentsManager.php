<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 1:28 AM
 */

class PaymentsManager extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/PaymentsManager/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page']['PaymentsManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['PaymentsManager'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/PaymentsManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function load()
    {
        $page = "index";

        $this->index($page);
    }

    public function viewPayments()
    {
        $page = "viewPayments";
        $this->load->model('payment_model');
        $this->load->model('member_model');

        $members = $this->payment_model->getAllPayingMembers();
        $this->data['payableClassDetail'] = $this->payableClassDetailsAsAssocArray();
        $this->data['payheadDetails'] = $this->payheadNamesAsAssocArray();
        foreach($members as $member)
        {
            $this->data['membersPayments'][$member->member_id] = $this->payment_model->getMemberPayments($member->member_id);
            $this->data['memberDetails'][$member->member_id] = $this->member_model->getMemberInfo($member->member_id);
        }

        $this->index($page);
    }

    public function paymentBreakup($mid, $pid, $payhead)
    {

    }

    public function waiveOff()
    {
        $page = "waiveOff";
        $this->load->model("submission_model");
        $this->load->model("payable_class_model");
        $this->load->model("payment_head_model");

        $this->data['mid'] = $mid = $this->input->get('mid');
        $this->data['pid'] = $pid = $this->input->get('pid');
        $this->data['payableClass'] = $payableClass = $this->input->get('payableClass');
        $this->data['waiveOffAmount'] = $waiveOffAmount = $this->input->get('waiveOffAmount');

        if($mid != null && $pid == null)
        {
            $this->data['memberPapers'] = $this->submission_model->getSubmissionsByAttribute("submission_member_id", $mid);
        }
        if($pid != null && $mid == null)
        {
            $this->data['paperMembers'] = $this->submission_model->getSubmissionsByAttribute("submission_paper_id", $pid);
        }
        if($payableClass != null)
        {
            $this->data['payableClassDetails'] = $this->payable_class_model->getPayableClassDetails($payableClass);
        }
        $this->data['payheadDetails'] = $this->payheadNamesAsAssocArray();
        $this->data['nationalityDetails'] = $this->nationalityNamesAsAssocArray();

        $this->index($page);
    }

    private function payheadNamesAsAssocArray()
    {
        $this->load->model('payment_head_model');
        $allPayHeads = $this->payment_head_model->getAllPayheadDetails();
        $payHeads = array();
        foreach($allPayHeads as $payHead)
        {
            $payHeads[$payHead->payment_head_id] = $payHead->payment_head_name;
        }
        return $payHeads;
    }

    private function nationalityNamesAsAssocArray()
    {
        $this->load->model('nationality_model');
        $allNationalities = $this->nationality_model->getAllNationalities();
        $nationalities = array();
        foreach($allNationalities as $nationality)
        {
            $nationalities[$nationality->Nationality_id] = $nationality->Nationality_type;
        }
        return $nationalities;
    }

    private function payableClassDetailsAsAssocArray()
    {
        $this->load->model('payable_class_model');
        $allPayableClasses = $this->payable_class_model->getAllPayableClassDetails();
        $payableClasses = array();
        foreach($allPayableClasses as $payableClass)
        {
            $payableClasses[$payableClass->payable_class_id]['amount'] = $payableClass->payable_class_amount;
            $payableClasses[$payableClass->payable_class_id]['payhead'] = $payableClass->payable_class_payhead_id;
        }
        return $payableClasses;
    }
}