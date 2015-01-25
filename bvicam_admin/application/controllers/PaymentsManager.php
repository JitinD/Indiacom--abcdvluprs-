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

    public function newTransaction()
    {
        $this->load->model('transaction_mode_model');
        $this->load->model('currency_model');
        $this->load->helper('url');
        $page = "newTransaction";
        $this->data['transaction_modes'] = $this->transaction_mode_model->getAllTransactionModes();
        $this->data['currencies'] = $this->currency_model->getAllCurrencies();
        if($this->newTransactionSubmitHandle())
            redirect('PaymentsManager/newPayment');
        $this->index($page);
    }

    private function newTransactionSubmitHandle()
    {
        $this->load->model('transaction_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('trans_mode', 'Transaction Mode', 'required');
        $this->form_validation->set_rules('trans_amount', 'Amount', 'required');
        $this->form_validation->set_rules('trans_currency', 'Currency', 'required');
        $this->form_validation->set_rules('trans_bank', 'Bank Name', 'required');
        $this->form_validation->set_rules('trans_no', 'Transaction Number', 'required');
        $this->form_validation->set_rules('trans_date', 'Transaction Date', 'required');
        $this->form_validation->set_rules('trans_memberId', 'Member ID', 'required');

        if($this->form_validation->run())
        {
            $transDetails = array(
                "transaction_member_id" => $this->input->post('trans_memberId'),
                "transaction_bank" => $this->input->post('trans_bank'),
                "transaction_number" => $this->input->post('trans_no'),
                "transaction_mode" => $this->input->post('trans_mode'),
                "transaction_amount" => $this->input->post('trans_amount'),
                "transaction_date" => $this->input->post('trans_date'),
                "transaction_currency" => $this->input->post('trans_currency'),
                "is_verified" => 1,
                "transaction_remarks" => $this->input->post('trans_remarks')
            );
            $this->transaction_model->newTransaction($transDetails);
            $_SESSION[APPID]['transId'] = $this->transaction_model->getTransactionId($transDetails);
            return true;
        }
        return false;
    }

    public function newPayment()
    {
        $this->load->model('transaction_model');
        $this->load->model('paper_status_model');
        $this->load->model('member_categories_model');
        $this->load->model('member_model');
        $this->load->model('currency_model');
        $this->load->model('transaction_mode_model');
        $this->load->model('payment_model');
        $page = "newPayment";
        if(isset($_SESSION[APPID]['transId']))
        {
            $transId = $_SESSION[APPID]['transId'];
            $memberId =  $this->input->post('payment_memberId');
            $this->data['transDetails'] = $this->transaction_model->getTransactionDetails($transId);
            $this->data['transUsedAmount'] = $this->transaction_model->getTransactionUsedAmount($transId);
            if($memberId != null)
            {
                $this->data['paymentMemberId'] = $memberId;
                $this->data['memberDetails'] = $this->member_model->getMemberInfo($memberId);
                $this->data['isProfBodyMember'] = true;
                $this->data['registrationCategories'] = $this->member_categories_model->getMemberCategories();
                $this->data['registrationCat'] = $this->member_model->getMemberCategory($memberId);
                $this->data['papers'] = $this->paper_status_model->getMemberAcceptedPapers($memberId);
                $this->data['transaction_modes'] = $this->transaction_mode_model->getAllTransactionModes();
                if($this->newPaymentSubmitHandle(
                    $memberId,
                    $this->data['registrationCat'],
                    $this->data['transDetails']->transaction_currency,
                    $transId,
                    $this->data['transDetails']->transaction_EQINR - $this->data['transUsedAmount']
                ))
                {
                    $morePayments = $this->input->post('morePayments');
                    if($morePayments)
                    {
                        unset($this->data['paymentMemberId']);
                    }
                    else
                    {
                        unset($_SESSION[APPID]['transId']);
                    }
                }
                $this->data['papersInfo'] = $this->payment_model->calculatePayables($memberId, $this->data['transDetails']->transaction_currency, $this->data['registrationCat'], $this->data['papers']);
            }
            $this->index($page);
        }
        else
        {
            echo "No transaction selected";
        }
    }

    private function newPaymentSubmitHandle($memberID, $registrationCat, $currency, $transId, $transAmount)
    {
        $this->load->library('form_validation');
        $this->load->model('payable_class_model');
        $this->load->model('payment_head_model');
        $this->load->model('submission_model');
        $this->load->model('transaction_model');
        $this->load->model('member_model');

        $this->form_validation->set_rules('paymentForMemberId', 'Member Id', 'required');

        if($this->form_validation->run())
        {
            $submissionIds = $this->input->post('submissionIds');
            $paymentsDetails = array();
            $totalPayAmount = 0;
            foreach($submissionIds as $submission)
            {
                $payAmount = $this->input->post($submission."_payAmount");
                $payHead = $this->input->post($submission."_payhead");
                $totalPayAmount += $payAmount;
                $payHeadId = $this->payment_head_model->getPaymentHeadId($payHead);
                $submissionDetails = $this->submission_model->getSubmissionsByAttribute("submission_id", $submission);
                if($payHeadId != null)
                {
                    $payableClass = $this->payable_class_model->getPayableClass(
                        $payHeadId,
                        !$this->member_model->isProfBodyMember($memberID),
                        $registrationCat->member_category_id,
                        $currency
                    );
                    $paymentsDetails[] = array(
                        "payment_submission_id" => $submission,
                        "payment_member_id" => $submissionDetails[0]->submission_member_id ,
                        "payment_paper_id" => $submissionDetails[0]->submission_paper_id,
                        "payment_amount_paid" => $payAmount,
                        "payment_payable_class" => $payableClass->payable_class_id
                    );
                }
            }
            if($totalPayAmount <= $transAmount)
            {
                $this->payment_model->addMultiPaymentsWithCommonTransaction($paymentsDetails, $transId);
                return true;
            }
        }
        return false;
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