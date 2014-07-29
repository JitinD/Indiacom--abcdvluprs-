<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/29/14
 * Time: 10:52 PM
 */

class ReviewResultModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllReviewResultTypeNames()
    {
        $sql = "Select review_result_id, review_result_type_name From review_result_master Where review_result_dirty = 0";
        $query = $this->db->query($sql);
        $types = array();
        foreach($query->result() as $reviewType)
        {
            $types[$reviewType->review_result_id] = $reviewType->review_result_type_name;
        }
        return $types;
    }
}