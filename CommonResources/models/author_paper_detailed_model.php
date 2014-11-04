<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 7/29/14
 * Time: 8:09 PM
 */

class Author_paper_detailed_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCurrentAuthorPaperDetailsByAttribute($attrName, $attrVal)
    {
        $sql = "Select * From author_paper_details Where $attrName = ? And submission_member_id = ?";
        $query = $this->db->query($sql, array($attrVal, $_SESSION[APPID]['member_id']));
        if($query->num_rows() == 1)
            return $query->row();
        return $query->result();
    }

    public function getAllAuthorPaperDetailsByAttribute($attrName, $attrVal)
    {
        $sql = "Select * From author_paper_details Where $$attrName = ?";
        $query = $this->db->query($sql, array($attrVal));
        return $query->result();
    }
}