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

        $orig_payments[$brPayheadId] = $this->payment_model->getPayments($memberId, null, $brPayheadId);
        $orig_payments[$prPayheadId] = $this->payment_model->getPayments($memberId, null, $prPayheadId);

        $payments = array();

        /*foreach($orig_payments as $payheadId => $payments_array)
        {
            foreach($payments_array as $index => $payments)
            {
                $payable_class_amount = $payments -> payable_class_amount;
                $waiveoff_amount = $payments -> waiveoff_amount;
                $discount_amount = $payments -> discount_type_amount ? $payments -> discount_type_amount : 0;
                $pay_amount = $payable_class_amount - ($waiveoff_amount + $discount_amount);
                $paid_amount = $payments -> paid_amount;

                $pending_amount = $pay_amount - $paid_amount;

                if($pending_amount == 0)
                   $payments[$payheadId] = $this->payment_model->getPayments($memberId, null, $payheadId);
            }
        }*/

        return $orig_payments;
    }

    public function assignMemberDeliverables($member_id)
    {
        $page = "assignMemberDeliverables";

        $this -> load -> model('deliverables_model');

        $this -> data['deliverablesPayments'] = $this -> getMemberDeliverablesPayments($member_id);

        foreach($this -> data['deliverablesPayments'] as $payheadId => $payments_array)
        {
            foreach($payments_array as $index => $payments)
                $this -> data['deliverablesStatus'][$payments -> submission_member_id][$payments -> payment_submission_id] = $this -> deliverables_model -> getDeliverablesStatusRecord($payments -> submission_member_id, $payments -> payment_submission_id);
        }

        $this -> index($page);

    }

    public function assignPaperDeliverables($paper_id)
    {
        $page = "assignPaperDeliverables";

        $this -> load -> model('submission_model');
        $this -> load -> model('deliverables_model');

        $paper_authors_array = $this->submission_model->getAllAuthorsOfPaper($paper_id);

        foreach ($paper_authors_array as $index => $author)
        {
            $member_id = $author->submission_member_id;

            $this -> data['deliverablesPayments'][$member_id] = $this -> getMemberDeliverablesPayments($member_id);

            foreach($this -> data['deliverablesPayments'][$member_id] as $payheadId => $payments_array)
            {
                foreach($payments_array as $index => $payments)
                    $this -> data['deliverablesStatus'][$payments -> submission_member_id][$payments -> payment_submission_id] = $this -> deliverables_model -> getDeliverablesStatusRecord($payments -> submission_member_id, $payments -> payment_submission_id);
            }

        }

        $this -> index($page);

    }
} 