<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 12:59 PM
 */

class Paper_model extends CI_Model
{
    public $error;

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

    public function isUniquePaperTitle($paperTitle, $eventId)
    {
        $papers = $this->getAllPaperDetails($eventId);
        $pattern = "/[^\w]/";
        $paperTitle = strtolower(preg_replace($pattern, '', $paperTitle));
        foreach($papers as $paper)
        {
            if(strtolower(preg_replace($pattern, '', $paper->paper_title)) == $paperTitle)
                return false;
        }
        return true;
    }

    private function getAllPaperDetails($eventId)
    {
        $sql1 = "Select track_id From track_master Where track_event_id = ?";
        $sql2 = "Select subject_id From subject_master Where subject_track_id IN ($sql1)";
        $sql = "Select paper_code, paper_title From paper_master Where paper_subject_id IN ($sql2) Order By paper_code Desc";
        $query = $this->db->query($sql, array($eventId));
        return $query->result();
    }

    public function getPaperDetails($paperId)
    {
        $sql = "Select * From paper_master Where paper_id = ?";
        //print_r($paperId);
        //die();
        $query = $this->db->query($sql, array($paperId));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function getPaperID($paperCode, $eventId)
    {
        $sql = "Select paper_master.paper_id From
        paper_master  JOIN
        subject_master
        on paper_master.paper_subject_id=subject_master.subject_id
        JOIN
        track_master
        on subject_master.subject_track_id=track_master.track_id
        Where paper_master.paper_code = ? AND
        track_master.track_event_id=?";

        $query = $this->db->query($sql, array($paperCode, $eventId));
        if($query->num_rows() == 0)
            return null;
        $row = $query->row();
        return $row->paper_id;
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
        $sql = "
        Select
            MAX(CAST(paper_code as Unsigned)) as paper_code
        From
            paper_subject_track_event
        Where event_id = ?";
        $query = $this->db->query($sql, array($eventId));
        $row = $query->row();
        if($row->paper_code == null)
            return 1;
        return $row->paper_code + 1;
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

    /*//Get all the papers of an author
    public function getAllPapers($memberID)
    {
            $this->db->select('paper_master.paper_id,paper_master.paper_code,paper_master.paper_title');
            $this->db->from('submission_master');
            $this->db->join('paper_master','submission_master.submission_paper_id=paper_master.paper_id');
            $this->db->join('paper_latest_version','paper_latest_version.paper_id=submission_master.submission_paper_id');
            $this->db->where('submission_member_id',$memberID);
            $this->db->where('review_result_type_name','Accepted');
            $query=$this->db->get();
            if($query -> num_rows() > 0)
                return $query->result();
    }*/

    //Check if the author is the main author
    public function checkMainAuthor($memberID)
    {
        $this->db->select('paper_id');
        $this->db->from('paper_master');
        $this->db->where('paper_contact_author_id',$memberID);
        $query=$this->db->get();
        if($query->num_rows()>0)
            return true;
        else
            return false;
    }

    //Get the main author of a paper
    public function getMainAuthor($paperID)
    {
        $this->db->select('paper_contact_author_id');
        $this->db->from('paper_master');
        $this->db->where('paper_id',$paperID);
        $query = $this->db->get();
        if($query->num_rows() == 0)
            return null;
        $row = $query->row();
        return $row->paper_contact_author_id;
    }

    //Get the co-authors of a paper
    public function getCoAuthors($paperID)
    {
        $this->db->select('submission_member_id');
        $this->db->from('submission_master');
        $this->db->where('submission_paper_id',$paperID);
        $query=$this->db->get();
        $this->db->count_all_results('my_table');
            if($query->num_rows()>0)
                return $query -> result();
    }

    //Get co-author count
    //public function getCoAuthorCount($paperID)
    public function getNumberOfAuthors($paperID)
    {
        $this->db->select('count(*)as count');
        $this->db->from('submission_master');
        $this->db->where('submission_paper_id',$paperID);
        $query=$this->db->get();
        if($query->num_rows()>0)
            return $query -> row();
    }

    //Get the total count of papers of a member
    public function getPaperCount($memberID)
    {
        $this->db->select('count(*)as count');
        $this -> db -> from('paper_latest_version');
        $this -> db-> join('submission_master','paper_latest_version.paper_id=submission_master.submission_paper_id');
        $this -> db-> where('review_result_type_name','Accepted');
        $this->db->where('submission_member_id',$memberID);
        $query=$this->db->get();
        if($query->num_rows()>0)
            return $query -> row();

    }

    
}