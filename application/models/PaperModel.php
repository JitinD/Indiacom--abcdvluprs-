<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 12:59 PM
 */

class PaperModel extends CI_Model
{
    public $error;
    private $papers;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addPaper(&$paperDetails = array(), $eventId)
    {
        $paperDetails['paper_id'] = $this->assignPaperId();
        $paperDetails['paper_code'] = $this->assignPaperCode($eventId);
        $paperDetails['paper_date_of_submission'] = date('Y-m-d H:i:s');
        $this->db->insert('paper_master', $paperDetails);
        if($this->db->trans_status() == FALSE)
        {
            $this->error = "There was an error creating a new paper. Check contact author Id. <br>If problem persists contact the admin.";
            return false;
        }
        return $paperDetails['paper_id'];
    }

    public function isUniquePaperTitle($paperTitle)
    {
        $pattern = "/[^\w]/";
        $paperTitle = strtolower(preg_replace($pattern, '', $paperTitle));
        foreach($this->papers as $paper)
        {
            if(strtolower(preg_replace($pattern, '', $paper->paper_title)) == $paperTitle)
                return false;
        }
        return true;
    }

    public function getAllPaperDetails($eventId)
    {
        $sql1 = "Select track_id From track_master Where track_event_id = ?";
        $sql2 = "Select subject_id From subject_master Where subject_track_id IN ($sql1)";
        $sql = "Select paper_code, paper_title From paper_master Where paper_subject_id IN ($sql2) Order By paper_code Desc";
        $query = $this->db->query($sql, array($eventId));
        $this->papers = $query->result();
    }

    public function getPaperDetails($paperId)
    {
        $sql = "Select * From paper_master Where paper_id = ?";
        $query = $this->db->query($sql, array($paperId));
        return $query->row();
    }

    public function getPaperEventDetails($paperId)
    {
        $sql = "Select event_master.* From
                (
                    (
                        paper_master Join subject_master On paper_master.paper_subject_id = subject_master.subject_id
                    )
                    Join track_master On subject_master.subject_track_id = track_master.track_id
                ) Join event_master On track_master.track_event_id = event_master.event_id
                Where paper_id = ?";
        $query = $this->db->query($sql, array($paperId));
        return $query->row();
    }

    private function assignPaperCode($eventId)
    {
        if(empty($this->papers))
            return 1;
        return $this->papers[0]->paper_code + 1;
    }

    private function assignPaperId()
    {
        $sql = "Select paper_id From paper_master Order By paper_id Desc Limit 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->paper_id + 1;
    }
}