<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 2:00 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class NewsManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "NewsManager";
        require(dirname(__FILE__) . '/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        $folder = "NewsManager/";
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if (!file_exists(APPPATH . "views/pages/$folder" . $page . '.php')) {
            show_404();
        }
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view("pages/{$folder}$page", $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {
        /*$links['viewPaymentsMemberWise'] = "View payments memberwise";
        $links['viewPaymentsPaperWise'] = "View payments paperwise";
        $links['newPayment'] = "New payment";
        $links['spotPayments'] = "Spot payment";
        return $links;*/
    }

    public function load($appId = -1)
    {
        if(!$this->checkAccess("load"))
            return;
        $page = "allNews";
        $this->load->library('form_validation');
        $this->load->model('application_model');
        $this->load->model('news_model');
        $this->data['currentAppId'] = $appId;
        $this->data['allApplications'] = $this->application_model->getAllApplications();
        if($appId != -1)
        {
            $this->data['allNews'] = $this->news_model->getAllNewsInclDirtyByAppId($appId);
            $appName = str_replace(' ', '', $this->application_model->getApplicationName($appId));
            $this->data['addNewsController'] = "NewsManager_$appName";
        }
        else
        {
            $this->data['allNews'] = $this->news_model->getAllNewsInclDirty();
            $this->data['addNewsController'] = "NewsManager";
        }

        $this->index($page);
    }

    public function changeApplication()
    {
        $this->load->helper('url');
        $appId = $this->input->post('application');
        if($appId != -1)
            redirect("/NewsManager/load/$appId");
        redirect("/NewsManager/load/");
    }

    protected function addNewsSubmitHandle($appId)
    {
        $this->load->model('news_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', "News Title", 'required');
        $this->form_validation->set_rules('content', "News Content", 'required');
        $this->form_validation->set_rules('publishDate', "News Content", 'required');

        if($this->form_validation->run())
        {
            $newsDetails = array(
                "news_title" => $this->input->post('title'),
                "news_content" => $this->input->post('content'),
                "news_publish_date" => $this->input->post('publishDate'),
                "news_application_id" => $appId
            );
            $this->news_model->addNews($newsDetails);
            return $newsDetails['news_id'];
        }
        return null;
    }

    protected function disableNews($newsId)
    {
        $this->load->model('news_model');
        $this->news_model->disableNews($newsId);
    }

    protected function enableNews($newsId)
    {
        $this->load->model('news_model');
        $this->news_model->enableNews($newsId);
    }

    protected function deleteNews($newsId)
    {
        $this->load->model('news_model');
        $this->news_model->deleteNews($newsId);
    }
}



