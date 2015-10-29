<?php

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class InitialPaperReviewer extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('paper_model');//paper
        $this -> load -> model('subject_model');//subject
        $this -> load -> model('track_model');//track
        $this -> load -> model('event_model');//event
        $this -> load -> model('paper_model');//paper_version
        $this -> load -> model('paper_version_model');
        $this -> load -> model('submission_model');
        $this -> load -> model('reviewer_model');
        $this -> load -> model('paper_version_review_model');
        $this->load->helper(array('form', 'url'));
        $this->controllerName = "InitialPaperReviewer";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $controllerName = "FinalPaperReviewer";
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            show_404();
        }

        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {

    }

    public function load()
    {
        if(!$this->checkAccess("load"))
            return;
        $page = "ReviewerDashboardHome";
        $this->load->model('event_model');
        $this->load->model('review_stage_model');
        $this->data['events'] = $this->event_model->getAllActiveEvents();
        $this->data['reviewStages'] = $this->review_stage_model->getAllReviewStages();
        $this->data['user_id'] = $_SESSION[APPID]['user_id'];
        foreach($this->data['events'] as $event)
        {
            $this->data['pendingReviews'][$event->event_id] = $this->paper_version_review_model->getReviewerPendingReviews($this->data['user_id'], $event->event_id);
            $this->data['completedReviews'][$event->event_id] = $this->paper_version_review_model->getReviewerCompletedReviews($this->data['user_id'], $event->event_id);
        }
        $this->index($page);
    }

    private function uploadComments($fileElem,$eventId,$paper_version_review_id)
    {
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/FileNameUtil.php");
        $config['upload_path'] = SERVER_ROOT . UPLOAD_PATH . $eventId . "/" . REVIEWER_REVIEW_FOLDER;
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['file_name'] = FileNameUtil::makeReviewerReviewCommentsFile($paper_version_review_id);
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();

        return UPLOAD_PATH . $eventId . "/" . REVIEWER_REVIEW_FOLDER . $config['file_name'] . $uploadData['file_ext'];
    }

    public function reviewPaperInfo($paper_version_review_id)
    {
        if(!$this->checkAccess("reviewPaperInfo"))
            return;
        $page = 'reviewPaperInfo';
        $paperVersionReviewDetails = $this->paper_version_review_model->getPaperVersionReviewerReview($paper_version_review_id);
        if($paperVersionReviewDetails == null || $paperVersionReviewDetails->paper_version_reviewer_id != $_SESSION[APPID]['user_id'])
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $this->data['paperVersionDetails'] = $this->paper_version_model->getPaperVersionDetails($paperVersionReviewDetails->paper_version_id);
        $this->data['paperDetails'] = $this->paper_model->getPaperDetails($this->data['paperVersionDetails']->paper_id);
        $this->data['subjectDetails'] = $this->subject_model->getSubjectDetails($this->data['paperDetails']->paper_subject_id);
        $this->data['trackDetails'] = $this->track_model->getTrackDetails($this->data['subjectDetails']->subject_track_id);
        $this->data['eventDetails'] = $this->event_model->getEventDetails($this->data['trackDetails']->track_event_id);
        $this->data['submissions'] = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $this->data['paperVersionDetails']->paper_id);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('comments', 'Comments','required');

        if($this->form_validation->run())
        {
            if(($doc_path = $comments_url=$this->uploadComments('commentsFile',$this->data['eventDetails']->event_id,$paper_version_review_id)) == false)
            {
                $this->data['uploadError'] = $this->upload->display_errors();
            }
            else
            {
                date_default_timezone_set('Asia/Kolkata');
                $details = array(
                    "paper_version_review_comments_file_path" => $doc_path,
                    "paper_version_review_comments" => $this->input->post('comments'),
                    "paper_version_review_date_of_receipt" => date("Y-m-d")
                );
                $this->paper_version_review_model->sendReviewerComments($details, $paper_version_review_id);
            }
        }
        $this->data['review'] = $this->paper_version_review_model->getPaperVersionReviewerReview($paper_version_review_id);
        $this->index($page);
    }

    /*private function downloadPaperVersionDocuments($paperVersionId, $documentPathFieldName)
    {
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/DownloadUtil.php");
        $this->load->model('paper_version_model');
        $versionInfo = $this->paper_version_model->getPaperVersionDetails($paperVersionId);
        DownloadUtil::downloadFile(SERVER_ROOT . $versionInfo->$documentPathFieldName, basename($versionInfo->$documentPathFieldName));
    }*/

    public function downloadPaperVersion($paperVersionId, $eventId)
    {
        if(!$this->checkAccess("downloadPaperVersion"))
            return;
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/DownloadUtil.php");
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/FileNameUtil.php");
        $this->load->model('paper_version_model');
        $versionInfo = $this->paper_version_model->getPaperVersionDetails($paperVersionId);
        $fileName = FileNameUtil::makePaperVersionFilename(
            $versionInfo->paper_id,
            $versionInfo->paper_version_number,
            $versionInfo->paper_version_document_path
        );
        DownloadUtil::downloadFile(
            SERVER_ROOT.UPLOAD_PATH.$eventId."/".PAPER_FOLDER.$fileName,
            $fileName
        );
        //$this->downloadPaperVersionDocuments($paperVersionId, "paper_version_document_path");
    }

    public function downloadReviewerComments($paperVersionReviewId, $eventId)
    {
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/DownloadUtil.php");
        require_once(dirname(__FILE__) . "/../../../CommonResources/Utils/FileNameUtil.php");
        $this->load->model('paper_version_review_model');
        $versionReviewInfo = $this->paper_version_review_model->getPaperVersionReviewerReview($paperVersionReviewId);
        $fileName = FileNameUtil::makeReviewerReviewCommentsFilename(
            $paperVersionReviewId,
            $versionReviewInfo->paper_version_review_comments_file_path
        );
        DownloadUtil::downloadFile(
            SERVER_ROOT.UPLOAD_PATH.$eventId."/".REVIEWER_REVIEW_FOLDER.$fileName,
            $fileName
        );
    }
}
?>