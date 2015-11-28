<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/23/14
 * Time: 9:47 AM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class Page extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "Page";
        require(dirname(__FILE__) . '/../config/privileges.php');
        $this->privileges = $privilege;
    }

    public function index($page = 'home')
    {
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            show_404();
        }

        if($page == 'home' && !$this->checkAccess('home'))
            return;
        $this->load->model('access_model');
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {

    }

    public function login()
    {
        $page = "login";
        /*$this->load->model('role_model');
        $this->load->model('login_model');*/
        $this->load->helper('url');
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
                $roles = array();
                foreach($_SESSION[APPID]['role_id'] as $roleId)
                {
                    $roleDetails = $this->role_model->getRoleDetails($roleId);
                    if($roleDetails != null && $roleDetails->role_application_id."a" == APPID)
                        $roles[] = $roleDetails;
                }
                if(count($roles) > 1)
                {
                    $this->data['roles'] = $roles;
                    $page = "selectRole";
                }
                else
                {
                    $this->setRole($roles[0]->role_id);
                    return;
                }
            }
        }
        $this->index($page);
    }

    public function setRole($roleId = null)
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
        if($this->form_validation->run() || $roleId != null)
        {
            if($roleId == null)
                $roleId = $this->input->post('role_id');
            if($this->login_model->adminSetRole($roleId))
                redirect('Page/index');
            else
                redirect('Page/logout');
            return;
        }
        else
        {
            redirect('Page/login');
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