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

        public function index()
        {
            $page = "signup";

            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }
            if(isset($privilege[$page]) && !$this->AccessModel->hasPrivileges($privilege[$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

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

            if($this->form_validation->run())
            {

                $organization_id_array = $this -> RegistrationModel -> getOrganizationId($this -> input -> post('organization'));
                $category_id_array = $this -> RegistrationModel -> getMemberCategoryId($this -> input -> post('category'));
                $member_id = $this -> RegistrationModel -> assignMemberId();
                $pass = $this -> input -> post('password');
                $encrypted_password = $this->encrypt->encode($pass);
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

                    header('Location: MainController/index');

                }

            }
            else
            {
                $data = loginModalInit();
                $data['navbarItem'] = pageNavbarItem($page);
                $this->load->view('templates/header', $data);
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/footer');
            }
        }
    }

?>