<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/22/14
 * Time: 8:50 PM
 */

class Submission_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addSubmission($paperId, $members = array())
    {
        $details = array(
            'submission_id' => $this->assignSubmissionId(),
            'submission_paper_id' => $paperId,
            'submission_member_id' => ''
        );
        $override = false;
        foreach($members as $memberId)
        {
            $details['submission_member_id'] = $memberId;
            $this->db->insert('submission_master', $details);
            if($this->db->trans_status() == false)
            {
                $sql = "Update submission_master Set submission_dirty = 0 Where submission_member_id = ? And submission_paper_id = ?";
                $this->db->query($sql, array($memberId, $details['submission_paper_id']));
                if($this->db->affected_rows() > 0)
                {
                    $override = true;
                }
                else
                {
                    //if control comes here then a total rollback will be required.
                    $override = false;
                    break;
                }
            }
            $details['submission_id']++;
        }
        if($this->db->trans_status() == false && !$override)
        {
            $this->error = "There was an error adding authors to paper. Check all author Ids. <br>If problem persists contact the admin.";
            return false;
        }
        return true;
    }

    public function deleteSubmission($paperId, $members = array())
    {
        $sql = "Update submission_master Set submission_dirty = 1 Where submission_member_id In (" . implode(",", $members) . ") And submission_paper_id = ? And submission_dirty = 0";
        $this->db->query($sql, array($paperId));
        return $this->db->trans_status();
    }

    public function getSubmissionsByAttribute($attrName, $attrVal)
    {
        $sql = "Select * From submission_master Where $attrName = ? AND submission_dirty = 0";
        $query = $this->db->query($sql, array($attrVal));
        if($query->num_rows() == 0)
            return null;
        return $query->result();
    }

    public function getAllPapersByAuthor($memberId)
    {
        return $this->getSubmissionsByAttribute("submission_member_id", $memberId);
    }

    public function getAllAuthorsOfPaper($paperId)
    {
        return $this->getSubmissionsByAttribute("submission_paper_id", $paperId);
    }

    public function isMemberValidAuthorOfPaper($memberId, $paperId)
    {
        $sql = "Select submission_id From submission_master Where submission_member_id = ? And submission_paper_id = ?";
        $query = $this->db->query($sql, array($memberId, $paperId));
        if($query->num_rows() == 1)
            return true;
        return false;
    }

    private function assignSubmissionId()
    {
        $sql = "Select submission_id From submission_master Order By submission_id Desc Limit 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->submission_id + 1;
    }

    public function getSubmissionID($member_id, $paper_id)
    {
        $sql = "Select submission_id from
              submission_master
              where
              submission_paper_id=? AND
              submission_member_id=?";
        $query = $this->db->query($sql, array($paper_id, $member_id));
        if ($query->num_rows() == 0)
            return array();
        return $query->row();
    }

}