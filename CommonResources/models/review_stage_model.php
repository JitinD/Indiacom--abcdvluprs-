<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 10/28/15
 * Time: 6:07 PM
 */

class Review_stage_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getAllReviewStages()
    {
        $this->db->select("review_stage_id, review_stage_name, stage_number, is_final_stage");
        $this->db->order_by("stage_number");
        $query = $this->db->get("review_stage_master");
        return $query->result();
    }

    public function getReviewStageDetails($reviewStageId)
    {
        $this->db->select("review_stage_id, review_stage_name, stage_number, is_final_stage");
        $this->db->where("review_stage_id", $reviewStageId);
        $query = $this->db->get();
        return $query->row();
    }
}