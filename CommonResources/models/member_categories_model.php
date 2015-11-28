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

        public function getMemberCategoryId($categoryName)
        {
            $sql = "Select member_category_id
                    From member_category_master
                    Where member_category_name = ?";
            $query = $this->db->query($sql, array($categoryName));

            if($query->num_rows() == 1)
            {
                $row = $query->row();
                return $row->member_category_id;
            }
            return null;
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

        public function getMemberCategoriesAsAssocArray()
        {
            $memCats = $this->getMemberCategories();
            $cats = array();
            foreach($memCats as $memCat)
            {
                $cats[$memCat['member_category_id']] = $memCat;
            }
            return $cats;
        }

        public function getMemberCategoryName($member_category_id)
        {
            $member_category = $this -> getMemberCategoryInfo($member_category_id);

            return $member_category['member_category_name'];
        }
    }

?>