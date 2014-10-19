<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 2:00 PM
 */
class NewsManager extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $folder = "NewsManager/";
        require(dirname(__FILE__) . '/../config/privileges.php');
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');
        if (!file_exists(APPPATH . "views/pages/$folder" . $page . '.php')) {
            show_404();
        }
        if (isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->load->view('templates/header', $this->data);
        $this->load->view("pages/{$folder}$page", $this->data);
        $this->load->view('templates/footer');
    }

    public function load($appId = -1)
    {
        $page = "allNews";
        $this->load->library('form_validation');
        $this->load->model('ApplicationModel');
        $this->load->model('NewsModel');
        $this->data['currentAppId'] = $appId;
        $this->data['allApplications'] = $this->ApplicationModel->getAllApplications();
        if($appId != -1)
        {
            $this->data['allNews'] = $this->NewsModel->getAllNewsInclDirtyByAppId($appId);
            $appName = str_replace(' ', '', $this->ApplicationModel->getApplicationName($appId));
            $this->data['addNewsController'] = "NewsManager_$appName";
        }
        else
        {
            $this->data['allNews'] = $this->NewsModel->getAllNewsInclDirty();
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

    /*public function addNews($appId)
    {
        $this->loadViews($appId);
    }*/

    protected function addNewsSubmitHandle($appId)
    {
        $this->load->model('NewsModel');
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
            $this->NewsModel->addNews($newsDetails);
            return $newsDetails['news_id'];
        }
        return null;
    }

    // Upload news description
    //THIS FUNCTION NOT REQUIRED ANYMORE.
    /*public function uploadNewsDescription($fileElem, $eventId, $newsId)
    {
        $config['upload_path'] = 'C:/xampp/htdocs/Indiacom2015/indiacom_online/application/views/news';
        $config['allowed_types'] = 'html';
        $config['file_name'] = $newsId . "News";
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($fileElem)) {
            return false;
        }
        $uploadData = $this->upload->data();

        return "news" . "/" . $config['file_name'] . $uploadData['file_ext'];
    }*/


    /*private function loadViews($appId)
    {
        $folder = "NewsManager/";
        $this->load->model('ApplicationModel');
        $applicationDetails = $this->ApplicationModel->getApplicationName($appId);
        $appName = str_replace(' ', '', $applicationDetails->application_name);

        $this->load->view('templates/header', $this->data);
        $this->load->view("pages/{$folder}addNews", array("appName"=>$appName));
        $this->load->view("pages/{$folder}addNews" . $appName);
        $this->load->view('templates/footer');
    }*/
}



