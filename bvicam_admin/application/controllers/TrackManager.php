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
    private $member_id;

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__) . '/../config/privileges.php');
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');
        if (!file_exists(APPPATH . 'views/pages/TrackManager/' . $page . '.php')) {
            show_404();
        }
        if (isset($privilege['Page']['TrackManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['TrackManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/TrackManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function trackAttendance($paper_id,$member_id=5413)
    {
        $page = "markAttendance";
        $this->load->model('attendance_model');
        $this->data['attendance']=$this->attendance_model->getDeskAttendance($member_id,$paper_id);

        $this->index($page);
    }

    public function getTrackMember($track_id = 0)
    {
        $page = "getMember";
        $this->load->helper('url');
        $this->load->model('attendance_model');
        $member_id = $this->input->post('member');
        if ($member_id > 0) {
            $this->load->model('paper_status_model');
            $this->load->model('track_model');
            $this->data['papers'] = $this->paper_status_model->getTrackPapersInfo($member_id, $track_id);
        }
        $paper_id=$this->input->post('paper');
        if($paper_id>0)
        {
            redirect("/TrackManager/trackAttendance/".$paper_id."/".$member_id);
        }

        $this->index($page);
    }

    public function Home()
    {
        $this->load->helper('url');
        $page = "selectTrack";
        $this->load->model('track_model');
        $this->data['tracks'] = $this->track_model->getAllTracks(EVENT_ID);
        $track_id = $this->input->post('track');
        if ($track_id > 0) {
            redirect("/TrackManager/getTrackMember/$track_id");
        }

        $this->index($page);
    }


}
