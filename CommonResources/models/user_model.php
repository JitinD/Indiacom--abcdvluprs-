<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/10/14
 * Time: 4:36 PM
 */

class User_model extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        if(isset($_SESSION['sudo']))
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

    public function addUser($userDetails)
    {
        $this->dbCon->insert('user_master', $userDetails);
        if(!$this->dbCon->trans_status())
        {
            throw new InsertException("Error inserting into user_master", mysql_error(), mysql_errno());
        }
    }

    public function assignRoleToUser($userId, $roleId)
    {
        $details = array(
            "user_id" => $userId,
            //"event_id" => $eventId,
            "role_id" => $roleId
        );
        $this->dbCon->insert('user_event_role_mapper', $details);
    }

    public function enableUser($userId)
    {
        $sql = "Update user_master Set user_dirty = 0
                Where user_id = ? And user_dirty = 1";
        $query = $this->dbCon->query($sql, array($userId));
        return $this->dbCon->trans_status();
    }

    public function disableUser($userId)
    {
        $sql = "Update user_master Set user_dirty = 1
                Where user_id = ? And user_dirty = 0";
        $query = $this->dbCon->query($sql, array($userId));
        return $this->dbCon->trans_status();
    }

    public function deleteUser($userId)
    {
        $sql = "Delete From user_master
                Where user_id = ?";
        $query = $this->dbCon->query($sql, array($userId));
        if(!$this->db->trans_status())
        {
            throw new DeleteException("Error deleting user", mysql_error(), mysql_errno());
        }
    }

    public function enableUserRole($userId, $roleId)
    {
        $sql = "Update user_event_role_mapper
                Set user_event_role_mapper_dirty = 0
                Where user_id = ? And role_id = ?
                      And user_event_role_mapper_dirty = 1";
        $query = $this->dbCon->query($sql, array($userId, $roleId));
        return $this->dbCon->trans_status();
    }

    public function disableUserRole($userId, $roleId)
    {
        $sql = "Update user_event_role_mapper
                Set user_event_role_mapper_dirty = 1
                Where user_id = ? And role_id = ?
                      And user_event_role_mapper_dirty = 0";
        $query = $this->dbCon->query($sql, array($userId, $roleId));
        return $this->dbCon->trans_status();
    }

    public function deleteUserRole($userId, $roleId)
    {
        $sql = "Delete From user_event_role_mapper
                Where user_id = ? And role_id = ?";
        $query = $this->dbCon->query($sql, array($userId, $roleId));
        return $this->dbCon->trans_status();
    }

    public function deleteRoleMappings($roleId)
    {
        $sql = "Delete From user_event_role_mapper
                Where role_id = ?";
        $query = $this->dbCon->query($sql, array($roleId));
        return $this->dbCon->trans_status();
    }

    public function deleteUserMappings($userId)
    {
        $sql = "Delete From user_event_role_mapper
                Where user_id = ?";
        $query = $this->dbCon->query($sql, array($userId));
        return $this->dbCon->trans_status();
    }

    public function getAllUsersInclDirty()
    {
        $sql = "Select * From user_master";
        $query = $this->dbCon->query($sql);
        return $query->result();
    }

    public function getUserInfo($userId)
    {
        $sql = "Select * From user_master Where user_id = ? And user_dirty = 0";
        $query = $this->dbCon->query($sql, array($userId));
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function getUserInfoByEmail($userEmail)
    {
        $sql = "Select * From user_master Where user_email = ? And user_dirty = 0";
        $query = $this->dbCon->query($sql, array($userEmail));
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function getUserRoles($userId)
    {
        $sql = "Select role_master.role_id, role_name, role_application_id, user_event_role_mapper_dirty
                From user_event_role_mapper
                      Join role_master On user_event_role_mapper.role_id = role_master.role_id
                Where user_id = ? And user_event_role_mapper_dirty = 0";
        $query = $this->dbCon->query($sql, array($userId));
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    public function getRegistrarUsers()
    {
        $sql = "Select * From user_master
                Where user_id IN
                        (Select user_registrar From user_master)";
        $query = $this->dbCon->query($sql);
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }
}