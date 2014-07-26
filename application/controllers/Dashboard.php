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
        $this->load->model('PaperVersionModel');
        $this->load->model('AccessModel');
        $this->load->model('PaperStatusModel');
    }

    public function index($page = "dashboardHome")
    {

        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $data = loginModalInit();
        $data['papers'] = $this -> PaperStatusModel -> getMemberPapers();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/dashboard/dashboardPanel');
        $this->load->view('pages/dashboard/'.$page, $data);
        $this->load->view('templates/dashboard/dashboardEnding');
        $this->load->view('templates/footer');
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
        $this->load->view('templates/dashboard/dashboardPanel');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('paper_title', "Paper Title", "required|callback_paperTitleCheck");
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
            $this->load->database();
            $this->db->trans_begin();
            $paperId = $this->PaperModel->addPaper($paperDetails, $this->input->post('event'));
            if($paperId == false)
            {
                $data['submitPaperError'] = $this->PaperModel->error;
                $this->db->trans_rollback();
            }
            else if($this->SubmissionModel->addSubmission($paperId, $authors) == false)
            {
                $data['submitPaperError'] = $this->SubmissionModel->error;
                $this->db->trans_rollback();
            }
            else if(($doc_path = $this->uploadPaperDoc('paper_doc', $this->input->post('event'), $paperId) == false))
            {
                $data['uploadError'] = $this->upload->display_errors();
                $this->db->trans_rollback();
            }
            else
            {
                $versionDetails = array(
                    'paper_id' => $paperId,
                    'paper_version_document_path' => $doc_path
                );
                if($this->PaperVersionModel->addPaperVersion($versionDetails) == false)
                {
                    $data['submitPaperError'] = $this->PaperVersionModel->error;
                    $this->db->trans_rollback();
                }
                else
                {
                    $this->db->trans_commit();
                    $page .= "Success";
                    $data['paper_code'] = $paperDetails['paper_code'];
                }
            }
        }
        $this->load->view('pages/dashboard/'.$page, $data);
        $this->load->view('templates/dashboard/dashboardEnding');
        $this->load->view('templates/footer');
    }

    private function uploadPaperDoc($fileElem, $eventId, $paperId)
    {
        $config['upload_path'] = "C:/wamp/www/Indiacom2015/uploads/".$eventId;
        $config['allowed_types'] = 'doc|docx';
        $config['file_name'] = $paperId . "v1";

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();
        return $config['upload_path'] . "/" . $config['file_name'] . $uploadData['file_ext'];
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

    public function paperTitleCheck($paperTitle)
    {
        //First get all paper details of selected event
        $this->PaperModel->getAllPaperDetails($this->input->post('event'));

        if($this->PaperModel->isUniquePaperTitle($paperTitle))
            return true;
        $this->form_validation->set_message('paperTitleCheck', 'Paper title is already used');
        return false;
    }
}