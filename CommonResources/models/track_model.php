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

    public function getAllTracks($eventId)
    {
        $this -> db -> select('track_id, track_number, track_name');
        $this -> db -> where('track_event_id', $eventId);
        $query = $this -> db -> get('track_master');
        return $query->result();
    }

    public function getTrackDetails($trackId)
    {
        $sql = "Select * From track_master Where track_id = ?";
        $query = $this->db->query($sql, array($trackId));
        return $query->row();
    }



}