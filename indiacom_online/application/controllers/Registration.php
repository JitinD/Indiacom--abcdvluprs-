<?php

/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class Registration extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_model');
        $this->load->helper(array('form', 'url'));
        $this->controllerName = "Registration";
        require_once(dirname(__FILE__) . '/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require_once(dirname(__FILE__) . '/../utils/ViewUtils.php');
        if (!file_exists(APPPATH . 'views/pages/registration/' . $page . '.php')) {
            show_404();
        }

        loginModalInit($this->data);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/registration/' . $page, $this->data, array('error' => ' '));
        $this->load->view('templates/footer');

    }

    private function hide_mail($email)
    {
        $email_id = explode("@", $email);
        $domain = explode(".", $email_id[1]);

        $visible_username_len = 3;
        $visible_domain_len = 2;

        return substr($email_id[0], 0, $visible_username_len) . str_repeat("*", strlen($email_id[0]) - $visible_username_len) . "@" .
        substr($domain[0], 0, $visible_domain_len) . str_repeat("*", strlen($domain[0]) - $visible_domain_len) . "." .
        $domain[1];

    }

    public function validate_captcha()
    {
        if(!$this->checkAccess("validate_captcha"))
            return;
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array('secret' => '6LcQQwYTAAAAAKGtQ968dkP7HCKcQ-PfG02jhRYp', 'response' => $this->input->post('g-recaptcha-response'));

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $var = json_decode($result);
        return $var->success;
    }

    public function validate_mobileNumber()
    {
        if(!$this->checkAccess("validate_mobileNumber"))
            return;
        $mobileNumberRegex = "/(\d{10})$/";

        if (!preg_match($mobileNumberRegex, $this->input->post('mobileNumber'))) {
            $this->form_validation->set_message('validate_mobileNumber', "Mobile number must have 10 digits!");
            return false;
        }
        return true;
    }

    public function validate_confirm_password()
    {
        if(!$this->checkAccess("validate_confirm_password"))
            return;
        if (strcmp($this->input->post('password'), $this->input->post('password2'))) {
            $this->form_validation->set_message('validate_confirm_password', "Passwords do not match!");
            return false;
        }
        return true;
    }

    public function formFilledCheck()
    {
        if(!$this->checkAccess("formFilledCheck"))
            return;
        $member_id = $this->input->post('memberID');
        $email_id = $this->input->post('email');

        if (!$member_id && !$email_id) {
            $this->data['error'] = "Both fields can't be empty";
            return false;
        }
        return true;
    }

    private function sendMail($email_id, $message)
    {
        $this->load->library('email');
        //$this->email->initialize($config);
        $this->email->from('conference@bvicam.ac.in', 'BVICAM');
        $this->email->to($email_id);
        $this->email->reply_to("conference@bvicam.ac.in");
        $this->email->subject('Indiacom Registration');
        $this->email->message($message);

        if ($this->email->send())
            return true;

        return false;
    }

    //uploading member bio data in temporary folder
    private function uploadTempBiodata($fileElem, $memberId)
    {
        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . TEMP_BIODATA_FOLDER;
        $config['allowed_types'] = 'doc|docx';
        $config['file_name'] = $memberId . "_biodata";
        $config['overwrite'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($fileElem)) {
            return false;
        }
        $uploadData = $this->upload->data();
        //die(UPLOAD_PATH . TEMP_BIODATA_FOLDER . $config['file_name'] . $uploadData['file_ext']);

        return UPLOAD_PATH . TEMP_BIODATA_FOLDER . $config['file_name'] . $uploadData['file_ext'];
    }

    public function forgotPassword()
    {
        if(!$this->checkAccess("forgotPassword"))
            return;
        $page = "forgotPassword";

        $this->load->library('form_validation');
        $this->load->model('member_model');

        if (isset($_POST['Reset']) && $this->formFilledCheck()) {
            $member_id = $this->input->post('memberID');
            $email_id = $this->input->post('email');

            if ($email_id) {
                if ($member_info = $this->member_model->getMemberInfo_Email($email_id)) {
                    $member_id = $member_info['member_id'];
                    $encrypted_password = $member_info['member_password'];

                    if (!strcmp($email_id, $member_info['member_email'])) {
                        $activation_code = $encrypted_password; //$this -> assignActivationCode();

                        //$update_data = array('member_password'   =>  $activation_code);

                        //if($this -> member_model -> updateMemberInfo($update_data, $member_id))
                        {
                            $this->data['member_id'] = $member_id;
                            $this->data['activation_code'] = $activation_code;

                            $message = $this->load->view('pages/EmailResetPasswordLink', $this->data, true);

                            if ($page = $this->sendMail($this->input->post('email'), $message))
                                $this->data['message'] = "An email has been sent to your registered mail id. Click on the activation link provided in the mail to reset your password<br/>NOTE: you can add co-authors at any stage later.";
                            else
                                $this->data['message'] = "Some problem occurred. Email can't be sent. Reset password unsuccessful";

                            $page = "signupSuccess";
                        }

                    } else
                        $this->data['email_id'] = $this->hide_mail($member_info['member_email']);
                } else
                    $this->data['error'] = "Sorry, no such email ID exists in our database";
            }

            if (!$email_id && $member_id) {
                if ($member_info = $this->member_model->getMemberInfo($member_id))
                    $this->data['email_id'] = $this->hide_mail($member_info['member_email']);
                else
                    $this->data['error'] = "Sorry, no such member ID exists in our database";
            }

        }

        $this->index($page);

    }

    private function assignActivationCode()
    {
        $active_str = array_merge(range(1, 9));
        $str = implode("", $active_str);
        $activation_code = substr(str_shuffle($str), 0, 8);
        return $activation_code;
    }

    public function getOrganizationNameSuggestions($keyword)
    {
        $this->load->model('organization_model');
        $organizations = $this->organization_model->getMatchingOrganizations($keyword);
        $resultArr = array();
        foreach($organizations as $organization)
        {
            $resultArr[] = $organization->organization_name;
        }
        echo json_encode($resultArr);
    }

    public function signUp()
    {
        if(!$this->checkAccess("signUp"))
            return;
        $page = "signup";
        $this->load->model('registration_model');
        $this->load->model('organization_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('salutation', 'Salutation', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('telephoneNumber_country', 'Telephone number Country Code', 'required');
        $this->form_validation->set_rules('telephoneNumber_city', 'Telephone number City Code', 'required');
        $this->form_validation->set_rules('telephoneNumber', 'Telephone number', 'required');
        $this->form_validation->set_rules('countryCode', 'Country Code', 'required');
        $this->form_validation->set_rules('mobileNumber', 'Mobile number', 'required|callback_validate_mobileNumber');
        $this->form_validation->set_rules('organization', 'Organization', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required|callback_validate_captcha');
        $this->form_validation->set_rules('fax_country', 'Fax Number Country Code');
        $this->form_validation->set_rules('fax_city', 'Fax Number City Code');
        $this->form_validation->set_rules('fax', 'Fax Number');
        $this->form_validation->set_rules('csimembershipno', 'CSI Membership Number');
        $this->form_validation->set_rules('ietemembershipno', 'IETE Membership Number');
        $this->form_validation->set_rules('designation', 'Designation');
        $this->form_validation->set_rules('experience', 'Experience');

        $this -> data['member_categories'] = $this -> registration_model -> getMemberCategories();
        $this -> data['countries'] = $this -> registration_model -> getCountries();
        
        if ($this->form_validation->run()) {
            $organization_id = $this->organization_model->getOrganizationId($this->input->post('organization'));
            $member_id = $this->registration_model->assignTempMemberId();

            if (($doc_path = $this->uploadTempBiodata('biodata', $member_id)) == false) {
                $this->data['uploadError'] = $this->upload->display_errors();
            }

            $activation_code = md5($this->assignActivationCode());

            $this->session->unset_userdata('captcha');
            $this->session->unset_userdata('image');

            if ($organization_id == null) {
                $details = array(
                    "organization_name" => $this->input->post('organization')
                );
                $this->organization_model->addNewOrganization($details);
                $organization_id = $this->organization_model->getOrganizationId($this->input->post('organization'));
            }

            if ($organization_id != null) {
                $member_record = array(
                    'member_id' => $member_id,
                    'member_salutation' => $this->input->post('salutation'),
                    'member_name' => $this->input->post('name'),
                    'member_address' => $this->input->post('address'),
                    'member_pincode' => $this->input->post('pincode'),
                    'member_email' => $this->input->post('email'),
                    'member_country' => $this->input->post('country'),
                    'member_city' => $this->input->post('city'),
                    'member_phone_countryCode' => $this->input->post('telephoneNumber_country'),
                    'member_phone_cityCode' => $this->input->post('telephoneNumber_city'),
                    'member_phone' => $this->input->post('telephoneNumber'),
                    'member_country_code' => $this->input->post('countryCode'),
                    'member_mobile' => $this->input->post('mobileNumber'),
                    'member_fax_countryCode' => $this->input->post('fax_country'),
                    'member_fax_cityCode' => $this->input->post('fax_city'),
                    'member_fax' => $this->input->post('fax'),
                    'member_designation' => $this->input->post('designation'),
                    'member_csi_mem_no' => $this->input->post('csimembershipno'),
                    'member_iete_mem_no' => $this->input->post('ietemembershipno'),
                    'member_password' => $activation_code,
                    'member_organization_id' => $organization_id,
                    'member_biodata_path' => ($doc_path != false) ? $doc_path : null,
                    'member_category_id' => $this->input->post('category'),
                    'member_department' => $this->input->post('department'),
                    'member_experience' => $this->input->post('experience'),
                    'member_is_activated' => "1"
                );

                if ($this->registration_model->addTempMember($member_record)) {
                    $this->data['member_id'] = $member_id;
                    $this->data['activation_code'] = $activation_code;
                    $this->load->helper('url');
                    redirect("Registration/EnterPassword/$member_id/$activation_code");
                    /*$message = $this -> load -> view('pages/Email/EmailActiveCode', $this -> data, true);

                    if($page = $this -> sendMail($this -> input -> post('email'), $message))
                    {
                        $this -> data['is_verified'] = 0;
                        $this -> data['message'] = "An email has been sent to your registered mail id. Click on the activation link provided in the mail to complete your registration process";
                    }
                    else
                        $this -> data['message'] = "Some problem occurred. Email can't be sent. Registration unsuccessful";

                    $page = "signupSuccess";*/
                }
            }
        }
        $this->index($page);
    }

    public function EnterPassword($member_id, $activation_code)
    {
        $this->load->model('member_model');
        $this->load->model('login_model');
        $member_info = $this->member_model->getTempMemberInfo($member_id);
        $this->login_model->setLoginParams("LM", $member_info['member_id'], $activation_code);
        $this->login_model->authenticate();
        if(!$this->checkAccess("EnterPassword"))
            return;
        $page = "EnterPassword";
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->load->library('ftp');


        /*if (!$this->login_model->authenticate()) {
            $this->loadUnauthorisedAccessPage();
            return;
        }*/
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|callback_validate_confirm_password');
        if ($this->form_validation->run()) {
            $pass = $this->input->post('password');
            $encrypted_password = md5($pass);
            $this->data['message'] = "Some problem occurred. Email can't be sent. Registration unsuccessful";
            $this->data['is_verified'] = 0;

            $biodata_url = SERVER_ROOT . UPLOAD_PATH . BIODATA_FOLDER;
            $assignedMemberId = $this->registration_model->assignMemberId();
            if ($member_info['member_biodata_path'] != null) {
                $biodata_path_array = pathinfo($member_info['member_biodata_path']);

                rename(SERVER_ROOT . $member_info['member_biodata_path'], $biodata_url . "{$assignedMemberId}_biodata.".$biodata_path_array['extension']);
                $member_info['member_biodata_path'] = UPLOAD_PATH . BIODATA_FOLDER . $assignedMemberId . "_biodata.".$biodata_path_array['extension'];
               
            }

            if ($this->registration_model->deleteTempMember($member_id)) {
                $this->load->database();
                $this->db->trans_begin();
                $member_info["member_id"] = $this->registration_model->assignMemberId();
                $member_info["member_password"] = $encrypted_password;
                $member_info["member_is_activated"] = 1;

                $this->data['member_id'] = $member_info["member_id"];
                if ($this->registration_model->addMember($member_info)) {
                    $message = $this->load->view('pages/Email/ListOfServices',
                        array(
                            "member_id" => $member_info['member_id'],
                            "member_name" => $member_info['member_name'],
                            "member_password" => $this->input->post('password')
                        ),
                        true
                    );
                    if ($this->sendMail($member_info['member_email'], $message)) {
                        $this->data['is_verified'] = 1;
                        $this->data['message'] = "An email has been sent to your registered email id. This mail will let you know about the services that would be provided to you.";
                        $this->db->trans_commit();
                    } else {
                        $this->db->trans_rollback();
                    }
                }
            }
            $page = "registrationSuccess";
            $success = true;
            $this->data['member_id'] = $member_info['member_id'];
            $this->login_model->setLoginParams("M", $member_info['member_id'], $pass);
            if (!$this->login_model->authenticate()) {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }
        }
        $this->index($page);
        if (!isset($success))
            $this->login_model->logout();
    }
}

?>