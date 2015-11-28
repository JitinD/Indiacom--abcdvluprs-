<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 1:09 PM
 */

class Event_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*public function getAllEvents_deprc()
    {
        $sql = "Select event_id, event_name From event_master Where event_dirty = 0";
        $query = $this->db->query($sql);
        $htmlStr = "";
        foreach($query->result() as $row)
        {
            $htmlStr .= "<option value='" . $row->event_id .  "'>" . $row->event_name . "</option>";
        }
        return $htmlStr;
    }*/

    public function newEvent($eventDetails = array())
    {
        $eventDetails['event_id'] = $this->assignEventId();
        $this->db->insert('event_master', $eventDetails);
        return $eventDetails['event_id'];
    }

    private function assignEventId()
    {
        $sql = "Select (Max(event_id) + 1) as new_event_id From event_master";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->new_event_id;
    }

    public function disableEvent($eventId)
    {
        $sql = "Update event_master
                Set event_dirty = 1
                Where event_id = ?";
        $this->db->query($sql, array($eventId));
        return $this->db->trans_status();
    }

    public function enableEvent($eventId)
    {
        $sql = "Update event_master
                Set event_dirty = 0
                Where event_id = ?";
        $this->db->query($sql, array($eventId));
        return $this->db->trans_status();
    }

    public function getAllEvents()
    {
        $sql = "Select * From event_master Where event_dirty = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getAllEventsInclDirty()
    {
        $sql = "Select * From event_master";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getAllActiveEvents()
    {
        $sql = "SELECT * FROM event_master Where event_end_date >= NOW() And event_dirty = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getEventDetails($eventId)
    {
        $sql = "Select * From event_master Where event_id = ?";
        $query = $this->db->query($sql, array($eventId));
        return $query->row();
    }

    public function isPaperSubmissionOpen($eventId)
    {
        $eventDetails = $this->getEventDetails($eventId);
        if($eventDetails->event_paper_submission_start_date > date("Y-m-d") || $eventDetails->event_paper_submission_end_date < date("Y-m-d"))
            return false;
        return true;
    }
}