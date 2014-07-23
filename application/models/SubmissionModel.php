<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/22/14
 * Time: 8:50 PM
 */

class SubmissionModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addSubmission($paperId, $members = array())
    {
        $details = array(
            'submission_id' => $this->getSubmissionId(),
            'submission_paper_id' => $paperId,
            'submission_member_id' => ''
        );
        foreach($members as $memberId)
        {
            $details['submission_member_id'] = $memberId;
            $this->db->insert('submission_master', $details);
            $details['submission_id']++;
        }
        return $this->db->trans_status();
    }

    private function getSubmissionId()
    {
        $sql = "Select submission_id From submission_master Order By submission_id Desc Limit 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->submission_id + 1;
    }
}