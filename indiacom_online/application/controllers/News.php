<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/27/14
 * Time: 9:45 AM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class News extends BaseController
{
    public function __construct() {
        parent::__construct();
        $this->controllerName = "News";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/news/'.$page.'.php'))
        {
            show_404();
        }

        loginModalInit($this->data);

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/news/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function load($page = 0)
    {
        if(!$this->checkAccess("load"))
            return;
        $this->load->library("pagination");
        $this->load->model('indiacom_news_model');
        /*$config = array();
        $config["base_url"] = BASEURL."NewsController/AllNews";
        $config["total_rows"] = 5;//$this->indiacom_news_model->record_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 4;

        $this->pagination->initialize($config);*/

        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['results'] = $this->indiacom_news_model->getPublishedStickyNews();
        $this->data['results'] = array_merge($this->data['results'], $this->indiacom_news_model->getPublishedNonStickyNews());

        $this->data['links'] = $this->pagination->create_links();
        $this->index("news");
    }

    public function viewNews($newsId)
    {
        if(!$this->checkAccess("viewNews"))
            return;
        $this->load->model('indiacom_news_model');
        $this->load->model('news_model');
        $this->data['extraDetails'] = $this->indiacom_news_model->getNewsDetails($newsId);
        $this->data['basicDetails'] = $this->news_model->getNewsDetails($newsId);
        $this->data['attachments'] = $this->indiacom_news_model->getNewsAttachments($newsId);
        $this->index("newsitem");
    }
}