<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 27/8/14
 * Time: 10:47 PM
 */

class Paper_version_review_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getReviewerAssignedPapers($user_id)
    {
        $this -> db -> select('paper_version_review_id, paper_master.paper_id as paper_id, paper_version_master.paper_version_id, paper_code, paper_version_number, paper_title');
        $this -> db -> from('paper_master');
        $this -> db -> join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');
        $this -> db -> join('paper_version_review', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id');
        $this -> db -> where('paper_version_reviewer_id', $user_id);

        $query = $this -> db -> get();

        if($query -> num_rows() > 0)
            return $query -> result();
    }

    public function getReviewerPendingReviews($reviewerId, $eventId = null)
    {
        $this->db->select('paper_version_number, paper_master.*, paper_version_review.*');
        $this->db->from('paper_version_review');
        $this->db->join('paper_version_master', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id');
        $this->db->join('paper_master', 'paper_master.paper_id = paper_version_master.paper_id');
        $this->db->where('paper_version_review_date_of_receipt', null);
        $this->db->where('paper_version_review_dirty', 0);
        $this->db->where('paper_version_reviewer_id', $reviewerId);

        if($eventId != null)
        {
            $this->db->join('paper_subject_track_event', 'paper_subject_track_event.paper_id = paper_master.paper_id');
            $this->db->where('event_id', $eventId);
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function getReviewerCompletedReviews($reviewerId, $eventId)
    {
        $this->db->select('paper_version_number, paper_master.*, paper_version_review.*');
        $this->db->from('paper_version_review');
        $this->db->join('paper_version_master', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id');
        $this->db->join('paper_master', 'paper_master.paper_id = paper_version_master.paper_id');
        $this->db->where('paper_version_review_date_of_receipt Is Not Null');
        $this->db->where('paper_version_review_dirty', 0);
        $this->db->where('paper_version_reviewer_id', $reviewerId);

        if($eventId != null)
        {
            $this->db->join('paper_subject_track_event', 'paper_subject_track_event.paper_id = paper_master.paper_id');
            $this->db->where('event_id', $eventId);
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function getPaperVersionAllReviews($paper_version_id)
    {
        //$this -> db -> select('paper_version_review_id, paper_version_id, paper_version_reviewer_id, paper_version_review_comments, date(paper_version_review_date_of_receipt) as paper_version_review_date_of_receipt');
        $this -> db -> select('*');
        $this -> db -> from('paper_version_review');
        $this -> db -> where('paper_version_id', $paper_version_id);

        $query = $this -> db -> get();
        return $query -> result();
    }

    public function getPaperVersionReviewerReview($paper_version_review_id)
    {
        $this -> db -> select('*');
        $this -> db -> from('paper_version_review');
        $this -> db -> where('paper_version_review_id', $paper_version_review_id);
        $query = $this -> db -> get();
        return $query -> row();
    }

    public function addPaperVersionReviewRecord($Record = array())
    {
        return $this -> db -> insert('paper_version_review', $Record);
    }

    public function removePaperVersionReviewer($paper_version_review_id)
    {
        return $this -> db -> delete('paper_version_review', array('paper_version_review_id' => $paper_version_review_id));
    }

    public function sendReviewerComments($update_data, $paper_version_review_id)
    {
        return $this -> db -> update('paper_version_review', $update_data, array("paper_version_review_id" => $paper_version_review_id));
    }
}

?>