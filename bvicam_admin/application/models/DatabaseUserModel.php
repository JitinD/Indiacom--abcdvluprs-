<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 8:05 PM
 */

class DatabaseUserModel extends CI_Model
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
}