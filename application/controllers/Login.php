<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 16/7/14
 * Time: 2:49 PM
 */

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginModel');
    }

    public function authenticate()
    {
        $this->load->library('form_validation');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->form_validation->set_rules('username', 'User Name' , 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run())
        {
            if($this->LoginModel->authenticate($username, $password))
            {
                $this->load->view('pages/aboutIndiacom');
            }
            //$this->load->view('pages/aboutIndiacom');
            //$this->load->view('pages/loginPage');
        }
    }
}