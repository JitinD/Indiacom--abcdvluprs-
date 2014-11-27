<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

    class Registration extends CI_Controller
    {
        private $data;

        public function __construct()
        {
            parent::__construct();

            $this -> load -> model('registration_model');
			$this->load->helper(array('form', 'url'));
        }

        private function hide_mail($email)
        {
            $email_id = explode("@", $email);
            $domain = explode(".", $email_id[1]);

            $visible_username_len = 3;
            $visible_domain_len = 2;

            return substr($email_id[0],0,$visible_username_len).str_repeat("*", strlen($email_id[0]) - $visible_username_len)."@".
                substr($domain[0],0,$visible_domain_len).str_repeat("*", strlen($domain[0]) - $visible_domain_len).".".
                $domain[1];

        }

        public function validate_captcha()
        {
            if(strcmp($this->input->post('captcha'), $this->session->userdata['captcha']))
            {
                $this->form_validation->set_message('validate_captcha', "Wrong captcha code!");
                return false;
            }

            return true;
        }

        public function validate_mobileNumber()
        {
            $mobileNumberRegex = "/(\d{10})$/";

            if(!preg_match($mobileNumberRegex, $this -> input -> post('mobileNumber')))
            {
                $this->form_validation->set_message('validate_mobileNumber', "Mobile number must have 10 digits!");
                return false;
            }
            return true;
        }

        public function validate_confirm_password()
        {
            if(strcmp($this -> input -> post('password'), $this -> input -> post('password2')))
            {
                $this->form_validation->set_message('validate_confirm_password', "Passwords do not match!");
                return false;
            }
            return true;
        }

        public function formFilledCheck()
        {
            $member_id = $this -> input -> post('memberID');
            $email_id = $this -> input -> post('email');

            if(!$member_id && !$email_id)
            {
                $this -> data['error'] = "Both fields can't be empty";
                return false;
            }
            return true;
        }

        public function sendMail($email_id, $message)
        {
            $config = array(
                    'protocol' => 'mail',
                    'smtp_host' => 'p3plcpnl0820.prod.phx3.secureserver.net',
                    'smtp_port' => 465,
                    'smtp_user' => 'info@bvicam.org',
                    'smtp_pass' => 'CPAcc#4012',
                    'mailtype'  => 'text',
                    'charset'   => 'utf-8',
                    'wordwrap'  => true,
                    'wrapchars' => 50
                );
            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from('stevejobs@deadmail.com', 'Indiacom 2015');
            $this->email->to($email_id);
            $this->email->subject('Indiacom Registration');
            $this->email->message($message);

            if($this->email->send())
                return true;

            return false;
        }
		
		//uploading member bio data in temporary folder
        public function uploadTempBiodata($fileElem, $memberId)
        {
            $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . TEMP_BIODATA_FOLDER;
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $memberId . "_biodata";
            $config['overwrite'] = true;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload($fileElem))
            {
                return false;
            }
            $uploadData = $this->upload->data();

            return UPLOAD_PATH . TEMP_BIODATA_FOLDER . $config['file_name'] . $uploadData['file_ext'];
        }

        private function index($page)
        {
            require_once(dirname(__FILE__).'/../config/privileges.php');
            require_once(dirname(__FILE__).'/../utils/ViewUtils.php');
            $this->load->model('access_model');
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }

            if(isset($privilege['Page'][$page]) && !$this->access_model->hasPrivileges($privilege['Page'][$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            loginModalInit($this->data);
            $this -> data['navbarItem'] = pageNavbarItem($page);
            $this->load->view('templates/header', $this -> data);
            $this->load->view('pages/'.$page, $this -> data, array('error' => ' '));
            $this->load->view('templates/footer');

        }

        public function forgotPassword()
        {
            $page = "forgotPassword";

            $this->load->library('form_validation');
            $this -> load -> model('member_model');

            if(isset($_POST['Reset']) && $this->formFilledCheck())
            {
                $member_id = $this -> input -> post('memberID');
                $email_id = $this -> input -> post('email');

                if($email_id)
                {
                    if($member_info = $this -> member_model -> getMemberInfo_Email($email_id))
                    {
                        $member_id = $member_info['member_id'];
                        $encrypted_password = $member_info['member_password'];

                        if(!strcmp($email_id, $member_info['member_email']))
                        {
                            $activation_code = $encrypted_password; //$this -> assignActivationCode();

                            //$update_data = array('member_password'   =>  $activation_code);

                            //if($this -> member_model -> updateMemberInfo($update_data, $member_id))
                            {
                                $this -> data['member_id'] = $member_id;
                                $this -> data['activation_code'] = $activation_code;

                                $message = $this -> load -> view('pages/EmailResetPasswordLink', $this -> data, true);

                                if($page = $this -> sendMail($this -> input -> post('email'), $message))
                                    $this -> data['message'] = "An email has been sent to your registered mail id. Click on the activation link provided in the mail to reset your password";
                                else
                                    $this -> data['message'] = "Some problem occurred. Email can't be sent. Reset password unsuccessful";

                                $page = "signupSuccess";
                            }

                        }
                        else
                            $this -> data['email_id'] = $this -> hide_mail($member_info['member_email']);
                    }
                    else
                        $this -> data['error'] = "Sorry, no such email ID exists in our database";
                }

                if(!$email_id && $member_id)
                {
                    if($member_info = $this -> member_model -> getMemberInfo($member_id))
						$this -> data['email_id'] = $this -> hide_mail($member_info['member_email']);
					else
						$this -> data['error'] = "Sorry, no such member ID exists in our database";
                }

            }

            $this -> index($page);

        }

        public function assignActivationCode()
        {
            $active_str = array_merge(range(1,9));
            $str = implode("", $active_str);
            $activation_code  = substr(str_shuffle($str), 0, 8);
            return $activation_code;
        }

        public function signUp()
        {
            $page = "signup";

            $this->load->library('session');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('salutation', 'Salutation', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phoneNumber', 'Phone number', 'required');
            $this->form_validation->set_rules('countryCode', 'Country Code', 'required');
            $this->form_validation->set_rules('mobileNumber', 'Mobile number', 'required|callback_validate_mobileNumber');
            $this->form_validation->set_rules('organization', 'Organization', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('department', 'Department', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_validate_captcha');
            $this->form_validation->set_rules('fax', 'Fax Number');
            $this->form_validation->set_rules('csimembershipno', 'CSI Membership Number');
            $this->form_validation->set_rules('ietemembershipno', 'IETE Membership Number');
            $this->form_validation->set_rules('designation', 'Designation');
            $this->form_validation->set_rules('experience', 'Experience');


            if($this->form_validation->run())
            {
                $organization_id_array = $this -> registration_model -> getOrganizationId($this -> input -> post('organization'));
                $member_id = $this -> registration_model -> assignTempMemberId();
				
				if(($doc_path = $this->uploadTempBiodata('biodata', $member_id)) == false)
                {
                    $this->data['uploadError'] = $this->upload->display_errors();
                    $this->db->trans_rollback();
                }

                $activation_code  = md5($this -> assignActivationCode());

                $this->session->unset_userdata('captcha');
                $this->session->unset_userdata('image');

                if($organization_id_array)
                {
                    $member_record = array(
                                            'member_id'             =>   $member_id,
                                            'member_salutation'     =>   $this -> input -> post('salutation'),
                                            'member_name'           =>   $this -> input -> post('name'),
                                            'member_address'        =>   $this -> input -> post('address'),
                                            'member_pincode'        =>   $this -> input -> post('pincode'),
                                            'member_email'          =>   $this -> input -> post('email'),
                                            'member_phone'          =>   $this -> input -> post('phoneNumber'),
                                            'member_country_code'   =>   $this -> input -> post('countryCode'),
                                            'member_mobile'         =>   $this -> input -> post('mobileNumber'),
                                            'member_fax'            =>   $this -> input -> post('fax'),
                                            'member_designation'    =>   $this -> input -> post('designation'),
                                            'member_csi_mem_no'     =>   $this -> input -> post('csimembershipno'),
                                            'member_iete_mem_no'    =>   $this -> input -> post('ietemembershipno'),
                                            'member_password'       =>   $activation_code ,
                                            'member_organization_id'=>   $organization_id_array['organization_id'],
                                            'member_biodata_path'   =>   $doc_path,
                                            'member_category_id'    =>   $this -> input -> post('category'),
                                            'member_department'     =>   $this -> input -> post('department'),
                                            'member_experience'     =>   $this -> input -> post('experience'),
                                            'member_is_activated'   =>   ""
                                         );


                    if($this -> registration_model -> addTempMember($member_record))
                    {
                        $this -> data['member_id'] = $member_id;
                        $this -> data['activation_code'] = $activation_code;

                        $message = $this -> load -> view('pages/EmailActiveCode', $this -> data, true);

                        if($page = $this -> sendMail($this -> input -> post('email'), $message))
                        {
                            $this -> data['is_verified'] = 0;
                            $this -> data['message'] = "An email has been sent to your registered mail id. Click on the activation link provided in the mail to complete your registration process";
                        }
                        else
                            $this -> data['message'] = "Some problem occurred. Email can't be sent. Registration unsuccessful";

                        $page = "signupSuccess";
                    }
                }
            }
            else
            {
                $this -> load -> helper('captcha');
                $this -> load -> helper('url');

                $captcha_path = dirname(__FILE__)."/../../../CommonResources/assets/captcha/";

                $str = array_merge(range(1,9), range('a','z'), range('A', 'Z'));
                $str = implode("", $str);
                $word  = substr(str_shuffle($str), 0, 8);

                $captcha = array
                (
                    'word' => $word,
                    'img_path' => $captcha_path,
                    'img_url' => base_url() . '../CommonResources/assets/captcha/',
                    'font_path' => base_url() . '../CommonResources/assets/fonts/impact.ttf',
                    'img_width' => '200',
                    'img_height' => 40,
                    'expiration' => 3600
                );

              $img = create_captcha($captcha);

                $this -> data['image'] = $img['image'];
                $this -> data['member_categories'] = $this -> registration_model -> getMemberCategories();

                if(isset($this->session->userdata['image']) && file_exists($captcha_path.$this->session->userdata['image']))
                    unlink($captcha_path.$this->session->userdata['image']);

                $this->session->set_userdata(array('captcha'=>$word, 'image' => $img['time'].'.jpg'));

            }
            $this->index($page);
        }

        public function EnterPassword($member_id, $activation_code)
        {
            $page = "EnterPassword";

            $this->load->model('member_model');
            $this->load->library('encrypt');
            $this->load->library('form_validation');
            $this->load->library('ftp');

            $member_info = $this -> member_model -> getTempMemberInfo($member_id);

            if(strcmp($activation_code, $member_info['member_password']))// || $member_info['member_is_activated'])
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required|callback_validate_confirm_password');

            if($this->form_validation->run())
            {
                $pass = $this -> input -> post('password');
                $encrypted_password = md5($pass);
                $this -> data['message'] = "Some problem occurred. Email can't be sent. Registration unsuccessful";
                $this -> data['is_verified'] = 0;

                $biodata_url = SERVER_ROOT . UPLOAD_PATH . BIODATA_FOLDER;
                $assignedMemberId = $this->registration_model->assignMemberId();
                rename(SERVER_ROOT . $member_info['member_biodata_path'], $biodata_url."/{$assignedMemberId}_biodata");

                if($this -> registration_model -> deleteTempMember($member_id))
                {
                    $member_info["member_id"] = $this -> registration_model -> assignMemberId();
                    //$member_info["member_biodata_path"]=rename($biodata_url/"biodata.pdf",$biodata_url/$member_info["member_id"]."biodata.pdf");
                    $member_info["member_password"] = $encrypted_password;
                    $member_info["member_is_activated"] = 1;

                    $this -> data['member_id'] = $member_info["member_id"];

                    if($this -> registration_model -> addMember($member_info))
                    {
                        $message = $this -> load -> view('pages/ListOfServices', $this -> data, true);

                        if($this -> sendMail($member_info['member_email'], $message))
                        {
                            $this -> data['is_verified'] = 1;
                            $this -> data['message'] = "An email has been sent to your registered email id. This mail will let you know about the services that would be provided to you.";
                        }
                    }
                }

                $page = "signupSuccess";
            }

            $this->index($page);
        }


    }

?>