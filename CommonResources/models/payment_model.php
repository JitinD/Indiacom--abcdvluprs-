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
        return $this->dbCon->trans_status();
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
                "Group By payment_submission_id, payment_payable_class
            ) As table1
            Left Join
            (/* waiveoff_amount against mid,pid,payhead */
                Select
                    payment_payable_class,
                    payment_submission_id,
                    SUM(payment_amount_paid) as waiveoff_amount
                From
                    payment_master
                        Join
                    transaction_master
                        On transaction_id = payment_trans_id
                Where is_waived_off = 1 " . ($includeRejected ? "" : " And is_verified !=2 ") . "
                Group By payment_submission_id, payment_payable_class
            ) As table2
                On
            table1.payment_payable_class = table2.payment_payable_class And
            table1.payment_submission_id = table2.payment_submission_id
                Left Join
            submission_master
                On submission_master.submission_id = table1.payment_submission_id
                Join
            payable_class
                On table1.payment_payable_class = payable_class_id
                Left Join
            discount_type_master
                On discount_type_id = table1.payment_discount_type";
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

    public function getPaymentBreakup($mid, $pid, $payhead)
    {
        $sql = "
        Select
            payment_amount_paid,
            transaction_date
        From
            payment_master
                Join
            transaction_master
                On
                  payment_trans_id = transaction_id
                Join
            submission_master
                On submission_master.submission_id = payment_master.payment_submission_id
        Where
            submission_member_id = ? And
            submission_paper_id = ? And
            payment_head = ?
        Order By transaction_date";
        $query = $this->dbCon->query($sql, array($mid, $pid, $payhead));
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
            payable_class_amount
        From payment_master
            Join payable_class
                On payment_payable_class = payable_class_id
            Join submission_master
                On submission_master.submission_id = payment_master.payment_submission_id
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
            if($row->total_amount_paid >= $row->payable_class_amount)
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
        $sql = "Select Distinct submission_member_id as member_id
                From
                  payment_master
                    Join
                  submission_master
                    On submission_master.submission_id = payment_master.payment_submission_id";
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
                    On submission_master.submission_id = payment_master.payment_submission_id";
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

    public function calculatePayables($memberID, $selectedCurrency, $registrationCat, $papers, $transDate)
    {
        $this->load->model('payable_class_model');
        $this->load->model('submission_model');
        $this->load->model('member_model');
        $currency = $selectedCurrency;
        $brPayableClass = $this->payable_class_model->getBrPayableClass(
            !$this->member_model->isProfBodyMember($memberID),
            $registrationCat->member_category_id,
            $currency,
            $transDate
        );
        $epPayableClass = $this->payable_class_model->getEpPayableClass(
            !$this->member_model->isProfBodyMember($memberID),
            $registrationCat->member_category_id,
            $currency,
            $transDate
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
            if(!$isPaid)
            {
                $this->setPayablePayments(
                    $memberID,
                    $paper,
                    $isPaperRegistered,
                    $isAuthorRegistered,
                    $noofPapers,
                    $brPayableClass->payable_class_amount,
                    $epPayableClass->payable_class_amount,
                    $papersInfo[$paper->paper_id]
                );
            }
        }
        return $papersInfo;
    }

    private function setPaidPayments($mid, $paper, &$paperInfo = array())
    {
        //$this->load->model('payment_model');
        $this->load->model('payable_class_model');
        $this->load->model('discount_model');
        $payments = $this->getPayments($mid, $paper->paper_id);
        if(!empty($payments))
        {
            $paymentClass = $payments[0]->payment_payable_class;
            $paymentDiscountType = $payments[0]->payment_discount_type;
            $paperInfo['paid'] = $payments[0]->paid_amount;
            $paperInfo['waiveOff'] = $payments[0]->waiveoff_amount;

            $paymentClassDetails = $this->payable_class_model->getPayableClassDetails($paymentClass);
            $discountAmount = 0;
            if($paymentDiscountType != null)
            {
                $discountTypeDetails = $this->discount_model->getDiscountDetails($paymentDiscountType);
                $discountAmount = ($discountTypeDetails == null) ? 0 : floor($discountTypeDetails->discount_type_amount * $paymentClassDetails->payable_class_amount);
                $paperInfo['discountType'] = $discountTypeDetails;
            }
            switch($paymentClassDetails->payable_class_payhead_id)
            {
                case 1: //BR
                    $paperInfo['br'] = $paymentClassDetails->payable_class_amount - $discountAmount;
                    $paperInfo['pending'] = $paperInfo['br'] - $paperInfo['paid'] - $paperInfo['waiveOff'];
                    break;
                case 2: //EP
                    $paperInfo['ep'] = $paymentClassDetails->payable_class_amount - $discountAmount;
                    $paperInfo['pending'] = $paperInfo['ep'] - $paperInfo['paid'] - $paperInfo['waiveOff'];
                    break;
            }
            return true;
        }
        return false;
    }

    private function setPayablePayments($mid, $paper, $isPaperRegistered, $isAuthorRegistered, $noofPapers, $brPayable, $epPayable, &$paperInfo = array())
    {
        if($noofPapers == 1)
        {
            if(!$isAuthorRegistered)
            {
                $paperInfo['br'] = $brPayable;
            }
        }
        else
        {
            $noofAuthors = count($this->submission_model->getAllAuthorsOfPaper($paper->paper_id));
            if($noofAuthors == 1)
            {
                $paperInfo['br'] = $brPayable;
            }
            else
            {
                $noofEps = $this->noofEps($paper->paper_id);
                if($noofEps == $noofAuthors - 1)
                {
                    $paperInfo['br'] = $brPayable;
                }
                else if($noofEps < $noofAuthors - 1)
                {
                    if($isPaperRegistered && $isAuthorRegistered)
                    {
                        $paperInfo['ep'] = $epPayable;
                    }
                    else
                    {
                        $paperInfo['ep'] = $epPayable;
                        $paperInfo['br'] = $brPayable;
                    }
                }
                else
                {
                    //Payment error. All eps received against paper.
                }
            }
        }
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
        //return $query -> result_array();
        return $query -> row();
    }

    //Check if one basic registration paid under a member registration
    public function  isMemberBRPaid($memberID)
    {
        $this -> dbCon -> select ('*');
        $this -> dbCon -> from ('payment_master');
        $this -> dbCon -> join ('payment_head_master','payment_master.payment_head=payment_head_master.payment_head_id');
        $this -> dbCon -> where('payment_member_id',$memberID);
        $this -> dbCon -> where('payment_head_name','BR');
        $query = $this -> dbCon -> get();
        if($query -> num_rows() > 0)
            return $query -> row();
        //return $query->row_array();
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
            return $query -> row();
        //return $query->row_array();

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

        /*$row = $query->row();

        return $row->payable_class_amount;
        */

        //return $query->result_array();
        return $query -> row();
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
            //return $query->result_array();
            return $query -> row();

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
            // return $query->row_array();
            return $query -> row();
    }
}