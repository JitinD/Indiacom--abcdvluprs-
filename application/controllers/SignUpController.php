<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

class SignUpController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this -> load -> model('RegistrationModel');
    }

    public function register($page = "signup")
    {
        $privs = $this->getRequiredPrivileges($page);

        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }
        if($privs && !$this->AccessModel->hasPrivileges($privs))
        {
            die("Unauthorised Access");
        }

        $data['page'] = $this->getLogicalName($page); // Capitalize the first letter
        $data['isFormError'] = false;

        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phoneNumber', 'Phone number', 'required');
        $this->form_validation->set_rules('organization', 'Organization', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required');

        if($this->form_validation->run())
        {

            $organization_id_array = $this -> RegistrationModel -> getOrganizationId($this -> input -> post('organization'));
            $category_id_array = $this -> RegistrationModel -> getMemberCategoryId($this -> input -> post('category'));

            if($organization_id_array && $category_id_array)
            {

                $member_record = array(
                                        'member_id'             =>   "18",
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
                                        'member_pass'           =>   $this -> input -> post('password'),
                                        'member_organization_id'=>   $organization_id_array['organization_id'],
                                        'member_biodata_path'   =>   $this -> input -> post('biodata'),
                                        'member_category_id'    =>   $category_id_array['member_category_id'],
                                        'member_experience'     =>   $this -> input -> post('experience')
                                     );




                $this -> RegistrationModel -> addMember($member_record);

               // header('Location: index');

            }
            else
            {
                echo "<h1>Not workingMember</h1>";
            }
        }
        else
        {
            if($this->input->post('submit') == "1")
            {
                $data['isFormError'] = true;
            }
            $this->load->view('pages/loginPage', $data);
            echo "<h1>Not working</h1>";
        }

        $this->load->view('templates/banner');
        $this->load->view('templates/quickLinks');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }


    private function getLogicalName($pageFileName)
    {
        switch($pageFileName)
        {
            case "index" :
                return "Home";
            case "aboutIndiacom":
                return "About INDIACom";
            default:
                return "";
        }
    }

    private function getRequiredPrivileges($page)
    {
        switch($page)
        {
            case "TestPage" :
                return array("P1", "P2");
            default:
                return false;
        }
    }
}