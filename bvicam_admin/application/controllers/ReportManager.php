<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:06 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class ReportManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "ReportManager";
        require(dirname(__FILE__) . '/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if (!file_exists(APPPATH . 'views/pages/ReportManager/' . $page . '.php')) {
            show_404();
        }
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view('pages/ReportManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {
        $links['paymentsReport'] = "Payment Report";
        return $links;
    }

    public function downloadReport()
    {
        if(!$this->checkAccess("downloadReport"))
            return;
        $this->load-> helper ('download');
        $data=file_get_contents(SERVER_ROOT.BASEURL.'reports/report.csv');
        $name = date("Y/m/d").".csv";
        force_download ($name, $data);

    }
    public function getReport($sql1)
    {
        if(!$this->checkAccess("getReport"))
            return;
        $page = "viewReport";
        $this->load->helper('url');
        $this->load->model('reports_model');
        $sql = rawurldecode($sql1);
        $this->data['fields'] = $this->reports_model->getQueryFields($sql);
        $this->data['results'] = $this->reports_model->getQueryReport($sql);
        $this->reports_model->writeToFile($sql);


        $this->index($page);
    }

    public function home()
    {
        if(!$this->checkAccess("home"))
            return;
        $page = "queryInput";
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('query', 'Query Field', 'required');
        $sql = $this->input->post("query");

        if ((strpos($sql, 'insert') === FALSE) && (strpos($sql, 'Insert') === FALSE)&&(strpos($sql, 'INSERT') === FALSE)&&(strpos($sql, 'update') === FALSE) && (strpos($sql, 'Update') === FALSE)&&(strpos($sql, 'UPDATE') === FALSE)&& (strpos($sql, 'delete') === FALSE)&&(strpos($sql, 'Delete') === FALSE)&&(strpos($sql, 'DELETE') === FALSE)) {
            if ($sql != null) {
                redirect('/ReportManager/getReport/' . $sql);

            }
        } else {
            $this->data['error'] = 0;
        }

        $this->index($page);
    }

    public function paymentsReport()
    {
        if(!$this->checkAccess("paymentsReport"))
            return;
        $page = "paymentReport";
        $this->load->model('paper_status_model');
        $this->load->model('member_model');
        $this->load->model('submission_model');
        $this->load->model('payment_model');
        $this->load->model('member_categories_model');
        $this->load->model('transaction_model');
        $this->load->model('transaction_mode_model');
        $submissions = $this->data['submissions'] = $this->paper_status_model->getAcceptedPapersMembers();
        $this->data['memCategories'] = $this->member_categories_model->getMemberCategoriesAsAssocArray();
        $this->data['transModes'] = $this->transaction_mode_model->getAllTransactionModesAsAssocArray();
        $membersInfo = array();
        foreach($submissions as $submission)
        {
            if(!isset($membersInfo[$submission->member_id]['memberBasicInfo']))
            {
                $membersInfo[$submission->member_id]['memberBasicInfo'] = $this->member_model->getMemberInfo($submission->member_id);
                $membersInfo[$submission->member_id]['isProfBodyMember'] = $this->member_model->isProfBodyMember($submission->member_id);
                $membersInfo[$submission->member_id]['transactions'] = $this->transaction_model->getMemberPaymentsTransactions($submission->member_id);
                $payables[$submission->member_id] = $this->payment_model->calculatePayables(
                    $submission->member_id,
                    DEFAULT_CURRENCY,
                    $this->member_model->getMemberCategory($submission->member_id),
                    $this->paper_status_model->getMemberAcceptedPapers($submission->member_id, EVENT_ID),
                    date("Y-m-d"),
                    EVENT_ID
                );
            }
        }
        $this->data['membersInfo'] = $membersInfo;
        $this->data['payables'] = $payables;

        $this->index($page);
    }
}
?>
