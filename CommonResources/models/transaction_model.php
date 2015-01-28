<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 17/1/15
 * Time: 1:04 PM
 */
    class Transaction_model extends CI_Model
    {
        public $error;

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function newTransaction($transDetails = array())
        {
            $this->load->model('currency_model');
            $transDetails['transaction_EQINR'] = $transDetails['transaction_amount'] * $this->currency_model->getCurrencyExchangeRateInINR($transDetails['transaction_currency']);
            if(!isset($transDetails['is_waived_off']))
                $transDetails['is_waived_off'] = 0;
            if(!isset($transDetails['is_verified']))
                $transDetails['is_verified'] = 0;
            $this->db->insert('transaction_master', $transDetails);
        }

        public function newWaiveOffTransaction($amount)
        {
            $this->load->model('currency_model');
            $transDetails = array(
                'transaction_bank' => "",
                'transaction_number' => "",
                'transaction_amount' => $amount,
                'transaction_date' => 0,
                'transaction_currency' => $this->currency_model->getCurrencyId("INR"),
                'is_waived_off' => 1,
                'is_verified' => 1
            );
            $this->newTransaction($transDetails);
        }

        public function getTransactionId($transDetails = array())
        {
            $sql = "Select transaction_id
                    From transaction_master
                    Where ";
            $vals = array();
            foreach($transDetails as $attr=>$val)
            {
                $sql .= "$attr=? And ";
                $vals[] = $val;
            }
            $sql = preg_replace('/ And $/', '', $sql);
            $query = $this->db->query($sql, $vals);
            if($query->num_rows() == 0 || $query->num_rows() > 1)
                return null;
            $row = $query->row();
            return $row->transaction_id;
        }

        public function getTransactionDetails($transId)
        {
            $sql = "Select * From transaction_master
                    Where transaction_id = ?";
            $query = $this->db->query($sql, array($transId));
            if($query->num_rows() == 0)
                return array();
            return $query->row();
        }

        public function getTransactionUsedAmount($transId)
        {
            $sql = "
            Select
                Case
                    When payment_amount_paid is Null
                    Then 0
                    Else SUM(payment_amount_paid)
                End as amount_used
            From
                transaction_master
                    Left Join
                payment_master
                    On transaction_id = payment_trans_id
            Where transaction_id = ?
            Group By
                transaction_id";
            $query = $this->db->query($sql, array($transId));
            if($query->num_rows() == 0)
                return null;
            $row = $query->row();
            return $row->amount_used;
        }

        public function getUnusedTransactions()
        {
            $sql = "Select
                        table1.*
                    From
                        (
                            Select
                                transaction_master.*,
                                Case
                                    When payment_amount_paid is Null
                                    Then 0
                                    Else SUM(payment_amount_paid)
                                End as amount_used
                            From
                                transaction_master
                                    Left Join
                                payment_master
                                    On transaction_id = payment_trans_id
                            Group By
                                transaction_id
                        ) as table1
                    Where amount_used < transaction_amount";
            $query = $this->db->query($sql);
            if($query->num_rows() == 0)
                return array();
            return $query->result();
        }

        public function getTransactions()
        {
            $this -> db -> select('member_name, transaction_id, transaction_bank, transaction_number, transaction_mode_name, transaction_amount, transaction_date, transaction_currency, transaction_EQINR, is_verified, transaction_remarks');
            $this -> db -> from('transaction_master');
            $this -> db -> join('transaction_mode_master', 'transaction_mode_master.transaction_mode_id = transaction_master.transaction_mode');
            $this -> db -> join('member_master', 'transaction_member_id = member_id');
            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
            return array();
        }

        public function getWaiveOffTransactions()
        {
            $sql = "Select transaction_id, transaction_amount, transaction_remarks, transaction_dor
                    From transaction_master
                    Where is_waived_off = 1";
            $query = $this->db->query($sql);
            if($query->num_rows() == 0)
                return array();
            return $query->result();
        }

        public function verifyDetails($update_data, $transaction_id)
        {
            return $this -> db -> update('transaction_master', $update_data, array("transaction_id" => $transaction_id));
        }

        public function getMemberTransactions($memberID)
        {
            $this -> db -> select('member_name,transaction_bank, transaction_number, transaction_mode_name, transaction_amount, transaction_date, transaction_currency, transaction_EQINR, is_verified, transaction_remarks');
            $this -> db -> from('transaction_master');
            $this -> db -> join('transaction_mode_master', 'transaction_mode_master.transaction_mode_id = transaction_master.transaction_mode');
            $this -> db -> join('member_master', 'transaction_member_id = member_id');
            $this -> db -> where('member_id',$memberID);
            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
            else
                return array();
        }

    }
