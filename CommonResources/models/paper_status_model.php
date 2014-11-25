<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 19/7/14
 * Time: 6:10 PM
 */


class Paper_status_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getMemberPapers($member_id)
    {
        //$query = $this -> db -> get_where('paper_status_info',array('submission_member_id' => $member_id));
        $sql = "Select paper_id, paper_code, paper_title, latest_paper_version_number, review_result_type_name
                From paper_latest_version join submission_master on paper_id = submission_paper_id
                Where submission_member_id = ? And submission_dirty = 0";
        $query = $this->db->query($sql, array($member_id));
        if($query->num_rows() > 0)
            return $query->result();
        return array();
        /*$number = 0;
        $paper = "";

        if($query -> num_rows() > 0)
        {
            foreach($query -> result() as $record)
                $paper .= "<tr><td>".(++$number)."</td><td>".$record -> paper_id."</td><td>".$record -> paper_title."</td><td>".$record -> review_result_type_name."</td><td>".$record -> paper_version_number."</td></tr>";
        }
        return $paper;*/

    }
}