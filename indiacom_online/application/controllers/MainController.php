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
    }

    public function viewPage($page = "index")
    {
        $_SESSION['sudo'] = true;
        $this->load->model('AccessModel');
        $this->load->model('IndiacomNewsModel');
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

        $data = loginModalInit();
        $data['stickyNews']=$this->IndiacomNewsModel->getPublishedStickyNews();
        $data['nonStickyNews'] = $this->IndiacomNewsModel->getPublishedNonStickyNews();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
    }
}