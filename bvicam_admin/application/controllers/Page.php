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
            $this->data['loadableComponents'] = $this->AccessModel->getLoadableDashboardComponents($privilege['Component']);
        }
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function login()
    {
        $page = "login";
        /*$this->load->model('RoleModel');
        $this->load->model('LoginModel');*/
        $this->load->model('EventModel');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('emailId', 'Email Id', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() || (isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated']))
        {
            $_SESSION['sudo'] = true;
            $this->load->model('LoginModel');
            $this->LoginModel->setLoginType('A');
            $this->LoginModel->setUsername($this->input->post('emailId'));
            $this->LoginModel->setPassword($this->input->post('password'));
            if(!$this->LoginModel->authenticate() && !(isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated']))
            {
                $this->data['loginError'] = $this->LoginModel->error;;
            }
            else
            {
                $_SESSION['sudo'] = true;
                $this->load->model('RoleModel');
                $_SESSION['sudo'] = true;
                $this->load->model('ApplicationModel');
                $applications = $this->ApplicationModel->getAllApplications();
                foreach($applications as $app)
                {
                    $this->data['applications'][$app->application_id] = $app->application_name;
                }
                $roles = array();
                foreach($_SESSION[APPID]['role_id'] as $roleId)
                {
                    {
                        $roleDetails = $this->RoleModel->getRoleDetails($roleId);
                        if($roleDetails != null)
                            $roles[] = $roleDetails;
                    }
                }
                $this->data['roles'] = $roles;
                $page = "selectRole";
            }
        }
        $this->index($page);
    }

    public function setRole()
    {
        $this->load->model('EventModel');
        if(isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated'])
        {
            $_SESSION['sudo'] = true;
        }
        $this->load->model('LoginModel');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        if($this->form_validation->run())
        {
            $role = $this->input->post('role_id');
            $this->LoginModel->adminSetRole($role);
            redirect('Page/index');
        }
    }

    public function logout()
    {
        $this->load->helper('url');
        unset($_SESSION[APPID]);
        //session_destroy();
        redirect('Page/login');
    }
}