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
        $sql = "Select application_name From application_master Where application_id = ?";
        $query = $this->dbCon->query($sql, array($applicationID));
        if($query && $query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->application_name;
        }
        if(!$query)
            throw new SelectException("Error fetching application id", mysql_error(), mysql_errno());
        return null;
    }

    public function getApplicationId($applicationName)
    {
        $sql = "Select application_id From application_master Where application_name = ?";
        $query = $this->dbCon->query($sql, array($applicationName));
        if($query && $query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->application_id;
        }
        if(!$query)
            throw new SelectException("Error fetching application id", mysql_error(), mysql_errno());
        return null;
    }
}