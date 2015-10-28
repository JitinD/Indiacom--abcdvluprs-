<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/23/14
 * Time: 10:21 AM
 */

class Paper_version_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addPaperVersion(&$versionDetails = array())
    {
        //$versionDetails['paper_version_id'] = $this->assignPaperVersionId();
        $versionDetails['paper_version_number'] = $this->getLatestPaperVersionNumber($versionDetails['paper_id']) + 1;
        $versionDetails['paper_version_date_of_submission'] = date('Y-m-d H:i:s');
        $this->db->insert('paper_version_master', $versionDetails);
        if($this->db->trans_status() == false)
        {
            $this->error = "There was an error saving new paper version. Contact the admin.";
            return false;
        }
        return true;
    }

    public function updatePaperVersionDetails($details = array(), $paperVersionId)
    {
        return $this->db->update('paper_version_master', $details, array("paper_version_id" => $paperVersionId));
    }

    public function getAllPapersVersionsByEvent($eventId)
    {
        $sql = "Select *
                From paper_version_master
                    Join
                    (
                        SELECT paper_id FROM `paper_subject_track_event` Where event_id = ? And paper_id Is Not Null
                    ) as event_papers
                    On paper_version_master.paper_id = event_papers.paper_id";
        $query = $this->db->query($sql, array($eventId));
        return $query->result();
    }

    public function getLatestPaperVersionNumber($paperId)
    {
        $sql = "Select paper_version_number From paper_version_master Where paper_id = ? Order By paper_version_number Desc Limit 1";
        $query = $this->db->query($sql, array($paperId));
        if($query->num_rows() == 0)
        {
            return 0;
        }
        $row = $query->row();
        return $row->paper_version_number;
    }

    public function getLatestPaperVersionDetails($paperId)
    {
        $sql = "Select * From paper_version_master Where paper_id = ? And paper_version_dirty = 0 Order By paper_version_number Desc Limit 1";
        $query = $this->db->query($sql, array($paperId));
        return $query->row();
    }

    public function getPaperAllVersionDetails($paperId)
    {
        $sql = "Select * From paper_version_master Where paper_id = ? And paper_version_dirty = 0";
        $query = $this->db->query($sql, array($paperId));
        return $query->result();
    }

