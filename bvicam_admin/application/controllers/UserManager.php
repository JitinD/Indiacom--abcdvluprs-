<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/11/14
 * Time: 8:31 PM
 */

class UserManager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/UserManager/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar');
        $this->load->view('pages/UserManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function newUser()
    {
        $page = "newUser";
        $this->load->model('EventModel');
        $this->load->model('RoleModel');
        $this->data['events'] = $this->EventModel->getAllEvents();
        $this->data['roles'] = $this->RoleModel->getAllRoles();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userEmail', 'Email Id', 'required');
        $this->form_validation->set_rules('userName', 'Name', 'required');
        $this->form_validation->set_rules('userPassword', 'Password', 'required');

        if($this->form_validation->run())
        {
            $userDetails = array(
                'user_name' => $this->input->post('userName'),
                'user_email' => $this->input->post('userEmail'),
                'user_password' => $this->input->post('userPassword')
            );
        }
        $this->index($page);
    }
}