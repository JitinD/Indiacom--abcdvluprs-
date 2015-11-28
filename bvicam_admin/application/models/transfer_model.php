<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/17/15
 * Time: 8:22 PM
 */

class Transfer_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function newTransfer($sourcePaymentId, $destPaymentId, $transferAmount)
    {
        $details = array(
            'from_payment_id' => $sourcePaymentId,
            'to_payment_id' => $destPaymentId
        );
        $this->db->insert('transfer_master', $details);
    }
}