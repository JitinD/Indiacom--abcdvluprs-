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
            $this->load->library('encrypt');
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
            $this->load->view('pages/'.$page, $this -> data);
            $this->load->view('templates/footer');

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
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_validate_captcha');

            if($this->form_validation->run())
            {

                $organization_id_array = $this -> RegistrationModel -> getOrganizationId($this -> input -> post('organization'));
                $member_id = $this -> RegistrationModel -> assignMemberId();

                $pass = $this -> input -> post('password');
                $encrypted_password = md5($pass);//$this->encrypt->encode($pass);



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
                                            'member_password'       =>   $encrypted_password ,
                                            'member_organization_id'=>   $organization_id_array['organization_id'],
                                            'member_biodata_path'   =>   "",
                                            'member_category_id'    =>   $this -> input -> post('category'),
                                            'member_experience'     =>   $this -> input -> post('experience')
                                         );


                    print_r($member_record);

                    if($this -> RegistrationModel -> addMember($member_record))
                    {
                        $page .= "Success";

                        $message = "You are successfully registered.";

                        $this -> data['member_id'] = $member_id;

                        $this->load->library('email');

                        $this->email->from('indiacom15@gmail.com', 'Indiacom 2015');
                        $this->email->to($this -> input -> post('email'));
                        $this->email->subject('Email Test');
                        $this->email->message($message);

                        if($this->email->send())
                            $this -> data['message'] = "An email has been sent to your registered email id";
                        else
                            $this -> data['message'] = "Email can't be sent.";

                    }


                    //header('Location: SignUpController');   // move to successful registration page.

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