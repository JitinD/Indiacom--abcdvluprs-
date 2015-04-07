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

    public function getMemberPapers($member_id, $event_id = null)
    {
        $sql = "Select
                  paper_latest_version.paper_id,
                  paper_latest_version.paper_code,
                  paper_title,
                  latest_paper_version_number,
                  review_result_type_name,
                  event_id,
                  event_name
                From
                  paper_latest_version
                    Join
                  submission_master
                    On paper_latest_version.paper_id = submission_paper_id
                    Join
                  paper_subject_track_event
                    On paper_latest_version.paper_id = paper_subject_track_event.paper_id
                Where
                  submission_member_id = ? And submission_dirty = 0";
        $params = array($member_id);
        if($event_id != null)
        {
            $sql .= " And event_id = ?";
            $params[] = $event_id;
        }
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0)
            return $query->result();
        return array();
    }

    public function getMemberAcceptedPapers($memberId)
    {
        $sql = "Select paper_master.paper_id, paper_master.paper_code, paper_master.paper_title,submission_master.submission_member_id,submission_master.submission_id,schedule_master.track_id,schedule_master.session_id,schedule_master.sub_session_id,schedule_master.venue,schedule_master.start_time,schedule_master.end_time
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
                     track_master
                     On subject_master.subject_track_id=track_master.track_id
                     Left JOIN
                     paper_schedule_tracker
                     On paper_latest_version.paper_id=paper_schedule_tracker.paper_id
                     Left JOIN
                     schedule_master
                     On paper_schedule_tracker.schedule_id=schedule_master.schedule_id

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
    public function getTrackAcceptedPapersInfo($member_id)
    {
        $sql = "Select paper_master.paper_id, paper_master.paper_code, paper_master.paper_title,submission_master.submission_member_id,submission_master.submission_id,schedule_master.track_id,schedule_master.session_id,schedule_master.sub_session_id,schedule_master.venue,schedule_master.start_time,schedule_master.end_time,member_master.member_name
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
                     track_master
                     On subject_master.subject_track_id=track_master.track_id
                     JOIN
                     paper_schedule_tracker
                     On paper_latest_version.paper_id=paper_schedule_tracker.paper_id
                     JOIN
                     schedule_master
                     On paper_schedule_tracker.schedule_id=schedule_master.schedule_id
                     JOIN
                     member_master
                     On submission_master.submission_member_id=member_master.member_id

                Where
                  submission_member_id = ? And
                  submission_dirty = 0 AND
                  review_result_id = ?";
        $query = $this->db->query($sql, array($member_id,REVIEW_RESULT_ACCEPTED_ID));
        if ($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getTrackMemberInfo($paper_id)
    {
        $sql = "Select paper_master.paper_id, paper_master.paper_code, paper_master.paper_title,submission_master.submission_member_id,submission_master.submission_id,member_master.member_name,schedule_master.track_id,schedule_master.session_id,schedule_master.sub_session_id,schedule_master.venue,schedule_master.start_time,schedule_master.end_time
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
                     JOIN
                     track_master
                     On subject_master.subject_track_id=track_master.track_id
                     JOIN
                     paper_schedule_tracker
                     On paper_latest_version.paper_id=paper_schedule_tracker.paper_id
                     JOIN
                     schedule_master
                     On paper_schedule_tracker.schedule_id=schedule_master.schedule_id
                Where
                  paper_master.paper_code = ? And
                  submission_dirty = 0 AND
                  track_event_id=? AND
                  review_result_id = ?";
        $query = $this->db->query($sql, array($paper_id,EVENT_ID,REVIEW_RESULT_ACCEPTED_ID));
        if ($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getAcceptedPapersMembers()
    {
        $sql = "
        Select
            Cast(submission_member_id as Unsigned) as member_id,
            paper_latest_version.paper_code,
            paper_latest_version.paper_id,
            schedule_master.*
        From
            paper_latest_version
                Join
            submission_master
                On paper_latest_version.paper_id = submission_master.submission_paper_id
                Left Join
            paper_schedule_tracker
                On paper_schedule_tracker.paper_id = paper_latest_version.paper_id
                Left Join
            schedule_master
                On schedule_master.schedule_id = paper_schedule_tracker.schedule_id
        Where
            review_result_id = ?
        Order By member_id, paper_latest_version.paper_code";
        $query = $this->db->query($sql, array(REVIEW_RESULT_ACCEPTED_ID));
        if($query->num_rows() == 0)
        {
            return array();
        }
        return $query->result();
    }
}