<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 2:21 PM
 */
class DeskManager extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));

        $this->load->model('paper_model'); //paper
        $this->load->model('subject_model'); //subject
        $this->load->model('track_model'); //track
        $this->load->model('event_model'); //event
        $this->load->model('submission_model');
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__) . '/../config/privileges.php');
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');

        if (!file_exists(APPPATH . 'views/pages/DeskManager/' . $page . '.php')) {
            show_404();
        }
        if (isset($privilege['Page']['DeskManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['DeskManager'][$page])) {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/DeskManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    public function home()
    {
        $page = "index";

        $this->load->library('form_validation');

        $this->form_validation->set_rules('searchValue', 'Search value', 'required');

        if ($this->form_validation->run()) {
            $this->load->helper('url');

            $search_by = $this->input->post('searchBy');
            $search_value = $this->input->post('searchValue');

            switch ($search_by) {
                case 'MemberID':    if(isset($search_value) && $search_value)
                                        redirect('/DeskManager/viewAuthorPapersPayments/' . $search_value);
                                    break;

                case 'PaperID':     if(isset($search_value) && $search_value)
                                        redirect('/DeskManager/viewPaperAuthorsPayments/' . $search_value);
                                    break;

                case 'MemberName':  $this -> getMatchingMembers_AJAX($search_value);
                                    return;
            }
        }

        $this->index($page);
    }

    private function getMatchingMembers_AJAX($member_name)
    {
        $this -> load -> model('member_model');

        $matchingRecords = $this -> member_model -> getMatchingMembers($member_name);

        echo json_encode($matchingRecords);
    }

    private function getPaperInfo($paper_id)
    {
        $this->data['paperDetails'] = $this->paper_model->getPaperDetails($paper_id);

        if(isset($this->data['paperDetails']))
            $this->data['subjectDetails'] = $this->subject_model->getSubjectDetails($this->data['paperDetails']->paper_subject_id);

        if(isset($this->data['subjectDetails']))
            $this->data['trackDetails'] = $this->track_model->getTrackDetails($this->data['subjectDetails']->subject_track_id);

        if(isset($this->data['trackDetails']))
            $this->data['eventDetails'] = $this->event_model->getEventDetails($this->data['trackDetails']->track_event_id);
        $this->data['submissions'] = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paper_id);

    }

    public function viewPaperAuthorsPayments($paper_id = null)
    {
        $page = "paperAuthorsPayments";

        $this->getPaperInfo($paper_id);

        $this->load->model('paper_status_model');
        $this->load->model('member_categories_model');
        $this->load->model('member_model');
        $this->load->model('payment_model');
        $this->load->model('discount_model');
        $this->load->model('paper_model');
        $this->load->model('attendance_model');

        if(isset($paper_id) && $paper_id)
        {
            $paper_authors_array = $this->submission_model->getAllAuthorsOfPaper($paper_id);

            if(isset($paper_authors_array))
            {
                foreach ($paper_authors_array as $index => $author)
                {
                    $member_id = $author->submission_member_id;

                    $memberInfo = $this->member_model->getMemberInfo($member_id);

                    $member_id_name_array[$member_id] = $memberInfo['member_name'];
                    $this->data['member_id_name_array'] = $member_id_name_array;

                    if ($memberInfo) {
                        $this->data['registrationCat'][$member_id] = $this->member_model->getMemberCategory($member_id);
                        $this->data['papers'][$member_id] = $this->paper_status_model->getMemberAcceptedPapers($member_id);
                        $this->data['isMemberRegistered'][$member_id] = $this->payment_model->isMemberRegistered($member_id);

                        $papers = $this->data['papers'][$member_id];

                        foreach ($papers as $index => $paper) {
                            $this->data['isPaperRegistered'][$paper->paper_id] = $this->payment_model->isPaperRegistered($paper->paper_id);
                            $this->data['attendance'][$paper->submission_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);
                        }

                        //$this->data['isPaperRegistered'] = $isPaperRegistered;

                        $paperPayables = $this->payment_model->calculatePayables(
                            $member_id,
                            DEFAULT_CURRENCY,
                            $this->data['registrationCat'][$member_id],
                            $this->data['papers'][$member_id],
                            date("Y-m-d")
                        );
                    }
                    //$paper_authors_payables[$member_id] = $paperPayables;

                    $this->data['paper_authors_payables'][$member_id] = $paperPayables;
                }
            }
        }

        $this->index($page);
    }

    public function viewAuthorPapersPayments($member_id = null)
    {
        $page = "authorPapersPayments";

        if(isset($member_id) && $member_id)
        {
            $this->load->model('paper_status_model');
            $this->load->model('member_categories_model');
            $this->load->model('member_model');
            $this->load->model('payment_model');
            $this->load->model('discount_model');
            $this->load->model('paper_model');
            $this->load->model('attendance_model');

            $this->data['memberDetails'] = $this->member_model->getMemberInfo($member_id);

            if ($this->data['memberDetails']) {
                $this->data['registrationCategories'] = $this->member_categories_model->getMemberCategories();
                $this->data['registrationCat'] = $this->member_model->getMemberCategory($member_id);
                $this->data['papers'] = $this->paper_status_model->getMemberAcceptedPapers($member_id);
                $this->data['isMemberRegistered'] = $this->payment_model->isMemberRegistered($member_id);

                $papers = $this->data['papers'];

                foreach ($papers as $index => $paper) {
                    $isPaperRegistered[$paper->paper_id] = $this->payment_model->isPaperRegistered($paper->paper_id);
                    $this->data['attendance'][$paper->submission_id] = $this->attendance_model->getAttendanceRecord($paper->submission_id);
                }

                if(isset($isPaperRegistered))
                    $this->data['isPaperRegistered'] = $isPaperRegistered;

                $this->data['papersInfo'] = $this->payment_model->calculatePayables(
                    $member_id,
                    DEFAULT_CURRENCY,
                    $this->data['registrationCat'],
                    $this->data['papers'],
                    date("Y-m-d")
                );
            }
        }
        $this->index($page);
    }
}