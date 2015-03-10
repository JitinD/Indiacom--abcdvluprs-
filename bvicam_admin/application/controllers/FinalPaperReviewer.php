<?php

    class FinalPaperReviewer extends CI_Controller
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
            $this -> load -> model('paper_version_review_model');
            $this -> load -> model('reviewer_model');
            $this -> load -> model('review_result_model');
            $this->load->helper(array('form', 'url'));
        }

        private function sendMail($email_id, $message)
        {
            $config = array(
                'protocol' => 'mail',
                'smtp_host' => 'p3plcpnl0820.prod.phx3.secureserver.net',
                'smtp_port' => 465,
                'smtp_user' => 'info@bvicam.org',
                'smtp_pass' => 'CPAcc#4012',
                'charset'   => 'utf-8',
                'wordwrap'  => true,
                'wrapchars' => 50
            );

            /*$config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 587,
                'smtp_user' => 'indiacom15@gmail.com',
                'smtp_pass' => '!nd!@c0m',
                'charset'   => 'utf-8',
                'mailtype' => 'text',
                'wordwrap'  => true,
                'wrapchars' => 50
            );*/

            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from('indiacom15@gmail.com', 'CSI 2015');
            $this->email->to($email_id);
            $this->email->subject('CSI Paper Review');
            $this->email->message($message);

            if($this->email->send())
                return true;

            return false;
        }

        public function uploadComments($fileElem,$eventId,$paper_version_id)
        {
            //$config['upload_path'] = "C:/xampp/htdocs/Indiacom2015/uploads/biodata/".$eventId;
            //$config['upload_path'] = dirname(__FILE__)."/../../../uploads/".$eventId.'/convener_reviews';
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
            //return $config['upload_path'] . "/" . $config['file_name'] . $uploadData['file_ext'];
        }

        public function index($page = "ConvenerDashboardHome")
        {
            require(dirname(__FILE__).'/../config/privileges.php');
            require(dirname(__FILE__).'/../utils/ViewUtils.php');
            $this->load->model('access_model');
            $sidebarData['controllerName'] = $controllerName = "FinalPaperReviewer";
            $sidebarData['links'] = $this->setSidebarLinks();
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }

            if(isset($privilege['Page']['FinalPaperReviewer'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['FinalPaperReviewer'][$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            //$_SESSION[APPID]['user_id'] = 1;
            $this -> data['user_id'] = $_SESSION[APPID]['user_id'];
            //$this -> data['papers'] = $this -> paper_version_model -> getAssignedPapers($this -> data['user_id']);

            $this -> data['no_reviewer_papers'] = $this -> paper_version_model -> getNoReviewerPapers($this -> data['user_id']);
            $this -> data['reviewed_papers'] = $this -> paper_version_model -> getReviewedPapers($this -> data['user_id']);
            $this -> data['not_reviewed_papers'] = $this -> paper_version_model -> getNotReviewedPapers($this -> data['user_id']);
            $this -> data['convener_reviewed_papers'] = $this -> paper_version_model -> getConvenerReviewedPapers($this -> data['user_id']);
            $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($privilege['Page']);
            $this->data['navbarItem'] = pageNavbarItem($page);
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/navbar', $sidebarData);
            $this->load->view('pages/'.$page, $this->data);
            $this->load->view('templates/footer');
        }

        private function setSidebarLinks()
        {

        }

        public function setReviewerAssigned($paper_version_id, $value)
        {
            $update_data = array('paper_version_is_reviewer_assigned'   =>  $value);

            if($this -> paper_version_model -> setReviewerAssigned($update_data, $paper_version_id))
                $this -> data['message'] = "success";
            else
                $this -> data['error1'] = "Sorry, there is some problem. Try again later";
        }

        public function paperInfo($paper_id, $paper_version_id)
        {
            $page = 'paperInfo';
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
                                                'paper_version_review_date' =>  date("Y/m/d H:i:s"),
                                                'paper_version_is_reviewed_convener' => 1
                                            );

                        if($this -> paper_version_model -> sendConvenerReview($update_data, $paper_version_id))
                        {
                            $this -> load -> model('submission_model');
                            $this -> load -> model('member_model');

                            $message = "hello";

                            $authors = $this -> submission_model -> getAllAuthorsOfPaper($paper_id);

                            foreach($authors as $index => $author)
                            {
                                $member_id = $author -> submission_member_id;

                                $member_info = $this -> member_model -> getMemberInfo($member_id);

                                $email_id = $member_info['member_email'];

                                if($this -> sendMail($email_id, $message))
                                    $this -> data['message'] = "success";
                                else
                                    $this -> data['error2'] = "Sorry, there is some problem. Try again later";

                            }

                        }
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
            $this -> data['Allreviewers'] = $this -> reviewer_model -> getAllReviewers();

            $reviewers = array();

            if($this -> data['Allreviewers'])
            {
                foreach($this -> data['Allreviewers'] as $index=>$reviewer)
                {
                    $reviewers[$reviewer -> reviewer_id] = $reviewer -> user_name;
                }
            }

            $this -> data['reviewers'] = $reviewers;

            $this -> data['reviews'] = $this -> paper_version_review_model -> getPaperVersionReviews($paper_version_id);

            if(empty($this -> data['reviews']))
                $this -> setReviewerAssigned($paper_version_id, 0);

            $this->index($page);
        }
    }
?>