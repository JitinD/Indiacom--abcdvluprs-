<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:19 PM
 */
class reports_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getQueryFields()
    {
        $sql="Select * from member_master";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0)
            return null;
        return $query->list_fields();
    }

    public function getQueryReport()
    {
        $sql="Select * from member_master";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0)
            return null;
        return $query->row_array();
    }
}
?>