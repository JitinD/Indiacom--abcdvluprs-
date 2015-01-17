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

        public function verifyDetails($update_data, $transaction_id)
        {
            return $this -> db -> update('transaction_master', $update_data, array("transaction_id" => $transaction_id));
        }
    }
