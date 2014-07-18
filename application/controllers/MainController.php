<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

class MainController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
    }

    public function viewPage($page = "index")
    {
        if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['page'] = $this->getLogicalName($page); // Capitalize the first letter
        $data['isFormError'] = false;

        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);

        $this->load->library('form_validation');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->form_validation->set_rules('username', 'Member Id' ,'required|callback_usernameCheck');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_passwordCheck');
        if($this->form_validation->run())
        {
            $_SESSION['UserName'] = $username;
            $_SESSION['Password'] = $password;
        }
        else
        {
            if($this->input->post('submit') == "1")
            {
                $data['isFormError'] = true;
            }
            $this->load->view('pages/loginPage', $data);
        }

        $this->load->view('templates/banner');
        $this->load->view('templates/quickLinks');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function usernameCheck($username)
    {
        $this->LoginModel->setUsername($username);
        return true;
    }

    public function passwordCheck($password)
    {
        $this->LoginModel->setPassword($password);
        if($this->LoginModel->authenticate())
        {
            return true;
        }
        $this->form_validation->set_message('passwordCheck', 'Member id or password is invalid');
        return false;
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
}