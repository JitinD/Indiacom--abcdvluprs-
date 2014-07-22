<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 8:18 PM
 */
require(dirname(__FILE__).'/../config/privileges.php');
require(dirname(__FILE__).'/../utils/ViewUtils.php');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('EventModel');
        $this->load->model('TrackModel');
        $this->load->model('SubjectModel');
    }

    public function index()
    {

    }

    public function submitPaper()
    {
        $page = 'submitpaper';
        if(isset($privileges[$page]) && !$this->AccessModel->hasPrivileges($privileges[$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $data = loginModalInit();
        $data['navbarItem'] = pageNavbarItem($page);
        $data['events'] = $this->EventModel->getAllEvents();
        $this->load->view('templates/header', $data);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('paper_title', "Paper Title", "required");
        $this->form_validation->set_rules('event', 'Event', 'required');
        $this->form_validation->set_rules('track', 'Track', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('paper_doc', 'Paper', 'required');
        $this->form_validation->set_rules('main_author', 'Main Author', 'required');
        $this->form_validation->set_rules('authors', 'Author Id', 'required');

        if($this->form_validation->run())
        {
            $paperDetails = array(
                'paper_title' => $this->input->post('paper_title'),
                'paper_contact_author_id' => $this->input->post('main_author')
            );
        }
        else
        {
            $this->load->view('pages/'.$page, $data);
        }

        $this->load->view('templates/footer');
    }

    private function uploadPaperDoc($fileElem)
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|doc|docx';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        return true;
    }

    public function tracks()
    {
        $eventId = $this->input->post('eventId');
        echo $this->TrackModel->getAllTracks($eventId);
    }

    public function subjects()
    {
        $trackId = $this->input->post('trackId');
        echo $this->SubjectModel->getAllSubjects($trackId);
    }
}