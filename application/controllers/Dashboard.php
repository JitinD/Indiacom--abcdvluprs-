<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 8:18 PM
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('EventModel');
        $this->load->model('TrackModel');
        $this->load->model('SubjectModel');
        $this->load->model('PaperModel');
        $this->load->model('SubmissionModel');
        $this->load->model('AccessModel');
    }

    public function submitPaper()
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $page = 'submitpaper';
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $data = loginModalInit();
        $data['navbarItem'] = pageNavbarItem($page);
        $data['events'] = $this->EventModel->getAllEvents();
        $this->load->view('templates/header', $data);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('paper_title', "Paper Title", "required|is_unique[paper_master.paper_title]");
        $this->form_validation->set_rules('event', 'Event', 'required');
        $this->form_validation->set_rules('track', 'Track', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        //$this->form_validation->set_rules('paper_doc', 'Paper', 'required');
        $this->form_validation->set_rules('main_author', 'Main Author', 'required');
        $this->form_validation->set_rules('authors', 'Author Id(s)', 'required|callback_authorsCheck');

        if($this->form_validation->run())
        {
            $paperDetails = array(
                'paper_title' => $this->input->post('paper_title'),
                'paper_subject_id' => $this->input->post('subject'),
                'paper_contact_author_id' => $this->input->post('main_author')
            );
            $authors = $this->input->post('authors');
            $paperId = $this->PaperModel->addPaper($paperDetails);
            $this->SubmissionModel->addSubmission($paperId, $authors);
            $this->uploadPaperDoc('paper_doc');
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

    public function authorsCheck($authors = array())
    {
        $retVal = false;
        $this->form_validation->set_message('authorsCheck', 'Signed in author missing in authors list');
        foreach($authors as $author)
        {
            if($author == "")
            {
                $this->form_validation->set_message('authorsCheck', 'One or more author fields are empty');
                $retVal = false;
                break;
            }
            if($author == $_SESSION['member_id'])
                $retVal = true;
        }

        return $retVal;
    }
}