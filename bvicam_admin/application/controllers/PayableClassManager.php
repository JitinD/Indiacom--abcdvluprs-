<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 11/24/15
 * Time: 4:07 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class PayableClassManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "PayableClassManager";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $this->load->model('access_model');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH."views/pages/{$this->controllerName}/$page".'.php'))
        {
            show_404();
        }

        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view("pages/{$this->controllerName}/$page", $this->data);
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

    public function load()
    {

    }

    public function editPayableClasses($eventId, $payheadId)
    {
        $page = "editPayableClasses";
        $this->load->model('payable_class_model');
        $this->load->model('payment_head_model');
        $this->load->model('member_categories_model');
        $this->load->model('nationality_model');
        $this->load->model('event_model');
        $this->data['eventDetails'] = $this->event_model->getEventDetails($eventId);
        $this->data['payheadDetails'] = $this->payment_head_model->getPayheadDetails($payheadId);
        $this->data['memberCategories'] = $this->member_categories_model->getMemberCategories();
        $this->data['nationalities'] = $this->nationality_model->getAllNationalities();

        $this->editPayableClassesSubmitHandle($eventId, $payheadId);

        $this->data['payableClasses'] = $this->payable_class_model->getAllPayableClassDetails($eventId);

        $this->index($page);
    }

    private function editPayableClassesSubmitHandle($eventId, $payheadId)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('useless', 'useless', 'required');

        if($this->form_validation->run())
        {
            foreach($this->input->post('amount') as $post=>$value)
            {
                $payableClassDetails = array("payable_class_amount" => $value);
                $this->payable_class_model->updatePayableClass($payableClassDetails, array("payable_class_id" => $post));
            }
            foreach($this->input->post('date') as $dates=>$newDate)
            {
                $oldDates = explode("_", $dates);
                $payableClassDetails = array(
                    "start_date" => $newDate['start_date'],
                    "end_date" => $newDate['end_date']
                );
                $this->payable_class_model->updatePayableClass($payableClassDetails, array(
                    "payable_class_event" => $eventId,
                    "payable_class_payhead_id" => $payheadId,
                    "start_date" => ($oldDates[0] == "") ? null : $oldDates[0],
                    "end_date" => ($oldDates[1] == "") ? null : $oldDates[1]
                ));
            }
        }
    }
}