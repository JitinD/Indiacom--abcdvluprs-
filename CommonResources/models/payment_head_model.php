<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 11:27 PM
 */

class Payment_head_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllPayheadDetails()
    {
        $sql = "Select * From payment_head_master";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getPayheadDetails($payheadId)
    {
        $sql = "Select * From payment_head_master
                Where payment_head_id = ?";
        $query = $this->db->query($sql, array($payheadId));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function getPaymentHeadId($payHeadName)
    {
        $sql = "Select payment_head_id
                From payment_head_master
                Where payment_head_name = ?";
        $query = $this->db->query($sql, array($payHeadName));
        if($query->num_rows() == 0 || $query->num_rows() > 1)
            return null;
        $row = $query->row();
        return $row->payment_head_id;
    }
}