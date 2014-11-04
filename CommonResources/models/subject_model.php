<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 3:27 PM
 */

class Subject_model extends CI_Model
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

    public function getSubjectDetails($subjectId)
    {
        $sql = "Select * From subject_master Where subject_id = ?";
        $query = $this->db->query($sql, array($subjectId));
        return $query->row();
    }
}