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

    public function getUserInfo($userId)
    {
        $sql = "Select * From user_master Where user_id = ? And user_dirty = 0";
        $query = $this->query($sql, array($userId));
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function getUserInfoByEmail($userEmail)
    {
        $sql = "Select * From user_master Where user_email = ? And user_dirty = 0";
        $query = $this->query($sql, array($userEmail));
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function getUserEventAndRoles($userId)
    {
        $sql = "Select event_id, role_id From user_event_role_mapper
                Where user_id = ? And user_event_role_mapper_dirty = 0
                Order By event_id";
        $query = $this->query($sql, array($userId));
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        return false;
    }
}