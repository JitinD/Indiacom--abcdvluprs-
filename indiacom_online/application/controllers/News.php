<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/27/14
 * Time: 9:45 AM
 */
class News extends CI_Controller
{
    private $data;

    public function __construct() {
        parent:: __construct();
    }

    private function index($page)
    {
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $this->load->model('AccessModel');
        if ( ! file_exists(APPPATH.'views/pages/news/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        loginModalInit($this->data);

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/news/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function load($page = 0)
    {
        $this->load->library("pagination");
        $this->load->model('IndiacomNewsModel');
        /*$config = array();
        $config["base_url"] = BASEURL."NewsController/AllNews";
        $config["total_rows"] = 5;//$this->IndiacomNewsModel->record_count();
        $config["per_page"] = 5;
        $config["uri_segment"] = 4;

        $this->pagination->initialize($config);*/

        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->data['results'] = $this->IndiacomNewsModel->getPublishedStickyNews();
        $this->data['results'] = array_merge($this->data['results'], $this->IndiacomNewsModel->getPublishedNonStickyNews());

        $this->data['links'] = $this->pagination->create_links();
        $this->index("news");
    }

    public function viewNews($newsId)
    {
        $this->load->model('IndiacomNewsModel');
        $this->load->model('NewsModel');
        $this->data['extraDetails'] = $this->IndiacomNewsModel->getNewsDetails($newsId);
        $this->data['basicDetails'] = $this->NewsModel->getNewsDetails($newsId);
        $this->data['attachments'] = $this->IndiacomNewsModel->getNewsAttachments($newsId);
        $this->index("newsitem");
    }
}