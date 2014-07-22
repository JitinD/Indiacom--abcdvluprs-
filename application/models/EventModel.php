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

    public function getAllEvents()
    {
        $sql = "Select event_id, event_name From event_master";
        $query = $this->db->query($sql);
        $htmlStr = "";
        foreach($query->result() as $row)
        {
            $htmlStr .= "<option value='" . $row->event_id .  "'>" . $row->event_name . "</option>";
        }
        return $htmlStr;
    }
}