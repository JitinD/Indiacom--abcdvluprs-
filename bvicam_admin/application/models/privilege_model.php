<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/2/14
 * Time: 5:55 PM
 */

class Privilege_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addPrivilege($privilegeDetails = array())
    {
        $this->db->insert('privilege_master', $privilegeDetails);
        return $this->db->trans_status();
    }

    public function newPrivilege($privilegeDetails = array())
    {
        $sql = "Select privilege_id From privilege_master Where privilege_entity = ? And privilege_operation = ?";  //do not check for dirty
        $query = $this->db->query($sql, array($privilegeDetails['privilege_entity'], $privilegeDetails['privilege_operation']));
        if($query->num_rows() == 0)
        {
            $privilegeDetails['privilege_id'] = $this->assignPrivilegeId();
            $this->db->insert('privilege_master', $privilegeDetails);
            if($this->db->trans_status() == false)
                return false;
            $query = $this->db->query($sql, array($privilegeDetails['privilege_entity'], $privilegeDetails['privilege_operation']));
        }
        $row = $query->row();
        return $row->privilege_id;
    }

    private function assignPrivilegeId()
    {
        $sql = "Select max(cast(privilege_id as UNSIGNED)) as privilege_id From privilege_master Order By privilege_id Desc Limit 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->privilege_id + 1;
    }

    public function getPrivilegeDetails($privilegeIds = array(), $extraQuery = "")
    {
        $sql = "Select * From privilege_master Where privilege_id IN (" . implode(',', $privilegeIds) . ") " . $extraQuery;
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return null;
        return $query->result();
    }
}