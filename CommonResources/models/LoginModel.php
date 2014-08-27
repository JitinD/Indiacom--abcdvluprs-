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

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setLoginType($loginType)
    {
        $this->loginType = $loginType;
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
        $this->load->model('RoleModel');
        $this->load->model('MemberModel');
        $encrypted_pass = md5($this->password);
        $memberInfo = $this->MemberModel->getMemberInfo($this->username);
        if($encrypted_pass == $memberInfo['member_password'])
        {
            $roleName = "Author";
            $_SESSION['authenticated'] = true;
            if(($_SESSION['role_id'] = $this->RoleModel->getRoleId($roleName)) == false)
            {
                $this->error = $roleName . " role not defined. Contact admin";
                return false;
            }
            $_SESSION['current_role_id'] = $_SESSION['role_id'];
            $_SESSION['member_id'] = $this->username;
            $_SESSION['member_name'] = $memberInfo['member_name'];
            $this->setDbLoginCredentials($roleName);
            return true;
        }
        $this->error = "Incorrect credentials";
        return false;
    }

    private function adminAuthenticate()
    {
        $this->load->model('UserModel');
        $userInfo = $this->UserModel->getUserInfoByEmail($this->username);
        if($userInfo != false && $userInfo->user_password == $this->password)
        {
            $userRolesEvents = $this->UserModel->getUserEventsAndRoles($userInfo->user_id);
            foreach($userRolesEvents as $row)
            {
                $_SESSION['role_id'][$row->event_id][] = $row->role_id;
            }
//            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $userInfo->user_id;
            $_SESSION['user_name'] = $userInfo->user_name;
            return true;
        }
        return false;
    }

    public function adminSetRoleEvent($roleId, $eventId)
    {
        $this->load->model('RoleModel');
        $_SESSION['current_role_id'] = $roleId;
        $_SESSION['current_event_id'] = $eventId;
        $_SESSION['authenticated'] = true;
        $roleInfo = $this->RoleModel->getRoleDetails($roleId);
        $roleName = $roleInfo->role_name;
        $this->setDbLoginCredentials($roleName);
    }

    private function setDbLoginCredentials($roleName)
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