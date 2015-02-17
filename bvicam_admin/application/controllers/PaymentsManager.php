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
        $this->load->model('discount_model');
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
                $payableClass = $this->getPseudoPayableClass(
                    $submissionDetails[0]->submission_member_id,
                    $submissionDetails[0]->submission_paper_id,
                    $payHeadId,
                    $currency,
                    $transDate,
                    $discountType
                );

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

    public function spotPayments()
    {
        $page = "spotPayment";
        $this->load->model('payment_head_model');
        $this->load->model('discount_model');
        $this->data['paymentHeads'] = $this->payment_head_model->getAllPayheadDetails();
        $this->data['discounts'] = $this->discount_model->getAllDiscounts();
        $this->spotPaymentsSubmitHandle();
        $this->index($page);
    }

    private function spotPaymentsSubmitHandle()
    {
        $this->load->model('transaction_model');
        $this->load->model('submission_model');
        $this->load->model('payment_model');
        $this->load->model('paper_status_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('trans_memberId', "Member ID", 'required');
        if($this->form_validation->run())
        {
            $this->data['papers'] = $this->paper_status_model->getMemberAcceptedPapers($this->input->post('trans_memberId'));
        }
        $this->form_validation->set_rules('trans_amount', "Amount", 'required');
        $this->form_validation->set_rules('trans_no', "Transaction Number", 'required');
        $this->form_validation->set_rules('trans_payhead', "Payhead", 'required');
        $this->form_validation->set_rules('trans_isWaivedOff', "Waived Off flag", 'required');

        if($this->form_validation->run())
        {
            if(!$this->verifyPayheadDiscountCombination($this->input->post('trans_payhead'), $this->input->post('trans_discountType')))
            {
                $this->data['pay_error'] = "The selected discount is not available for the selected payhead!";
                return false;
            }
            $discountType = $this->input->post('trans_discountType');
            $payableClass = $this->getPseudoPayableClass(
                $this->input->post('trans_memberId'),
                $this->input->post('trans_paperId'),
                $this->input->post('trans_payhead'),
                DEFAULT_CURRENCY,
                date("Y-m-d"),
                $discountType
            );
            if($this->input->post('trans_amount') <= $payableClass->payable_class_amount)
            {
                $transDetails = array(
                    "transaction_member_id" => $this->input->post('trans_memberId'),
                    "transaction_bank" => FAKE_BANK,
                    "transaction_number" => $this->input->post('trans_no'),
                    "transaction_mode" => CASH_MODE_ID,
                    "transaction_amount" => $this->input->post('trans_amount'),
                    "transaction_date" => date("Y-m-d"),
                    "transaction_currency" => DEFAULT_CURRENCY,
                    "is_verified" => 1,
                    "transaction_remarks" => "Spot Payment"
                );
                if($this->input->post('trans_isWaivedOff') == "true")
                {
                    $transDetails['transaction_mode'] = null;
                    $transDetails['is_waived_off'] = true;
                    $transDetails['transaction_bank'] = "";
                    $transDetails['transaction_number'] = "";
                }
                if(!$this->transaction_model->newTransaction($transDetails))
                {
                    $this->data['pay_error'] = "Error creating transaction. Transaction number might be duplicate.";
                    return false;
                }
                $this->data['info'][] = "Transaction created";
                $paymentDetails = array(
                    "payment_trans_id" => $transDetails["transaction_id"],
                    "payment_amount_paid" => $transDetails["transaction_amount"],
                    "payment_payable_class" => $payableClass->payable_class_id
                );
                if($this->checkPayheadPapersRequirement($this->input->post('trans_payhead')))
                {
                    $paymentDetails["payment_submission_id"] = $this->submission_model->getSubmissionID(
                        $this->input->post('trans_memberId'),
                        $this->input->post('trans_paperId')
                    );
                }
                else
                {
                    $paymentDetails["payment_member_id"] = $this->input->post('trans_memberId');
                }
                if($discountType != null)
                {
                    $paymentDetails["payment_discount_type"] = $discountType;
                }
                if(!$this->payment_model->addNewPayment($paymentDetails))
                {
                    $this->data['pay_error'] = "Error creating payment. Contact Admin.";
                    return false;
                }
                $this->data['info'][] = "Payment created";
            }
            else
            {
                $this->data['pay_error'] = "Pay amount more than required amount of " . $payableClass->payable_class_amount;
                return false;
            }
            return true;
        }
    }

    private function verifyPayheadDiscountCombination($payheadId, $discountType)
    {
        if($discountType != null)
        {
            $this->load->model('discount_model');
            $discountDetails = $this->discount_model->getDiscountDetails($discountType);
            if($payheadId != $discountDetails->discount_type_payhead)
                return false;
        }
        return true;
    }

    private function checkPayheadPapersRequirement($payheadId)
    {
        $this->load->model('payment_head_model');
        $payheadDetails = $this->payment_head_model->getPayheadDetails($payheadId);
        if($payheadDetails->payment_head_name == "PR")
        {
            return false;
        }
        return true;
    }

    private function getPseudoPayableClass($memberId, $paperId, $payheadId, $currency, $date, &$discountType)
    {
        $this->load->model('member_model');
        $this->load->model('payment_model');
        $this->load->model('payable_class_model');
        $registrationCat = $this->member_model->getMemberCategory($memberId);
        $paidPayments = $this->payment_model->getPayments(
            $memberId,
            $paperId,
            $payheadId
        );
        $discountAmt = 0;
        $paidAmount = 0;
        if(empty($paidPayments))
        {
            $payableClass = $this->payable_class_model->getPayableClass(
                $payheadId,
                !$this->member_model->isProfBodyMember($memberId),
                $registrationCat->member_category_id,
                $currency,
                $date
            );
        }
        else
        {
            $payableClass = $this->payable_class_model->getPayableClassDetails($paidPayments[0]->payment_payable_class);
            $discountType = $paidPayments[0]->payment_discount_type;
            $paidAmount = $paidPayments[0]->paid_amount + $paidPayments[0]->waiveoff_amount;
        }
        if($discountType != null)
        {
            $detail = $this->discount_model->getDiscountDetails($discountType);
            $discountAmt = floor($payableClass->payable_class_amount * $detail->discount_type_amount);
        }
        $payableClass->payable_class_amount -= ($paidAmount + $discountAmt);
        return $payableClass;
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