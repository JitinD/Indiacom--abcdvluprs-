<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

    require(dirname(__FILE__).'/../config/privileges.php');
    require(dirname(__FILE__).'/../utils/ViewUtils.php');

    class SignUpController extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();

            $this -> load -> model('RegistrationModel');
            $this->load->library('encrypt');
        }

        public function validate_captcha()
        {
            if(strcmp($this->input->post('captcha'), $this->session->userdata['captcha']['word']))
            {
                $this->form_validation->set_message('validate_captcha', "Wrong captcha code!");
                return false;
            }

            return true;
        }

        public function index()
        {
            $page = "signup";
            $captcha_path = "C:/xampp/htdocs/Indiacom2015/application/assets/captcha/";

            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }
            if(isset($privilege[$page]) && !$this->AccessModel->hasPrivileges($privilege[$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

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
                $category_id_array = $this -> RegistrationModel -> getMemberCategoryId($this -> input -> post('category'));
                $member_id = $this -> RegistrationModel -> assignMemberId();

                $pass = $this -> input -> post('password');
                $encrypted_password = $this->encrypt->encode($pass);

                if(file_exists($captcha_path.$this->session->userdata['image']))
                    unlink($captcha_path.$this->session->userdata['image']);

                $this->session->unset_userdata('captcha');
                $this->session->unset_userdata('image');

                if($organization_id_array && $category_id_array)
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
                                            'member_pass'           =>   $encrypted_password ,
                                            'member_organization_id'=>   $organization_id_array['organization_id'],
                                            'member_biodata_path'   =>   $this -> input -> post('biodata'),
                                            'member_category_id'    =>   $category_id_array['member_category_id'],
                                            'member_experience'     =>   $this -> input -> post('experience')
                                         );




                    $this -> RegistrationModel -> addMember($member_record);

                    header('Location: MainController/viewPage/index');   // move to successful registration page.

                }

            }
            else
            {
                $this -> load -> helper('captcha');
                $this -> load -> helper('url');

                $str = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
                $str = implode("", $str);
                $word  = substr(str_shuffle($str), 0, 8);

                $captcha = array
                (
                    'word'	=> $word,
                    'img_path'	=> $captcha_path,
                    'img_url'	=> base_url().'application/assets/captcha/',
                    'font_path'	=> '../assets/fonts/impact.ttf',
                    'img_width'	=> '200',
                    'img_height' => 40,
                    'expiration' => 3600
                );

                $img = create_captcha($captcha);
                $data = loginModalInit();
                $data['navbarItem'] = pageNavbarItem($page);
                $data['image'] = $img['image'];

                $this->load->view('templates/header', $data);
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/footer');

                $this->session->set_userdata(array('captcha'=>$captcha, 'image' => $img['time'].'.jpg'));
            }
        }
    }

?>