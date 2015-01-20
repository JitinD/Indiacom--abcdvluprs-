<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/19/15
 * Time: 4:36 PM
 */

class Registration_category_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllRegistrationCategories()
    {
        $sql = "Select * From registration_category_master";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }
}