<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/17/15
 * Time: 3:45 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class CertificateManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "CertificateManager";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    public function markOutwardNumber_AJAX()
    {
        if(!$this->checkAccess("markOutwardNumber_AJAX"))
            return;
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
        if(!$this->checkAccess("markCertificateGiven_AJAX"))
            return;
        $this->load->model("certificate_model");
        $this->load->model('attendance_model');
        $this->load->model('submission_model');
        $this->load->model('paper_status_model');
        $this->load->model('payment_model');
        $this->load->model('member_model');

        $submission_id = $this->input->post('submissionId');
        $is_certificate_given = $this->input->post('is_certificate_given');
        $certificateRecord = $this->certificate_model->getCertificateRecord($submission_id);
        $attendanceRecord = $this->attendance_model->getAttendanceRecord($submission_id);

        $member_id = $this->submission_model->getMemberID($submission_id);
        $paper_id = $this->submission_model->getPaperID($submission_id);

        $papers = $this->paper_status_model->getTrackAcceptedPapersInfo($member_id);

        $registrationCat = $this->member_model->getMemberCategory($member_id);

        if(isset($registrationCat) && isset($papers))
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

        if(!isset($attendanceRecord) || (isset($attendanceRecord) && !$attendanceRecord['is_present_in_hall']) || !isset($certificateRecord['certificate_outward_number']) || (!isset($papersInfo[$paper_id]['paid'])) || (isset($papersInfo[$paper_id]['paid']) && $pendingAmount > 0))
            echo json_encode(false);

        if ($certificateRecord != null)
        {
            $certificateRecord['is_certificate_given'] = $is_certificate_given;
            echo json_encode($this->certificate_model->submitCertificateData($certificateRecord));
        }
    }

    public function removeCertificateRecord_AJAX()
    {
        if(!$this->checkAccess("removeCertificateRecord_AJAX"))
            return;
        $this->load->model("certificate_model");
        $submission_id = $this->input->post('submissionId');
        $certificateRecord = $this->certificate_model->getCertificateRecord($submission_id);
        if($certificateRecord!=null)
        {
            echo json_encode($this->certificate_model->deleteCertificateRecord($submission_id));
        }
    }
}