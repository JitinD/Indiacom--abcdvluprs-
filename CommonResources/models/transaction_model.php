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
            $this->insert('transaction_master', $transDetails);
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

        public function getTransactions()
        {
            $this -> db -> select('member_name, transaction_id, transaction_bank, transaction_number, transaction_mode_name, transaction_amount, transaction_date, transaction_currency, transaction_EQINR, is_verified, transaction_remarks');
            $this -> db -> from('transaction_master');
            $this -> db -> join('transaction_mode_master', 'transaction_mode_master.transaction_mode_id = transaction_master.transaction_mode');
            $this -> db -> join('member_master', 'transaction_member_id = member_id');
            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
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
    }
