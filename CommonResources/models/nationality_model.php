<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/19/15
 * Time: 1:06 PM
 */
class Nationality_model extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        if(isset($_SESSION['sudo']))
        {
            $this->dbCon = $this->load->database(DBGROUP, TRUE);
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
        $this->dbCon = $this->load->database(DBGROUP, TRUE);
    }

    public function getAllNationalities()
    {
        $sql = "Select * From nationality_master";
        $query = $this->dbCon->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getAllNationalitiesAsAssocArray()
    {
        $nationalities = $this->getAllNationalities();
        $nations = array();
        foreach($nationalities as $nationality)
        {
            $nations[$nationality->Nationality_id] = $nationality;
        }
        return $nations;
    }
}