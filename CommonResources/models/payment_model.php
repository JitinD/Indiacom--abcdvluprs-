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

    public function addNewPayment($paymentDetails = array())
    {
        $paymentDetails['payment_is_transferred'] = 0;
        $this->dbCon->insert('payment_master', $paymentDetails);
        $transStatus = $this->dbCon->trans_status();
        /*if($transStatus)
        {
            $this->checkAutomatedBulkDiscount($paymentDetails);
        }*/
        return $transStatus;
    }

    private function checkAutomatedBulkDiscount($paymentDetails)
    {
        $this->load->model('submission_model');
        $this->load->model('member_model');
        $this->load->model('discount_model');
        $submissionDetails = $this->submission_model->getSubmissionsByAttribute("submission_id", $paymentDetails['payment_submission_id']);
        $memberInfo = $this->member_model->getMemberInfo($submissionDetails[0]->submission_member_id);
        $noofRegs = 0;
        $this->discount_model->isBulkRegistrationDiscountValid($memberInfo['member_organization_id'], $noofRegs);
        if($noofRegs == BULK_REGISTRATION_MIN_REGISTRATION_VALUE)
        {
            $this->discount_model->setBulkRegistrationDiscount($memberInfo['member_organization_id']);
        }
    }

    public function addMultiPaymentsWithCommonTransaction($paymentsDetails = array(), $transId)
    {
        $noofPayments = 0;
        foreach($paymentsDetails as $paymentDetail)
        {
            $paymentDetail['payment_trans_id'] = $transId;
            if($this->addNewPayment($paymentDetail))
                $noofPayments++;
            else
                die(mysql_error());
        }
        return $noofPayments;
    }

    public function updatePayableClass($submissionId, $payableClassId, $newPayableClassId)
    {
        $sql = "Update payment_master
                Set payment_payable_class = ?
                Where payment_submission_id=? And payment_payable_class=?";
        $this->dbCon->query($sql, array($newPayableClassId, $submissionId, $payableClassId));
        return $this->dbCon->trans_status();
    }

    public function updateDiscountType($submissionId, $payableClassId, $newDiscountType)
    {
        $sql = "Update payment_master
                Set payment_discount_type = ?
                Where payment_submission_id=? And payment_payable_class=?";
        /*if($newDiscountType == null)
            die("HERE");*/
        $this->dbCon->query($sql, array($newDiscountType, $submissionId, $payableClassId));
        return $this->dbCon->trans_status();
    }

    public function transferPaymentAmount($paymentId, $transferAmount)
    {
        $paymentDetails = $this->getPaymentDetails($paymentId);
        $newAmount = $paymentDetails->payment_amount_paid - $transferAmount;
        if($newAmount >= 0 && $newAmount < $paymentDetails->payment_amount_paid)
        {
            $sql = "Update payment_master
                    Set payment_amount_paid=?
                    Where payment_id=?";
            $this->dbCon->query($sql, array($newAmount, $paymentId));
            return $this->dbCon->trans_status();
        }
        return false;
    }

    public function quickWaiveOff()
    {

    }

    public function transferPayment($sourceDetails = array(), $destinationDetails = array())
    {
        $this->load->model('transfer_model');
        $fromPayments = $this->fetchPayments($sourceDetails['payment_submission_id'], $sourceDetails['payment_head']);
        $transferAmount = 0;
        foreach($fromPayments as $fromPayment)
        {
            $transferAmount += $fromPayment->payment_amount_paid;
            $this->setIsTransferred($fromPayment->payment_id);
            $destPayment = array(
                'payment_trans_id' => $fromPayment->payment_trans_id,
                'payment_head' => $destinationDetails['payment_head'],
                'payment_submission_id' => $destinationDetails['payment_submission_id'],
                'payment_amount_paid' => $fromPayment->payment_amount_paid,
                'payment_payable_class' => $destinationDetails['payment_payable_class']
            );
            $this->addNewPayment($destPayment);
            $this->transfer_model->newTransfer(
                $fromPayment['payment_id'],
                $this->getPaymentId(
                    $destPayment['payment_submission_id'],
                    $destPayment['payment_head'],
                    $destPayment['payment_trans_id']
                ),
                $destPayment['payment_amount_paid']
            );
        }
    }

    public function getMemberPayments($mid, $includeRejected = false)
    {
        return $this->getPayments($mid, null, null, $includeRejected);
    }

    public function getPaperPayments($pid, $includeRejected = false)
    {
        return $this->getPayments(null, $pid, null, $includeRejected);
    }

    public function getPayments($mid=null, $pid=null, $payheadId=null, $includeRejected = false, $limit=null, $offset=null)
    {
        $sql = "
        Select
            table1.payment_payable_class,
            payable_class_amount,
            payable_class_nationality,
            payable_class_payhead_id,
            table1.payment_submission_id,
            table1.payment_member_id,
            submission_member_id,
            submission_paper_id,
            Case
                When waiveoff_amount Is Null
                Then 0
                Else waiveoff_amount
            End As waiveoff_amount,
            Case
                When waiveoff_amount Is NULL
                Then total_amount
                Else (total_amount - waiveoff_amount)
            End As paid_amount,
            payment_discount_type,
            discount_type_amount,
            table1.is_verified
        From
            (/* total amount against mid,pid,payhead including waiveoff amount (not discount) */
                Select
                    payment_payable_class,
                    payment_submission_id,
                    payment_member_id,
                    payment_discount_type,
                    SUM(payment_amount_paid) As total_amount,
                    is_verified
                From
                    payment_master
                        Join
                    transaction_master
                        On transaction_id = payment_trans_id
                " . ($includeRejected ? " " : " Where is_verified != 2 ") .
                "Group By
                    Case
                        When payment_submission_id Is Null
                        Then payment_member_id
                        Else payment_submission_id
                    End, payment_payable_class
            ) As table1
            Left Join
            (/* waiveoff_amount against mid,pid,payhead */
                Select
                    payment_payable_class,
                    payment_submission_id,
                    payment_member_id,
                    SUM(payment_amount_paid) as waiveoff_amount
                From
                    payment_master
                        Join
                    transaction_master
                        On transaction_id = payment_trans_id
                Where is_waived_off = 1 " . ($includeRejected ? "" : " And is_verified !=2 ") . "
                Group By
                    Case
                        When payment_submission_id Is Null
                        Then payment_member_id
                        Else payment_submission_id
                    End, payment_payable_class
            ) As table2
                On
            table1.payment_payable_class = table2.payment_payable_class And
            Case
                When table1.payment_submission_id Is Null And table2.payment_submission_id Is Null
                Then table1.payment_member_id = table2.payment_member_id
                Else table1.payment_submission_id = table2.payment_submission_id
            End
                Left Join
            submission_master
                On submission_master.submission_id = table1.payment_submission_id
                Join
            payable_class
                On table1.payment_payable_class = payable_class_id
                Left Join
            discount_type_master
                On discount_type_id = table1.payment_discount_type
                Left Join
            nationality_master
                On payable_class_nationality = Nationality_id";
        $where = " Where ";
        $params = array();
        if($pid != null)
        {
            $where .= " submission_paper_id = ? And ";
            $params[] = $pid;
        }
        if($mid != null)
        {
            $where .= " (submission_member_id = ? Or table1.payment_member_id = ?) And ";
            $params[] = $mid;
            $params[] = $mid;
        }
        if($payheadId != null)
        {
            $where .= " payable_class_payhead_id = ? And ";
            $params[] = $payheadId;
        }
        $where .= " 1 ";
        $sql .= $where;
        $query = $this->dbCon->query($sql, $params);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getPaymentBreakup($submissionId, $payhead)
    {
        $sql = "
        Select
            payment_id,
            payment_trans_id,
            transaction_EQINR,
            transaction_date,
            is_verified,
            is_waived_off,
            payment_amount_paid,
            payment_remarks
        From
            payment_master
                Join
            payable_class
                On payment_payable_class = payable_class_id
                Join
            transaction_master
                On transaction_id = payment_trans_id
        Where payment_submission_id = ? And
              payable_class_payhead_id = ?
          Order By transaction_date";
        $query = $this->dbCon->query($sql, array($submissionId, $payhead));
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getPaymentDetails($paymentId)
    {
        $sql = "Select * From payment_master Where payment_id = ?";
        $query = $this->dbCon->query($sql, array($paymentId));
        if($query->num_rows() == 1)
            return $query->row();
        return null;
    }

    public function getPaymentDiscountType($submissionId, $payableClassId)
    {
        $sql = "Select payment_discount_type
                From payment_master
                Where payment_submission_id=? And payment_payable_class=?";
        $query = $this->dbCon->query($sql, array($submissionId, $payableClassId));
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->payment_discount_type;
        }
        return null;
    }

    public function isMemberRegistered($mid)
    {
        $sql = "
        Select
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
            submission_member_id = ?
        Group By payment_submission_id";
        $query = $this->dbCon->query($sql, array($mid));
        if($query->num_rows() == 0)
            return false;
        $result = $query->result();
        foreach($result as $row)
        {
            if($row->total_amount_paid >= ($row->payable_class_amount - $row->discount_amount))
                return true;
        }
        return false;
    }

    public function getRegisteredMembers()
    {
        $sql = "Select
                  submission_member_id
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
                        payable_class_payhead_id = 1
                    Group By payment_submission_id
                ) as table1
                Where total_amount_paid >= (payable_class_amount - discount_amount)";
        $query = $this->dbCon->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function isPaperRegistered($pid)
    {
        $sql = "
        Select
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
            submission_paper_id = ?
        Group By payment_submission_id";
        $query = $this->dbCon->query($sql, array($pid));
        if($query->num_rows() == 0)
            return false;
        $result = $query->result();
        foreach($result as $row)
        {
            if($row->total_amount_paid >= $row->payable_class_amount - $row->discount_amount)
                return true;
        }
        return false;
    }

    public function noofEps($pid)
    {
        //Partial ep payment also counted
        $sql = "
        Select
            payment_submission_id
        From payment_master
            Join payable_class
                On payment_payable_class = payable_class_id
            Join submission_master
                On submission_master.submission_id = payment_master.payment_submission_id
            Join transaction_master
		        On transaction_id = payment_trans_id And is_verified = 1
        Where
            payable_class_payhead_id = 2 And
            submission_paper_id = ?
        Group By payment_submission_id";
        $query = $this->db->query($sql, array($pid));
        return $query->num_rows();
    }

    public function getAllPayingMembers()
    {
        $sql = "Select
                  Distinct Case
                    When submission_member_id Is Null
                    Then payment_member_id
                    Else submission_member_id
                  End as member_id
                From
                payment_master
                  Left Join
                submission_master
                  On submission_master.submission_id = payment_master.payment_submission_id
                  Join
                transaction_master
                  On payment_trans_id = transaction_id And is_verified != 2";
        $query = $this->dbCon->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getAllPayingPapers()
    {
        $sql = "Select Distinct submission_paper_id as paper_id
                From
                    payment_master
                        Join
                    submission_master
                        On submission_master.submission_id = payment_master.payment_submission_id
                        Join
                    transaction_master
                        On payment_trans_id = transaction_id And is_verified != 2";
        $query = $this->dbCon->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    private function getPaymentId($submissionId, $paymentHead, $transId)
    {
        $sql = "Select payment_id From payment_master
                Where payment_submission_id=? And payment_head=? And payment_trans_id=?";
        $query = $this->dbCon->query($sql, array($submissionId, $paymentHead, $transId));
        if($query->num_rows() == 0)
            return null;
        $row = $query->row();
        return $row->payment_id;
    }

    private function fetchPayments($submissionId, $paymentHead)
    {
        $sql = "Select * From payment_master
                Where payment_submission_id=? And payment_head=?";
        $query = $this->dbCon->query($sql, array($submissionId, $paymentHead));
        if($query->num_rows() > 0)
            return $query->result();
        return array();
    }

    private function setIsTransferred($paymentId)
    {
        $sql = "Update payment_master Set payment_is_transferred=1
                Where payment_id = ?";
        $this->dbCon->query($sql, array($paymentId));
    }

    public function calculatePayables($memberID, $selectedCurrency, $registrationCat, $papers, $transDate, $eventId)
    {
        $this->load->model('payable_class_model');
        $this->load->model('submission_model');
        $this->load->model('member_model');
        $currency = $selectedCurrency;
        $brPayableClass = $this->payable_class_model->getBrPayableClass(
            !$this->member_model->isProfBodyMember($memberID),
            $registrationCat->member_category_id,
            $currency,
            $transDate,
            $eventId
        );
        $epPayableClass = $this->payable_class_model->getEpPayableClass(
            !$this->member_model->isProfBodyMember($memberID),
            $registrationCat->member_category_id,
            $currency,
            $transDate,
            $eventId
        );
        if($brPayableClass == null || $epPayableClass == null)
            return array();
        $isAuthorRegistered = $this->isMemberRegistered($memberID);
        $papersInfo = array();
        $noofPapers = count($papers);
        foreach($papers as $paper)
        {
            $isPaperRegistered = $this->isPaperRegistered($paper->paper_id);
            $isPaid = $this->setPaidPayments($memberID, $paper, $papersInfo[$paper->paper_id]);
            if($isPaid)
            {
                $this->load->model('submission_model');
                $submissionId = $this->submission_model->getSubmissionId($memberID, $paper->paper_id);
                $breakup = $this->getPaymentBreakup($submissionId, $papersInfo[$paper->paper_id]['payhead'][0]->payment_head_id);
                $papersInfo[$paper->paper_id]['tax'] = $this->getTax($breakup[0]->transaction_date);
            }
            else
            {
                $this->setPayablePayments(
                    $memberID,
                    $paper,
                    $isPaperRegistered,
                    $isAuthorRegistered,
                    $noofPapers,
                    $brPayableClass,
                    $epPayableClass,
                    $papersInfo[$paper->paper_id]
                );
                $papersInfo[$paper->paper_id]['tax'] = $this->getTax($transDate);
            }
        }
        return $papersInfo;
    }

    private function setPaidPayments($mid, $paper, &$paperInfo = array())
    {
        $this->load->model('payable_class_model');
        $this->load->model('discount_model');
        $this->load->model('payment_head_model');
        $this->load->model('currency_model');
        $this->load->model('nationality_model');
        $payments = $this->getPayments($mid, $paper->paper_id);
        if(!empty($payments))
        {
            foreach($payments as $payment)
            {
                $paymentClass = $payment->payment_payable_class;
                $paymentDiscountType = $payment->payment_discount_type;
                $paymentClassDetails = $this->payable_class_model->getPayableClassDetails($paymentClass);
                $nationalityDetails = $this->nationality_model->getNationalityDetails($paymentClassDetails->payable_class_nationality);
                if($nationalityDetails == null)
                    $currency = DEFAULT_CURRENCY;
                else
                    $currency = $nationalityDetails->Nationality_currency;
                $paid = $paperInfo['paid'][] = $payment->paid_amount / $this->currency_model->getCurrencyExchangeRateInINR($currency);
                $waiveOff = $paperInfo['waiveOff'][] = $payment->waiveoff_amount;

                $discountAmount = 0;
                if($paymentDiscountType != null)
                {
                    $discountTypeDetails = $this->discount_model->getDiscountDetails($paymentDiscountType);
                    $discountAmount = ($discountTypeDetails == null) ? 0 : floor($discountTypeDetails->discount_type_amount * $paymentClassDetails->payable_class_amount);
                    $paperInfo['discountType'][] = $discountTypeDetails;
                }
                $payheadDetails = $this->payment_head_model->getPayheadDetails($paymentClassDetails->payable_class_payhead_id);
                $payable = $paperInfo['payable'][] = $paymentClassDetails->payable_class_amount - $discountAmount;
                $paperInfo['payhead'][] = $payheadDetails;
                $paperInfo['payableClass'][] = $paymentClassDetails;
                //$paperInfo['pending'][] = $payable - $paid - $waiveOff;
            }
            return true;
        }
        return false;
    }

    private function setPayablePayments($mid, $paper, $isPaperRegistered, $isAuthorRegistered, $noofPapers, $brPayableClass, $epPayableClass, &$paperInfo = array())
    {
        $this->load->model('payment_head_model');
        if($noofPapers == 1)
        {
            if(!$isAuthorRegistered)
            {
                //$paperInfo['br'] = $brPayableClass->payable_class_amount;
                //$paperInfo['payable'] = $paperInfo['pending'] =  $brPayableClass->payable_class_amount;
                $paperInfo['payhead'][] = $this->payment_head_model->getPayheadDetails($brPayableClass->payable_class_payhead_id);
                $paperInfo['payableClass'][] = $brPayableClass;
            }
        }
        else
        {
            $noofAuthors = count($this->submission_model->getAllAuthorsOfPaper($paper->paper_id));
            if($noofAuthors == 1)
            {
                //$paperInfo['br'] = $brPayableClass->payable_class_amount;
                //$paperInfo['payable'] = $paperInfo['pending'] =  $brPayableClass->payable_class_amount;
                $paperInfo['payhead'][] = $this->payment_head_model->getPayheadDetails($brPayableClass->payable_class_payhead_id);
                $paperInfo['payableClass'][] = $brPayableClass;
            }
            else
            {
                $noofEps = $this->noofEps($paper->paper_id);
                if($noofEps == $noofAuthors - 1)
                {
                    //$paperInfo['br'] = $brPayableClass->payable_class_amount;
                    //$paperInfo['payable'] = $paperInfo['pending'] =  $brPayableClass->payable_class_amount;
                    $paperInfo['payhead'][] = $this->payment_head_model->getPayheadDetails($brPayableClass->payable_class_payhead_id);
                    $paperInfo['payableClass'][] = $brPayableClass;
                }
                else if($noofEps < $noofAuthors - 1)
                {
                    if($isPaperRegistered && $isAuthorRegistered)
                    {
                        //$paperInfo['ep'] = $epPayableClass->payable_class_amount;
                        //$paperInfo['payable'] = $paperInfo['pending'] =  $epPayableClass->payable_class_amount;
                        $paperInfo['payhead'][] = $this->payment_head_model->getPayheadDetails($epPayableClass->payable_class_payhead_id);
                        $paperInfo['payableClass'][] = $epPayableClass;
                    }
                    else
                    {
                        //$paperInfo['ep'] = $epPayableClass->payable_class_amount;
                        //$paperInfo['br'] = $brPayableClass->payable_class_amount;
                        //$paperInfo['payable'][] = $paperInfo['pending'][] =  $brPayableClass->payable_class_amount;
                        $paperInfo['payhead'][] = $this->payment_head_model->getPayheadDetails($brPayableClass->payable_class_payhead_id);
                        $paperInfo['payableClass'][] = $brPayableClass;
                        //$paperInfo['payable'][] = $paperInfo['pending'][] =  $epPayableClass->payable_class_amount;
                        $paperInfo['payhead'][] = $this->payment_head_model->getPayheadDetails($epPayableClass->payable_class_payhead_id);
                        $paperInfo['payableClass'][] = $epPayableClass;
                    }
                }
                else
                {
                    die("System Logic Error. All EPs against paper. Contact Admin");
                    //Payment error. All eps received against paper.
                }
            }
        }
    }

    public function getTax($transDate)
    {
        $taxRate = HIGHER_TAX;
        $transTimestamp = strtotime($transDate);
        if($transTimestamp < TAX_DECISION_DATE)
            $taxRate = LOWER_TAX;
        $tax = 1 + ($taxRate/100);
        return $tax;
    }
}