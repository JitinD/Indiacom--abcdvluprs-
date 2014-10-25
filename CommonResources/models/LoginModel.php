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
        if(isset($_SESSION['sudo']))
        {
            $this->dbCon = $this->load->database('default', TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $this->load->database();
            $this->dbCon = $this->db;
        }
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
            return $this->memberAuthenticate("Author");
        }
        else if($this->loginType == 'LM')
        {
            return $this->memberAuthenticate("LimitedAuthor", false);
        }
        else if($this->loginType == 'A')
        {
            return $this->adminAuthenticate();
        }
        return false;
    }

    private function memberAuthenticate($roleName, $encryption=true)
    {
        $_SESSION['sudo'] = true;
        $this->load->model('RoleModel');
        $_SESSION['sudo'] = true;
        $this->load->model('MemberModel');
        if($encryption)
            $encrypted_pass = md5($this->password);
        else
            $encrypted_pass = $this->password;
        $memberInfo = $this->MemberModel->getMemberInfo($this->username);
        if($encrypted_pass == $memberInfo['member_password'] && $memberInfo['member_is_activated']==1)
        {
            $_SESSION[APPID]['authenticated'] = true;
            if(($_SESSION[APPID]['role_id'] = $this->RoleModel->getRoleId($roleName)) == false)
            {
                $this->error = $roleName . " role not defined. Contact admin";
                return false;
            }
            $_SESSION[APPID]['current_role_id'] = $_SESSION[APPID]['role_id'];
            $_SESSION[APPID]['member_id'] = $this->username;
            $_SESSION[APPID]['member_name'] = $memberInfo['member_name'];
            $roleInfo = $this->RoleModel->getRoleDetails($_SESSION[APPID]['role_id']);
            if(!$this->setDbLoginCredentials($roleName, $roleInfo->role_application_id))
            {
                $this->error = "Application id for role does not match with current application";
                return false;
            }
            return true;
        }
        $this->error = "Incorrect credentials";
        return false;
    }

    private function adminAuthenticate()
    {
        $_SESSION['sudo'] = true;
        $this->load->model('UserModel');
        $userInfo = $this->UserModel->getUserInfoByEmail($this->username);
        if($userInfo != false && $userInfo->user_password == $this->password)
        {
            $userRoles = $this->UserModel->getUserRoles($userInfo->user_id);
            $_SESSION[APPID]['role_id'] = array();
            if(!empty($userRoles))
            {
                foreach($userRoles as $row)
                {
                    $_SESSION[APPID]['role_id'][] = $row->role_id;
                }
                $_SESSION[APPID]['authenticated'] = true;
                $_SESSION[APPID]['user_id'] = $userInfo->user_id;
                $_SESSION[APPID]['user_name'] = $userInfo->user_name;
                return true;
            }
            $this->error = "No active role assigned to user";
            return false;
        }
        $this->error = "Incorrect Credentials";
        return false;
    }

    public function adminSetRole($roleId)
    {
        if(isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated'])
            $_SESSION['sudo'] = true;
        $this->load->model('RoleModel');
        $roleInfo = $this->RoleModel->getRoleDetails($roleId);
        $roleName = $roleInfo->role_name;
        $appId = $roleInfo->role_application_id;
        if($this->setDbLoginCredentials($roleName, $appId))
        {
            $_SESSION[APPID]['current_role_id'] = $roleId;
            $_SESSION[APPID]['authenticated'] = true;
        }
    }

    private function setDbLoginCredentials($roleName, $appId)
    {
        $sql = "Select database_user_password From database_user Where database_user_name = ?";
        $query = $this->dbCon->query($sql, array($roleName));
        if($query->num_rows() == 1 && APPID == $appId."a")
        {
            $row = $query->row();
            $_SESSION[$appId."a"]['dbUserName'] = $roleName;
            $_SESSION[$appId."a"]['dbPassword'] = $row->database_user_password;
        }
        else
        {
            return false;
        }
        return true;
    }
}