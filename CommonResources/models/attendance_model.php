<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/15/15
 * Time: 1:12 AM
 */
class Attendance_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function assignId($entity)
    {
        $sql = "SELECT max(cast(`member_id` as UNSIGNED))as `attendance_id` from $entity";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return 1;
        $attendance_id_array = $query->row_array();
        $attendance_id = $attendance_id_array['attendance_id'] + 1;
        return $attendance_id;
    }


    public function markDeskAttendance($entity,$attendanceRecord=array())
    {
        $attendanceRecord['attendance_id']=$this->assignId($entity);
        $this -> db -> insert($entity, $attendanceRecord);
        return $this->db->trans_status;
    }

    public function checkDeskAttendance($submission_id)
    {
        $sql="Select * from
              attendance_master
              where
              submission_id=?
              ";
        $query = $this->db->query($sql, array($submission_id));
        if ($query->num_rows() == 0)
            return array();
        return $query->row();
    }
    public function markTrackAttendance($entity,$attendanceRecord=array())
    {
        $this -> db -> update($entity,$attendanceRecord);
        return $this->db->trans_status;
    }

}