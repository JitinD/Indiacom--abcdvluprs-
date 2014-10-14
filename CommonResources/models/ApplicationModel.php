<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 9/30/14
 * Time: 7:15 PM
 */

class ApplicationModel extends CI_Model
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

    public function getAllApplications()
    {
        $sql = "Select * From application_master";
        $query = $this->dbCon->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getApplicationName($applicationID)
    {
        $this->dbCon->select('application_name');
        $this->dbCon->where('application_id', $applicationID);
        $query = $this->dbCon->get('application_master');
        return $query->row();

    }
}