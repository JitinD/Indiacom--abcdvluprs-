<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/27/14
 * Time: 9:45 AM
 */
class NewsController extends CI_Controller
{
    public function __construct() {
        parent:: __construct();
        $this->load->helper("url");
        $this->load->model('AccessModel');
        $this->load->model("AllNewsModel");
        $this->load->library("pagination");
    }

    public function AllNews($page = 0) {


        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $config = array();
        $config["base_url"] = base_url() ."d/NewsController/AllNews";
        $config["total_rows"] = $this->AllNewsModel->record_count();
        $config["per_page"] = 1;
        $config["uri_segment"] = 4;

        $this->pagination->initialize($config);

        //$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data = loginModalInit();
        $data["results"] = $this->AllNewsModel->fetch_news($config["per_page"], $page);
        $data['links'] = $this->pagination->create_links();
        $data['navbarItem'] = pageNavbarItem("");
        $this->load->view('templates/header', $data);
        $this->load->view('pages/news', $data);
        $this->load->view('templates/footer');

    }
}
?>