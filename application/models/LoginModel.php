<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 16/7/14
 * Time: 3:37 PM
 */

class LoginModel extends CI_Model
{
    private $username;
    private $password;

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function __construct()
    {
        $this->load->database();
    }

    public function authenticate()
    {
        $sql = "Select * From Member_Master Where member_id=? AND member_pass = ?";
        $query = $this->db->query($sql, array($this->username, $this->password));
        if($query->num_rows() == 1)
        {
            return true;
        }
        return false;
    }
}