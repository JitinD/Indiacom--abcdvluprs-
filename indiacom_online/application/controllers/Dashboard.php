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

        /*$this->load->model('event_model');
        $this->load->model('track_model');
        $this->load->model('subject_model');
        $this->load->model('paper_model');
        $this->load->model('submission_model');
        $this->load->model('paper_version_model');
        $this->load->model('access_model');
        $this->load->model('paper_status_model');
        $this->load->model('author_paper_detailed_model');
        $this->load->model('review_result_model');
        $this->load->model('organization_model');
        $this->load->model('member_categories_model');
        $this->load->model('member_model');
        $this->load->model('registration_model');*/
    }

    private function index($page = "dashboardHome")
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require_once(dirname(__FILE__).'/../utils/ViewUtils.php');
        $this->load->model('access_model');
        if ( ! file_exists(APPPATH.'views/pages/dashboard/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->access_model->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        loginModalInit($this->data);

        $this->data['navbarItem'] = pageNavbarItem($page);

        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/dashboard/dashboardPanel');
        $this->load->view('pages/dashboard/'.$page, $this->data);
        $this->load->view('templates/dashboard/dashboardEnding');
        $this->load->view('templates/footer');
    }

    public function home()
    {
        $this->load->model('paper_status_model');
        $this->load->model('member_model');
        $page = "dashboardHome";
        if(isset($_SESSION[APPID]['member_id']))
        {
            $this->data['papers'] = $this -> paper_status_model -> getMemberPapers($_SESSION[APPID]['member_id']);
            $this->data['miniProfile'] = $this -> member_model -> getMemberMiniProfile($_SESSION[APPID]['member_id']);
        }
        $this->index($page);
    }


    public function uploadBiodata($fileElem,$eventId,$memberId)
    {
        $config['upload_path'] = "C:/xampp/htdocs/Indiacom2015/uploads/biodata/".$eventId;
        //$config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . BIODATA_FOLDER . $eventId ;
        $config['allowed_types'] = 'pdf';
        $config['file_name'] = $memberId . "biodata";
        $config['overwrite'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();

        return UPLOAD_PATH . BIODATA_FOLDER . $eventId . "/" . $config['file_name'] . $uploadData['file_ext'];
    }

    private function uploadPaperVersion($fileElem, $eventId, $paperId, $versionNumber=1)
    {

        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . $eventId . "/" . PAPER_FOLDER;
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

    public function submitPaper()
    {
        $this->load->model('event_model');
        $this->load->model('paper_model');
        $this->load->model('submission_model');
        $this->load->model('paper_version_model');
        $page = 'submitpaper';
        $this->data['events'] = $this->event_model->getAllEvents_deprc();

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
                    $page = "submitPaperSuccess";
                    $this->data['paper_code'] = $paperDetails['paper_code'];
                }
            }
        }
        $this->index($page);
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
            if($author == $_SESSION[APPID]['member_id'])
                $retVal = true;
        }

        return $retVal;
    }

    public function paperTitleCheck($paperTitle)
    {
        $this->load->model('paper_model');
        //First get all paper details of selected event
        $this->paper_model->getAllPaperDetails($this->input->post('event'));

        if($this->paper_model->isUniquePaperTitle($paperTitle))
            return true;
        $this->form_validation->set_message('paperTitleCheck', 'Paper title is already used');
        return false;
    }

    public function submitPaperRevision($paperId = null)
    {
        $this->load->model('paper_model');
        $this->load->model('paper_version_model');
        $this->load->model('submission_model');
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
        $paperDetails = $this->paper_model->getPaperDetails($paperId);
        $this->data['paper_title'] = $paperDetails->paper_title;
        $this->data['paper_code'] = $paperDetails->paper_code;
        $this->data['paper_main_author'] = $paperDetails->paper_contact_author_id;
        $this->data['paper_version'] = $this->paper_version_model->getLatestPaperVersionNumber($paperId) + 1;
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
            else if(($report_path = $this->uploadComplianceReport('compliance_report_doc', $eventId, $paperId, $this->data['paper_version'])) == false)
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
                $versionDetails = array(
                    'paper_id' => $paperId,
                    'paper_version_document_path' => $doc_path,
                    'paper_version_compliance_report_path' => $report_path
                );
                $this->db->trans_start();
                $this->paper_version_model->addPaperVersion($versionDetails);
                $page .= "Success";
                $this->db->trans_complete();
            }
        }
        $this->index($page);
    }
    /*public function payment($page)
    {
        $this->load->model('payment_model');
        $this->load->model('paper_model');
        $this->data['paperDetails']=$this->paper_model->getAllPapers($_SESSION[APPID]['member_id']);
        $this->data['brcharges']=$this->payment_model->getBRCharges($_SESSION[APPID]['member_id'],1,2);
        $this->data['eps']=$this->payment_model->getEPCharges();
        $this->data['brs']=$this->payment_model->getBRCharges($_SESSION[APPID]['member_id'],1,2);
        $this->index($page);
    }*/


    public function paperInfo($paperId)
    {
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
            $this->data['invalidAuthorAccess'] = true;
        }
        $this->index($page);
    }

    private function paperVersionList()
    {
        $this->load->model('paper_status_model');
        $page = "submitPaperRevisionList";
        $this->data['papers'] = $this -> paper_status_model -> getMemberPapers($_SESSION[APPID]['member_id']);
        $this->data['paperCanRevise'][] = array();
        foreach($this->data['papers'] as $paper)
        {
            $this->data['paperCanRevise'][$paper->paper_id] = $this->canSubmitRevision($paper->paper_id);
        }
        $this->data['methodName'] = "submitPaperRevision";
        $this->index($page);
    }

    //Checks if paper is currently under review
    private function canSubmitRevision($paperId)
    {
        $this->load->model('paper_version_model');
        $versionDetails = $this->paper_version_model->getLatestPaperVersionDetails($paperId);
        if($versionDetails->paper_version_is_reviewer_assigned == 0 || $versionDetails->paper_version_review_date != '')
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
        $page = "changePassword";

        $this -> data['toResetPassword'] = $toResetPassword;

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
                                    'member_password'       =>  $encrypted_password,
                                    'member_is_activated'   =>  1
                                );

            if($this -> member_model -> updateMemberInfo($update_data, $member_id))
            {
                $page .= "Success";
               // return true;
            }

            //return false;
        }

        $this->index($page);

        //return false;
    }

    public function resetPassword($member_id, $activation_code)
    {
        $page = "resetPassword";

        $_SESSION['sudo'] = true;
        $this -> load -> model('login_model');
        $this -> load -> model('member_model');

        $this -> login_model -> setUsername($member_id);
        $this -> login_model -> setPassword($activation_code);
        $this -> login_model -> setLoginType('LM');
        $this -> login_model -> authenticate();

        $update_data = array('member_is_activated'   =>  0);

        if($this -> member_model -> updateMemberInfo($update_data, $member_id))
        {
            if($this -> changePassword(true))
                redirect('Login/Logout');
        }

    }

    public function validateCurrentPassword()
    {
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
        if(strcmp($this->input->post('newPassword'),$this->input->post('confirmPassword')))
        {
            $this->form_validation->set_message('validateConfirmPassword',"Both passwords should match");
            return false;
        }

        return true;
    }

    public function downloadBiodata()
    {
        $this->load-> helper ('download');
        $data=file_get_contents(SERVER_ROOT.UPLOAD_PATH.BIODATA_FOLDER."1/".$_SESSION[APPID]['member_id']."biodata.pdf");
        $name = $_SESSION[APPID]['member_id']."biodata.pdf";
        force_download ($name, $data);
    }

    public function editProfile()
    {
        $this->load->model('member_model');
        $this->load->model('registration_model');
        $page="editProfile";
        $this->data['editProfile'] =$this->member_model->getMemberInfo($_SESSION[APPID]['member_id']);
        $this -> data['member_categories'] = $this -> registration_model -> getMemberCategories();
        $this->data['miniProfile'] = $this -> member_model -> getMemberMiniProfile($_SESSION[APPID]['member_id']);
        $this->load->library('form_validation');



        $this->form_validation->set_rules('salutation', 'Salutation', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phoneNumber', 'Phone number', 'required');
        $this->form_validation->set_rules('mobileNumber', 'Mobile number', 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('department', 'Department', 'required');

        if($this->form_validation->run())
        {

            $organization_id_array = $this -> registration_model -> getOrganizationId($this -> input -> post('organization'));

            if(($doc_path = $biodata_url=$this->uploadBiodata('biodata',1,$_SESSION[APPID]['member_id'])) == false)
            {
                $this->data['uploadError'] = $this->upload->display_errors();
                $this->db->trans_rollback();
            }
            if($organization_id_array)
            {
                $member_record = array(
                    'member_id'             =>  $_SESSION[APPID]['member_id'],
                    'member_salutation'     =>  $this -> input -> post('salutation'),
                    'member_name'           =>   $this -> input -> post('name'),
                    'member_address'        =>   $this -> input -> post('address'),
                    'member_pincode'        =>   $this -> input -> post('pincode'),
                    'member_email'          =>   $this -> input -> post('email'),
                    'member_phone'          =>   $this -> input -> post('phoneNumber'),
                    'member_mobile'         =>   $this -> input -> post('mobileNumber'),
                    'member_fax'            =>   $this -> input -> post('fax'),
                    'member_designation'    =>   $this -> input -> post('designation'),
                    'member_csi_mem_no'     =>   $this -> input -> post('csimembershipno'),
                    'member_iete_mem_no'    =>   $this -> input -> post('ietemembershipno'),
                    'member_organization_id'=>   $organization_id_array['organization_id'],
                    'member_biodata_path'   =>   $doc_path,
                    'member_category_id'    =>   $this -> input -> post('category'),
                    'member_department'     =>   $this-> input -> post ('department'),
                    'member_experience'     =>   $this -> input -> post('experience'),
                    'member_is_activated'   =>   ""
                );

                if($this->member_model->updateMemberInfo($member_record, $_SESSION[APPID]['member_id']))
                    $page .= "Success";

            }
            else
                $this -> data['error'] = "No such organization";

        }


                $this->index($page);
    }

    private function getOLPCAmount($paperID)
    {
        $olpc_amount = 0;

        $this -> load -> model('payment_model');

        if($this -> payment_model -> checkOLPCValid($paperID))
        {
            if(!(checkOLPCPaid($paperID)))
            {
                $olpc_amount_object = getOLPCCharges();
                $olpc_amount = $olpc_amount_object -> payable_class_amount;
            }
        }

        return $olpc_amount;
    }

    //Calculate the payable for a paper
    private function calculateBRPayable($memberID, $paperID)
    {
        $this -> load -> model('paper_model');
        $this -> load -> model('member_model');
        $this -> load -> model('payment_model');

        $member_category_object = $this -> member_model -> getMemberCategory($memberID);
        $paper_count_object = $this -> paper_model -> getPaperCount($memberID);
        $num_authors_object = $this -> paper_model -> getNumberOfAuthors($paperID);

        //$count_paper = $paper_counts['count'];
        //$count_coauthor = $coauthor_counts['count'] - 1;

        $total_papers = $paper_count_object -> count;
        $num_coauthors = ($num_authors_object -> count) - 1;

        $br_amount = $ep_amount = $discounted_br_amount = 0;
        $olpc_amount = $this -> getOLPCAmount($paperID);


        //Check if the paper is registered

        $isPaperRegistered = $this -> payment_model -> checkPaperRegistered($paperID); //Give proper name to variable
        $isMemberRegistered = $this -> payment_model -> checkBRPaid($memberID); //Give proper name to variable


        if($num_coauthors == 0)
        {
            if(!($isPaperRegistered))
            {
                $br_amount_object = $this -> payment_model -> getBRCharges($memberID, 1, $member_category_object -> member_category_id);
                $br_amount = $br_amount_object -> payable_class_amount;
            }
        }
        else
        {
            if($isMemberRegistered)
            {

                if($total_papers > 1)
                {
                    if($isPaperRegistered)
                    {
                        if(!($isPaperRegistered -> payment_member_id == $memberID))
                        {
                            $ep_amount_object = $this -> payment_model -> getEPCharges();
                            $ep_amount = $ep_amount_object -> payable_class_amount;
                        }

                    }
                }

            }
            else
            {
                if($isPaperRegistered)
                {
                    if(!($isPaperRegistered -> payment_member_id == $memberID))
                    {
                        $br_amount_object = $this -> payment_model -> getBRCharges($memberID,1,$member_category_object -> member_category_id);
                        $ep_amount_object = $this -> payment_model -> getEPCharges();

                        $br_amount = $br_amount_object -> payable_class_amount;
                        $ep_amount = $ep_amount_object -> payable_class_amount;

                    }
                }
            }
        }

        return array('BR' => $br_amount, 'EP' => $ep_amount, 'OLPC' => $olpc_amount);
    }

    //Calculate payable amount for a member
    private function calculatePayable($memberID, $papers)
    {
        $this -> load -> model('paper_model');

        $payable = array();

        foreach($papers as $paper)
            $payable[$paper -> paper_id] = array('BR' => '', 'EP' => '', 'OLPC' => '');

        foreach($papers as $paper)
            $payable[$paper -> paper_id] = $this -> calculateBRPayable($memberID, $paper -> paper_id);


        return $payable;
    }

    public function payment($page)
    {
        $memberID = $_SESSION[APPID]['member_id'];

        $this->load->model('payment_model');
        $this->load->model('paper_model');

        $this -> data['papers'] = $papers = $this -> paper_model -> getAllPapers($memberID);
        $this -> data['payable'] = $this -> calculatePayable($memberID, $papers);

        //$this->data['brcharges']=$this->payment_model->getBRCharges($_SESSION[APPID]['member_id'],1,2);
        //$this->data['eps']=$this->payment_model->getEPCharges();
        //$this->data['brs']=$this->payment_model->getBRCharges($_SESSION[APPID]['member_id'],1,2);
        $this->index($page);
    }


}