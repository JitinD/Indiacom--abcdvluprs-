<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/21/15
 * Time: 7:58 PM
 */

class Transaction_mode_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllTransactionModes()
    {
        $sql = "Select * From transaction_mode_master
                Where transaction_mode_dirty = 0";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getTransactionModeDetails($trans_mode_id)
    {
        $sql = "Select * From transaction_mode_master
                Where transaction_mode_id = ?";
        $query = $this->db->query($sql, array($trans_mode_id));
        if($query->num_rows() == 0)
            return array();
        return $query->row();
    }
}