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

    public function index($page)
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
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
//        $this->load->view('templates/sidebar');
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function login()
    {
        $page = "login";
        $this->load->model('LoginModel');
        $this->load->library('form_validation');
        $this->load->helper('url');
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
                redirect('home');
            }
        }
        $this->index($page);
    }
}