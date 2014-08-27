<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/23/14
 * Time: 9:47 AM
 */

class Page extends CI_Controller
{
    private $data;
    public function __construct()
    {
        parent::__construct();
    }

    public function index($page = 'home')
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $this->load->model('AccessModel');
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        if($page == "home")
        {
            $this->data['loadableComponents'] = $this->AccessModel->getLoadableComponents($privilege['Component']);
        }
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function login()
    {
        $page = "login";
        $this->load->model('LoginModel');
        $this->load->model('EventModel');
        $this->load->model('RoleModel');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('emailId', 'Email Id', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run())
        {
            $this->LoginModel->setLoginType('A');
            $this->LoginModel->setUsername($this->input->post('emailId'));
            $this->LoginModel->setPassword($this->input->post('password'));
            if(!$this->LoginModel->authenticate())
            {
                $this->data['loginError'] = "Incorrect credentials";
            }
            else
            {
                $roles = array();
                foreach($_SESSION['role_id'] as $event=>$eventRoles)
                {
                    $eventDetails = $this->EventModel->getEventDetails($event);
                    foreach($eventRoles as $role)
                    {
                        $roleDetails = $this->RoleModel->getRoleDetails($role);
                        $roles[$event . "_" . $role] = $eventDetails->event_name . " " . $roleDetails->role_name;
                    }
                }
                $this->data['roles'] = $roles;
                $page = "selectRole";
                //redirect('Page/index');
            }
        }
        $this->index($page);
    }

    public function setRole()
    {
        $this->load->model('LoginModel');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_rules('event_role_id', 'Role', 'required');
        if($this->form_validation->run())
        {
            $event_role = explode('_', $this->input->post('event_role_id'));
            $event = $event_role[0];
            $role = $event_role[1];
            $this->LoginModel->adminSetRoleEvent($role, $event);
            redirect('Page/index');
        }
    }

    public function logout()
    {
        $this->load->helper('url');
        unset($_SESSION);
        session_destroy();
        redirect('Page/login');
    }
}