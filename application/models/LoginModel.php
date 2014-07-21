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
    private $loginType;

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setLoginType($loginType)
    {
        $this->loginType = $loginType;
    }

    public function __construct()
    {
        $this->load->database();
    }

    public function authenticate()
    {
        if($this->loginType == 'M')
        {
              return $this->memberAuthenticate();
        }
        else if($this->loginType == 'A')
        {
            return $this->adminAuthenticate();
        }
        return false;
    }

    private function memberAuthenticate()
    {
        $sql = "Select * From Member_Master Where member_id=? AND member_pass = ? AND member_dirty = 0";
        $query = $this->db->query($sql, array($this->username, $this->password));
        if($query->num_rows() == 1)
        {
            $_SESSION['role_id'] = 0;
            $_SESSION['current_role_id'] = 0;
            $_SESSION['member_id'] = $this->username;
            $row = $query->row();
            $_SESSION['member_name'] = $row->member_name;
            return true;
        }
        return false;
    }

    private function adminAuthenticate()
    {
        $sql = "Select * From User_Master Where user_id=? AND user_password = ? AND user_dirty = 0";
        $query = $this->db->query($sql, array($this->username, $this->password));
        if($query->num_rows() == 1)
        {
            $sql = "SELECT event_id, role_id FROM user_event_role_mapper WHERE user_id = ? ORDER BY event_id";
            $query = $this->db->query($sql, array($this->username));
            foreach($query->result() as $row)
            {
                array_push($_SESSION['role_id'][$row->event_id], $row->role_id);
            }
            $_SESSION['user_id'] = $this->username;
            $row = $query->row();
            $_SESSION['current_role_id'] = $row->role_id;
            return true;
        }
        return false;
    }
}