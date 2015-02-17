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

    public function markDeskAttendance_AJAX()
    {
        $this->load->model("attendance_model");
        $this->load->model("submission_model");

        $member_id = $this->input->post('memberId');
        $paper_id = $this->input->post('paperId');
        $is_present = $this->input->post('isPresent');

        $submission_id = $this->submission_model->getSubmissionID($member_id, $paper_id);

        $attendanceRecord = array(
            'event_id' => EVENT_ID,
            'submission_id' => $submission_id,
            'is_present_on_desk' => $is_present
        );

        echo json_encode($this->attendance_model->markDeskAttendance($attendanceRecord));
    }

    public function markTrackAttendance_AJAX()
    {
        $this->load->model("attendance_model");
        $this->load->model("submission_model");

        $member_id = $this->input->post('memberId');
        $paper_id = $this->input->post('paperId');
        $is_present = $this->input->post('isPresent');
        $submission_id_array = $this->submission_model->getSubmissionID($member_id, $paper_id);
        $submission_id = $submission_id_array->submission_id;

        $track_attendance = $this->attendance_model->getAttendanceRecord($submission_id);

        if ($track_attendance->is_present_on_desk == 1) {
            $track_attendance['is_present_in_hall'] = $is_present;
            echo json_encode($this->attendance_model->markTrackAttendance("attendance_master", $track_attendance));
        }
        else {
            echo json_encode(false);
        }
    }
}