<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 4/8/15
 * Time: 8:18 PM
 */

class Reviewer_model extends CI_Model
{
    public $error = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getReviewerIDs()
    {
        $this -> db -> select('reviewer_id');
        $query = $this -> db -> get('reviewer_master');

        if($query -> num_rows() > 0)
            return $query -> result_array();

    }

    private function getReviewerRoleId()
    {
        $role_id = -1;

        $query = $this -> db -> get_where('role_master', array('role_name' => 'Reviewer'));

        if($query -> num_rows() > 0)
        {
            $record = $query -> row();

            $role_id = $record -> role_id;
        }

        return $role_id;
    }

    public function getAllReviewers()
    {
        /*$this -> db -> select('*');
        $this -> db -> from('reviewer_master');
        $this -> db -> join('user_master', 'reviewer_id = user_id');*/

        $role_id = $this -> getReviewerRoleId();

        if($role_id > 0)
        {
            $this -> db -> select('*');
            $this -> db -> from('user_event_role_mapper');
            $this -> db -> join('user_master', 'user_event_role_mapper.user_id = user_master.user_id');
            $this -> db -> where('role_id', $role_id);

            $query = $this -> db -> get();

            if($query -> num_rows() > 0)
                return $query -> result();
        }

        return null;
    }
}