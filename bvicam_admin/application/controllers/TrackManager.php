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

        if (!file_exists(APPPATH . 'views/pages/TrackManager/' . $page . '.php')) {
            show_404();
            show_404();
        }
        if (isset($privilege['Page']['TrackManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['TrackManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
       $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/TrackManager/' . $page, $this->data);
        $this->load->view('templates/footer');
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
            $this->data['papers'] = $this->paper_status_model->getTrackAcceptedPapersInfo($member_id);
            foreach ($this->data['papers'] as $paper) {
                $this->data['attendance'][$paper->paper_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);
                $this->data['certificate'][$paper->paper_id] = $this->certificate_model->getCertificateRecord($paper->submission_id);
            }
        } else {
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
            $this->data['members'] = $this->paper_status_model->getTrackMemberInfo($paper_id);

            foreach ($this->data['members'] as $index => $member) {
                $this->data['papers'][$member -> submission_member_id] = $this->paper_status_model->getTrackAcceptedPapersInfo($member->submission_member_id);
                foreach ($this->data['papers'][$member -> submission_member_id] as $index => $paper) {
                    if(!isset($this->data['attendance'][$paper->submission_id]))
                    {
                        $this->data['attendance'][$paper->submission_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);

                    }
                    $this->data['certificate'][$paper->submission_id] = $this->certificate_model->getCertificateRecord($paper->submission_id);

                }
            }
        } else {
            $this->data['paperId'] = false;
        }

        $this->index($page);
    }


}
