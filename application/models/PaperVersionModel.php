<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/23/14
 * Time: 10:21 AM
 */

class PaperVersionModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addPaperVersion($versionDetails = array())
    {
        $versionDetails['paper_version_id'] = $this->getPaperVersionId();
        $versionDetails['paper_version'] = $this->getPaperVersion($versionDetails['paper_id']);
        $versionDetails['paper_version_date_of_submission'] = date('Y-m-d H:i:s');
        $this->db->insert('paper_version_master', $versionDetails);
    }

    private function getPaperVersion($paperId)
    {
        $sql = "Select paper_version From paper_version_master Where paper_id = ? Order By paper_version Desc Limit 1";
        $query = $this->db->query($sql, array($paperId));
        if($query->num_rows() == 0)
        {
            return 1;
        }
        $row = $query->row();
        return $row->paper_version + 1;
    }

    private function getPaperVersionId()
    {
        $sql = "Select paper_version_id From paper_version_master Order By paper_version_id Desc Limit 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
        {
            return 1;
        }
        $row = $query->row();
        return $row->paper_version_id + 1;
    }
}