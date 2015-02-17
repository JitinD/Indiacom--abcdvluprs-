<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 8:24 PM
 */
class TrackManager extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');

        if ( ! file_exists(APPPATH.'views/pages/TrackManager/'.$page.'.php'))
        {
            show_404();
            show_404();
        }
        if(isset($privilege['Page']['TrackManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['TrackManager'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/TrackManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }
    public function Home()
    {
        $page = "selectTrack";
        $this->load->helper('url');
        $this->load->model('track_model');
        $this->data['tracks'] = $this->track_model->getAllTracks(EVENT_ID);
        $_SESSION[APPID]['track_id']= $this->input->post('track');
        if ($_SESSION[APPID]['track_id']> 0) {
            redirect("/TrackManager/MemberDetails");
        }
        $this->index($page);
    }

    public function MemberDetails()
    {
        $page="getMember";
        $this->load->helper('url');
        $member_id=$this->input->post('member');
        if($member_id>0)
        {
            redirect("/TrackManager/AttendanceOnHall/".$_SESSION[APPID]['track_id']."/".$member_id);
        }
        $this->index($page);
    }
    public function AttendanceOnHall($track_id,$member_id)
    {
        $page="markAttendance";
        $this->load->model('paper_status_model');
        $this->load->model('attendance_model');
        $this->load->model('certificate_model');
        $this->load->model('submission_model');
        $this->load->model('certificate_model');
        $this->data['papers'] = $this->paper_status_model->getTrackAcceptedPapersInfo($member_id, $track_id);
        foreach ($this->data['papers'] as $paper) {
            $this->data['attendance'][$paper->paper_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);
            $this->data['certificate'][$paper->paper_id] = $this->certificate_model->getCertificateData($paper->submission_id);
        }
        $this->index($page);
    }

}
