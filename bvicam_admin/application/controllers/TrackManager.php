<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/12/15
 * Time: 8:24 PM
 */
class TrackManager extends CI_Controller
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
        $sidebarData['controllerName'] = $controllerName = "PaymentsManager";
        $sidebarData['links'] = $this->setSidebarLinks();
        if (!file_exists(APPPATH . 'views/pages/TrackManager/' . $page . '.php')) {
            show_404();
            show_404();
        }
        if (isset($privilege['Page']['TrackManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['TrackManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($privilege['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
       $this->load->view('templates/header');
        $this->load->view('templates/navbar', $sidebarData);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/TrackManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {

    }

    public function home()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('searchValue', 'Search value', 'required');

        if ($this->form_validation->run()) {
            $this->load->helper('url');

            $search_by = $this->input->post('searchBy');
            $search_value = $this->input->post('searchValue');

            switch ($search_by) {
                case 'MemberID':
                    if (isset($search_value))
                        redirect('/TrackManager/markAuthorAttendance/' . $search_value);
                    break;

                case 'PaperID':
                    if (isset($search_value))
                        redirect('/TrackManager/markPaperAttendance/' . $search_value);
                    break;

                case 'MemberName':
                    $this->getMatchingMembers_AJAX($search_value);
                    return;
            }
        }

    }

    private function getMatchingMembers_AJAX($member_name)
    {
        $this->load->model('member_model');

        $matchingRecords = $this->member_model->getMatchingMembers($member_name);

        echo json_encode($matchingRecords);
    }

    public function markAuthorAttendance($member_id = null)
    {
        $this->home();
        $page = "markAuthorAttendance";

        if ($member_id) {
            $this->load->model('paper_status_model');
            $this->load->model('attendance_model');
            $this->load->model('certificate_model');
            $this->load->model('submission_model');
            $this->load->model('certificate_model');
            $this->load->model('member_model');
            $this->load->model('discount_model');
            $this->load->model('payment_model');

            $this->data['memberId'] = true;

            $this->data['papers'] = $this->paper_status_model->getTrackAcceptedPapersInfo($member_id);

            $this->data['registrationCat'] = $this->member_model->getMemberCategory($member_id);
            //$papers = $this->paper_status_model->getMemberAcceptedPapers($member_id);

            if(!isset($this->data['registrationCat']))
                $this->data['memberId'] = false;

            $this->data['discounts'] = $this->discount_model->getMemberEligibleDiscounts($member_id, $this->data['papers']);

            if($this->discount_model->error != null)
                die($this->discount_model->error);

            if(isset($this->data['registrationCat']) && isset($this->data['papers']))
                $this->data['papersInfo'] = $this->payment_model->calculatePayables(
                    $member_id,
                    DEFAULT_CURRENCY,
                    $this->data['registrationCat'],
                    $this->data['papers'],
                    date("Y-m-d")
                );

            foreach ($this->data['papers'] as $paper) {
                $this->data['attendance'][$paper->paper_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);
                $this->data['certificate'][$paper->paper_id] = $this->certificate_model->getCertificateRecord($paper->submission_id);
            }
        } else {
            if($member_id == null)
                $this->data['memberId'] = null;
            else
                $this->data['memberId'] = false;
        }

        $this->index($page);

    }

    public function markPaperAttendance($paper_id = null)
    {
        $page = "markPaperAttendance";

        $this->home();

        if ($paper_id) {
            $this->load->helper('url');
            $this->load->model('paper_status_model');
            $this->load->model('attendance_model');
            $this->load->model('certificate_model');
            $this->load->model('submission_model');
            $this->load->model('certificate_model');
            $this->load->model('paper_status_model');
            $this->load->model('attendance_model');
            $this->load->model('certificate_model');
            $this->load->model('submission_model');
            $this->load->model('certificate_model');
            $this->load->model('payment_model');
            $this->load->model('discount_model');

            $this->data['members'] = $this->paper_status_model->getTrackMemberInfo($paper_id);

            foreach ($this->data['members'] as $index => $member) {
                $this->data['papers'][$member -> submission_member_id] = $this->paper_status_model->getTrackAcceptedPapersInfo($member->submission_member_id);

                foreach ($this->data['papers'][$member -> submission_member_id] as $index => $paper) {
                    if(!isset($this->data['attendance'][$paper->submission_id]))
                    {
                        $this->data['attendance'][$paper->submission_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);

                    }

                    $this->data['discounts'] = $this->discount_model->getMemberEligibleDiscounts($member -> submission_member_id, $this->data['papers'][$member -> submission_member_id]);

                    if($this->discount_model->error != null)
                        die($this->discount_model->error);

                    $this->data['registrationCat'][$member -> submission_member_id] = $this->member_model->getMemberCategory($member -> submission_member_id);

                    $paperPayables = $this->payment_model->calculatePayables(
                        $member -> submission_member_id,
                        DEFAULT_CURRENCY,
                        $this->data['registrationCat'][$member -> submission_member_id],
                        $this->data['papers'][$member -> submission_member_id],
                        date("Y-m-d")
                    );

                    $this->data['paper_authors_payables'][$member -> submission_member_id] = $paperPayables;

                    $this->data['certificate'][$paper->submission_id] = $this->certificate_model->getCertificateRecord($paper->submission_id);

                }
            }
        } else {
            $this->data['paperId'] = false;
        }

        $this->index($page);
    }


}
