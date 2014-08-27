<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/19/14
 * Time: 4:02 PM
 */

class AccessModel extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        $this->dbCon = $this->load->database('default', TRUE);
    }

    public function hasPrivileges($privileges = array())
    {
        if(!isset($_SESSION['current_role_id']))
        {
            $this->load->model('RoleModel');
            $_SESSION['current_role_id'] = $this->RoleModel->getRoleId($_SESSION['dbUserName']);
        }
        $roleId = $_SESSION['current_role_id'];
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

    public function getLoadableComponents($componentPrivs = array())
    {
        $loadableComponents = array();
        foreach($componentPrivs as $component=>$privs)
        {
            if($this->hasPrivileges($privs))
            {
                $loadableComponents[] = $component;
            }
        }
        return $loadableComponents;
    }

        /*$this->load->model('RoleModel');
        if(!isset($_SESSION['current_role_id']))
        {
        $_SESSION['current_role_id'] = $this->RoleModel->getRoleId($_SESSION['dbUserName']);
        }
        $roleId = $_SESSION['current_role_id'];
        $rolePrivileges = $this->RoleModel->getRolePrivileges($roleId);
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