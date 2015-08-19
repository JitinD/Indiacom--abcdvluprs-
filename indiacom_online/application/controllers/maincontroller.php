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
        $this->load->model('access_model');
        $this->load->model('indiacom_news_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/static/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->access_model->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $data = loginModalInit();
        $data['stickyNews']=$this->indiacom_news_model->getPublishedStickyNews();
        $data['nonStickyNews'] = $this->indiacom_news_model->getPublishedNonStickyNews();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/static/'.$page, $data);
        $this->load->view('templates/footer');
    }

    public function index($page = 'index')
    {
        $_SESSION['sudo'] = true;
        $this->load->model('access_model');
        $this->load->model('indiacom_news_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/static/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->access_model->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $data = loginModalInit();
        $data['stickyNews']=$this->indiacom_news_model->getPublishedStickyNews();
        $data['nonStickyNews'] = $this->indiacom_news_model->getPublishedNonStickyNews();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/static/'.$page, $data);
        $this->load->view('templates/footer');
    }
}