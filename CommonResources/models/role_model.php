<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 5:42 PM
 */

class Role_model extends CI_Model
{
    private $dbCon;
    public $error;
    public function __construct()
    {
        if(false && isset($_SESSION['sudo']))
        {
            $this->dbCon = $this->load->database(DBGROUP, TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $this->load->database();
            $this->dbCon = $this->db;
        }
    }

    public function addRole(&$roleDetails)
    {
        $this->dbCon->insert('role_master', $roleDetails);
        if($this->dbCon->trans_status() == false)
            throw new Exception("Error inserting into role_master." . mysql_error());
        $sql = "Select role_id From role_master Where role_name = ?";
        $query = $this->dbCon->query($sql, array($roleDetails['role_name']));
        $row = $query->row();
        $roleDetails['role_id'] = $row->role_id;
        return true;
    }

    public function assignPrivileges($roleId, $privileges = array())
    {
        $details['role_id'] = $roleId;
        foreach($privileges as $privilegeId)
        {
            $details['privilege_id'] = $privilegeId;
            $this->dbCon->insert('privilege_role_mapper', $details);
        }
//        if(!$this->dbCon->trans_status())
//        {
//            $this->error = "One or more privileges already assigned to role";
//            throw new Exception("Error inserting into privilege_role_mapper." . mysql_error());
//        }
        return $this->dbCon->trans_status();
    }

    public function disablePrivilege($roleId, $privilegeId)
    {
        $sql = "Update privilege_role_mapper Set privilege_role_mapper_dirty = 1
                Where role_id = ? And privilege_id = ? And privilege_role_mapper_dirty = 0";
        $query = $this->dbCon->query($sql, array($roleId, $privilegeId));
        return $this->dbCon->trans_status();
    }

    public function enablePrivilege($roleId, $privilegeId)
    {
        $sql = "Update privilege_role_mapper Set privilege_role_mapper_dirty = 0
                Where role_id = ? And privilege_id = ? And privilege_role_mapper_dirty = 1";
        $query = $this->dbCon->query($sql, array($roleId, $privilegeId));
        return $this->dbCon->trans_status();
    }

    public function deletePrivilege($roleId, $privilegeId)
    {
        $sql = "Delete From privilege_role_mapper Where role_id = ? And privilege_id = ?";
        $query = $this->dbCon->query($sql, array($roleId, $privilegeId));
        return $this->dbCon->trans_status();
    }

    public function deleteAllRolePrivileges($roleId)
    {
        $sql = "Delete From privilege_role_mapper Where role_id = ?";
        $query = $this->dbCon->query($sql, array($roleId));
        return $this->dbCon->trans_status();
    }

    public function createDbUser($username, $privileges = array())
    {
        if(isset($_SESSION['sudo']))
        {
            $dbCon = $this->load->database(DBGROUP, TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $dbCon = $this->dbCon;
        }

        $this->load->model('database_user_model');
        $host = rtrim(HOST, '/');
        $pwd = 1234;
        $sql = "Create User '$username'@'$host' Identified By '$pwd'";
        $dbCon->query($sql);
        $_SESSION['sudo'] = true;
        $this->grantPrivileges($username, $privileges);
        $this->database_user_model->addUser(array('database_user_name'=>$username, 'database_user_password'=>$pwd));
    }

    public function dropDbUser($username)
    {
        if(isset($_SESSION['sudo']))
        {
            $dbCon = $this->load->database(DBGROUP, TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $dbCon = $this->dbCon;
        }

        $this->load->model('database_user_model');
        $host = rtrim(HOST, '/');
        $sql = "Drop User '$username'@'$host'";
        $dbCon->query($sql);
        $this->database_user_model->deleteUser($username);
    }

    public function grantPrivileges($username, $privileges = array())
    {
        if(isset($_SESSION['sudo']))
        {
            $dbCon = $this->load->database(DBGROUP, TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $dbCon = $this->dbCon;
        }

        $this->load->model('privilege_model');
        $host = rtrim(HOST, '/');
        $privDetails = $this->privilege_model->getPrivilegeDetails($privileges);
        $privTypes = array();
        foreach($privDetails as $priv)
        {
            $privTypes[$priv->privilege_entity][] = $priv->privilege_operation;
        }
        foreach($privTypes as $entity=>$privType)
        {
            $sql = "Grant " . implode(',', $privType) . " On $entity To '$username'@'$host'";
            $dbCon->query($sql);
        }
    }

    public function revokePrivileges($username, $privileges = array())
    {
        if(isset($_SESSION['sudo']))
        {
            $dbCon = $this->load->database(DBGROUP, TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $dbCon = $this->dbCon;
        }

        $this->load->model('privilege_model');
        $host = rtrim(HOST, '/');
        $privDetails = $this->privilege_model->getPrivilegeDetails($privileges);
        $privTypes = array();
        foreach($privDetails as $priv)
        {
            $privTypes[$priv->privilege_entity][] = $priv->privilege_operation;
        }
        foreach($privTypes as $entity=>$privType)
        {
            $sql = "Revoke " . implode(',', $privType) . " On $entity From '$username'@'$host'";
            $dbCon->query($sql);
        }
    }

    public function enableRole($roleId)
    {
        $sql = "Update role_master Set role_dirty = 0
                Where role_id = ? And role_dirty = 1";
        $query = $this->dbCon->query($sql, array($roleId));
        return $this->dbCon->trans_status();
    }

    public function disableRole($roleId)
    {
        $sql = "Update role_master Set role_dirty = 1
                Where role_id = ? And role_dirty = 0";
        $query = $this->dbCon->query($sql, array($roleId));
        return $this->dbCon->trans_status();
    }

    public function deleteRole($roleId)
    {
        $sql = "Delete From role_master Where role_id = ?";
        $query = $this->dbCon->query($sql, array($roleId));
        return $this->dbCon->trans_status();
    }

    public function getAllRoles()
    {
        $sql = "Select * From role_master Where role_dirty = 0";
        $query = $this->dbCon->query($sql);
        return $query->result();
    }

    public function getAllRolesInclDirty()
    {
        $sql = "Select * From role_master";
        $query = $this->dbCon->query($sql);
        return $query->result();
    }

    //Gets only enabled privileges
    public function getRolePrivileges($roleId)
    {
        $sql = "Select * From privilege_role_mapper Where role_id = ? And privilege_role_mapper_dirty = 0";
        $query = $this->dbCon->query($sql, array($roleId));
        if($query->num_rows() == 0)
            return null;
        return $query->result();
    }

    //Gets disabled privileges also
    public function getRolePrivilegesInclDirty($roleId)
    {
        $sql = "Select * From privilege_role_mapper Where role_id = ?";
        $query = $this->dbCon->query($sql, array($roleId));
        if($query->num_rows() == 0)
            return null;
        return $query->result();
    }

    public function getRoleDetails($roleId)
    {
        $sql = "Select * From role_master Where role_id = ? And role_dirty = 0";
        $query = $this->dbCon->query($sql, array($roleId));
        if($query->num_rows() == 1)
            return $query->row();
        return null;
    }

    public function getRoleId($roleName)
    {
        $sql = "Select role_id From role_master Where role_name = ? And role_dirty = 0";
        $query = $this->dbCon->query($sql, array($roleName));
        if($query->num_rows() == 0)
            return false;
        $row = $query->row();
        return $row->role_id;
    }
}