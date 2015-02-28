<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/18/15
 * Time: 2:26 PM
 */

class deliverables_model extends CI_Model
{
    public $error;
    private $entity = "deliverables_status";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function assignId()
    {
        $sql = "Select Max(deliverables_status_id) As deliverables_status_id From {$this->entity}";

        $query = $this->db->query($sql);

        $deliverables_status_id_object = $query->row();
        $deliverables_status_id = $deliverables_status_id_object -> deliverables_status_id;

        if(!$deliverables_status_id)
            $deliverables_status_id = 0;

        return $deliverables_status_id + 1;
    }


    public function assignDeliverables($deliverablesStatusRecord=array())
    {
        $record = $this->getDeliverablesStatusRecord($deliverablesStatusRecord['member_id'], $deliverablesStatusRecord['submission_id']);

        if($record == null)
        {
            $deliverablesStatusRecord['deliverables_status_id'] = $this->assignId();
            $this -> db -> insert($this -> entity, $deliverablesStatusRecord);
        }
        else
        {
            $this -> db -> where('deliverables_status_id', $record['deliverables_status_id']);
            $this -> db -> update($this -> entity, $deliverablesStatusRecord);
        }

        return $this->db->trans_status();
    }

    public function getDeliverablesStatusRecord($member_id, $submission_id)
    {
        $sql =
                "Select * From deliverables_status
                 Where
                    Case
                        When submission_id is not null
                            Then submission_id = ?
                        Else member_id = ?
                    End";


        $query = $this->db->query($sql, array($submission_id, $member_id));

        if ($query->num_rows() == 0)
            return null;

        return $query->row_array();
    }
} 