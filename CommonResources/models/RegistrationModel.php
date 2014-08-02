<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 19/7/14
 * Time: 6:10 PM
 */


class RegistrationModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function addMember($memberRecord = array())
    {
        return $this -> db -> insert('member_master', $memberRecord);
    }

    public function getOrganizationId($organization)
    {
        $this -> db -> select('organization_id');
        $this -> db -> where ('organization_name', $organization);
        $query = $this -> db -> get('organization_master');

        if($query -> num_rows() > 0)
            return $query ->  row_array();
    }

    public function assignMemberId()
    {
        $sql = "SELECT max(cast(`member_id` as UNSIGNED))as `member_id` from `member_master`";

        //$this -> db -> select('max(cast(member_id as UNSIGNED)');
        //$this->db->order_by("member_id", "desc");

        $query = $this -> db -> query($sql);

        if($query -> num_rows() == 0)
            return 1;
        $member_id_array = $query ->  row_array();
        $member_id = $member_id_array['member_id'] + 1;

        return $member_id;
    }

    public function getMemberCategories()
    {
        $this -> db -> select('member_category_id, member_category_name');
        $query = $this -> db -> get('member_category_master');

        return $query -> result();

    }
}

?>