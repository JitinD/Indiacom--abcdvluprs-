<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 10/13/15
 * Time: 3:05 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class CsvController extends BaseController
{
    private $dataPath = "C:\\Users\\saura_000\\Desktop\\";
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "CsvController";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    public function importMembers()
    {
        $this->load->model('registration_model');
        $this->load->model('organization_model');
        $this->load->model('member_categories_model');
        $fileName = $this->dataPath . "Members.csv";
        $fieldMapping = array(
            "member_id",
            "member_name",
            "member_address",
            "member_pincode",
            "member_email",
            "member_phone",
            "member_mobile",
            "member_fax",
            "member_designation",
            "member_csi_mem_no",
            "member_iete_mem_no",
            "member_password",
            "member_organization_id",
            "member_biodata_path",
            "member_category_id",
            "member_experience",
            "member_salutation",
            "member_country",
            "member_state"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $memberDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];
                    if($fieldMapping[$c] == "member_password")
                        $val = md5($val);
                    else if($fieldMapping[$c] == "member_category_id")
                    {
                        $val = $this->member_categories_model->getMemberCategoryId($val);
                    }
                    else if($fieldMapping[$c] == "member_country")
                    {
                        $val = 24;
                    }

                    $memberDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }
                $this->registration_model->addMember($memberDetails);
            }
            fclose($handle);
        }
    }

    public function importOrganizations()
    {
        $this->load->model('organization_model');
        $fileName = $this->dataPath . "Orgs.csv";
        $fieldMapping = array(
            "organization_id",
            "organization_name",
            "organization_short_name",
            "organization_address",
            "organization_email",
            "organization_phone",
            "organization_contact_person_name",
            "organization_fax"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $orgDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];

                    $orgDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }
                $this->organization_model->addNewOrganization($orgDetails);
            }
            fclose($handle);
        }
    }

    public function importEvents()
    {
        $this->load->model('event_model');
        $fileName = $this->dataPath . "Events.csv";
        $fieldMapping = array(
            "event_id",
            "event_name",
            "event_description",
            "event_start_date",
            "event_end_date",
            "event_paper_submission_start_date",
            "event_abstract_submission_end_date",
            "event_abstract_acceptance_notification",
            "event_paper_submission_end_date",
            "event_paper_submission_notification",
            "event_review_info_avail_after",
            "event_clear_min_dues_by",
            "event_email",
            "event_info",
            "event_attachment"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $eventDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];

                    $eventDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }
                $this->event_model->newEvent($eventDetails);
            }
            fclose($handle);
        }
    }

    public function importTracks($eventId)
    {
        $this->load->model('track_model');
        $fileName = $this->dataPath . "Tracks.csv";
        $fieldMapping = array(
            "track_event_id",
            "track_number",
            "track_name",
            "track_description"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $trackDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];
                    if($fieldMapping[$c] == "track_event_id")
                        $val = $eventId;
                    $trackDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }
                $this->track_model->newTrack($trackDetails, $eventId);
            }
            fclose($handle);
        }
    }

    public function importSubjects($eventId)
    {
        $this->load->model('track_model');
        $this->load->model('subject_model');
        $fileName = $this->dataPath . "Subjects.csv";
        $fieldMapping = array(
            "pseudo_event_id",
            "pseudo_track_number",
            "subject_code",
            "subject_name",
            "subject_description"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $subjectDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];
                    if($fieldMapping[$c] == "pseudo_event_id")
                    {
                        $subjectDetails["subject_track_id"] = $this->track_model->getTrackId($eventId, $data[$c+1]);
                        echo "TRACK ID : " . $subjectDetails["subject_track_id"] . "<br/>";
                    }
                    else if($fieldMapping[$c] != "pseudo_track_number")
                        $subjectDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }

                $this->subject_model->newSubject($subjectDetails, $subjectDetails["subject_track_id"]);
            }
            fclose($handle);
        }
    }

    public function importPapers($eventId)
    {
        $this->load->model('track_model');
        $this->load->model('subject_model');
        $this->load->model('paper_model');
        $fileName = $this->dataPath . "Papers.csv";
        $fieldMapping = array(
            "paper_code",
            "paper_title",
            "paper_date_of_submission",
            "pseudo_event_id",
            "pseudo_track_number",
            "pseudo_subject_code",
            "paper_abstract_path",
            "paper_presentation_path",
            "paper_contact_author_id",
            "paper_isclose"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $paperDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];
                    if($fieldMapping[$c] == "pseudo_event_id")
                    {
                        $trackId = $this->track_model->getTrackId($eventId, $data[$c+1]);
                        $paperDetails['paper_subject_id'] = $this->subject_model->getSubjectId($trackId, $data[$c+2]);
                    }
                    else if($fieldMapping[$c] != "pseudo_track_number" && $fieldMapping[$c] != "pseudo_subject_code")
                    {
                        if($fieldMapping[$c] == "paper_isclose")
                            $val = ($val == "Y") ? false : true;
                        $paperDetails[$fieldMapping[$c]] = $val;
                    }

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }

                $this->paper_model->addPaper($paperDetails, $eventId);
            }
            fclose($handle);
        }
    }

    public function importPaperVersions()
    {
        $this->load->model('paper_version_model');
        $fileName = $this->dataPath . "PaperVersions.csv";
        $fieldMapping = array(
            "paper_version_id",
            "paper_id",
            "paper_version_number",
            "paper_version_document_path",
            "paper_version_date_of_submission",
            "paper_version_compliance_report_path"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $paperVersionDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];

                    $paperVersionDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }

                $this->paper_version_model->addPaperVersion($paperVersionDetails);
            }
            fclose($handle);
        }
    }

    public function importSubmissions($eventId)
    {
        $this->load->model('paper_model');
        $this->load->model('submission_model');
        $fileName = $this->dataPath . "Submissions.csv";
        $fieldMapping = array(
            "submission_paper_id",
            "pseudo_event_id",
            "submission_member_id"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $submissionDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];
                    if($fieldMapping[$c] == "pseudo_event_id")
                    {
                        $submissionDetails["submission_paper_id"] = $this->paper_model->getPaperID($data[$c-1], $eventId);
                    }
                    if($fieldMapping[$c] != "submission_paper_id" && $fieldMapping[$c] != "pseudo_event_id")
                        $submissionDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }

                $this->submission_model->addSubmissionArray($submissionDetails);
            }
            fclose($handle);
        }
    }

    public function importReviews()
    {
        $this->load->model('paper_version_review_model');
        $fileName = $this->dataPath . "Reviews.csv";
        $fieldMapping = array(
            "paper_version_review_id",
            "paper_version_id",
            "paper_version_reviewer_id",
            "paper_version_review_comments",
            "paper_version_review_comments_file_path",
            "paper_version_date_sent_for_review",
            "paper_version_review_date_of_receipt"
        );

        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;
            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                echo "<hr><br/>Row $row <br/><br/>";
                if($row++ == 0)
                    continue;
                $versionReviewDetails = array();
                $num = count($data);

                for ($c=0; $c < $num; $c++)
                {
                    $val = $data[$c];

                    $versionReviewDetails[$fieldMapping[$c]] = $val;

                    echo $fieldMapping[$c] . ": " . $data[$c] . "<br />\n";
                }

                $this->paper_version_review_model->addPaperVersionReviewRecord($versionReviewDetails);
            }
            fclose($handle);
        }
    }

    public function importVersionReviewResults()
    {
        $this->load->model('paper_version_model');
        $fileName = $this->dataPath . "ReviewResults.csv";
        $reviewResults = array();
        if (($handle = fopen($fileName, "r")) !== FALSE)
        {
            $row = 0;

            while (($data = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                if($row++ == 0)
                    continue;

                if($this->paper_version_model->getPaperVersionDetails($data[1]) != false)
                {
                    $reviewResults[$data[1]] = $data[3];
                    echo "<hr><br/>$data[1] : $data[3]<br/><br/>";
                }
            }
            fclose($handle);
        }
        $versionDetails = array();
        foreach($reviewResults as $versionId => $reviewResult)
        {
            $versionDetails["paper_version_review_result_id"] = $reviewResult;
            $this->paper_version_model->sendConvenerReview($versionDetails, $versionId);
        }
    }

    public function importDocumentSoftCopies($eventId)
    {

    }

    public function importPaperSoftCopies($eventId)
    {
        $this->load->model('paper_version_model');
        $sourceDocumentsPath = $this->dataPath . "documents/";
        $destDocumentsPath = SERVER_ROOT . UPLOAD_PATH . "$eventId/" . PAPER_FOLDER;
        $versions = $this->paper_version_model->getAllPapersVersionsByEvent($eventId);
        $versionDetails = array();
        foreach($versions as $version)
        {
            $sourceFileName = $version->paper_version_document_path;
            $fileInfo = pathinfo($sourceFileName);
            $fileExt = $fileInfo['extension'];
            $destFileName = "Paper_" . $version->paper_id . "v" . $version->paper_version_number . ".$fileExt";
            if(copy($sourceDocumentsPath . $sourceFileName, $destDocumentsPath . $destFileName))
            {
                $versionDetails["paper_version_document_path"] = UPLOAD_PATH . "$eventId/" . PAPER_FOLDER . $destFileName;
                $this->paper_version_model->updatePaperVersionDetails($versionDetails, $version->paper_version_id);
            }
            else
            {
                echo "Error copying : $sourceFileName, VersionId : {$version->paper_version_id}<br/>";
            }
        }
    }

    public function importPaperVersionComplianceReports($eventId)
    {
        $this->load->model('paper_version_model');
        $sourceDocumentsPath = $this->dataPath . "documents/";
        $destDocumentsPath = SERVER_ROOT . UPLOAD_PATH . "$eventId/" . COMPLIANCE_REPORT_FOLDER;
        $versions = $this->paper_version_model->getAllPapersVersionsByEvent($eventId);
        $versionDetails = array();
        foreach($versions as $version)
        {
            $sourceFileName = $version->paper_version_compliance_report_path;
            $fileInfo = pathinfo($sourceFileName);
            $fileExt = $fileInfo['extension'];
            $destFileName = "Report_" . $version->paper_id . "v" . $version->paper_version_number . ".$fileExt";
            if(copy($sourceDocumentsPath . $sourceFileName, $destDocumentsPath . $destFileName))
            {
                $versionDetails["paper_version_compliance_report_path"] = UPLOAD_PATH . "$eventId/" . COMPLIANCE_REPORT_FOLDER . $destFileName;
                $this->paper_version_model->updatePaperVersionDetails($versionDetails, $version->paper_version_id);
            }
            else
            {
                echo "Error copying : $sourceFileName, VersionId : {$version->paper_version_id}<br/>";
            }
        }
    }
}