<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 8:05 PM
 */

class Database_user_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addUser($userDetails = array())
    {
        $this->db->insert('database_user', $userDetails);
        return $this->db->trans_status();
    }

    public function deleteUser($userId)
    {
        $sql = "Delete From database_user Where database_user_name = ?";
        $query = $this->db->query($sql, array($userId));
        return $this->db->trans_status();
    }
}