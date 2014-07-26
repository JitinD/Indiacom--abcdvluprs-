<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 26/7/14
 * Time: 11:49 AM
 */

    class MemberCategories extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function getMemberCategoryInfo($member_category_id)
        {
            $query = $this -> db -> get_where('member_category_master', array('member_category_id' => $member_category_id));
            return $query -> row_array();
        }
    }

?>