<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class MainController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "MainController";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    public function sample()
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->load->model('sample_model');
        $this->sample_model->sample($privilege);
    }

    public function viewPage($page)
    {
        if(!$this->checkAccess("viewPage"))
            return;
        $this->index($page);
    }

    public function index($page = "index")
    {
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $_SESSION['sudo'] = true;
        $this->load->model('indiacom_news_model');

        if ( ! file_exists(APPPATH.'views/pages/static/'.$page.'.php'))
        {
            show_404();
        }
        if($page == "index" && !$this->checkAccess("index"))
            return;

        $data = loginModalInit();
        $data['stickyNews']=$this->indiacom_news_model->getPublishedStickyNews();
        $data['nonStickyNews'] = $this->indiacom_news_model->getPublishedNonStickyNews();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/static/'.$page, $data);
        $this->load->view('templates/footer');
    }
}