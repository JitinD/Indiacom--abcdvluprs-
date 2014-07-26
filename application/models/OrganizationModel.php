<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 26/7/14
 * Time: 11:58 AM
 */

    class OrganizationModel extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function getOrganizationInfo($member_organization_id)
        {
            $query = $this -> db -> get_where('organization_master', array('organization_id' => $member_organization_id));
            return $query -> row_array();
        }
    }