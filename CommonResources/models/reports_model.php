<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 8:19 PM
 */
class reports_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getQueryFields($sql)
    {

        $query = $this->db->query($sql);

        if ($query->num_rows() == 0)
            return null;
        return $query->list_fields();
    }

    public function getQueryReport($sql)
    {
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0)
            return null;
        return $query->result_array();
    }

    public function writeToFile($sql)
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $delimiter = ',';
        $newline = "\n";
        $report =$query = $this->db->query($sql);
        $new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
        if (!write_file('reports/report.csv',utf8_encode($new_report)))
        {
            return false;
        }
        else
        {
           return true;
        }
    }
}

?>