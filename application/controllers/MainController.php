<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

require(dirname(__FILE__).'/../config/privileges.php');
require(dirname(__FILE__).'/../utils/ViewUtils.php');

class MainController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AccessModel');
    }

    public function viewPage($page = "index")
    {
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privileges[$page]) && !$this->AccessModel->hasPrivileges($privileges[$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $data = loginModalInit();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
    }
}