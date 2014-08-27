<?php

    class FinalPaperReviewer extends CI_Controller
    {
        private $data = array();
        public function __construct()
        {
            parent::__construct();
            //$this -> load -> model('ConvenerModel');
            $this -> load -> model('PaperModel');//paper
            $this -> load -> model('SubjectModel');//subject
            $this -> load -> model('TrackModel');//track
            $this -> load -> model('EventModel');//event
            $this -> load -> model('PaperModel');//paper_version
            $this -> load -> model('PaperVersionModel');
            $this -> load -> model('SubmissionModel');
            $this -> load -> model('PaperVersionReviewModel');
            $this -> load -> model('ReviewerModel');
            $this -> load -> model('ReviewResultModel');
        }

        public function index($page = "ConvenerDashboardHome")
        {
            require(dirname(__FILE__).'/../config/privileges.php');
            require(dirname(__FILE__).'/../utils/ViewUtils.php');
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }


            if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            //$_SESSION['user_id'] = 1;
            $this -> data['user_id'] = $_SESSION['user_id'];

            $this -> data['papers'] = $this -> PaperVersionModel -> getAssignedPapers($this -> data['user_id']);
            $this->data['navbarItem'] = pageNavbarItem($page);
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar');
            $this->load->view('pages/'.$page, $this->data);
            $this->load->view('templates/footer');
        }

        public function setReviewerAssigned($paper_version_id, $value)
        {
            $update_data = array('paper_version_is_reviewer_assigned'   =>  $value);

            if($this -> PaperVersionModel -> setReviewerAssigned($update_data, $paper_version_id))
                $this -> data['message'] = "success";
            else
                $this -> data['error1'] = "Sorry, there is some problem. Try again later";
        }

        public function paperInfo($paper_id, $paper_version_id)
        {
            $page = 'paperInfo';

            $this->data['paperDetails'] = $this->PaperModel->getPaperDetails($paper_id);
            $this->data['subjectDetails'] = $this->SubjectModel->getSubjectDetails($this->data['paperDetails']->paper_subject_id);
            $this->data['trackDetails'] = $this->TrackModel->getTrackDetails($this->data['subjectDetails']->subject_track_id);
            $this->data['eventDetails'] = $this->EventModel->getEventDetails($this->data['trackDetails']->track_event_id);
            $this->data['submissions'] = $this->SubmissionModel->getSubmissionsByAttribute('submission_paper_id', $paper_id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('event', 'Event','');


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
                                                'paper_version_review_date' =>  date("Y/m/d H:i:s")
                                            );

                        if($this -> PaperVersionModel -> sendConvenerReview($update_data, $paper_version_id))
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

                        if($this -> PaperVersionReviewModel -> addPaperVersionReviewRecord($paper_version_review_record))
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
                    if($this -> PaperVersionReviewModel -> removePaperVersionReviewer($this -> input -> post('Form3')))
                        $this -> data['message'] = "success";
                    else
                        $this -> data['error3'] = "Sorry, there is some problem. Try again later";

                }
            }

            $this -> data['review_results'] = $this -> ReviewResultModel -> getAllReviewResults();
            $this -> data['comments'] = $this -> PaperVersionModel -> getPaperVersionComments($paper_version_id);
            //$this -> data['reviewers'] = $this -> ConvenerModel -> getReviewerIDs();
            $this -> data['Allreviewers'] = $this -> ReviewerModel -> getAllReviewers();

            $reviewers = array();

            if($this -> data['Allreviewers'])
            {
                foreach($this -> data['Allreviewers'] as $index=>$reviewer)
                {
                    $reviewers[$reviewer -> reviewer_id] = $reviewer -> user_name;
                }
            }

            $this -> data['reviewers'] = $reviewers;

            $this -> data['reviews'] = $this -> PaperVersionReviewModel -> getPaperVersionReviews($paper_version_id);

            if(empty($this -> data['reviews']))
                $this -> setReviewerAssigned($paper_version_id, 0);

            $this->index($page);
        }
    }
?>