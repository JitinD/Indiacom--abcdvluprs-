<?php

    class ConvenerModel extends CI_Model
    {
        public function __construct()
        {
          $this->load->database();
        }

        public function getAssignedPapers($user_id)
        {
            $this -> db -> select('paper_master.paper_id as paper_id, paper_version_id, paper_code, paper_version_number, paper_title');
            $this -> db -> from('paper_master');
            $this -> db -> join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');
            $this -> db -> where('paper_version_convener_id', $user_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }

        public function getReviewerAssignedPapers($user_id)
        {
            $this -> db -> select('paper_version_review_id, paper_master.paper_id as paper_id, paper_version_master.paper_version_id, paper_code, paper_version_number, paper_title');
            $this -> db -> from('paper_master');
            $this -> db -> join('paper_version_master', 'paper_master.paper_id = paper_version_master.paper_id');
            $this -> db -> join('paper_version_review', 'paper_version_master.paper_version_id = paper_version_review.paper_version_id');
            $this -> db -> where('paper_version_reviewer_id', $user_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }

        public function getPaperVersionReviews($paper_version_id)
        {
            $this -> db -> select('paper_version_review_id, paper_version_id, paper_version_reviewer_id, paper_version_review_comments, date(paper_version_review_date_of_receipt) as paper_version_review_date_of_receipt');
            $this -> db -> from('paper_version_review');
            $this -> db -> where('paper_version_id', $paper_version_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }

        public function  getPaperVersionReview($paper_version_review_id)
        {
            $this -> db -> select('paper_version_review_comments');
            $this -> db -> from('paper_version_review');
            $this -> db -> where('paper_version_review_id', $paper_version_review_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }

        public function sendConvenerReview($update_data, $paper_version_id)
        {
            return $this -> db -> update('paper_version_master', $update_data, array("paper_version_id" => $paper_version_id));
        }

        public function sendReviewerComments($update_data, $paper_version_review_id)
        {
            return $this -> db -> update('paper_version_review', $update_data, array("paper_version_review_id" => $paper_version_review_id));
        }

        public function getPaperVersionComments($paper_version_id)
        {
            $this -> db -> select('paper_version_review');
            $this -> db -> from('paper_version_master');
            $this -> db -> where('paper_version_id', $paper_version_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }

        public  function  getReviewerIDs()
        {
            $this -> db -> select('reviewer_id');
            $query = $this -> db -> get('reviewer_master');

            if($query -> num_rows() > 0)
                return $query -> result_array();

        }

        public function addPaperVersionReviewRecord($Record = array())
        {
            return $this -> db -> insert('paper_version_review', $Record);
        }

        public function removePaperVersionReviewer($paper_version_review_id)
        {
            return $this -> db -> delete('paper_version_review', array('paper_version_review_id' => $paper_version_review_id));
        }

        public function setReviewerAssigned($update_data, $paper_version_id)
        {
            return $this -> db -> update('paper_version_master', $update_data, array("paper_version_id" => $paper_version_id));
        }

        public function getAllReviewResults()
        {
            $this -> db -> select('review_result_id, review_result_type_name');
            $query = $this -> db -> get('review_result_master');

            if($query -> num_rows() > 0)
                return $query -> result();
        }
    }
?>