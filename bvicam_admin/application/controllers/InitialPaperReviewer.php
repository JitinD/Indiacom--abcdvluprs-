<?php

class InitialPaperReviewer extends CI_Controller
{
    private $data = array();
    public function __construct()
    {
        parent::__construct();
        //$this -> load -> model('convener_model');
        $this -> load -> model('paper_model');//paper
        $this -> load -> model('subject_model');//subject
        $this -> load -> model('track_model');//track
        $this -> load -> model('event_model');//event
        $this -> load -> model('paper_model');//paper_version
        $this -> load -> model('paper_version_model');
        $this -> load -> model('submission_model');
        $this -> load -> model('reviewer_model');
        $this -> load -> model('paper_version_review_model');
        $this->load->helper(array('form', 'url'));
    }

    public function uploadComments($fileElem,$eventId,$paper_version_review_id)
    {
        //$config['upload_path'] = "C:/xampp/htdocs/Indiacom2015/uploads/biodata/".$eventId;
        //$config['upload_path'] = dirname(__FILE__)."/../../../uploads/".$eventId.'/reviewer_reviews';
        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . $eventId . "/" . REVIEWER_REVIEW_FOLDER;
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['file_name'] = $paper_version_review_id . "reviews";
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();

        return UPLOAD_PATH . $eventId . "/" . REVIEWER_REVIEW_FOLDER . $config['file_name'] . $uploadData['file_ext'];
        //return $config['upload_path'] . "/" . $config['file_name'] . $uploadData['file_ext'];
    }
    public function index($page = "ReviewerDashboardHome")
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            show_404();
        }
        $this->load->model('access_model');
        if(isset($privilege['Page']['InitialPaperReviewer'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['InitialPaperReviewer'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        //$_SESSION[APPID]['user_id'] = 2;
        $this -> data['user_id'] = $_SESSION[APPID]['user_id'];

        $this -> data['papers'] = $this -> paper_version_review_model -> getReviewerAssignedPapers($this -> data['user_id']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar');
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function reviewPaperInfo($paper_id, $paper_version_review_id)
    {
        $page = 'reviewPaperInfo';

        $this->data['paperDetails'] = $this->paper_model->getPaperDetails($paper_id);
        $this->data['subjectDetails'] = $this->subject_model->getSubjectDetails($this->data['paperDetails']->paper_subject_id);
        $this->data['trackDetails'] = $this->track_model->getTrackDetails($this->data['subjectDetails']->subject_track_id);
        $this->data['eventDetails'] = $this->event_model->getEventDetails($this->data['trackDetails']->track_event_id);
        $this->data['submissions'] = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paper_id);
        $paperVersionReviewDetails = $this->paper_version_review_model->getPaperVersionReview($paper_version_review_id);
        $this->data['paperVersionDetails'] = $this->paper_version_model->getPaperVersionDetails($paperVersionReviewDetails[0]->paper_version_id);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('event', 'Event','');

        if(($doc_path = $comments_url=$this->uploadComments('comments',$this->data['eventDetails']->event_id,$paper_version_review_id)) == false)
        {
            $this->data['uploadError'] = $this->upload->display_errors();
            //$this->db->trans_rollback();
        }
        else
        {
            $details = array(
                "paper_version_review_comments_file_path" => $doc_path
            );
            $this->paper_version_review_model->sendReviewerComments($details, $paper_version_review_id);
        }

        if($this -> input -> post('Form2'))
        {
            if($this->form_validation->run())
            {
                if($this -> input -> post('comments'))
                {
                    date_default_timezone_set('Asia/Kolkata');

                    $update_data = array(
                                            'paper_version_review_comments'         =>  $this -> input -> post('comments'),
                                            'paper_version_review_date_of_receipt'  =>  date("Y/m/d H:i:s")
                                        );

                    if($this -> paper_version_review_model -> sendReviewerComments($update_data, $paper_version_review_id))
                        $this -> data['message'] = "success";
                    else
                        $this -> data['error2'] = "Sorry, there is some problem. Try again later";

                }

            }
        }
        $this -> data['reviews'] = $this -> paper_version_review_model -> getPaperVersionReview($paper_version_review_id);

        $this->index($page);
    }
}
?>