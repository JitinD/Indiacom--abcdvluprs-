<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/19/15
 * Time: 11:38 AM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class EventManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "EventManager";
        require(dirname(__FILE__) . '/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if (!file_exists(APPPATH . "views/pages/{$this->controllerName}/" . $page . '.php')) {
            show_404();
        }
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $sidebarData);
        //$this->load->view('templates/sidebar');
        $this->load->view("pages/{$this->controllerName}/" . $page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {

    }

    public function load()
    {
        if(!$this->checkAccess("load"))
            return;
        $page = "index";
        $this->load->model('event_model');

        $this->data['events'] = $this->event_model->getAllEventsInclDirty();

        $this->index($page);
    }

    public function newEvent()
    {
        if(!$this->checkAccess("newEvent"))
            return;
        $page = "newEvent";

        if($this->newEventSubmitHandle())
        {
            return;
        }
        $this->index($page);
    }

    private function newEventSubmitHandle()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('event_name', 'Event Name', 'required');

        if($this->form_validation->run())
        {
            $this->load->model('event_model');
            $this->load->model('track_model');
            $this->load->model('subject_model');
            $this->load->database();
            $this->db->trans_begin();
            $eventDetails = array(
                "event_name" => $this->input->post('event_name'),
                "event_description" => $this->input->post('event_desc'),
                "event_start_date" => $this->input->post('event_start_date'),
                "event_end_date" => $this->input->post('event_end_date'),
                "event_paper_submission_start_date" => $this->input->post('event_paper_submission_start_date'),
                "event_paper_submission_end_date" => $this->input->post('event_paper_submission_end_date'),
                "event_abstract_submission_end_date" => $this->input->post('event_abstract_submission_end_date'),
                "event_abstract_acceptance_notification" => $this->input->post('event_abstract_acceptance_notification'),
                "event_paper_submission_notification" => $this->input->post('event_paper_submission_notification'),
                "event_review_info_avail_after" => $this->input->post('event_review_info_avail_after'),
                "event_clear_min_dues_by" => $this->input->post('event_clear_min_dues_by'),
                "event_email" => $this->input->post('event_email')
            );
            $eventId = $this->event_model->newEvent($eventDetails);

            $sno = 0;
            $success = false;
            $tracks = $this->input->post('event_tracks');
            $maxSubsPerTrack = 20;
            $maxSno = count($tracks) * $maxSubsPerTrack;
            foreach($tracks as $trackNo=>$track)
            {
                if($track == null)
                    continue;
                $track_subjects = null;
                while($track_subjects == null && $sno <= $maxSno)
                {
                    $track_subjects = $this->input->post($sno++ . "_subjects");
                }
                if($track_subjects != null)
                {
                    $trackDetails = array(
                        "track_number" => $trackNo + 1  ,
                        "track_name" => $track
                    );
                    $trackId = $this->track_model->newTrack($trackDetails, $eventId);
                    $subCode = 1;
                    foreach($track_subjects as $subject)
                    {
                        if($subject == null)
                            continue;
                        $subjectDetails = array(
                            "subject_code" => $subCode++,
                            "subject_name" => $subject
                        );
                        $this->subject_model->newSubject($subjectDetails, $trackId);
                    }
                    $success = true;
                }
            }
            if($success)
                $success = $this->makeEventFolders($eventId);
            if($success)
            {
                $this->db->trans_commit();
            }
            else
                $this->db->trans_rollback();
            return true;
        }

        return false;
    }

    private function makeEventFolders($eventId)
    {
        $success = false;
        $path = SERVER_ROOT . UPLOAD_PATH . $eventId;
        $folders = array("compliance_reports", "convener_reviews", "papers", "reviewer_reviews");
        if(mkdir($path))
        {
            $path .= "/";
            foreach($folders as $folder)
            {
                if(!mkdir($path . $folder))
                {
                    $success = false;
                    break;
                }
                $success = true;
            }
        }
        return $success;
    }

    public function viewEvent()
    {

    }

    public function enableEvent_AJAX()
    {
        if(!$this->checkAccess("enableEvent_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('event_model');
        $this->form_validation->set_rules('eventId', 'Event Id', 'required');
        if($this->form_validation->run() && $this->event_model->enableEvent($this->input->post('eventId')))
        {
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function disableEvent_AJAX()
    {
        if(!$this->checkAccess("disableEvent_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('event_model');
        $this->form_validation->set_rules('eventId', 'Event Id', 'required');
        if($this->form_validation->run() && $this->event_model->disableEvent($this->input->post('eventId')))
        {
            echo true;
            return;
        }
        echo false;
        return;
    }
}

?>