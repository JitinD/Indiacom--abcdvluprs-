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
    private $entity = "attendance_master";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function assignId()
    {
        //$sql = "SELECT max(cast(`member_id` as UNSIGNED))as `attendance_id` from $entity";
        /*$sql = "SELECT `attendance_id` from $this -> entity";

        $query = $this->db->query($sql);

        if($query->num_rows()==0)
            return 1;

        $attendance_id_array = $query->row_array();
        $attendance_id = $attendance_id_array['attendance_id'] + 1;*/

        $sql = "SELECT max(`attendance_id`) from $this -> entity";

        $query = $this->db->query($sql);

        if($query->num_rows()==0)
            return 1;

        $attendance_id_object = $query->row();
        $attendance_id = $attendance_id_object -> attendance_id;

        return $attendance_id;
    }


    public function markDeskAttendance($attendanceRecord=array())
    {
        $record = $this->getAttendanceRecord($attendanceRecord['submission_id']);

        if($record==null)
        {
            $attendanceRecord['attendance_id']=$this->assignId();
            $this -> db -> insert($this -> entity, $attendanceRecord);
        }
        else
        {
            $this -> db -> where('attendance_id', $attendanceRecord -> attendance_id);
            $this -> db -> update($this -> entity, $attendanceRecord);
        }

        return $this->db->trans_status;
    }

    public function getAttendanceRecord($submission_id)
    {
        $sql="Select * from
              attendance_master
              where
              submission_id=?
              ";
        $query = $this->db->query($sql, array($submission_id));
        if ($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function markTrackAttendance($attendanceRecord=array())
    {
        $this -> db -> update($attendanceRecord);
        return $this->db->trans_status;
    }

}