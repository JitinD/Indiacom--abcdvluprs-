<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:06 PM
 */
class ReportManager extends CI_Controller
{

    private $data = array();

    public function __construct()
    {
        parent::__construct();

    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__) . '/../config/privileges.php');
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');

        if (!file_exists(APPPATH . 'views/pages/ReportManager/' . $page . '.php')) {
            show_404();
        }
        if (isset($privilege['Page']['ReportManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['ReportManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('pages/ReportManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function getReport($sql)
    {
        $page = "viewReport";
        $this->load->helper('url');
        $this->load->model('reports_model');
        $this->data['fields'] = $this->reports_model->getQueryFields();
        $this->data['results']= $this->reports_model->getQueryReport();

        $this->index($page);
    }

    public function home()
    {
        $page = "queryInput";
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('query', 'Query Field', 'required');
        $sql= str_replace('%20',' ',($this->input->get("query")));
        if($sql!=null)
        {
            redirect('/ReportManager/getReport/'.$sql);
        }

        $this->index($page);
    }
}

?>
