<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 4/8/15
 * Time: 8:18 PM
 */

class Reviewer_model extends CI_Model
{
    public $error = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getReviewerIDs()
    {
        $this -> db -> select('reviewer_id');
        $query = $this -> db -> get('reviewer_master');

        if($query -> num_rows() > 0)
            return $query -> result_array();

    }

    public function getAllReviewers()
    {
        $this -> db -> select('*');
        $this -> db -> from('reviewer_master');
        $this -> db -> join('user_master', 'reviewer_id = user_id');

        $query = $this -> db -> get();

        if($query -> num_rows() > 0)
            return $query -> result();
    }
}