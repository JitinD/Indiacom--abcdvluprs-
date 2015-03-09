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
        $sidebarData['controllerName'] = $controllerName = "ReportManager";
        $sidebarData['links'] = $this->setSidebarLinks();
        if (!file_exists(APPPATH . 'views/pages/ReportManager/' . $page . '.php')) {
            show_404();
        }
        if (isset($privilege['Page']['ReportManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['ReportManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($privilege['Page']);
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
        $this->load-> helper ('download');
        $data=file_get_contents(SERVER_ROOT.INDIACOM.'reports/report.csv');
        $name = date("Y/m/d").".csv";
        force_download ($name, $data);

    }
    public function getReport($sql1)
    {
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
                    $this->paper_status_model->getMemberAcceptedPapers($submission->member_id),
                    date("Y-m-d")
                );
            }
        }
        $this->data['membersInfo'] = $membersInfo;
        $this->data['payables'] = $payables;

        $this->index($page);
    }
}
?>
