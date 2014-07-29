<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/23/14
 * Time: 10:21 AM
 */

class PaperVersionModel extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addPaperVersion($versionDetails = array())
    {
        $versionDetails['paper_version_id'] = $this->assignPaperVersionId();
        $versionDetails['paper_version_number'] = $this->getLatestPaperVersionNumber($versionDetails['paper_id']) + 1;
        $versionDetails['paper_version_date_of_submission'] = date('Y-m-d H:i:s');
        $this->db->insert('paper_version_master', $versionDetails);
        if($this->db->trans_status() == false)
        {
            $this->error = "There was an error saving paper doc path. Contact the admin.";
            return false;
        }
        return true;
    }

    public function getLatestPaperVersionNumber($paperId)
    {
        $sql = "Select paper_version_number From paper_version_master Where paper_id = ? Order By paper_version_number Desc Limit 1";
        $query = $this->db->query($sql, array($paperId));
        if($query->num_rows() == 0)
        {
            return 0;
        }
        $row = $query->row();
        return $row->paper_version_number;
    }

    public function getLatestPaperVersionDetails($paperId)
    {
        $sql = "Select * From paper_version_master Where paper_id = ? And paper_version_dirty = 0 Order By paper_version_number Desc Limit 1";
        $query = $this->db->query($sql, array($paperId));
        return $query->row();
    }

    public function getPaperAllVersionDetails($paperId)
    {
        $sql = "Select * From paper_version_master Where paper_id = ? And paper_version_dirty = 0";
        $query = $this->db->query($sql, array($paperId));
        return $query->result();
    }

    private function assignPaperVersionId()
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