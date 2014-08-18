<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/10/14
 * Time: 4:36 PM
 */

class UserModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addUser($userDetails)
    {
        $this->db->insert('user_master', $userDetails);
        return $this->db->trans_status();
    }

    public function assignEventRoleToUser($userId, $eventId, $roleId)
    {
        $details = array(
            "user_id" => $userId,
            "event_id" => $eventId,
            "role_id" => $roleId
        );
        $this->db->insert('user_event_role_mapper', $details);
    }

    public function enableUser($userId)
    {
        $sql = "Update user_master Set user_dirty = 0
                Where user_id = ? And user_dirty = 1";
        $query = $this->db->query($sql, array($userId));
        return $this->db->trans_status();
    }

    public function disableUser($userId)
    {
        $sql = "Update user_master Set user_dirty = 1
                Where user_id = ? And user_dirty = 0";
        $query = $this->db->query($sql, array($userId));
        return $this->db->trans_status();
    }

    public function enableUserEventRole($userId, $eventId, $roleId)
    {
        $sql = "Update user_event_role_mapper
                Set user_event_role_mapper_dirty = 0
                Where user_id = ? And event_id = ? And role_id = ?
                      And user_event_role_mapper_dirty = 1";
        $query = $this->db->query($sql, array($userId, $eventId, $roleId));
        return $this->db->trans_status();
    }

    public function disableUserEventRole($userId, $eventId, $roleId)
    {
        $sql = "Update user_event_role_mapper
                Set user_event_role_mapper_dirty = 1
                Where user_id = ? And event_id = ? And role_id = ?
                      And user_event_role_mapper_dirty = 0";
        $query = $this->db->query($sql, array($userId, $eventId, $roleId));
        return $this->db->trans_status();
    }

    public function deleteUserEventRole($userId, $eventId, $roleId)
    {
        $sql = "Delete From user_event_role_mapper
                Where user_id = ? And event_id = ? And role_id = ?";
        $query = $this->db->query($sql, array($userId, $eventId, $roleId));
        return $this->db->trans_status();
    }

    public function getAllUsersInclDirty()
    {
        $sql = "Select * From user_master";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getUserInfo($userId)
    {
        $sql = "Select * From user_master Where user_id = ? And user_dirty = 0";
        $query = $this->db->query($sql, array($userId));
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function getUserInfoByEmail($userEmail)
    {
        $sql = "Select * From user_master Where user_email = ? And user_dirty = 0";
        $query = $this->db->query($sql, array($userEmail));
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function getUserEventsAndRoles($userId)
    {
        $sql = "Select event_master.event_id, event_name, role_master.role_id, role_name, user_event_role_mapper_dirty
                From user_event_role_mapper
                      Join event_master On user_event_role_mapper.event_id = event_master.event_id
                      Join role_master On user_event_role_mapper.role_id = role_master.role_id
                Where user_id = ?
                Order By event_id";
        $query = $this->db->query($sql, array($userId));
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }
}