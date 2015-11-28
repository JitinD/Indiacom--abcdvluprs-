<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 2:21 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class DeskManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('paper_model'); //paper
        $this->load->model('subject_model'); //subject
        $this->load->model('track_model'); //track
        $this->load->model('event_model'); //event
        $this->load->model('submission_model');
        $this->controllerName = "DeskManager";
        require(dirname(__FILE__) . '/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require(dirname(__FILE__) . '/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if (!file_exists(APPPATH . 'views/pages/DeskManager/' . $page . '.php')) {
            show_404();
        }
        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $sidebarData);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/DeskManager/' . $page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {
        
    }

    public function home()
    {
        if(!$this->checkAccess("home"))
        return;
        $this->load->library('form_validation');

        $this->form_validation->set_rules('searchValue', 'Search value', 'required');

        if ($this->form_validation->run()) {
            $this->load->helper('url');

            $search_by = $this->input->post('searchBy');
            $search_value = $this->input->post('searchValue');

            switch ($search_by) {
                case 'MemberID':    if(isset($search_value))
                                        redirect('/DeskManager/viewAuthorPapersPayments/' . $search_value);
                                    break;

                case 'PaperID':     if(isset($search_value))
                                        redirect('/DeskManager/viewPaperAuthorsPayments/' . $search_value);
                                    break;

                case 'MemberName':  $this -> getMatchingMembers_AJAX($search_value);
                                    return;
            }
        }

 //       $this->index($page);
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

    public function viewPaperAuthorsPayments($paper_code = null)
    {
        if(!$this->checkAccess("viewPaperAuthorsPayments"))
            return;
        $page = "paperAuthorsPayments";

        $this -> home();
        $this->load->model('paper_model');
        $paper_id = $this->paper_model->getPaperID($paper_code, EVENT_ID);

        if($paper_id != null)
        {
            $this->load->model('payment_model');
            $this->load->model('member_model');
            $this->load->model('submission_model');
            $this->getPaperInfo($paper_id);
            $this->data['PaperRegistered'] = $this->payment_model->isPaperRegistered($paper_id);
            $paperAuthors = $this->submission_model->getAllAuthorsOfPaper($paper_id);
            $this->data['authorsInfo'] = array();
            foreach($paperAuthors as $author)
            {
                $this->data['authorsInfo'][] = $this->member_model->getMemberInfo($author->submission_member_id);
            }
        }
        else
        {
            $this->data['paperId'] = false;
        }

        $this->index($page);
    }

    public function viewAuthorPapersPayments($member_id = null)
    {
        if(!$this->checkAccess("viewAuthorPapersPayments"))
            return;
        $page = "authorPapersPayments";

        $this -> home();

        if($member_id)
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
                $this->data['papers'] = $this->paper_status_model->getMemberAcceptedPapers($member_id, EVENT_ID);
                $this->data['isMemberRegistered'] = $this->payment_model->isMemberRegistered($member_id);
                $this->data['discounts'] = $this->discount_model->getMemberEligibleDiscounts($member_id, $this->data['papers']);
                $this->data['memberDetails']['category_name'] = $this->member_categories_model->getMemberCategoryName($this->data['memberDetails']['member_category_id']);

                if($this->discount_model->error != null)
                    die($this->discount_model->error);
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
                    date("Y-m-d"),
                    EVENT_ID
                );
            }
        }
        else
        {
            $this->data['memberId'] = false;
        }

        $this->index($page);
    }
}