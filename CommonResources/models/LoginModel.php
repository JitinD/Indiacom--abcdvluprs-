<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 16/7/14
 * Time: 3:37 PM
 */

class LoginModel extends CI_Model
{
    public $error;
    private $username;
    private $password;
    private $member_name;
    private $loginType;
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = $this->load->database('default', TRUE);
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function fetch()
    {
        $this -> dbCon -> select('member_password,member_name');
        $this -> dbCon -> where('member_id', $this -> username);
        $query = $this -> dbCon -> get('member_master');
        $member_pass_array = $query -> row_array();
        $this->password=$member_pass_array['member_password'];
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
        //$this->load->library('encrypt');
        $encrypted_pass = md5($password);
        $this->load->model('RoleModel');
        $roleName = "Author";
        //$decrypted_pass = $this->encrypt->decode($encrypted_pass);
        if($encrypted_pass == $this->password)
        {
            $_SESSION['authenticated'] = true;
            if(($_SESSION['role_id'] = $this->RoleModel->getRoleId($roleName)) == false)
            {
                $this->error = $roleName . " role not defined. Contact admin";
                return false;
            }
            $_SESSION['current_role_id'] = $_SESSION['role_id'];
            $_SESSION['member_id'] = $this->username;
            $_SESSION['member_name'] = $this->member_name;
            $this->getDbLoginCredentials($roleName);
            return true;
        }
        $this->error = "Incorrect credentials";
        return false;
    }

    private function adminAuthenticate()
    {
        $sql = "Select * From User_Master Where user_id=? AND user_password = ? AND user_dirty = 0";
        $query = $this->dbCon->query($sql, array($this->username, $this->password));
        if($query->num_rows() == 1)
        {
            $sql = "SELECT event_id, role_id FROM user_event_role_mapper WHERE user_id = ? ORDER BY event_id";
            $query = $this->dbCon->query($sql, array($this->username));
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

    private function getDbLoginCredentials($roleName)
    {
        $sql = "Select database_user_password From database_user Where database_user_name = ?";
        $query = $this->dbCon->query($sql, array($roleName));
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            $_SESSION['dbUserName'] = $roleName;
            $_SESSION['dbPassword'] = $row->database_user_password;
        }
    }
}