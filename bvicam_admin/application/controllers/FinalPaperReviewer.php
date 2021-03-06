<?php

    class FinalPaperReviewer extends CI_Controller
    {
        private $data = array();
        public function __construct()
        {
            parent::__construct();
            //$this -> load -> model('convener_model');
            /*$this -> load -> model('paper_model');//paper
            $this -> load -> model('subject_model');//subject
            $this -> load -> model('track_model');//track
            $this -> load -> model('event_model');//event
            $this -> load -> model('paper_model');//paper_version
            $this -> load -> model('paper_version_model');
            $this -> load -> model('submission_model');
            $this -> load -> model('paper_version_review_model');
            $this -> load -> model('reviewer_model');
            $this -> load -> model('review_result_model');
            $this->load->helper(array('form', 'url'));*/
        }

        private function index($page)
        {
            $folder = "FinalPaperReviewer/";
            require(dirname(__FILE__).'/../config/privileges.php');
            require(dirname(__FILE__).'/../utils/ViewUtils.php');
            $this->load->model('access_model');
            if ( ! file_exists(APPPATH."views/pages/$folder".$page.'.php'))
            {
                show_404();
            }

            if(isset($privilege['Page'][$page]) && !$this->access_model->hasPrivileges($privilege['Page'][$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            $this->data['navbarItem'] = pageNavbarItem($page);
            $this->load->view('templates/header', $this->data);
            $this->load->view("pages/$folder".$page, $this->data);
            $this->load->view('templates/footer');
        }

        public function load()
        {
            $this->load->model('paper_version_model');
            $page = "ConvenerDashboardHome";
            $this->data['user_id'] = $_SESSION[APPID]['user_id'];
            $this->data['papersWithoutReviewers'] = $this -> paper_version_model -> getPaperVersionsWithoutReviewer();
            $this->index($page);
        }

        public function paperInfo($paper_id, $paper_version_id)
        {
            $page = 'paperInfo';
            $_SESSION['sudo'] = true;
            $this->load->model('role_model');
            $_SESSION['sudo'] = true;
            $this->load->model('user_model');
            $this->load->model('paper_model');
            $this->load->model('subject_model');
            $this->load->model('track_model');
            $this->load->model('submission_model');
            $this->load->model('paper_version_model');
            $this->load->model('paper_version_review_model');
            $this->load->model('review_result_model');
            //$this->load->model('reviewer_model');
            $this->load->model('event_model');

            $this->data['paperDetails'] = $this->paper_model->getPaperDetails($paper_id);
            $this->data['subjectDetails'] = $this->subject_model->getSubjectDetails($this->data['paperDetails']->paper_subject_id);
            $this->data['trackDetails'] = $this->track_model->getTrackDetails($this->data['subjectDetails']->subject_track_id);
            $this->data['eventDetails'] = $this->event_model->getEventDetails($this->data['trackDetails']->track_event_id);
            $this->data['submissions'] = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paper_id);
            $this->data['paperVersionDetails'] = $this->paper_version_model->getPaperVersionDetails($paper_version_id);
            $this->load->library('form_validation');

            $this->form_validation->set_rules('event', 'Event','');

            if(($doc_path = $comments_url=$this->uploadComments('comments',$this->data['eventDetails']->event_id,$paper_version_id)) == false)
            {
                $this->data['uploadError'] = $this->upload->display_errors();
            }
            else
            {
                $versionDetails = array(
                    "paper_version_comments_path" => $doc_path
                );
                $this->paper_version_model->sendConvenerReview($versionDetails, $paper_version_id);
            }

            if($this -> input -> post('Form2'))
            {
                if($this->form_validation->run())
                {
                    if($this -> input -> post('comments'))
                    {
                        date_default_timezone_set('Asia/Kolkata');

                        $update_data = array(
                            'paper_version_review_result_id' => $this -> input -> post('review_result'),
                            'paper_version_review'      =>  $this -> input -> post('comments'),
                            'paper_version_is_reviewed_convener' => 1,
                            'paper_version_review_date' =>  date("Y/m/d H:i:s")
                        );

                        if($this -> paper_version_model -> sendConvenerReview($update_data, $paper_version_id))
                            $this -> data['message'] = "success";
                        else
                            $this -> data['error2'] = "Sorry, there is some problem. Try again later";

                    }

                }
            }
            else if(($this -> input -> post('Form1')))
            {
                if($this->form_validation->run())
                {
                    foreach($this -> input -> post('selectReviewer') as $reviewer_id)
                    {
                        $paper_version_review_record = array
                        (
                            'paper_version_id'          =>  $paper_version_id,
                            'paper_version_reviewer_id' =>  $reviewer_id
                        );

                        if($this -> paper_version_review_model -> addPaperVersionReviewRecord($paper_version_review_record))
                            $this -> data['message'] = "success";
                        else
                            $this -> data['error1'] = "Sorry, there is some problem. Try again later";
                    }

                    $this -> setReviewerAssigned($paper_version_id, 1);
                }
            }
            else if(($this -> input -> post('Form3')))
            {
                if($this->form_validation->run())
                {
                    if($this -> paper_version_review_model -> removePaperVersionReviewer($this -> input -> post('Form3')))
                        $this -> data['message'] = "success";
                    else
                        $this -> data['error3'] = "Sorry, there is some problem. Try again later";

                }
            }

            $this -> data['review_results'] = $this -> review_result_model -> getAllReviewResults();
            $this -> data['comments'] = $this -> paper_version_model -> getPaperVersionComments($paper_version_id);
            //$this -> data['reviewers'] = $this -> convener_model -> getReviewerIDs();
            $reviewerRoleId = $this->role_model->getRoleId('Reviewer');
            $this -> data['Allreviewers'] = $this -> user_model -> getUsersByRoleId($reviewerRoleId);

            $reviewers = array();

            if($this -> data['Allreviewers'])
            {
                foreach($this -> data['Allreviewers'] as $index=>$reviewer)
                {
                    $reviewers[$reviewer -> user_id] = $reviewer -> user_name;
                }
            }

            $this -> data['reviewers'] = $reviewers;

            $this -> data['reviews'] = $this -> paper_version_review_model -> getPaperVersionReviews($paper_version_id);

            if(empty($this -> data['reviews']))
                $this -> setReviewerAssigned($paper_version_id, 0);

            $this->index($page);
        }

        private function uploadComments($fileElem,$eventId,$paper_version_id)
        {
            $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . $eventId . "/" . CONVENER_REVIEW_FOLDER;
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['file_name'] = $paper_version_id . "reviews";
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload($fileElem))
            {
                return false;
            }
            $uploadData = $this->upload->data();

            return UPLOAD_PATH . $eventId . "/" . CONVENER_REVIEW_FOLDER . $config['file_name'] . $uploadData['file_ext'];
        }

        public function setReviewerAssigned($paper_version_id, $value)
        {
            $update_data = array('paper_version_is_reviewer_assigned'   =>  $value);

            if($this -> paper_version_model -> setReviewerAssigned($update_data, $paper_version_id))
                $this -> data['message'] = "success";
            else
                $this -> data['error1'] = "Sorry, there is some problem. Try again later";
        }
    }
?>