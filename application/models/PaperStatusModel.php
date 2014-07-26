<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 19/7/14
 * Time: 6:10 PM
 */


class PaperStatusModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getMemberPapers($member_id)
    {
        $query = $this -> db -> get_where('paper_status_info',array('submission_member_id' => $member_id));
        $number = 0;
        $paper = "";
        foreach($query -> result() as $record)
            $paper .= "<tr><td>".(++$number)."</td><td>".$record -> paper_id."</td><td>".$record -> paper_title."</td><td>".$record -> review_result_type_name."</td><td>".$record -> paper_version_number."</td></tr>";

        return $paper;

    }
}