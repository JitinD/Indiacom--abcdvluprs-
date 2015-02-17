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
    private $entity = "member_certificate_tracker";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function assignId()
    {
        $sql = "Select Max(member_certificate_tracker_id) As member_certificate_tracker_id From {$this->entity}";

        $query = $this->db->query($sql);

        $certificate_id_object = $query->row();
        $certificate_id = $certificate_id_object->member_certificate_tracker_id;

        if (!$certificate_id)
            $certificate_id = 0;

        return $certificate_id + 1;
    }

    public function submitCertificateData($certificateRecord = array())
    {
        $record = $this->getCertificateRecord($certificateRecord['submission_id']);

        if ($record == null) {
            $certificateRecord['member_certificate_tracker_id'] = $this->assignId();
            $this->db->insert($this->entity, $certificateRecord);
        } else {
            $this->db->where('member_certificate_tracker_id', $record['member_certificate_tracker_id']);
            $this->db->update($this->entity, $certificateRecord);
        }

        return $this->db->trans_status();
    }

    public function getCertificateRecord($submission_id)
    {
        $sql = "Select * from
              member_certificate_tracker
              where
              submission_id=?
              ";
        $query = $this->db->query($sql, array($submission_id));
        if ($query->num_rows() == 0)
            return null;
        return $query->row_array();
    }
}
