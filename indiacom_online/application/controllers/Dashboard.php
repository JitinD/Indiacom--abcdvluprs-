<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 8:18 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class Dashboard extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->controllerName = "Dashboard";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require_once(dirname(__FILE__).'/../utils/ViewUtils.php');
        $this->load->model('access_model');
        
        if ( !file_exists(APPPATH.'views/pages/dashboard/'.$page.'.php'))
        {
            show_404();
        }

        loginModalInit($this->data);

        $this->data['navbarItem'] = pageNavbarItem($page);

        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/dashboard/dashboardPanel');
        $this->load->view('pages/dashboard/'.$page, $this->data);
        $this->load->view('templates/dashboard/dashboardEnding');
        $this->load->view('templates/footer');
    }

    private function uploadBiodata($fileElem, $memberId)
    {
        if(!$this->checkAccess("uploadBiodata"))
            return;
        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . BIODATA_FOLDER;
        $config['allowed_types'] = 'doc|docx';
        $config['file_name'] = $memberId . "_biodata";
        $config['overwrite'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();

        return UPLOAD_PATH . BIODATA_FOLDER . $config['file_name'] . $uploadData['file_ext'];
    }

    private function uploadPaperVersion($fileElem, $eventId, $paperId, $versionNumber=1)
    {
        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . $eventId . "\\" . PAPER_FOLDER;
        $config['allowed_types'] = 'doc|docx';
        $config['file_name'] = "Paper_" . $paperId . "v" . $versionNumber;
        $config['overwrite'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();
        return UPLOAD_PATH . $eventId . "/" . PAPER_FOLDER . $config['file_name'] . $uploadData['file_ext'];
    }

    private function uploadComplianceReport($fileElem, $eventId, $paperId, $versionNumber=1)
    {
        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . $eventId . "/" . COMPLIANCE_REPORT_FOLDER;
        $config['allowed_types'] = 'pdf';
        $config['file_name'] = "Report_" . $paperId . "v" . $versionNumber;
        $config['overwrite'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();
        return UPLOAD_PATH . $eventId . "/" . COMPLIANCE_REPORT_FOLDER . $config['file_name'] . $uploadData['file_ext'];
    }

    private function sendMail($email_id, $message, $attachments = array())
    {
        $this->load->library('email');

        $this->email->from('conference@bvicam.ac.in', 'Indiacom');
        $this->email->to($email_id);
        $this->email->reply_to("conference@bvicam.ac.in");
        $this->email->subject('Indiacom Paper Submission');
        $this->email->message($message);
        foreach($attachments as $attachment)
        {
            $this->email->attach($attachment);
        }

        if($this->email->send())
            return true;

        return false;
    }

    private function sendSms($to, $text)
    {
        $url = SMS_SEND_LINK;
        $data = array(
            "username" => SMS_SERVICE_USER_ID,
            "password" => SMS_SERVICE_PWD,
            "to" => $to,
            "from" => SMS_FROM,
            "text" => $text
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        file_get_contents($url, false, $context);
    }

    private function authorsCorrespondence($authors = array(), $emailMessageVars, $emailContentView, $attachments)
    {
        foreach($authors as $author)
        {
            $emailMessageVars['member_name'] = $author['member_salutation'] . " " . $author['member_name'];
            $message = $this->load->view("pages/Email/$emailContentView", $emailMessageVars, true);
            $this->sendMail($author['member_email'], $message, $attachments);
            //TODO: check valid format of member mobile avaialbale or not
            $this->sendSms($author['member_mobile'], $this->load->view("pages/Sms/$emailContentView", $emailMessageVars, true));
        }
    }

    public function home()
    {
        if(!$this->checkAccess("home"))
            return;
        $this->load->model('paper_status_model');
        $this->load->model('member_model');
        $this->load->model('event_model');
        $page = "dashboardHome";
        if(isset($_SESSION[APPID]['member_id']))
        {
            $this->data['events'] = $this->event_model->getAllActiveEvents();
            foreach($this->data['events'] as $event)
            {
                $this->data['papers'][$event->event_id] = $this->paper_status_model->getMemberPapers($_SESSION[APPID]['member_id'], $event->event_id);
            }
            $this->data['miniProfile'] = $this -> member_model -> getMemberMiniProfile($_SESSION[APPID]['member_id']);
            $this->data['methodName'] = "submitPaperRevision";
        }
        $this->index($page);
    }

    public function submitPaper()
    {
        if(!$this->checkAccess("submitPaper"))
            return;
        $this->load->model('event_model');
        $this->load->helper('url');
        $page = 'submitpaper';
        $this->data['events'] = $this->event_model->getAllActiveEvents();

        if($this->submitPaperSubmitHandle($paperId))
        {
            $_SESSION[APPID]['messages'][] = "Paper added succesfully.";
            redirect('Dashboard/paperInfo/'.$paperId);
        }

        $this->index($page);
    }

    private function submitPaperSubmitHandle(&$paperId)
    {
        $this->load->model('paper_model');
        $this->load->model('submission_model');
        $this->load->model('paper_version_model');
        $this->load->model('subject_model');
        $this->load->model('member_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('paper_title', "Paper Title", "required|callback_paperTitleCheckCallback");
        $this->form_validation->set_rules('event', 'Event', 'required');
        $this->form_validation->set_rules('track', 'Track', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('main_author', 'Main Author', 'required');
        $this->form_validation->set_rules('authors', 'Author Id(s)', 'required|callback_authorsCheckCallback');

        if($this->form_validation->run())
        {
            $paperDetails = array(
                'paper_title' => $this->input->post('paper_title'),
                'paper_subject_id' => $this->input->post('subject'),
                'paper_contact_author_id' => $this->input->post('main_author')
            );
            $authors = $this->input->post('authors');
            $eventId = $this->subject_model->getSubjectEvent($this->input->post('subject'));
            if($eventId != $this->input->post('event'))
            {
                $this->data['submitPaperError'] = "Selected subject does not belong to selected event";
                return false;
            }
            if(!$this->event_model->isPaperSubmissionOpen($eventId))
            {
                $this->data['submitPaperError'] = "Cannot submit paper to event as paper submission is not open(or has been closed).";
                return false;
            }
            $this->load->database();
            $this->db->trans_begin();
            $paperId = $this->paper_model->addPaper($paperDetails, $this->input->post('event'));
            if($paperId == false)
            {
                $this->data['submitPaperError'] = $this->paper_model->error;
                $this->db->trans_rollback();
            }
            else if($this->submission_model->addSubmission($paperId, $authors) == false)
            {
                $this->data['submitPaperError'] = $this->submission_model->error;
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
                if($this->paper_version_model->addPaperVersion($versionDetails) == false)
                {
                    $this->data['submitPaperError'] = $this->paper_version_model->error;
                    $this->db->trans_rollback();
                }
                else
                {
                    $this->db->trans_commit();
                    $paperId = $versionDetails['paper_id'];
                    $this->data['paper_code'] = $paperDetails['paper_code'];

                    $members = array();
                    foreach($authors as $author)
                    {
                        $members[] = $this->member_model->getMemberInfo($author);
                    }

                    $this->authorsCorrespondence(
                        $members,
                        array(
                            "member_ids" => $authors,
                            "paper_code" => $paperDetails['paper_code'],
                            "paper_title" => $paperDetails['paper_title'],
                            "receipt_date" => date("Y")
                        ),
                        "PaperSubmission",
                        array(SERVER_ROOT.$doc_path)
                    );

                    return true;
                }
            }
        }
        return false;
    }

    /*public function emailPage($pageName)
    {
        $this->load->view("pages/Email/$pageName", array(
            "member_name" => "Saurabv",
            "paper_title" => "sd",
            "paper_code" => 23,
            "complianceReport" => true,
            "receipt_date" => "September 17, 2015",
            "member_ids" => array(5413, 5414)
        ));
    }*/

    public function authorsCheckCallback($authors = array())
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
            if($author == $_SESSION[APPID]['member_id'])
                $retVal = true;
        }

        return $retVal;
    }

    public function paperTitleCheckCallback($paperTitle)
    {
        $this->load->model('paper_model');
        if($this->paper_model->isUniquePaperTitle($paperTitle, $this->input->post('event')))
            return true;
        $this->form_validation->set_message('paperTitleCheck', 'Paper title is already used');
        return false;
    }

    public function submitPaperRevision($paperId = null)
    {
        if(!$this->checkAccess("submitPaperRevision"))
            return;
        $this->load->model('paper_model');
        $this->load->model('paper_version_model');
        $this->load->model('submission_model');
        $this->load->model('member_model');
        if(isset($paperId))
            $page = "submitPaperRevision";
        else
        {
            $this->paperVersionList();
            return;
        }

        if(!$this->isValidPaper($paperId) || !$this->canSubmitRevision($paperId))
        {
            $this->loadUnauthorisedAccessPage();
            return;
        }
        $paperDetails = $this->paper_model->getPaperDetails($paperId);
        $this->data['paper_title'] = $paperDetails->paper_title;
        $this->data['paper_code'] = $paperDetails->paper_code;
        $this->data['paper_main_author'] = $paperDetails->paper_contact_author_id;
        $this->data['paper_version'] = $this->paper_version_model->getLatestPaperVersionNumber($paperId) + 1;
        $complianceReportReqd = $this->data['complianceReportReqd'] = $this->isComplianceReportReqd($paperId);
        $submissions = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paperId);
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
            $eventDetails = $this->paper_model->getPaperEventDetails($paperId);
            $eventId = $eventDetails->event_id;
            $this->load->database();
            $this->db->trans_begin();
            if(!empty($removed_authors) && $this->submission_model->deleteSubmission($paperId, $removed_authors) == false)
            {
                $this->db->trans_rollback();
            }
            if(!empty($added_authors) && $this->submission_model->addSubmission($paperId, $added_authors) == false)
            {
                $this->data['submitPaperRevisionError'] = $this->submission_model->error;
                $this->db->trans_rollback();
            }
            else if(($doc_path = $this->uploadPaperVersion('paper_revision_doc', $eventId, $paperId, $this->data['paper_version'])) == false)
            {
                $this->data['uploadRevisionError'] = $this->upload->display_errors();
                $this->db->trans_rollback();
            }
            else if($complianceReportReqd && ($report_path = $this->uploadComplianceReport('compliance_report_doc', $eventId, $paperId, $this->data['paper_version'])) == false)
            {
                $this->data['uploadReportError'] = $this->upload->display_errors();
                $this->db->trans_rollback();
                //TODO: Delete uploaded paper document.
            }
            else
            {
                //TODO:Revisit this part. Right now ignoring error generated by addPaperVersion.
                //Reason: When addSubmission leads to setting dirty bit of an entry to 0 then a trans_error occurs which although is handled
                //in addSubmission leads to a trans_status() == false in addPaperVersion() too even though the entry does go in paperVersionMaster
                //table correctly.
                $this->db->trans_commit();
                $this->db->trans_off();
                $attachments = array();
                $versionDetails = array(
                    'paper_id' => $paperId,
                    'paper_version_document_path' => $doc_path
                );
                if($complianceReportReqd)
                {
                    $versionDetails['paper_version_compliance_report_path'] = $report_path;
                    $attachments[] = SERVER_ROOT.$report_path;
                }
                $this->db->trans_start();
                $this->paper_version_model->addPaperVersion($versionDetails);
                $this->db->trans_complete();

                $submissions = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paperId);
                $members = array();
                foreach($submissions as $submission)
                {
                    $members[] = $this->member_model->getMemberInfo($submission->submission_member_id);
                }
                $attachments[] = SERVER_ROOT.$doc_path;
                $this->authorsCorrespondence(
                    $members,
                    array(
                        "paper_version" => $versionDetails['paper_version_number'],
                        "paper_code" => $paperDetails->paper_code,
                        "complianceReport" => $complianceReportReqd
                    ),
                    "PaperRevisionSubmission",
                    $attachments
                );

                $_SESSION[APPID]['messages'][] = "Paper version added successfully.";
                redirect('Dashboard/paperInfo/'.$versionDetails['paper_id']);
            }
        }
        $this->index($page);
    }

    private function paperVersionList()
    {
        $this->load->model('paper_status_model');
        $this->load->model('event_model');
        $page = "submitPaperRevisionList";
        $this->data['events'] = $this->event_model->getAllActiveEvents();
        $this->data['paperCanRevise'] = array();
        foreach($this->data['events'] as $event)
        {
            $this->data['papers'][$event->event_id] = $this->paper_status_model->getMemberPapers($_SESSION[APPID]['member_id'], $event->event_id);
            foreach($this->data['papers'][$event->event_id] as $paper)
            {
                $this->data['paperCanRevise'][$paper->paper_id] = $this->canSubmitRevision($paper->paper_id);
            }
        }
        //$this->data['papers'] = $this -> paper_status_model -> getMemberPapers($_SESSION[APPID]['member_id']);
        $this->data['methodName'] = "submitPaperRevision";
        $this->index($page);
    }

    public function paperInfo($paperId)
    {
        if(!$this->checkAccess("paperInfo"))
            return;
        $this->load->model('submission_model');
        $this->load->model('paper_model');
        $this->load->model('subject_model');
        $this->load->model('track_model');
        $this->load->model('event_model');
        $this->load->model('paper_version_model');
        $this->load->model('review_result_model');
        $page = 'paperInfo';
        if($this->submission_model->isMemberValidAuthorOfPaper($_SESSION[APPID]['member_id'], $paperId))
        {
            $this->data['paperDetails'] = $this->paper_model->getPaperDetails($paperId);
            $this->data['subjectDetails'] = $this->subject_model->getSubjectDetails($this->data['paperDetails']->paper_subject_id);
            $this->data['trackDetails'] = $this->track_model->getTrackDetails($this->data['subjectDetails']->subject_track_id);
            $this->data['eventDetails'] = $this->event_model->getEventDetails($this->data['trackDetails']->track_event_id);
            $this->data['allVersionDetails'] = $this->paper_version_model->getPaperAllVersionDetails($paperId);
            $this->data['reviewTypes'] = $this->review_result_model->getAllReviewResultTypeNames();
            $this->data['submissions'] = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paperId);
            $this->data['canSubmitRevision'] = $this->canSubmitRevision($this->data['paperDetails']->paper_id);
        }
        else
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $this->index($page);
    }

    //Checks if paper is currently under review
    private function canSubmitRevision($paperId)
    {
        $this->load->model('paper_version_model');
        $this->load->model('review_result_model');
        $this->load->model('paper_version_review_model');
        $versionDetails = $this->paper_version_model->getLatestPaperVersionDetails($paperId);
        if($versionDetails->paper_version_review_result_id == null)
        {
            $reviews = $this->paper_version_review_model->getPaperVersionAllReviews($versionDetails->paper_version_id);
            if(empty($reviews))
                return true;
        }
        else
        {
            $reviewResultDetails = $this->review_result_model->getReviewResultDetails($versionDetails->paper_version_review_result_id);
            if($reviewResultDetails->is_final_step_review_result == 1 && $reviewResultDetails->is_end_of_review_process == 0)
                return true;
        }
        return false;
    }

    private function isComplianceReportReqd($paperId)
    {
        $this->load->model('paper_version_model');
        $versionDetails = $this->paper_version_model->getLatestPaperVersionDetails($paperId);
        if($versionDetails->paper_version_review_date != '')
        {
            return true;
        }
        return false;
    }

    //Checks if the paper is a valid submission by currently logged in member
    private function isValidPaper($paperId)
    {
        $this->load->model('submission_model');
        $allSubmissions = $this->submission_model->getSubmissionsByAttribute('submission_member_id', $_SESSION[APPID]['member_id']);
        foreach($allSubmissions as $submission)
        {
            if($submission->submission_paper_id == $paperId)
                return true;
        }
        return false;
    }

    //Allows user to change current password
    public function changePassword($toResetPassword = false)
    {
        if(!$this->checkAccess("changePassword"))
            return;

        $page = "changePassword";

        $this->data['toResetPassword'] = $toResetPassword;

        $this->load->model('registration_model');
        $this->load->library('form_validation');

        $member_id = $_SESSION[APPID]['member_id'];

        if(!$toResetPassword)
            $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|callback_validateCurrentPassword');
        $this->form_validation->set_rules('newPassword', 'New Password', 'required');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|callback_validateConfirmPassword');

        if($this->form_validation->run())
        {
            $encrypted_password = md5($this -> input -> post('newPassword'));

            $update_data = array(
                'member_password' => $encrypted_password,
                'member_is_activated' => 1
            );

            if($this -> member_model -> updateMemberInfo($update_data, $member_id))
            {
                if($toResetPassword)
                    return true;
                $page .= "Success";
            }
        }

        $this->index($page);
        return false;
    }

    public function resetPassword($member_id, $activation_code)
    {
        $this -> load -> model('login_model');
        $this -> load -> model('member_model');

        $this -> login_model -> setUsername($member_id);
        $this -> login_model -> setPassword($activation_code);
        $this -> login_model -> setLoginType('LM');

        if(!($auth = $this->login_model->authenticate(false)) || !$this->checkAccess("resetPassword"))
        {
            if(!$auth)
                $this->loadUnauthorisedAccessPage();
            return;
        }

        $update_data = array('member_is_activated'   =>  0);

        if($this->member_model->updateMemberInfo($update_data, $member_id))
        {
            if($this->changePassword(true))
            {
                $this->login_model->setUsername($member_id);
                $this->login_model->setPassword($this->input->post('newPassword'));
                $this->login_model->setLoginType('M');
                $this->login_model->authenticate();
                $this->index("changePasswordSuccess");
                return;
            }
        }
        $this->login_model->logout();
    }

    public function validateCurrentPassword()
    {
        if(!$this->checkAccess("validateCurrentPassword"))
            return;
        $this->load->model('member_model');

        $member_id  = $_SESSION[APPID]['member_id'];

        $member_record = $this -> member_model -> getMemberInfo($member_id);
        $encrypted_password = md5($this -> input -> post('currentPassword'));

        if(strcmp($encrypted_password, $member_record['member_password']))
        {
            $this->form_validation->set_message('validateCurrentPassword', "Incorrect Password");
            return false;
        }
       return true;
    }

    public function validateConfirmPassword()
    {
        if(!$this->checkAccess("validateConfirmPassword"))
            return;
        if(strcmp($this->input->post('newPassword'),$this->input->post('confirmPassword')))
        {
            $this->form_validation->set_message('validateConfirmPassword',"Both passwords should match");
            return false;
        }

        return true;
    }

    public function downloadBiodata()
    {
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/DownloadUtil.php");
        $this->load->model('member_model');
        if(!$this->checkAccess("downloadBiodata"))
            return;
        $memberInfo = $this->member_model->getMemberInfo($_SESSION[APPID]['member_id']);
        $pathInfo = pathinfo($memberInfo['member_biodata_path']);
        DownloadUtil::downloadFile(SERVER_ROOT . $memberInfo['member_biodata_path'], "Bio Data." . $pathInfo['extension']);
    }

    private function downloadPaperVersionDocuments($paperVersionId, $documentPathFieldName)
    {
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/DownloadUtil.php");
        $this->load->model('paper_version_model');
        $this->load->model('submission_model');
        $versionInfo = $this->paper_version_model->getPaperVersionDetails($paperVersionId);
        if($this->submission_model->isMemberValidAuthorOfPaper($_SESSION[APPID]['member_id'], $versionInfo->paper_id))
            DownloadUtil::downloadFile(SERVER_ROOT . $versionInfo->$documentPathFieldName, basename($versionInfo->$documentPathFieldName));
        else
            $this->loadUnauthorisedAccessPage();
    }

    public function watchFlash()
    {
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/DownloadUtil.php");
        $filePath = "D:/Extras/TV Shows/The Flash/Season 2/The.Flash.2014.S02E03.HDTV.x264-LOL[eztv].mp4";
        DownloadUtil::downloadFile($filePath, basename($filePath));
    }

    public function downloadPaperVersion($paperVersionId)
    {
        if(!$this->checkAccess("downloadPaperVersion"))
            return;
        $this->downloadPaperVersionDocuments($paperVersionId, "paper_version_document_path");
    }

    public function downloadComplianceReport($paperVersionId)
    {
        if(!$this->checkAccess("downloadComplianceReport"))
            return;
        $this->downloadPaperVersionDocuments($paperVersionId, "paper_version_compliance_report_path");
    }

    public function downloadReviewerComments($paperVersionId)
    {
        if(!$this->checkAccess("downloadPaperVersion"))
            return;
        $this->downloadPaperVersionDocuments($paperVersionId, "paper_version_comments_path");
    }

    public function editProfile()
    {
        if(!$this->checkAccess("editProfile"))
            return;
        $this->load->model('member_model');
        $this->load->model('registration_model');
        $this->load->model('organization_model');
        $page="editProfile";
        $this -> data['countries'] = $this -> registration_model -> getCountries();
        $this->data['editProfile'] = $this->member_model->getMemberInfo($_SESSION[APPID]['member_id']);
        $this->data['organizationDetails'] =  $this->organization_model->getOrganizationInfo($this->data['editProfile']['member_organization_id']);
        $this -> data['member_categories'] = $this -> registration_model -> getMemberCategories();
        $this->data['miniProfile'] = $this -> member_model -> getMemberMiniProfile($_SESSION[APPID]['member_id']);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('salutation', 'Salutation', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('countryCode', 'Country Code', 'required');
        $this->form_validation->set_rules('mobileNumber', 'Mobile number', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'required');
        $this->form_validation->set_rules('department', 'Department', 'required');

        if($this->form_validation->run())
        {
            $organization_id_array = $this -> registration_model -> getOrganizationId($this -> input -> post('organization'));

            if(!empty($_FILES['biodata']['name']) && ($doc_path = $this->uploadBiodata('biodata', $_SESSION[APPID]['member_id'])) == false)
            {
                $this->data['uploadError'] = $this->upload->display_errors();
            }
            else if($organization_id_array)
            {
                $member_record = array(
                    'member_salutation' => $this->input->post('salutation'),
                    'member_name' => $this->input->post('name'),
                    'member_email' => $this->input->post('email'),
                    'member_country' => $this->input->post('country'),
                    'member_address' => $this->input->post('address'),
                    'member_city' => $this->input->post('city'),
                    'member_state' => $this->input->post('state'),
                    'member_pincode' => $this->input->post('pincode'),
                    'member_country_code' => $this->input->post('countryCode'),
                    'member_mobile' => $this->input->post('mobileNumber'),
                    'member_phone_countryCode' => $this->input->post('telephoneNumber_country'),
                    'member_phone_cityCode' => $this->input->post('telephoneNumber_city'),
                    'member_phone' => $this->input->post('telephoneNumber'),
                    'member_fax_countryCode' => $this->input->post('fax_country'),
                    'member_fax_cityCode' => $this->input->post('fax_city'),
                    'member_fax' => $this->input->post('fax'),
                    'member_iete_mem_no' => $this->input->post('ietemembershipno'),
                    'member_csi_mem_no' => $this->input->post('csimembershipno'),
                    'member_category_id' => $this->input->post('category'),
                    'member_organization_id' => $organization_id_array['organization_id'],
                    'member_department' => $this->input->post('department'),
                    'member_designation' => $this->input->post('designation'),
                    'member_experience' => $this->input->post('experience')
                );
                if(isset($doc_path))
                    $member_record['member_biodata_path'] = $doc_path;

                if($this->member_model->updateMemberInfo($member_record, $_SESSION[APPID]['member_id']))
                    $page .= "Success";
            }
            else
                $this -> data['error'] = "Invalid organization. Contact Admin.";
        }
        $this->index($page);
    }

    public function payment()
    {
        if(!$this->checkAccess("payment"))
            return;
        $page = "paymentHome";
        $memberID = $_SESSION[APPID]['member_id'];

        $this->load->model('paper_status_model');
        $this->load->model('member_categories_model');
        $this->load->model('member_model');
        $this->load->model('currency_model');
        $this->load->model('transaction_mode_model');
        $this->load->model('payment_model');
        $this->load->model('discount_model');
        $this->load->model('transaction_model');

        $currency = ($this->input->get('trans_currency') == null) ? 1 : $this->input->get('trans_currency');
        $transDate = $this->input->get('trans_date');
        if($transDate == null)
            $transDate = $this->data['transDate'] = date("Y-m-d");
        else
            $this->data['transDate'] = $transDate;

        $this->data['isProfBodyMember'] = $this->member_model->isProfBodyMember($memberID);
        $this->data['registrationCategories'] = $this->member_categories_model->getMemberCategories();
        $this->data['registrationCat'] = $this->member_model->getMemberCategory($memberID);
        $this->data['currencies'] = $this->currency_model->getAllCurrencies();
        $this->data['selectedCurrency'] = $currency;
        $this->data['papers'] = $this->paper_status_model->getMemberAcceptedPapers($memberID);
        $this->data['transaction_modes'] = $this->transaction_mode_model->getAllTransactionModes();
        $this->data['discounts'] = $this->discount_model->getMemberEligibleDiscounts($memberID, $this->data['papers']);
        $this->data['mappedTransactions'] = $this->transaction_model->getMemberTempTransactionMappings($memberID);
        foreach($this->data['mappedTransactions'] as $transaction)
        {
            $this->data['transactionUsedAmount'][$transaction->transaction_id] = $this->transaction_model->getTransactionUsedAmount($transaction->transaction_id);
        }
        if($this->discount_model->error != null)
            die($this->discount_model->error);
        if($this->paymentSubmitHandle($memberID, $this->data['registrationCat'], $currency))
        {
            foreach($this->data['mappedTransactions'] as $transaction)
            {
                $this->data['transactionUsedAmount'][$transaction->transaction_id] = $this->transaction_model->getTransactionUsedAmount($transaction->transaction_id);
            }
        }
        $this->data['papersInfo'] = $this->payment_model->calculatePayables($memberID, $currency, $this->data['registrationCat'], $this->data['papers'], $transDate);
        $this->index($page);
    }

    private function paymentSubmitHandle($memberID, $registrationCat, $currency)
    {
        $this->load->library('form_validation');
        $this->load->model('payable_class_model');
        $this->load->model('payment_head_model');
        $this->load->model('payment_model');
        $this->load->model('discount_model');
        $this->load->model('submission_model');
        $this->load->model('transaction_model');
        $this->load->model('member_model');

        if($this->input->post('mapped_transaction_id') >= 0)
        {
            $this->form_validation->set_rules('trans_no', "Transaction No.", 'required');
        }
        else
        {
            $this->form_validation->set_rules('trans_mode', "Payment Mode", 'required');
            $this->form_validation->set_rules('trans_amount', "Amount", 'required');
            $this->form_validation->set_rules('trans_bank', "Bank Name", 'required');
            $this->form_validation->set_rules('trans_no', "Transaction No.", 'required');
            $this->form_validation->set_rules('trans_date', "Transaction Date", 'required');
        }

        if($this->form_validation->run())
        {
            $transAuthorIds = $this->input->post('trans_authorIds');
            $submissionIds = $this->input->post('submissionIds');
            if($submissionIds == null)
                $submissionIds = array();
            $paymentsDetails = array();
            $totalPayAmount = 0;

            if(!empty($this->data['mappedTransactions']) && $this->input->post('mapped_transaction_id') >= 0)
            {
                $details = $this->transaction_model->getTransactionDetails($this->input->post('mapped_transaction_id'));
                $transCreated = true;
                $transactionDetails = array(
                    "transaction_id" => $details->transaction_id,
                    "transaction_amount" => $details->transaction_EQINR - $this->data['transactionUsedAmount'][$details->transaction_id],
                    "transaction_date" => $details->transaction_date
                );
                if($details == null)
                {
                    $this->data['pay_error'] = "Invalid transaction id!";
                    return false;
                }
                if($this->input->post('trans_no') != $details->transaction_number)
                {
                    $this->data['pay_error'] = "The transaction number does not match.";
                    return false;
                }
            }
            else
            {
                $transactionDetails = array(
                    "transaction_member_id" => $memberID,
                    "transaction_bank" => $this->input->post('trans_bank'),
                    "transaction_number" => $this->input->post('trans_no'),
                    "transaction_mode" => $this->input->post('trans_mode'),
                    "transaction_amount" => $this->input->post('trans_amount'),
                    "transaction_date" => $this->input->post('trans_date'),
                    "transaction_currency" => $currency
                );
            }
            $transDate = $transactionDetails['transaction_date'];
            foreach($submissionIds as $submission)
            {
                $payAmount = $this->input->post($submission."_payAmount");
                $payHead = $this->input->post($submission."_payheadAndDiscount");
                if($payAmount <= 0)
                    continue;
                $split = explode("_", $payHead);
                $payHead = $split[0];
                $discountType = (isset($split[1])) ? $split[1] : null;
                $payHeadId = $this->payment_head_model->getPaymentHeadId($payHead);
                $submissionDetails = $this->submission_model->getSubmissionsByAttribute("submission_id", $submission);
                if($payHeadId == null)
                {
                    $this->data['pay_error'] = "System Error: Payheads don't match! Contact Admin.";
                    return false;
                }
                $payableClass = $this->getPseudoPayableClass(
                    $submissionDetails[0]->submission_member_id,
                    $submissionDetails[0]->submission_paper_id,
                    $payHeadId,
                    $currency,
                    $transDate,
                    $discountType
                );
                if($payAmount > $payableClass->payable_class_amount)
                {
                    $this->data['pay_error'] = "One or more pay amount is greater than payable amount.";
                    return false;
                }
                $totalPayAmount += $payAmount;
                $paymentsDetails[] = array(
                    "payment_submission_id" => $submission,
                    "payment_amount_paid" => $payAmount,
                    "payment_payable_class" => $payableClass->payable_class_id,
                    "payment_discount_type" => $discountType
                );
            }

            if($totalPayAmount > 0 && $totalPayAmount <= $transactionDetails['transaction_amount'])
            {
                if($totalPayAmount < $transactionDetails['transaction_amount'] && !empty($transAuthorIds))
                {
                    $transactionDetails['is_open'] = 1;
                }
                else if($totalPayAmount == $transactionDetails['transaction_amount'] && !empty($transAuthorIds))
                {
                    $this->data['pay_error'] = "The transaction amount is exactly equal to selected pay amount and hence, cannot be selected for use by other authors.";
                    return false;
                }
                if(!isset($transactionDetails['transaction_id']))
                    $transCreated = $this->transaction_model->newTransaction($transactionDetails);
                if($transCreated)
                {
                    if(!empty($transAuthorIds))
                    {
                        if(!$this->transaction_model->makeTransactionTempMappings($transactionDetails['transaction_id'], $transAuthorIds))
                            $this->data['message'][] = "One or more author id's supplied in list of authors for this transaction was incorrect. It was ignored.";
                    }
                    $noofAdded = $this->payment_model->addMultiPaymentsWithCommonTransaction($paymentsDetails, $transactionDetails['transaction_id']);
                    $this->data['message'][] = $noofAdded . " payments added.";
                    if(isset($transactionDetails['is_open']) && $transactionDetails['is_open'] == 1)
                        $this->data['message'][] = "The transaction can be further used by the specified authors for their payments.";
                    return true;
                }
                else
                    $this->data['pay_error'] = "Unable to create transaction. Transaction details might be duplicate.";
            }
            else
            {
                $this->data['pay_error'] = "Selected pay amount unequal to transaction amount!";
            }
        }
        return false;
    }

    private function getPseudoPayableClass($memberId, $paperId, $payheadId, $currency, $date, &$discountType)
    {
        $this->load->model('member_model');
        $this->load->model('payment_model');
        $this->load->model('payable_class_model');
        $registrationCat = $this->member_model->getMemberCategory($memberId);
        $paidPayments = $this->payment_model->getPayments(
            $memberId,
            $paperId
        );
        $discountAmt = 0;
        $paidAmount = 0;
        if(empty($paidPayments))
        {
            $payableClass = $this->payable_class_model->getPayableClass(
                $payheadId,
                !$this->member_model->isProfBodyMember($memberId),
                $registrationCat->member_category_id,
                $currency,
                $date
            );
        }
        else
        {
            $payableClass = $this->payable_class_model->getPayableClassDetails($paidPayments[0]->payment_payable_class);
            $discountType = $paidPayments[0]->payment_discount_type;
            $paidAmount = $paidPayments[0]->paid_amount + $paidPayments[0]->waiveoff_amount;
        }
        if($discountType != null)
        {
            $detail = $this->discount_model->getDiscountDetails($discountType);
            $discountAmt = floor($payableClass->payable_class_amount * $detail->discount_type_amount);
        }
        $payableClass->payable_class_amount -= ($paidAmount + $discountAmt);
        return $payableClass;
    }

    public function transaction()
    {
        if(!$this->checkAccess("transaction"))
            return;
        $page="transactionHistory";
        $this->load->model('transaction_model');
        $this->load->model('transaction_mode_model');
        $this->data['transactions'] = $this->transaction_model->getMemberPaymentsTransactions($_SESSION[APPID]['member_id']);
        $this->data['transactionModes'] = $this->transaction_mode_model->getAllTransactionModesAsAssocArray();
        $this->index($page);
    }

    public function payablesChart()
    {
        if(!$this->checkAccess("payablesChart"))
            return;
        $this->load->model('payable_class_model');
        $this->load->model('member_categories_model');
        $this->load->model('nationality_model');
        $this->load->model('currency_model');
        $page = "viewPayableChart";
        $brPayableClasses = $this->payable_class_model->getAllBrPayableClassDetails();
        $this->data['memCats'] = $this->member_categories_model->getMemberCategoriesAsAssocArray();
        $this->data['nationalities'] = $this->nationality_model->getAllNationalitiesAsAssocArray();
        $this->data['currencies'] = $this->currency_model->getAllCurrenciesAsAssocArray();
        $payableClasses = array();
        foreach($brPayableClasses as $payableClass)
        {
            if($payableClass->start_date==null && $payableClass->end_date!=null)
                $dateType = "Early Bird";
            else if($payableClass->start_date!=null && $payableClass->end_date==null)
                $dateType = "Late Bird";
            else
                $dateType = "Spot";
            $payableClasses[$payableClass->payable_class_nationality]
                           [$payableClass->payable_class_registration_category]
                           [$dateType][$payableClass->is_general] = $payableClass;
        }
        $this->data['payableClasses'] = $payableClasses;
        $this->index($page);
    }
    
    
    
    private function request_special_session_handle($member_id)
    {
        $this->load->library('form_validation');
        $this->load->model('request_special_session');
        $this->form_validation->set_rules('session_name', "Session Name", "required");
        $this->form_validation->set_rules('session_aim', "Session Aim", "required");
        $retVal = false;
        if($this->form_validation->run()){
            $subject_name = htmlentities($this->input->post('session_name'));
            $session_aim = htmlentities($this->input->post('session_aim'));
            $ss_id = $this->request_special_session->insertSpecialSessionSubject($member_id, $subject_name, $session_aim);
            
            if($ss_id > 0){
                $retVal = true;
            } else{
                $retVal = false;
            }
            
        }
        return $retVal;
    }

    private function edit_session_Chairperson_handle($sid)
    {
        $this->load->library('form_validation');
        $this->load->model('request_special_session');
        $this->form_validation->set_rules('profile', "Profile", "required");
        $retVal = false;
        if($this->form_validation->run()){
            $profile = htmlentities($this->input->post('profile'));
            $ss_id = $this->request_special_session->updateChairPersonProfile($sid, $profile);
            
            if($ss_id){
                $retVal = true;
            } else{
                $retVal = false;
            }
            
        }
        return $retVal;
    }

    private function add_aoc_handle($sid)
    {
        $this->load->library('form_validation');
        $this->load->model('request_special_session');
        $this->form_validation->set_rules('aoc', "Area of Coverage", "required");
        $retVal = false;
        if($this->form_validation->run()){
            $aoc = htmlentities($this->input->post('aoc'));
            $ss_id = $this->request_special_session->insertSpecialSessionAOC($sid, $aoc);
            
            if($ss_id){
                $retVal = true;
            } else{
                $retVal = false;
            }
            
        }
        return $retVal;
    }

    private function add_tpc_handle($sid)
    {
        $this->load->library('form_validation');
        $this->load->model('request_special_session');
        $this->form_validation->set_rules('tpc', "Technical Programme Committee", "required");
        $retVal = false;
        if($this->form_validation->run()){
            $tpc = htmlentities($this->input->post('tpc'));
            $ss_id = $this->request_special_session->insertSpecialSessionTPC($sid, $tpc);
            
            if($ss_id){
                $retVal = true;
            } else{
                $retVal = false;
            }
            
        }
        return $retVal;
    }

    /*
    * function to handle request special session form with aoc and tpc multiple inputs for each field
    private function request_special_session_details_handle($member_id)
    {
        $this->load->library('form_validation');
        $this->load->model('request_special_session');
        $this->form_validation->set_rules('session_name', "Session Name", "required|alpha_dash");
        $this->form_validation->set_rules('session_aim', "Session Aim", "required|alpha_dash");
        $this->form_validation->set_rules('aoc[]', "Area of Coverage", "required|min_length[1]");
        $this->form_validation->set_rules('tpc[]', "Technical Programme Committee", "required|min_length[1]");
        $retVal = false;
        if($this->form_validation->run()){
            $subject_name = $this->input->post('session_name');
            $session_aim = $this->input->post('session_aim');
            $aoc = $this->input->post('aoc');
            $tpc = $this->input->post('tpc');
            $this->db->trans_begin();
            $ss_id = $this->request_special_session->insertSpecialSessionSubject($member_id, $subject_name, $session_aim);
            
            if($ss_id > 0){
                foreach($aoc as $item){
                    if(!$this->request_special_session->insertSpecialSessionAOC($ss_id, $item)){
                        $retVal = false;
                        break;
                    } else{
                        $retVal = true;
                    }
                }
                if($retVal){
                    foreach($tpc as $tpc_item){
                        if(!$this->request_special_session->insertSpecialSessionTPC($ss_id, $tpc_item)){
                            $retVal = false;
                            break;
                        } else{
                            $retVal = true;
                        }
                    }
                }
                $retVal = true;
            } else{
                $retVal = false;
            }
            
            if (!$retVal || $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $retVal = false;
            }
            else{
                $this->db->trans_commit();
                $retVal = true;
            }
            
        }
        return $retVal;
    }
    */
    
    public function request_special_session()
    {
        if(!$this->checkAccess("request_special_session"))
            return;
        $this->load->model('event_model');
        $this->load->helper('url');

        $page = 'request_special_session';
        
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $member_id = $_SESSION[APPID]['member_id'];
            if(isset($_POST['submit'])){
                if( $this->request_special_session_handle($member_id)){
                    $_SESSION[APPID]['message'] = "Request sent succesfully! Please review 'my special sessions' from sidebar links to add details to your requested special session once it has been verified.";
                } else{
                    $_SESSION[APPID]['message'] = "Technical Error occured!";
                }
            }
        }
        $this->index($page);    
    }

    public function special_sessions_list()
    {
        if(!$this->checkAccess("special_sessions_list"))
            return;
        $this->load->model('ss_track_model');
        $this->load->helper('url');
        $page = 'special_sessions_list';
        $this->data['sessions'] = $this->ss_track_model->getAllTracks();
        $this->index($page);    
    }

    public function my_special_session()
    {
        if(!$this->checkAccess("my_special_session"))
            return;
        $this->load->model('request_special_session');
        $page = 'my_special_session';
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $member_id = $_SESSION[APPID]['member_id'];
            $this->data['special_session'] = $this->request_special_session->get_special_session($member_id);
        }
        $this->index($page);    
    }

    public function special_session($sid)
    {
        if(!$this->checkAccess("special_session"))
            return;
        $this->load->model('request_special_session');
        $page = 'special_session';
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $this->data['special_session'] = $this->request_special_session->get_special_session_by_sid($sid);
            $this->data['aoc'] = $this->request_special_session->get_aoc($sid);
            $this->data['tpc'] = $this->request_special_session->get_tpc($sid);
            
        }
        $this->index($page);
    }


    public function special_session_details($sid)
    {
        if(!$this->checkAccess("special_session_details"))
            return;
        $this->load->model('request_special_session');
        $page = 'special_session_details';
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $this->data['sid'] = $sid;
            $this->data['aoc'] = $this->request_special_session->get_aoc($sid);
            $this->data['tpc'] = $this->request_special_session->get_tpc($sid);
        }
        $this->index($page);
    }

    public function edit_session_Chairperson($sid)
    {
        if(!$this->checkAccess("edit_session_Chairperson"))
            return;
        $this->load->model('request_special_session');
        $this->load->helper('url');
        $page = 'edit_chairperson';
        $this->data['sid'] = $sid;
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $member_id = $_SESSION[APPID]['member_id'];
            if(isset($_POST['submit'])){
                if( $this->edit_session_Chairperson_handle($sid)){
                    $_SESSION[APPID]['message'] = "Profile edited succesfully.";
                } else{
                    $_SESSION[APPID]['message'] = "Technical Error occured!";
                }
            }

            $result = $this->request_special_session->get_special_session_by_sid($sid);
            $result = array_pop($result);
            $this->data['chairper_profile'] = $result->profile;
            
        }
        $this->index($page);
    }

    public function add_aoc($sid)
    {
        if(!$this->checkAccess("add_aoc"))
            return;
        $this->load->model('request_special_session');
        $this->load->helper('url');
        $page = 'add_aoc';
        $this->data['sid'] = $sid;
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $member_id = $_SESSION[APPID]['member_id'];
            if(isset($_POST['submit'])){
                if( $this->add_aoc_handle($sid)){
                    $_SESSION[APPID]['message'] = "AOC edited succesfully.";
                } else{
                    $_SESSION[APPID]['message'] = "Technical Error occured!";
                }
            }
            
        }
        $this->index($page);
    }

    public function add_tpc($sid)
    {
        if(!$this->checkAccess("add_tpc"))
            return;
        $this->load->model('request_special_session');
        $this->load->helper('url');
        $page = 'add_tpc';
        $this->data['sid'] = $sid;
        if (isset($_SESSION) && isset($_SESSION[APPID]['member_id'])){
            $member_id = $_SESSION[APPID]['member_id'];
            if(isset($_POST['submit'])){
                if( $this->add_tpc_handle($sid)){
                    $_SESSION[APPID]['message'] = "AOC edited succesfully.";
                } else{
                    $_SESSION[APPID]['message'] = "Technical Error occured!";
                }
            }
            
        }
        $this->index($page);
    }
}