<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 26/7/14
 * Time: 11:58 AM
 */

class MemberModel extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        if(isset($_SESSION['sudo']))
        {
            $this->dbCon = $this->load->database('default', TRUE);
            unset($_SESSION['sudo']);
        }
        else
        {
            $this->load->database();
            $this->dbCon = $this->db;
        }
    }

    //Use this function to elevate privilege if $_SESSION['sudo'] method doesn't work
    public function sudo()
    {
        $this->dbCon->close();
        $this->dbCon = $this->load->database('default', TRUE);
    }

    private function getMemberInfo_Id($entity, $member_id)
    {
        //$query = $this -> dbCon -> get_where($entity, array('member_id' => $member_id));
        $sql = "Select * From {$entity} Where member_id = ?";
        $query = $this->dbCon->query($sql, array($member_id));

        /*if(!$this->dbCon->trans_status())
            throw new SelectException("Error fetching member info", mysql_error(), mysql_errno());
        return $query->row_array();*/
        if($query -> num_rows() > 0)
            return $query -> row_array();
        else
            return null;
    }

    public function getMemberInfo($member_id)
    {
        return $this -> getMemberInfo_Id('member_master', $member_id);
    }

    public function getTempMemberInfo($member_id)
    {
        return $this -> getMemberInfo_Id('temp_member_master', $member_id);
    }

    public function getMemberInfo_Email($email_id)
    {
        $query = $this -> dbCon -> get_where('member_master', array('member_email' => $email_id));

        if($query -> num_rows() > 0)
            return $query -> row_array();
        else
            return null;
    }

    public function getMembers()
    {
        $query = $this -> dbCon -> get('member_master');

        if($query -> num_rows() > 0)
            return $query -> result_array();
    }

    public function getMemberMiniProfile($member_id)
    {
        $this -> dbCon -> select('member_id,member_salutation,member_name,organization_name, member_category_name');
        $this -> dbCon -> from('member_master');
        $this -> dbCon -> join('organization_master', 'member_master.member_organization_id = organization_master.organization_id');
        $this -> dbCon -> join('member_category_master', 'member_category_master.member_category_id = member_master.member_category_id');
        $this -> dbCon -> where('member_master.member_id', $member_id);

        $query = $this -> dbCon -> get();

        if($query -> num_rows() > 0)
            return $query -> row_array();
    }

    public function updateMemberInfo($update_data, $member_id)
    {
        return $this -> dbCon -> update('member_master', $update_data, array("member_id" => $member_id));
    }
}