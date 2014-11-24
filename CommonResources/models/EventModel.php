<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 1:09 PM
 */

class EventModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllEvents_deprc()
    {
        $sql = "Select event_id, event_name From event_master Where event_dirty = 0";
        $query = $this->db->query($sql);
        $htmlStr = "";
        foreach($query->result() as $row)
        {
            $htmlStr .= "<option value='" . $row->event_id .  "'>" . $row->event_name . "</option>";
        }
        return $htmlStr;
    }

    public function getAllEvents()
    {
        $sql = "Select event_id, event_name From event_master Where event_dirty = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getAllEventsInclDirty()
    {
        $sql = "Select event_id, event_name From event_master";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getAllActiveEvents()
    {
        $sql = "SELECT * FROM event_master Where event_end_date > NOW() And event_dirty = 0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getEventDetails($eventId)
    {
        $sql = "Select * From event_master Where event_id = ?";
        $query = $this->db->query($sql, array($eventId));
        return $query->row();
    }
}