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
        $this->data['membersPayments'] = array();
        foreach($members as $member)
        {
            $this->data['membersPayments'][$member->member_id] = $this->payment_model->getMemberPayments($member->member_id, true);
            $this->data['memberDetails'][$member->member_id] = $this->member_model->getMemberInfo($member->member_id);
        }

        $this->index($page);
    }

    public function newPayment($transId = null)
    {
        $this->load->model('transaction_model');
        $this->load->model('paper_status_model');
        $this->load->model('member_categories_model');
        $this->load->model('member_model');
        $this->load->model('currency_model');
        $this->load->model('transaction_mode_model');
        $this->load->model('payment_model');
        $this->load->model('discount_model');
        $page = "newPayment";
        if(isset($_SESSION[APPID]['transId']) || $transId != null)
        {
            $transId = ($transId != null) ? $transId : $_SESSION[APPID]['transId'];
            $memberId =  $this->input->post('payment_memberId');
            $this->data['transDetails'] = $this->transaction_model->getTransactionDetails($transId);
            $this->data['transUsedAmount'] = $this->transaction_model->getTransactionUsedAmount($transId);
            if($memberId != null && !empty($this->data['transDetails']))
            {
                $this->data['paymentMemberId'] = $memberId;
                $this->data['memberDetails'] = $this->member_model->getMemberInfo($memberId);
                $this->data['currencyName'] = $this->currency_model->getCurrencyName($this->data['transDetails']->transaction_currency);
                $this->data['transModeDetails'] = $this->transaction_mode_model->getTransactionModeDetails($this->data['transDetails']->transaction_mode);
                if($this->data['memberDetails'] != null)
                {
                    $this->data['isProfBodyMember'] = $this->member_model->isProfBodyMember($memberId);
                    $this->data['registrationCategories'] = $this->member_categories_model->getMemberCategories();
                    $this->data['registrationCat'] = $this->member_model->getMemberCategory($memberId);
                    $this->data['papers'] = $this->paper_status_model->getMemberAcceptedPapers($memberId);
                    $this->data['transaction_modes'] = $this->transaction_mode_model->getAllTransactionModes();
                    $this->data['discounts'] = $this->discount_model->getMemberEligibleDiscounts($memberId, $this->data['papers']);
                    if($this->discount_model->error != null)
                        die($this->discount_model->error);
                    if($this->newPaymentSubmitHandle(
                        $memberId,
                        $this->data['registrationCat'],
                        $this->data['transDetails']->transaction_currency,
                        $transId,
                        $this->data['transDetails']->transaction_EQINR - $this->data['transUsedAmount'],
                        $this->data['transDetails']->transaction_date
                    ))
                    {
                        $this->data['transUsedAmount'] = $this->transaction_model->getTransactionUsedAmount($transId);
                        $morePayments = $this->input->post('morePayments');
                        if($morePayments)
                        {
                            unset($this->data['paymentMemberId']);
                        }
                    }
                    $this->data['papersInfo'] = $this->payment_model->calculatePayables(
                        $memberId,
                        $this->data['transDetails']->transaction_currency,
                        $this->data['registrationCat'],
                        $this->data['papers'],
                        $this->data['transDetails']->transaction_date
                    );
                }
                else
                {
                    $this->data['pay_error'] = "Unknown member id";
                    unset($this->data['paymentMemberId']);
                }
            }
            else if(empty($this->data['transDetails']))
            {
                unset($_SESSION[APPID]['transId']);
            }
            else
            {
                $this->data['currencyName'] = $this->currency_model->getCurrencyName($this->data['transDetails']->transaction_currency);
                $this->data['transModeDetails'] = $this->transaction_mode_model->getTransactionModeDetails($this->data['transDetails']->transaction_mode);
            }
            $this->index($page);
        }
        else
        {
            $this->index($page);
            //echo "No transaction selected";
        }
    }

    private function newPaymentSubmitHandle($memberID, $registrationCat, $currency, $transId, $transAmount, $transDate)
    {
        $this->load->library('form_validation');
        $this->load->model('payable_class_model');
        $this->load->model('payment_head_model');
        $this->load->model('payment_model');
        $this->load->model('submission_model');
        $this->load->model('transaction_model');
        $this->load->model('member_model');

        $this->form_validation->set_rules('paymentForMemberId', 'Member Id', 'required');

        if($this->form_validation->run())
        {
            $submissionIds = $this->input->post('submissionIds');
            if($submissionIds == null)
                $submissionIds = array();
            $paymentsDetails = array();
            $totalPayAmount = 0;
            foreach($submissionIds as $submission)
            {
                $payAmount = $this->input->post($submission."_payAmount");
                $payHead = $this->input->post($submission."_payheadAndDiscount");
                if($payAmount <= 0)
                    continue;
                $split = explode("_", $payHead);
                $payHead = $split[0];
                $discountType = (isset($split[1])) ? $split[1] : null;
                $payHeadId = $this->payment_head_model->getPaymentHeadId($payHead);
                $submissionDetails = $this->submission_model->getSubmissionsByAttribute("submission_id", $submission);
                if($payHeadId == null)
                {
                    $this->data['pay_error'] = "System Error: Payheads don't match! Contact Admin.";
                    return false;
                }
                $paidPayments = $this->payment_model->getPayments(
                    $submissionDetails[0]->submission_member_id,
                    $submissionDetails[0]->submission_paper_id,
                    true
                );
                if(empty($paidPayments))
                {
                    $payableClass = $this->payable_class_model->getPayableClass(
                        $payHeadId,
                        !$this->member_model->isProfBodyMember($memberID),
                        $registrationCat->member_category_id,
                        $currency,
                        $transDate
                    );
                }
                else
                {
                    $payableClass = $this->payable_class_model->getPayableClassDetails($paidPayments[0]->payment_payable_class);
                }
                if($payAmount > $payableClass->payable_class_amount)
                {
                    $this->data['pay_error'] = "One or more pay amount is greater than payable amount.";
                    return false;
                }
                $totalPayAmount += $payAmount;
                $paymentsDetails[] = array(
                    "payment_submission_id" => $submission,
                    "payment_amount_paid" => $payAmount,
                    "payment_payable_class" => $payableClass->payable_class_id,
                    "payment_discount_type" => $discountType
                );
            }
            if($totalPayAmount <= $transAmount)
            {
                $noofAdded = $this->payment_model->addMultiPaymentsWithCommonTransaction($paymentsDetails, $transId);
                $this->data['message'][] = $noofAdded . " payments added.";
                return true;
            }
            else
            {
                $this->data['pay_error'] = "Selected pay amount greater than transaction amount!";
            }
        }
        return false;
    }

    public function paymentBreakup($mid, $pid, $payhead)
    {

    }

    /*public function waiveOff()
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
        $this->data['payheadDetails'] = $this->payheadNamesAsAssocArraypayheadNamesAsAssocArray();
        $this->data['nationalityDetails'] = $this->nationalityNamesAsAssocArray();

        $this->index($page);
    }*/

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