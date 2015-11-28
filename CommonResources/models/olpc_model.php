<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 1:32 AM
 */

class Olpc_model extends CI_Model
{
    public $error;
    private $maxPages = 6;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function setPaperTotalPages($pid, $totalPages)
    {
        if($this->getPaperExtraPages($pid) == null)
            $this->addNewOlpc($pid, $totalPages);
        else
        {
            $extraPages = $totalPages - $this->maxPages;
            $sql = "Update olpc_master Set extra_pages = ?
                    Where overlength_paper_id = ?";
            $this->db->query($sql, array($extraPages, $pid));
        }
    }

    public function getPaperExtraPages($pid)
    {
        $sql = "Select extra_pages From olpc_master
                Where overlength_paper_id = ?";
        $query = $this->db->query($sql, array($pid));
        if($query->num_rows() == 0)
            return null;
        $row = $query->row();
        return $row->extra_pages;
    }

    public function getPaperTotalPages($pid)
    {
        $extra_pages = $this->getPaperExtraPages($pid);
        if($extra_pages == null)
            return null;
        return $extra_pages + $this->maxPages;
    }

    private function addNewOlpc($pid, $totalPages)
    {
        $extraPages = $totalPages - $this->maxPages;
        $details = array(
            'overlength_paper_id' => $pid,
            'extra_pages' => $extraPages
        );
        $this->db->insert('olpc_master', $details);
    }
}