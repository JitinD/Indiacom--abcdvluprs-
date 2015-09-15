<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 1:28 AM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class PaymentsManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "PaymentsManager";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH.'views/pages/PaymentsManager/'.$page.'.php'))
        {
            show_404();
        }

        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view('pages/PaymentsManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {
        $links['viewPaymentsMemberWise'] = "View payments memberwise";
        $links['viewPaymentsPaperWise'] = "View payments paperwise";
        $links['newPayment'] = "New payment";
        $links['spotPayments'] = "Spot payment";
        return $links;
    }

    public function load()
    {
        if(!$this->checkAccess("load"))
            return;
        $page = "index";
        $this->index($page);
    }

    public function viewPaymentsMemberWise()
    {
        if(!$this->checkAccess("viewPaymentsMemberWise"))
            return;
        $page = "viewPayments";
        $this->load->model('payment_model');
        $this->load->model('member_model');
        $this->load->model('discount_model');
        $this->load->model('currency_model');
        $this->load->model('nationality_model');

        $members = $this->payment_model->getAllPayingMembers();
        $this->data['payheadDetails'] = $this->payheadNamesAsAssocArray();
        $this->data['discountTypes'] = $this->discount_model->getAllDiscountsAsAssocArray();
        $this->data['nationalities'] = $this->nationality_model->getAllNationalitiesAsAssocArray();
        $currencies = $this->currency_model->getAllCurrencies();
        foreach($currencies as $currency)
        {
            $this->data['exchangeRate'][$currency->currency_id] = $this->currency_model->getCurrencyExchangeRateInINR($currency->currency_id);
            $this->data['currencyDetails'][$currency->currency_id] = $currency;
        }
        $this->data['viewBy'] = "members";
        $this->data['membersPayments'] = array();
        foreach($members as $member)
        {
            $this->data['membersPayments'][$member->member_id] = $this->payment_model->getMemberPayments($member->member_id);
            $this->data['memberDetails'][$member->member_id] = $this->member_model->getMemberInfo($member->member_id);
        }
        $this->index($page);
    }

    public function viewPaymentsPaperWise()
    {
        if(!$this->checkAccess("viewPaymentsPaperWise"))
            return;
        $page = "viewPayments";
        $this->load->model('payment_model');
        $this->load->model('paper_model');
        $this->load->model('discount_model');
        $this->load->model('currency_model');
        $this->load->model('nationality_model');

        $papers = $this->payment_model->getAllPayingPapers();
        $this->data['nationalities'] = $this->nationality_model->getAllNationalitiesAsAssocArray();
        $currencies = $this->currency_model->getAllCurrencies();
        foreach($currencies as $currency)
        {
            $this->data['exchangeRate'][$currency->currency_id] = $this->currency_model->getCurrencyExchangeRateInINR($currency->currency_id);
            $this->data['currencyDetails'][$currency->currency_id] = $currency;
        }
        $this->data['payheadDetails'] = $this->payheadNamesAsAssocArray();
        $this->data['discountTypes'] = $this->discount_model->getAllDiscountsAsAssocArray();
        $this->data['viewBy'] = "papers";
        $this->data['papersPayments'] = array();
        foreach($papers as $paper)
        {
            $this->data['papersPayments'][$paper->paper_id] = $this->payment_model->getPaperPayments($paper->paper_id);
            $this->data['paperDetails'][$paper->paper_id] = $this->paper_model->getPaperDetails($paper->paper_id);
        }
        $this->index($page);
    }

    public function newPayment($transId = null)
    {
        if(!$this->checkAccess("newPayment"))
            return;
        $this->load->model('transaction_model');
        $this->load->model('paper_status_model');
        $this->load->model('member_categories_model');
        $this->load->model('member_model');
        $this->load->model('currency_model');
        $this->load->model('transaction_mode_model');
        $this->load->model('payment_model');
        $this->load->model('discount_model');
        $page = "newPayment";
        if($transId != null)
        {
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
                        $this->data['discounts'] = $this->discount_model->getMemberEligibleDiscounts($memberId, $this->data['papers']);
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
            /*else if(empty($this->data['transDetails']))
            {
                unset($_SESSION[APPID]['transId']);
            }*/
            else if(!empty($this->data['transDetails']))
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
        $this->load->model('currency_model');

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
                $payAmount *= $this->currency_model->getCurrencyExchangeRateInINR($currency);
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

    public function paymentBreakup($submissionId, $payheadId)
    {
        if(!$this->checkAccess("paymentBreakup"))
            return;
        $page = "viewPaymentBreakup";
        $this->load->model('payment_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->data['paymentBreakups'] = $this->payment_model->getPaymentBreakup($submissionId, $payheadId);
        $this->form_validation->set_rules('transfer_amount', '', 'required');
        $this->form_validation->set_rules('transaction_id', '', 'required');
        $this->form_validation->set_rules('payment_id', '', 'required');
        if($this->form_validation->run())
        {
            $this->payment_model->transferPaymentAmount($this->input->post('payment_id'), $this->input->post('transfer_amount'));
            redirect('PaymentsManager/newPayment/' . $this->input->post('transaction_id'));
        }
        $this->index($page);
    }

    public function changePayableClass($submissionId, $payableClassId)
    {
        if(!$this->checkAccess("changePayableClass"))
            return;
        $page = "changePayableClass";
        $this->load->model('payable_class_model');
        $this->load->model('member_categories_model');
        $this->load->model('nationality_model');
        $this->load->model('payment_head_model');
        $this->data['memCats'] = $this->member_categories_model->getMemberCategoriesAsAssocArray();
        $this->data['nationalities'] = $this->nationality_model->getAllNationalitiesAsAssocArray();
        $this->data['paymentHeads'] = $this->payment_head_model->getAllPayheadsAsAssocArray();
        $this->data['payableClassId'] = $payableClassId;
        $allPayableClasses = $this->payable_class_model->getAllPayableClassDetails();
        $classesArray = array();
        foreach($allPayableClasses as $payableClass)
        {
            if(!isset($dateGroup[$payableClass->payable_class_payhead_id]))
            {
                $dateGroup[$payableClass->payable_class_payhead_id] = $this->payable_class_model->getDateGroups($payableClass->payable_class_payhead_id);
            }
            if($payableClass->start_date == null)
                $date = "upto " . $payableClass->end_date;
            else
                $date = $payableClass->start_date . " to " . $payableClass->end_date;
            $classesArray
                [$payableClass->payable_class_payhead_id]
                [$payableClass->payable_class_nationality]
                [$payableClass->payable_class_registration_category]
                [$date]
                [$payableClass->is_general] = array("id" => $payableClass->payable_class_id, "amount" => $payableClass->payable_class_amount);
        }
        $this->data['dateGroups'] = $dateGroup;
        $this->data['payableClasses'] = $classesArray;
        if($this->changePayableClassSubmitHandle($submissionId, $payableClassId, $newPayableClassId))
        {
            $this->data['message'][] = "Payable class has been updated";
            $this->data['payableClassId'] = $newPayableClassId;
        }
        $this->index($page);
    }

    private function changePayableClassSubmitHandle($submissionId, $payableClassId, &$newPayableClassId)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('payableClass', "", "required");
        if($this->form_validation->run())
        {
            $this->load->model('payment_model');
            $newPayableClassId = $this->input->post('payableClass');
            return $this->payment_model->updatePayableClass($submissionId, $payableClassId, $newPayableClassId);
        }
        return false;
    }

    public function changeDiscountType($submissionId, $payableClassId)
    {
        if(!$this->checkAccess("changeDiscountType"))
            return;
        $page = "changeDiscountType";
        $this->load->model('payment_model');
        $this->load->model('discount_model');
        $this->load->model('payable_class_model');
        if($this->changeDiscountTypeSubmitHandle($submissionId, $payableClassId))
        {
            $this->data['message'][] = "Discount Type has been updated";
        }
        $this->data['discountType'] = $this->payment_model->getPaymentDiscountType($submissionId, $payableClassId);
        $this->data['discounts'] = $this->discount_model->getAllDiscountsAsAssocArray();
        $payableClassDetails = $this->payable_class_model->getPayableClassDetails($payableClassId);
        $this->data['payheadId'] = $payableClassDetails->payable_class_payhead_id;
        $this->index($page);
    }

    private function changeDiscountTypeSubmitHandle($submissionId, $payableClassId)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('discountType', 'Discount Type', 'required');
        if($this->form_validation->run())
        {
            $this->load->model('payment_model');
            $newDiscountType = $this->input->post('discountType');
            if($newDiscountType == "null")
                $newDiscountType = null;
            return $this->payment_model->updateDiscountType($submissionId, $payableClassId, $newDiscountType);
        }
        return false;
    }

    public function paymentWaiveOff_AJAX()
    {
        if(!$this->checkAccess("paymentWaiveOff_AJAX"))
            return;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('payheadId', '', 'required');
        $this->form_validation->set_rules('amount', '', 'required');
        $this->form_validation->set_rules('memberId', '', 'required');
        if($this->form_validation->run())
        {
            $payheadId = trim($this->input->post('payheadId'));
            $amount = trim($this->input->post('amount'));
            $memberId = trim($this->input->post('memberId'));
            $paperId = trim(($this->input->post('paperId') == "") ? null : $this->input->post('paperId'));
            $discountType = trim(($this->input->post('discountType') == "") ? null : $this->input->post('discountType'));
            //echo "$payheadId $amount $memberId $paperId $discountType";
            echo json_encode($this->paymentWaiveOff($payheadId, $amount, $memberId, $paperId, $discountType));
        }
        else
        {
            echo json_encode(false);
        }
    }

    private function paymentWaiveOff($payheadId, $amount, $memberId, $paperId=null, $discountType=null)
    {
        $this->load->model('transaction_model');
        $this->load->model('payment_model');
        $this->load->database();
        if($amount <= 0)
            return false."A";
        $transDetails = array(
            "transaction_member_id" => $memberId,
            "transaction_bank" => "",
            "transaction_number" => "",
            "transaction_amount" => $amount,
            "transaction_date" => Date("Y-m-d"),
            "transaction_currency" => DEFAULT_CURRENCY,
            "is_waived_off" => 1,
            "is_verified" => 1
        );
        $this->db->trans_begin();
        if(!$this->transaction_model->newTransaction($transDetails))
        {
            $this->db->trans_commit();
            return false."B";
        }
        $payments = $this->payment_model->getPayments($memberId, $paperId, $payheadId);
        if(empty($payments))
        {
            $this->load->model('member_model');
            $this->load->model('payable_class_model');
            $this->load->model('submission_model');
            $regCat = $this->member_model->getMemberCategory($memberId);
            $payableClass = $this->payable_class_model->getPayableClass(
                $payheadId,
                !$this->member_model->isProfBodyMember($memberId),
                $regCat->member_category_id,
                $transDetails['transaction_currency'],
                $transDetails['transaction_date']
            );
            $paymentDetails = array(
                "payment_trans_id" => $transDetails['transaction_id'],
                "payment_amount_paid" => $amount,
                "payment_payable_class" => $payableClass->payable_class_id
            );
            if($paperId == null)
                $paymentDetails['payment_member_id'] = $memberId;
            else
                $paymentDetails['payment_submission_id'] = $this->submission_model->getSubmissionID($memberId, $paperId);
            if($discountType != null)
                $paymentDetails['payment_discount_type'] = $discountType;
        }
        else
        {
            $paymentDetails = array(
                "payment_trans_id" => $transDetails['transaction_id'],
                "payment_submission_id" => $payments[0]->payment_submission_id,
                "payment_member_id" => $payments[0]->payment_member_id,
                "payment_amount_paid" => $amount,
                "payment_payable_class" => $payments[0]->payment_payable_class,
                "payment_discount_type" => $payments[0]->payment_discount_type
            );
        }
        if(!$this->payment_model->addNewPayment($paymentDetails))
        {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function spotPayments()
    {
        if(!$this->checkAccess("spotPayments"))
            return;
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
}