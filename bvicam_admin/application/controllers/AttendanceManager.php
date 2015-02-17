<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/16/15
 * Time: 10:24 AM
 */
class AttendanceManager extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();

    }

    public function MarkDeskAttendance($member_id, $paper_id, $is_present)
    {
        $this->load->model("attendance_model");
        $this->load->model("submission_model");
        $submission_id_array = $this->submission_model->getSubmissionID($member_id, $paper_id);
        $submission_id = $submission_id_array->submission_id;
        $attendance_record = array(
            'event_id' => EVENT_ID,
            'member_id' => "",
            'submission_id' => $submission_id,
            'is_present_on_desk' => $is_present
        );
        $this->attendance_model->markDeskAttendance("attendance_master", $attendance_record);
    }

    public function MarkTrackAttendance($member_id, $paper_id, $is_present)
    {
        $this->load->model("attendance_model");
        $this->load->model("submission_model");
        $submission_id_array = $this->submission_model->getSubmissionID($member_id, $paper_id);
        $submission_id = $submission_id_array->submission_id;
        $track_attendance = $this->attendance_model->checkDeskAttendance($submission_id);
        if ($track_attendance->is_present_on_desk == 1) {
            $desk_attendance['is_present_in_hall'] = $is_present;
            return json_encode($this->attendance_model->markTrackAttendance("attendance_master", $track_attendance));
        }
        else {
            return json_encode(false);
        }
    }


}
