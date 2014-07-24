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
    private $member_name;
    private $loginType;

    public function __construct()
    {
        $this->load->database();

    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function fetch()
    {
        $this -> db -> select('member_pass,member_name');
        $this -> db -> where('member_id', $this -> username);
        $query = $this -> db -> get('member_master');
        $member_pass_array = $query -> row_array();
        $this->password=$member_pass_array['member_pass'];
        $this->member_name=$member_pass_array['member_name'];
    }

//    public function setPassword($password)
//    {
//        $this->password = $password;
//    }




    public function setLoginType($loginType)
    {
        $this->loginType = $loginType;
    }


    public function authenticate($password)
    {
        if($this->loginType == 'M')
        {
              return $this->memberAuthenticate($password);
        }
        else if($this->loginType == 'A')
        {
            return $this->adminAuthenticate();
        }
        return false;
    }

    private function memberAuthenticate($password)
    {
        $this->load->library('encrypt');
        $encrypted_pass = $this->password;
        $decrypted_pass = $this->encrypt->decode($encrypted_pass);
        if($decrypted_pass == $password)
        {
            $_SESSION['authenticated'] = true;
            $_SESSION['role_id'] = 0;
            $_SESSION['current_role_id'] = 0;
            $_SESSION['member_id'] = $this->username;
            $_SESSION['member_name'] = $this->member_name;
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
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $this->username;
            $row = $query->row();
            $_SESSION['current_role_id'] = $row->role_id;
            return true;
        }
        return false;
    }
}