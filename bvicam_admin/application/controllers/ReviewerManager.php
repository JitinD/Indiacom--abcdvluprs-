<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 4/8/15
 * Time: 8:02 PM
 */

class ReviewerManager extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $controllerName = "ReviewerManager";
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH."views/pages/{$controllerName}/".$page.".php"))
        {
            show_404();
        }
        if(isset($privilege['Page'][$controllerName][$page]) && !$this->access_model->hasPrivileges($privilege['Page'][$controllerName][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $this->data['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($privilege['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view("pages/{$controllerName}/".$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {
        $links['newUser'] = "Add new reviewer";
        $links['load'] = "View All Reviewers";
        return $links;
    }

    public function load()
    {
        $page = "index";
        $this->index($page);
    }
}