<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 8:49 PM
 */

class Login extends CI_Controller
{
    public $sample;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Member Id' ,'required|callback_usernameCheck');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_passwordCheck');
        if($this->form_validation->run())
        {
            unset($_SESSION['isFormError']);
            unset($_SESSION['usernameError']);
            unset($_SESSION['passwordError']);
            header('Location: /' . INDIACOM . 'Dashboard/home');
        }
        else
        {
            $_SESSION['isFormError'] = true;
            $_SESSION['usernameError'] = form_error('username');
            $_SESSION['passwordError'] = form_error('password');
            header('Location: ' . $this->input->get('redirect'));
        }

    }

    public function usernameCheck($username)
    {
        $_SESSION['sudo'] = true;
        $this->load->model('LoginModel');
        $this->LoginModel->setUsername($username);
        return true;
    }

    public function passwordCheck($password)
    {
        $this->LoginModel->setPassword($password);
        //$this -> LoginModel -> fetch();
        $this->LoginModel->setLoginType('M');
        if($this->LoginModel->authenticate())
        {
            return true;
        }
        $this->form_validation->set_message('passwordCheck', $this->LoginModel->error);
        return false;
    }

    public function logout()
    {
        //session_destroy();
        /*$_SESSION[APPID]['dbUserName'] = 'Minimal';
        $_SESSION[APPID]['dbPassword'] = '1234';*/
        unset($_SESSION[APPID]);
        header('location: /' . INDIACOM . 'index');
    }

}