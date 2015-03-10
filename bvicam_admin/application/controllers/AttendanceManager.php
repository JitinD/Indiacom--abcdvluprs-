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

        $this->load->model('member_model');
        $this->load->model('paper_status_model');
        $this->load->model('payment_model');

        $member_id = $this->input->post('memberId');
        $paper_id = $this->input->post('paperId');

        $registrationCat = $this->member_model->getMemberCategory($member_id);
        $papers = $this->paper_status_model->getMemberAcceptedPapers($member_id);

        $papersInfo = $this->payment_model->calculatePayables(
            $member_id,
            DEFAULT_CURRENCY,
            $registrationCat,
            $papers,
            date("Y-m-d")
        );

        $payheads = $papersInfo[$paper_id]['payhead'];

        foreach($payheads as $index=>$payhead)
        {
            if($payhead->payment_head_name == "BR" || $payhead->payment_head_name == "EP")
            {
                if(isset($papersInfo[$paper_id]['paid']))
                    $pendingAmount = $papersInfo[$paper_id]['pending'][$index];

            }
        }

        if ((!isset($papersInfo[$paper_id]['paid'])) || (isset($papersInfo[$paper_id]['paid']) && $pendingAmount > 0))//(!isset($papersInfo[$paper_id]['pending']) || (isset($papersInfo[$paper_id]['pending']) && $papersInfo[$paper_id]['pending'] != 0))
        {
            echo json_encode(false);
        }
        else
        {
            $this->load->model("attendance_model");
            $this->load->model("submission_model");
            $is_present = $this->input->post('isPresent');

            $submission_id = $this->submission_model->getSubmissionID($member_id, $paper_id);

            $attendanceRecord = array(
                'event_id' => EVENT_ID,
                'submission_id' => $submission_id,
                'is_present_on_desk' => $is_present
            );

            echo json_encode($this->attendance_model->markAttendance($attendanceRecord));
        }
    }

    public function markTrackAttendance_AJAX()
    {
        $this->load->model("attendance_model");
        $submission_id = $this->input->post('submissionId');
        $is_present = $this->input->post('isPresent');

        $attendanceRecord = array(
            'event_id' => EVENT_ID,
            'submission_id' => $submission_id,
            'is_present_in_hall' => $is_present
        );

        echo json_encode($this->attendance_model->markAttendance($attendanceRecord));

    }


}