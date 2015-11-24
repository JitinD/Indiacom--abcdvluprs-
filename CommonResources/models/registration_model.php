<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 19/7/14
 * Time: 6:10 PM
 */


class Registration_model extends CI_Model
{
   public function __construct()
    {
        $this->load->database();
    }

    private function addMemberRecord($entity, $memberRecord)
    {
        return $this -> db -> insert($entity, $memberRecord);
    }

    public function addMember($memberRecord = array())
    {
        return $this -> addMemberRecord('member_master', $memberRecord);
    }

    public function addTempMember($memberRecord = array())
    {
        return $this -> addMemberRecord('temp_member_master', $memberRecord);
    }

    private function assignId($entity)
    {
        $sql = "SELECT max(cast(`member_id` as UNSIGNED))as `member_id` from $entity";

        //$this -> db -> select('max(cast(member_id as UNSIGNED)');
        //$this->db->order_by("member_id", "desc");

        $query = $this -> db -> query($sql);

        if($query -> num_rows() == 0)
            return 1;

        $member_id_array = $query ->  row_array();
        $member_id = $member_id_array['member_id'] + 1;

        return $member_id;
    }

    public function deleteTempMember($member_id)
    {
        return $this->db->delete('temp_member_master', array('member_id' => $member_id));
    }

    public function getOrganizationId($organization)
    {
        $this -> db -> select('organization_id');
        $this -> db -> where ('organization_name', $organization);
        $query = $this -> db -> get('organization_master');

        if($query -> num_rows() > 0)
            return $query ->  row_array();
    }

    public function assignTempMemberId()
    {
        return $this -> assignId('temp_member_master');
    }

    public function assignMemberId()
    {
        return $this -> assignId('member_master');
    }

    public function getMemberCategories()
    {
        $this -> db -> select('*');
        $query = $this -> db -> get('member_category_master');

        return $query -> result();

    }
    public function getCountries()
    {
        $this -> db -> select('country_id, country_name');
        $query = $this -> db -> get('country_master');

        return $query -> result();

    }

    /*public function checkCurrentPassword($user_id,$password)
    {
        $this->db->select('member_password');
        $this->db->where('member_id',$user_id);
        $query=$this->db->get('member_master');
        $currentPassword_array=$query->row_array();
        $currentPassword=$currentPassword_array['member_password'];
        $pass=md5($password);
        if(!strcmp($currentPassword,$pass))
        {
            return 1;
        }

    }

    public function resetPassword($user_id,$newPassword,$confirmPassword)
    {
        if(!strcmp($newPassword,$confirmPassword))
        {
            $password=md5($newPassword);
            $data = array(
                'member_password' => $password );

            $this->db->where('member_id', $user_id);
            $this->db->update('member_master', $data);

        return true;

        }
      return false;
    }*/
}
?>