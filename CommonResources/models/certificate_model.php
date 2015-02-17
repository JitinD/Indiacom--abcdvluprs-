<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/15/15
 * Time: 1:12 AM
 */
class Certificate_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function assignId($entity)
    {
        $sql = "SELECT max(cast(`member_id` as UNSIGNED))as `member_certificate_tracker_id` from $entity";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return 1;
        $certificate_id_array = $query->row_array();
        $certificate_id = $certificate_id_array['member_certificate_tracker_id'] + 1;
        return $certificate_id;
    }

    public function submitCertificateData($entity,$certificateRecord=array())
    {
        $attendanceRecord['member_certificate_tracker_id']=$this->assignId($entity);
        $this -> db -> insert($entity, $certificateRecord);
        return $this->db->trans_status;
    }

    public function getCertificateData($submission_id)
    {
        $sql="Select * from
              member_certificate_tracker
              where
              submission_id=?
              ";
        $query = $this->db->query($sql, array($submission_id));
        if ($query->num_rows() == 0)
            return null;
        return $query->row();
    }
}
