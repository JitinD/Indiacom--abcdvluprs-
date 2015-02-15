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

    public function getDeskAttendance($member_id, $paper_id)
    {
        $sql = "Select attendance_master.is_present_on_desk,attendance_master.is_present_in_hall
                From
                   paper_latest_version
                    Join
                  submission_master
                  On paper_latest_version.paper_id = submission_master.submission_paper_id
                    JOIN
                   attendance_master
                    On submission_master.submission_id = attendance_master.submission_id
                Where
                  submission_member_id = ? And
                  submission_dirty = 0 AND
                  submission_paper_id= ? AND
                  review_result_id = ?";
        $query = $this->db->query($sql, array($member_id, $paper_id, REVIEW_RESULT_ACCEPTED_ID));
        if ($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function updateAttendance($member_id,$paper_id)
    {

    }
}