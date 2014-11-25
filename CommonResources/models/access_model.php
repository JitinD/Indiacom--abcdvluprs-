<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/19/14
 * Time: 4:02 PM
 */

class Access_model extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        $_SESSION['sudo'] = true;
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

    public function hasPrivileges($privileges = array())
    {
        if(!isset($_SESSION[APPID]['current_role_id']))
        {
            $_SESSION['sudo'] = true;
            $this->load->model('role_model');
            $_SESSION[APPID]['current_role_id'] = $this->role_model->getRoleId($_SESSION[APPID]['dbUserName']);
        }
        $roleId = $_SESSION[APPID]['current_role_id'];
        $sql = "Select privilege_id From privilege_role_mapper Where role_id = ? AND privilege_role_mapper_dirty = 0";
        $query = $this->dbCon->query($sql, array($roleId));

        foreach($query->result_array() as $row)
        {
            $privileges = array_diff($privileges, $row);
        }
        if(count($privileges) == 0)
        {
            return true;
        }
        return false;
    }

    public function getLoadableDashboardComponents($components = array())
    {
        $loadableComponents = array();
        foreach($components as $dashComponent=>$subComponents)
        {
            foreach($subComponents as $subComponentPriv)
            {
                if($this->hasPrivileges($subComponentPriv))
                {
                    $loadableComponents[] = $dashComponent;
                    break;
                }
            }
        }
        return $loadableComponents;
    }

        /*$this->load->model('role_model');
        if(!isset($_SESSION[APPID]['current_role_id']))
        {
        $_SESSION[APPID]['current_role_id'] = $this->role_model->getRoleId($_SESSION[APPID]['dbUserName']);
        }
        $roleId = $_SESSION[APPID]['current_role_id'];
        $rolePrivileges = $this->role_model->getRolePrivileges($roleId);
        $rolePrivs = array();
        $loadableComponents = array();
        foreach($rolePrivileges as $privilege)
        {
            $rolePrivs[] = $privilege->privilege_id;
        }
        foreach($componentPrivs as $component=>$privs)
        {
            $diffPrivs = array_diff($privs, $rolePrivs);
            if(count($diffPrivs) == 0)
        }*/
}