<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/17/15
 * Time: 3:45 PM
 */
class CertificateManager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function markOutwardNumber_AJAX()
    {
        $this->load->model("certificate_model");
        $submission_id = $this->input->post('submissionId');
        $outward_number = $this->input->post('certificate_outward_no');
        $certificateRecord = array(
            'event_id' => EVENT_ID,
            'submission_id' => $submission_id,
            'certificate_outward_number' => $outward_number,
            'is_certificate_given' => 0
        );

        echo json_encode($this->certificate_model->submitCertificateData($certificateRecord));
    }

    public function markCertificateGiven_AJAX()
    {
        $this->load->model("certificate_model");
        $this->load->model('attendance_model');

        $submission_id = $this->input->post('submissionId');
        $is_certificate_given = $this->input->post('is_certificate_given');
        $certificateRecord = $this->certificate_model->getCertificateRecord($submission_id);
        $attendanceRecord = $this->attendance_model->getAttendanceRecord($submission_id);

        if(!isset($attendanceRecord) || (isset($attendanceRecord) && !$attendanceRecord['is_present_in_hall']) || (isset($attendanceRecord) && !$attendanceRecord['is_present_on_desk']) || !isset($certificateRecord['certificate_outward_number']))
            echo json_encode(false);

        if ($certificateRecord != null)
        {
            $certificateRecord['is_certificate_given'] = $is_certificate_given;
            echo json_encode($this->certificate_model->submitCertificateData($certificateRecord));
        }
    }

    public function removeCertificateRecord_AJAX()
    {
        $this->load->model("certificate_model");
        $submission_id = $this->input->post('submissionId');
        $certificateRecord = $this->certificate_model->getCertificateRecord($submission_id);
        if($certificateRecord!=null)
        {
            echo json_encode($this->certificate_model->deleteCertificateRecord($submission_id));
        }

    }
}