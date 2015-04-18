<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 3/8/15
 * Time: 7:50 PM
 */

class Information_schema_model extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        $this->load->database();
        $this->dbCon = $this->db;
    }

    //Use this function to elevate privilege if $_SESSION['sudo'] method doesn't work
    public function sudo()
    {
        $this->dbCon->close();
        $this->dbCon = $this->load->database(DBGROUP, TRUE);
    }

    public function getAllTableNames()
    {
        $sql = "
        (
            SELECT table_name
            FROM information_schema.tables
            Where table_schema = ?
        )
        Union
        (
            Select table_name
            From information_schema.views
            Where table_schema = ?
        )";
        $query = $this->dbCon->query($sql, array('indiacom', 'indiacom'));
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }
}