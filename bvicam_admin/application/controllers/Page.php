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
        if($page == "home")
        {
            $this->data['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($privilege['Page']);
        }
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function login()
    {
        $page = "login";
        /*$this->load->model('role_model');
        $this->load->model('login_model');*/
        $this->load->model('event_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('emailId', 'Email Id', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() || (isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated']))
        {
            $_SESSION['sudo'] = true;
            $this->load->model('login_model');
            $this->login_model->setLoginType('A');
            $this->login_model->setUsername($this->input->post('emailId'));
            $this->login_model->setPassword($this->input->post('password'));
            if(!$this->login_model->authenticate() && !(isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated']))
            {
                $this->data['loginError'] = $this->login_model->error;;
            }
            else
            {
                $_SESSION['sudo'] = true;
                $this->load->model('role_model');
                $_SESSION['sudo'] = true;
                $this->load->model('application_model');
                $applications = $this->application_model->getAllApplications();
                foreach($applications as $app)
                {
                    $this->data['applications'][$app->application_id] = $app->application_name;
                }
                $roles = array();
                foreach($_SESSION[APPID]['role_id'] as $roleId)
                {
                    {
                        $roleDetails = $this->role_model->getRoleDetails($roleId);
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
        $this->load->model('event_model');
        if(isset($_SESSION[APPID]['authenticated']) && $_SESSION[APPID]['authenticated'])
        {
            $_SESSION['sudo'] = true;
        }
        $this->load->model('login_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        if($this->form_validation->run())
        {
            $role = $this->input->post('role_id');
            if($this->login_model->adminSetRole($role))
                redirect('Page/index');
            else
            {
                redirect('Page/logout');
            }
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