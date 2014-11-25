<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 26/7/14
 * Time: 11:49 AM
 */

    class Member_categories_model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function getMemberCategoryInfo($member_category_id)
        {
            $query = $this -> db -> get_where('member_category_master', array('member_category_id' => $member_category_id));

            if($query -> num_rows() > 0)
                return $query -> row_array();
        }

        public function getMemberCategories()
        {
            $query = $this -> db -> get('member_category_master');

            if($query -> num_rows() > 0)
                return $query -> result_array();
        }
    }

?>