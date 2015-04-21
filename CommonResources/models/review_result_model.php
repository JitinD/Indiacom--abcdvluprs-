<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/29/14
 * Time: 10:52 PM
 */

class Review_result_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //TODO:Redundant
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

    //TODO:Redundant;
    public function getAllReviewResults()
    {
        $this -> db -> select('review_result_id, review_result_type_name');
        $query = $this -> db -> get('review_result_master');

        if($query -> num_rows() > 0)
            return $query -> result();
    }

    public function getReviewResultDetails($reviewResultId)
    {
        $sql = "
        Select *
        From review_result_master
        Where review_result_id = ?";

        $query = $this->db->query($sql, array($reviewResultId));
        if($query->num_rows() == 1)
            return $query->row();
        else
            return null;
    }
}