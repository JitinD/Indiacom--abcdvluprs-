<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 2:36 PM
 */

class DeliverablesManager extends CI_Controller
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

        if (!file_exists(APPPATH . 'views/pages/DeliverablesManager/' . $page . '.php')) {
            show_404();
        }
        if (isset($privilege['Page']['DeliverablesManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['DeliverablesManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/DeliverablesManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }


    public function assignDeliverables_AJAX()
    {
        $this->load->model("deliverables_model");
        $this->load->model("submission_model");

        $member_id = $this->input->post('memberId');
        $submission_id = $this->input->post('submissionId');
        $is_deliverables_assigned = $this->input->post('isDeliverablesAssigned');

        if($submission_id)
            $member_id = null;
        else
            $submission_id = null;

        $deliverablesStatusRecord = array(
                'event_id' => EVENT_ID,
                'member_id' => $member_id,
                'submission_id' => $submission_id,
                'status' => $is_deliverables_assigned
            );


        echo json_encode($this->deliverables_model->assignDeliverables($deliverablesStatusRecord));
    }

    private function getMemberDeliverablesPayments($memberId)
    {
        $this->load->model('payment_model');
        $this->load->model('payment_head_model');
        $brPayheadId = $this->payment_head_model->getPaymentHeadId("BR");
        $prPayheadId = $this->payment_head_model->getPaymentHeadId("PR");
        if($brPayheadId == null || $prPayheadId == null)
        {
            return false;
        }
        $payments[$brPayheadId] = $this->payment_model->getPayments($memberId, null, $brPayheadId);
        $payments[$prPayheadId] = $this->payment_model->getPayments($memberId, null, $prPayheadId);
        return $payments;
    }

    public function assignMemberDeliverables($member_id)
    {
        $page = "assignDeliverables";

        $this -> load -> model('deliverables_model');

        $this -> data['deliverablesPayments'] = $this -> getMemberDeliverablesPayments($member_id);

        foreach($this -> data['deliverablesPayments'] as $payheadId => $payments_array)
        {
            foreach($payments_array as $index => $payments)
                $this -> data['deliverablesStatus'][$payments -> submission_member_id][$payments -> submission_paper_id] = $this -> deliverables_model -> getDeliverablesStatusRecord($payments -> submission_member_id, $payments -> submission_paper_id);
        }

        $this -> index($page);

    }
} 