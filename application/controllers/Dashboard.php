<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 8:18 PM
 */
class Dashboard extends CI_Controller
{
    private $data = array();
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
        $this -> load -> model('OrganizationModel');
        $this -> load -> model('MemberCategoriesModel');
        $this -> load -> model('MemberModel');
    }

    public function index($page = "dashboardHome")
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/dashboard/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        loginModalInit($this->data);
        $this->data['papers'] = $this -> PaperStatusModel -> getMemberPapers($_SESSION['member_id']);
        $this->data['miniProfile'] = $this -> MemberModel -> getMemberMiniProfile($_SESSION['member_id']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/dashboard/dashboardPanel');
        $this->load->view('pages/dashboard/'.$page, $this->data);
        $this->load->view('templates/dashboard/dashboardEnding');
        $this->load->view('templates/footer');
    }

    public function submitPaper()
    {
        $page = 'submitpaper';
        $this->data['events'] = $this->EventModel->getAllEvents();

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
                $this->data['submitPaperError'] = $this->PaperModel->error;
                $this->db->trans_rollback();
            }
            else if($this->SubmissionModel->addSubmission($paperId, $authors) == false)
            {
                $this->data['submitPaperError'] = $this->SubmissionModel->error;
                $this->db->trans_rollback();
            }
            else if(($doc_path = $this->uploadPaperVersion('paper_doc', $this->input->post('event'), $paperId)) == false)
            {
                $this->data['uploadError'] = $this->upload->display_errors();
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
                    $this->data['submitPaperError'] = $this->PaperVersionModel->error;
                    $this->db->trans_rollback();
                }
                else
                {
                    $this->db->trans_commit();
                    $page .= "Success";
                    $this->data['paper_code'] = $paperDetails['paper_code'];
                }
            }
        }
        $this->index($page);
    }

    private function uploadPaperVersion($fileElem, $eventId, $paperId, $versionNumber=1)
    {
        $config['upload_path'] = "C:/xampp/htdocs/Indiacom2015/upload/".$eventId;
        $config['allowed_types'] = 'doc|docx';
        $config['file_name'] = $paperId . "v" . $versionNumber;
        $config['overwrite'] = true;

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

    public function submitPaperRevision($paperId = null)
    {
        if(isset($paperId))
            $page = "submitPaperRevision";
        else
        {
            $this->paperVersionList();
            return;
        }

        if(!$this->isValidPaper($paperId) || !$this->canSubmitRevision($paperId))
        {
            $this->load->view('pages/errorPage', array('page_error' => "Ooops! Where'd you get that link???"));
            return;
        }
        $paperDetails = $this->PaperModel->getPaperDetails($paperId);
        $this->data['paper_title'] = $paperDetails->paper_title;
        $this->data['paper_code'] = $paperDetails->paper_code;
        $this->data['paper_main_author'] = $paperDetails->paper_contact_author_id;
        $this->data['paper_version'] = $this->PaperVersionModel->getLatestPaperVersionNumber($paperId) + 1;
        $submissions = $this->SubmissionModel->getSubmissionsByAttribute('submission_paper_id', $paperId);
        $authors = array();
        foreach($submissions as $key=>$submission)
        {
            $authors[$key] = $submission->submission_member_id;
        }
        $this->data['paper_authors'] = $authors;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('paper_title', "Paper Title", 'required');

        if($this->form_validation->run())
        {
            $removed_authors = $this->input->post('removed_authors');
            $added_authors = $this->input->post('added_authors');
            $eventDetails = $this->PaperModel->getPaperEventDetails($paperId);
            $eventId = $eventDetails->event_id;
            $this->load->database();
            $this->db->trans_begin();
            if(!empty($removed_authors) && $this->SubmissionModel->deleteSubmission($paperId, $removed_authors) == false)
            {
                $this->db->trans_rollback();
            }
            if(!empty($added_authors) && $this->SubmissionModel->addSubmission($paperId, $added_authors) == false)
            {
                $this->data['submitPaperRevisionError'] = $this->SubmissionModel->error;
                $this->db->trans_rollback();
            }
            else if(($doc_path = $this->uploadPaperVersion('paper_revision_doc', $eventId, $paperId, $this->data['paper_version'])) == false)
            {
                $this->data['uploadRevisionError'] = $this->upload->display_errors();
                $this->db->trans_rollback();
            }
            else
            {
                //Revisit this part. Right now ignoring error generated by addPaperVersion.
                //Reason: When addSubmission leads to setting dirty bit of an entry to 0 then a trans_error occurs which although is handled
                //in addSubmission leads to a trans_status() == false in addPaperVersion() too even though the entry does go in paperVersionMaster
                //table correctly.
                $this->db->trans_commit();
                $this->db->trans_off();
                $versionDetails = array(
                    'paper_id' => $paperId,
                    'paper_version_document_path' => $doc_path
                );
                $this->db->trans_start();
                $this->PaperVersionModel->addPaperVersion($versionDetails);
                $page .= "Success";
                $this->db->trans_complete();
            }
        }
        $this->index($page);
    }

    private function paperVersionList()
    {
        $page = "submitPaperRevisionList";
        $this->data['papers'] = $this -> PaperStatusModel -> getMemberPapers($_SESSION['member_id']);
        $this->data['methodName'] = "submitPaperRevision";
        $this->index($page);
    }

    //Checks if paper is currently under review
    private function canSubmitRevision($paperId)
    {
        $versionDetails = $this->PaperVersionModel->getLatestPaperVersionDetails($paperId);
        if($versionDetails->paper_version_is_reviewer_assigned == 0 || $versionDetails->paper_version_review_date != '')
        {
            return true;
        }
        return false;
    }

    //Checks if the paper is a valid submission by currently logged in member
    private function isValidPaper($paperId)
    {
        $allSubmissions = $this->SubmissionModel->getSubmissionsByAttribute('submission_member_id', $_SESSION['member_id']);
        foreach($allSubmissions as $submission)
        {
            if($submission->submission_paper_id == $paperId)
                return true;
        }
        return false;
    }
}