//    private function assignPaperVersionId()
//    {
//        $sql = "Select paper_version_id From paper_version_master Order By paper_version_id Desc Limit 1";
//        $query = $this->db->query($sql);
//        if($query->num_rows() == 0)
//        {
//            return 1;
//        }
//        $row = $query->row();
//        return $row->paper_version_id + 1;
//    }

    /*public function getAssignedPapers($user_id)
    {
        $this -> db -> select('paper_master.paper_id as paper_id, paper_version_id, paper_code, paper_version_number, paper_title');
        $this -> db -> from('paper_master');
        $this -> db -> join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');
        //$this -> db -> where('paper_version_convener_id', $user_id);

        $query = $this -> db -> get();

        if($query -> num_rows() > 0)
            return $query -> result();
    }*/

    /*
     * Papers whose latest versions have no assigned reviewers
     */
    public function getNoReviewerPapers($eventId = null, $trackId = null)
    {
        $this->db->select('paper_latest_version.*, paper_version_master.*');
        $this->db->from('paper_latest_version');
        $this->db->join('paper_version_master', 'paper_version_master.paper_id = paper_latest_version.paper_id And paper_version_number = latest_paper_version_number');
        $this->db->join('paper_version_review', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id', 'left');

        if($eventId != null || $trackId != null)
        {
            $this->db->join('paper_subject_track_event', 'paper_subject_track_event.paper_id = paper_latest_version.paper_id');
            $this->db->select('paper_subject_track_event.*');
        }
        if($eventId != null)
            $this->db->where('event_id', $eventId);
        else if($trackId != null)
            $this->db->where('track_id', $trackId);

        //$this -> db -> where('paper_version_is_reviewer_assigned', 0);
        $this->db->where('paper_version_review.paper_version_id is null');
        $this->db->order_by('paper_version_date_of_submission','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result();
    }

    /*
     * Papers whose latest versions have been reviewed by the assigned reviewer but, not yet reviewed by the convener
     */
    public function getReviewerReviewedPapers($eventId = null, $trackId = null)
    {
        $this->db->select('paper_master.paper_id as paper_id, paper_version_master.paper_version_id, paper_master.paper_code, paper_version_number, paper_title');
        $this->db->from('paper_master');
        $this->db->join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');
        $this->db->join('paper_version_review', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id');

        if($eventId != null || $trackId != null)
        {
            $this->db->join('paper_subject_track_event', 'paper_subject_track_event.paper_id = paper_master.paper_id');
            $this->db->select('paper_subject_track_event.*');
        }
        if($eventId != null)
            $this->db->where('event_id', $eventId);
        else if($trackId != null)
            $this->db->where('track_id', $trackId);

        //$this -> db -> where('paper_version_is_reviewer_assigned', 1);
        $this -> db -> where('paper_version_review_date_of_receipt Is Not null');   //reviewed by reviewer
        //$this -> db -> where('paper_version_is_reviewed_convener', 0);
        $this->db->where('paper_version_review_result_id is null'); //Not reviewed by convener
        $this->db->order_by('paper_version_review_date_of_receipt','desc');

        $query = $this->db->get();

        if($query -> num_rows() > 0)
            return $query -> result();
    }

    /*
     * Papers whose latest versions have been reviewed by convener.
     */
    public function getConvenerReviewedPapers($eventId = null, $trackId = null)
    {
        $this -> db -> select('paper_master.paper_id as paper_id, paper_version_master.paper_version_id, paper_master.paper_code, paper_version_number, paper_title');
        $this -> db -> from('paper_master');
        $this -> db -> join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');

        if($eventId != null || $trackId != null)
        {
            $this -> db -> join('paper_subject_track_event', 'paper_subject_track_event.paper_id = paper_master.paper_id');
            $this->db->select('paper_subject_track_event.*');
        }
        if($eventId != null)
            $this -> db -> where('event_id', $eventId);
        else if($trackId != null)
            $this->db->where('track_id', $trackId);

        //$this -> db -> where('paper_version_is_reviewed_convener', 1);
        $this->db->where('paper_version_review_result_id is not null');
        $this -> db -> order_by('paper_version_review_date','desc');

        $query = $this -> db -> get();

        if($query -> num_rows() > 0)
            return $query -> result();
    }

    /*
     * Papers whose latest versions have not been reviewed by assigned reviewer
     */
    public function getNotReviewedPapers($eventId = null, $trackId = null)
    {
        $this -> db -> select('paper_master.paper_id as paper_id, paper_version_master.paper_version_id, paper_master.paper_code, paper_version_number, paper_title');
        $this -> db -> from('paper_master');
        $this -> db -> join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');
        $this -> db -> join('paper_version_review', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id');

        if($eventId != null || $trackId != null)
        {
            $this -> db -> join('paper_subject_track_event', 'paper_subject_track_event.paper_id = paper_master.paper_id');
            $this->db->select('paper_subject_track_event.*');
        }
        if($eventId != null)
            $this -> db -> where('event_id', $eventId);
        else if($trackId != null)
            $this->db->where('track_id', $trackId);

        //$this -> db -> where('paper_version_is_reviewer_assigned', 1);
        $this -> db -> where('paper_version_review_date_of_receipt is null');
        $this -> db -> order_by('paper_version_date_of_submission','desc');

        $query = $this -> db -> get();

        if($query -> num_rows() > 0)
            return $query -> result();
    }

    public function sendConvenerReview($update_data, $paper_version_id)
    {
        return $this -> db -> update('paper_version_master', $update_data, array("paper_version_id" => $paper_version_id));
    }

    public function getPaperVersionComments($paper_version_id)
    {
        /*$this -> db -> select('*');
        $this -> db -> from('paper_version_master');
        $this -> db -> where('paper_version_id', $paper_version_id);*/

        $query = $this -> db -> get_where('paper_version_master', array("paper_version_id" => $paper_version_id));

        if($query -> num_rows() > 0)
            return $query -> result();
    }

    public function setReviewerAssigned($update_data, $paper_version_id)
    {
        return $this -> db -> update('paper_version_master', $update_data, array("paper_version_id" => $paper_version_id));
    }

    public function getPaperVersionDetails($paper_version_id)
    {
        $sql = "Select * From paper_version_master Where paper_version_id = ?";
        $query = $this->db->query($sql, array($paper_version_id));
        if($query->num_rows() == 0)
            return false;
        return $query->row();
    }
}

?>