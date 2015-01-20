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
}