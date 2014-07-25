<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 12:59 PM
 */

class PaperModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addPaper($paperDetails = array(), $eventId)
    {
        $paperDetails['paper_id'] = $this->getPaperId();
        $paperDetails['paper_code'] = $this->getPaperCode($eventId);
        $paperDetails['paper_date_of_submission'] = date('Y-m-d H:i:s');
        $this->db->insert('paper_master', $paperDetails);
        if($this->db->trans_status() == FALSE)
        {
            return false;
        }
        return $paperDetails['paper_id'];
    }

    private function getPaperCode($eventId)
    {
        $sql1 = "Select track_id From track_master Where track_event_id = ?";
        $sql2 = "Select subject_id From subject_master Where subject_track_id IN ($sql1)";
        $sql = "Select paper_code From paper_master Where paper_subject_id IN ($sql2) Order By paper_code Desc Limit 1";
        //$sql = "Select paper_code From paper_master Where paper_subject_id = ? Order By paper_code Desc Limit 1";
        $query = $this->db->query($sql, array($eventId));
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->paper_code + 1;
    }

    private function getPaperId()
    {
        $sql = "Select paper_id From paper_master Order By paper_id Desc Limit 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->paper_id + 1;
    }
}