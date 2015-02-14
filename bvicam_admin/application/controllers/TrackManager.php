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
        }
        if(isset($privilege['Page']['TrackManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['TrackManager'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/TrackManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function getTracks()
    {
        $page="selectTrack";
        $this->load->model('track_model');
        $this->data['tracks'] = $this->track_model->getAllTracks(EVENT_ID);
        $this->index($page);

    }

    public function trackAttendance()
    {
        $page="markAttendance";

        $this->index($page);
    }

}
