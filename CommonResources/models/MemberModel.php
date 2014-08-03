<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 26/7/14
 * Time: 11:58 AM
 */

    class MemberModel extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function getMemberInfo($member_id)
        {
            $query = $this -> db -> get_where('member_master', array('member_id' => $member_id));

            if($query -> num_rows() > 0)
                return $query -> row_array();
            else
                return null;
        }

        public function getMemberInfo_Email($email_id)
        {
            $query = $this -> db -> get_where('member_master', array('member_email' => $email_id));

            if($query -> num_rows() > 0)
                return $query -> row_array();
            else
                return null;
        }

        public function getMembers()
        {
            $query = $this -> db -> get('member_master');

            if($query -> num_rows() > 0)
                return $query -> result_array();
        }

        public function getMemberMiniProfile($member_id)
        {
            $this -> db -> select('member_id,member_salutation,member_name,organization_name, member_category_name');
            $this -> db -> from('member_master');
            $this -> db -> join('organization_master', 'member_master.member_organization_id = organization_master.organization_id');
            $this -> db -> join('member_category_master', 'member_category_master.member_category_id = member_master.member_category_id');
            $this -> db -> where('member_master.member_id', $member_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> row_array();
        }

        public function updateMemberInfo($update_data, $member_id)
        {
            return $this -> db -> update('member_master', $update_data, array("member_id" => $member_id));
        }
    }
?>