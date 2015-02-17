<?php

/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 19/7/14
 * Time: 6:10 PM
 */
class Paper_status_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getMemberPapers($member_id)
    {
        $sql = "Select paper_id, paper_code, paper_title, latest_paper_version_number, review_result_type_name
                From paper_latest_version join submission_master on paper_id = submission_paper_id
                Where submission_member_id = ? And submission_dirty = 0";
        $query = $this->db->query($sql, array($member_id));
        if ($query->num_rows() > 0)
            return $query->result();
        return array();
    }

    public function getMemberAcceptedPapers($memberId)
    {
        $sql = "Select paper_id, paper_code, paper_title, submission_id
                From
                  paper_latest_version
                    Join
                  submission_master
                    On paper_id = submission_paper_id
                Where
                  submission_member_id = ? And
                  submission_dirty = 0 AND
                  review_result_id = ?";
        $query = $this->db->query($sql, array($memberId, REVIEW_RESULT_ACCEPTED_ID));
        if ($query->num_rows() > 0)
            return $query->result();
        return array();
    }

    //Get accepted papers of a track
    public function getTrackAcceptedPapersInfo($member_id, $track_id)
    {
        $sql = "Select paper_master.paper_id, paper_master.paper_code, paper_master.paper_title,submission_master.submission_member_id,submission_master.submission_id
                From
                  paper_latest_version
                    Join
                  submission_master
                    On paper_latest_version.paper_id = submission_master.submission_paper_id
                    Join
                    paper_master
                    On
                    paper_latest_version.paper_id=paper_master.paper_id
                    Join
                    subject_master
                    On
                     paper_master.paper_subject_id=subject_master.subject_id
                Where
                  submission_member_id = ? And
                  submission_dirty = 0 AND
                  subject_track_id= ? AND
                  review_result_id = ?";
        $query = $this->db->query($sql, array($member_id, $track_id, REVIEW_RESULT_ACCEPTED_ID));
        if ($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getTrackMemberInfo($paper_id, $track_id)
    {
        $sql = "Select paper_master.paper_id, paper_master.paper_code, paper_master.paper_title,submission_master.submission_member_id,submission_master.submission_id,member_master.member_name
                From
                  paper_latest_version
                    Join
                  submission_master
                    On paper_latest_version.paper_id = submission_master.submission_paper_id
                    Join
                    paper_master
                    On
                    paper_latest_version.paper_id=paper_master.paper_id
                    Join
                    subject_master
                    On
                     paper_master.paper_subject_id=subject_master.subject_id
                     JOIN
                     member_master
                     On submission_master.submission_member_id=member_master.member_id
                Where
                  paper_master.paper_code = ? And
                  submission_dirty = 0 AND
                  subject_track_id= ? AND
                  review_result_id = ?";
        $query = $this->db->query($sql, array($paper_id, $track_id, REVIEW_RESULT_ACCEPTED_ID));
        if ($query->num_rows() == 0)
            return array();
        return $query->result();
    }


}