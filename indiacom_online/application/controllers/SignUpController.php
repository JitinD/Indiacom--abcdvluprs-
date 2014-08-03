<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */
 
	require_once(dirname(__FILE__).'/../config/privileges.php');
    require_once(dirname(__FILE__).'/../utils/ViewUtils.php');

    class SignUpController extends CI_Controller
    {
        private $data;

        public function __construct()
        {
            parent::__construct();

            $this -> load -> model('RegistrationModel');
            $this->load->helper(array('form', 'url'));

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

        public function validate_confirm_password()
        {
            if(strcmp($this -> input -> post('password'), $this -> input -> post('password2')))
            {
                $this->form_validation->set_message('validate_confirm_password', "Passwords do not match!");
                return false;
            }
            return true;
        }

        public function sendMail($email_id, $message)
        {
            $this->load->library('email');

            $this->email->from('indiacom15@gmail.com', 'Indiacom 2015');

            $this->email->to($email_id);
            $this->email->subject('Indiacom Registration');
            $this->email->message($message);

            if($this->email->send())
                return true;

            return false;
        }

        //uploading member bio data
        public function uploadBiodata($fileElem,$eventId,$memberId)
        {
            $config['upload_path'] = "C:/xampp/htdocs/Indiacom2015/uploads/biodata/".$eventId;
            $config['allowed_types'] = 'doc|docx';
            $config['file_name'] = $memberId . "biodata";
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload($fileElem))
            {
                return false;
            }
            $uploadData = $this->upload->data();

            return $config['upload_path'] . "/" . $config['file_name'] . $uploadData['file_ext'];
        }

        private function index($page)
        {
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }

            if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            loginModalInit($this->data);
            $this -> data['navbarItem'] = pageNavbarItem($page);
            $this->load->view('templates/header', $this -> data);
            $this->load->view('pages/'.$page, $this -> data,array('error' => ' ' ));
            $this->load->view('templates/footer');
        }

        public function EnterPassword($member_id, $activation_code)
        {
            $page = "EnterPassword";

            $this -> load -> model('MemberModel');
            $this->load->library('encrypt');
            $this->load->library('form_validation');

            $member_info = $this -> MemberModel -> getMemberInfo($member_id);

            if(strcmp($activation_code, $member_info['member_password']) || $member_info['member_is_activated'])
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

                $update_data = array(
                                        'member_password'   =>  $encrypted_password,
                                        'member_is_activated'  =>  1
                                    );

                $this -> data['member_id'] = $member_id;

                if($this -> MemberModel -> updateMemberInfo($update_data, $member_id))
                {
                    $message = $this -> load -> view('pages/ListOfServices', $this -> data, true);

                    if($this -> sendMail($member_info['member_email'], $message))
                        $this -> data['message'] = "An email has been sent to your registered email id. This mail will let you know about the services that would be provided to you.";
                    else
                        $this -> data['message'] = "Some problem occurred. Email can't be sent. Registration unsuccessful";

                    $page = "signupSuccess";
                }
            }

            $this->index($page);
        }




        public function signUp()
        {

            $page = "signup";

            $this->load->library('session');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('phoneNumber', 'Phone number', 'required');
            $this->form_validation->set_rules('mobileNumber', 'Mobile number', 'required');
            $this->form_validation->set_rules('organization', 'Organization', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_validate_captcha');

            if($this->form_validation->run())
            {

                $organization_id_array = $this -> RegistrationModel -> getOrganizationId($this -> input -> post('organization'));
                $member_id = $this -> RegistrationModel -> assignMemberId();

                if(($doc_path = $biodata_url=$this->uploadBiodata('biodata',1,$member_id)) == false)
                {
                    $this->data['uploadError'] = $this->upload->display_errors();
                    $this->db->trans_rollback();
                }

                $active_str = array_merge(range(1,9));
                $str = implode("", $active_str);
                $activation_code  = substr(str_shuffle($str), 0, 8);

                $this->session->unset_userdata('captcha');
                $this->session->unset_userdata('image');

                if($organization_id_array)
                {
                    $member_record = array(
                                            'member_id'             =>   $member_id,
                                            'member_name'           =>   $this -> input -> post('name'),
                                            'member_address'        =>   $this -> input -> post('address'),
                                            'member_pincode'        =>   $this -> input -> post('pincode'),
                                            'member_email'          =>   $this -> input -> post('email'),
                                            'member_phone'          =>   $this -> input -> post('phoneNumber'),
                                            'member_mobile'         =>   $this -> input -> post('mobileNumber'),
                                            'member_fax'            =>   $this -> input -> post('fax'),
                                            'member_designation'    =>   "",
                                            'member_csi_mem_no'     =>   $this -> input -> post('csimembershipno'),
                                            'member_iete_mem_no'    =>   $this -> input -> post('ietemembershipno'),
                                            'member_password'       =>   $activation_code ,
                                            'member_organization_id'=>   $organization_id_array['organization_id'],
                                            'member_biodata_path'   =>   $doc_path,
                                            'member_category_id'    =>   $this -> input -> post('category'),
                                            'member_experience'     =>   $this -> input -> post('experience'),
                                            'member_is_activated'   =>   ""
                                         );


                    if($this -> RegistrationModel -> addMember($member_record))
                    {
                        $this -> data['member_id'] = $member_id;
                        $this -> data['activation_code'] = $activation_code;

                        $message = $this -> load -> view('pages/EmailActiveCode', $this -> data, true);

                        if($page = $this -> sendMail($this -> input -> post('email'), $message))
                            $this -> data['message'] = "An email has been sent to your registered mail id. Click on the activation link provided in the mail to complete your registration process";
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
                    'word'	=> $word,
                    'img_path'	=> $captcha_path,
                    'img_url'	=> base_url().'../CommonResources/assets/captcha/',
                    'font_path'	=> base_url().'../CommonResources/assets/fonts/impact.ttf',
                    'img_width'	=> '200',
                    'img_height' => 40,
                    'expiration' => 3600
                );

              $img = create_captcha($captcha);

                $this -> data['image'] = $img['image'];
                $this -> data['member_categories'] = $this -> RegistrationModel -> getMemberCategories();

                if(isset($this->session->userdata['image']) && file_exists($captcha_path.$this->session->userdata['image']))
                    unlink($captcha_path.$this->session->userdata['image']);

                $this->session->set_userdata(array('captcha'=>$word, 'image' => $img['time'].'.jpg'));

            }
            $this->index($page);
        }

    }

?>