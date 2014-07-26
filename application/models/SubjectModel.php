<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 3:27 PM
 */

class SubjectModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getAllSubjects($trackId)
    {
        $this->db->select('subject_id, subject_code, subject_name');
        $this->db->where('subject_track_id', $trackId);
        $query = $this->db->get('subject_master');
        return $query->result();
    }
}