<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 27/8/14
 * Time: 11:28 PM
 */

    class ReviewerModel extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public  function  getReviewerIDs()
        {
            $this -> db -> select('reviewer_id');
            $query = $this -> db -> get('reviewer_master');

            if($query -> num_rows() > 0)
                return $query -> result_array();

        }

        public function getAllReviewers()
        {
            $this -> db -> select('reviewer_id, user_name');
            $this -> db -> from('reviewer_master');
            $this -> db -> join('user_master', 'reviewer_id = user_id');

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }
    }
?>