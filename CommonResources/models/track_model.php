<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 1:18 PM
 */

class Track_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function newTrack($trackDetails = array(), $trackEventId)
    {
        $trackDetails['track_id'] = $this->assignTrackId();
        $trackDetails['track_event_id'] = $trackEventId;
        $this->db->insert('track_master', $trackDetails);
        return $trackDetails['track_id'];
    }

    private function assignTrackId()
    {
        $sql = "Select (Max(track_id) + 1) as new_track_id From track_master";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->new_track_id;
    }

    public function getAllTracks($eventId)
    {
        $this -> db -> select('track_id, track_number, track_name');
        $this -> db -> where('track_event_id', $eventId);
        $query = $this -> db -> get('track_master');
        return $query->result();
    }

    public function getTrackId($eventId, $trackNumber)
    {
        $sql = "Select track_id From track_master
                Where track_event_id = ? And track_number = ?";
        $query = $this->db->query($sql, array($eventId, $trackNumber));
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->track_id;
        }
        return null;
    }

    public function getTrackDetails($trackId)
    {
        $sql = "Select * From track_master Where track_id = ?";
        $query = $this->db->query($sql, array($trackId));
        return $query->row();
    }

    public function getTracksByCoConvener($coConvenerId)
    {
        $sql = "Select * From track_master Where track_co_convener = ? And track_dirty = 0";
        $query = $this->db->query($sql, array($coConvenerId));
        return $query->result();
    }

    public function getCoConvenerTrackByEvent($eventId, $coConvenerId)
    {
        $sql = "Select track_master.*
                From track_master
                Where track_event_id = ? And track_co_convener = ? And track_dirty = 0";
        $query = $this->db->query($sql, array($eventId, $coConvenerId));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function setTrackCoConvener($trackId, $userId)
    {
        $trackDetails = $this->getTrackDetails($trackId);
        if($trackDetails == null)
            return false;
        $sql = "Update track_master
                Set track_co_convener = null
                Where track_co_convener = ? And track_event_id = ?";
        $this->db->query($sql, array($userId, $trackDetails->track_event_id));
        if(!$this->db->trans_status())
            return false;
        $sql = "Update track_master
                Set track_co_convener = ?
                Where track_id = ?";
        $this->db->query($sql, array($userId, $trackId));
        return $this->db->trans_status();
    }
}