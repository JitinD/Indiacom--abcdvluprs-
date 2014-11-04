<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/21/14
 * Time: 12:57 PM
 */

class Ajax_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function fetchOrganisationNames($keyword)
    {
        $sql = "select organization_name from organization_master where organization_name like '".$keyword."%' limit 0,100";
        $query = $this->db->query($sql);
        $response = "";
        if($query->num_rows() > 0)
        {
            $response = '<ul class="listAJAX">';
            foreach($query->result() as $row)
            {
                $str = strtolower($row->organization_name);
                $start = strpos($str,$keyword);
                $end   = similar_text($str,$keyword);
                $last = substr($str,$end,strlen($str));
                $first = substr($str,$start,$end);

                $final = '<span class="boldAJAX">'.$first.'</span>'.$last;

                $response .= '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
            }
            $response .= "</ul>";
        }
        else
            $response = false;
        return $response;
    }

    public function getAllTracks($eventId)
    {
        $this->load->model('track_model');
        $rows = $this->track_model->getAllTracks($eventId);
        $htmlStr = "";
        foreach($rows as $row)
        {
            $htmlStr .= "<option value='" . $row->track_id . "'>" . $row->track_number . " : " . $row->track_name . "</option>";
        }
        return $htmlStr;
    }

    public function getAllSubjects($trackId)
    {
        $this->load->model('subject_model');
        $rows = $this->subject_model->getAllSubjects($trackId);
        $htmlStr = "";
        foreach($rows as $row)
        {
            $htmlStr .= "<option value='" . $row->subject_id . "'>" . $row->subject_code . " : " . $row->subject_name . "</option>";
        }
        return $htmlStr;
    }
}