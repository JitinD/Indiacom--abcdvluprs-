<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 11:00 PM
 */

class Payable_class_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllPayableClassDetails()
    {
        $sql = "Select * From payable_class";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getAllBrPayableClassDetails()
    {
        $sql = "Select * From payable_class
                Where payable_class_payhead_id = 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getPayableClassDetails($payableClassId)
    {
        $sql = "Select * From payable_class Where payable_class_id = ?";
        $query = $this->db->query($sql, array($payableClassId));
        if($query->num_rows() == 0)
            return array();
        return $query->row();
    }

    public function getPayableClass($payhead, $isGeneral, $regCat, $currency, $transDate)
    {
        $sql = "
        Select *
        From payable_class
          Left Join nationality_master On payable_class_nationality = Nationality_id
        Where
            Case
                When start_date Is Not Null
                Then '$transDate' >= start_date
                Else 1
            End And
            Case
                When end_date Is Not Null
                Then '$transDate' <= end_date
                Else 1
            End And
            Case
                When is_general Is Not Null
                Then is_general = ?
                Else 1
            End And
            payable_class_payhead_id = ? And
            Case
                When payable_class_registration_category Is Not Null
                Then payable_class_registration_category = ?
                Else 1
            End And
            Case
                When Nationality_currency Is Not Null
                Then Nationality_currency = ?
                Else 1
            End";
        $query = $this->db->query($sql, array($isGeneral, $payhead, $regCat, $currency));
        if($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    public function getBrPayableClass($isGeneral, $regCat, $currency, $transDate)
    {
        return $this->getPayableClass(1, $isGeneral, $regCat, $currency, $transDate);
    }

    public function getEpPayableClass($isGeneral, $regCat, $currency, $transDate)
    {
        return $this->getPayableClass(2, $isGeneral, $regCat, $currency, $transDate);
    }

    public function getDateGroups($payheadId)
    {
        $sql = "
        Select
            Distinct (
                Case
                    When start_date Is Null
                    Then Concat('upto ',end_date)
                    Else Concat(start_date, ' to ', end_date)
                End
            ) as dates
        From
            payable_class
        Where payable_class_payhead_id = ?";
        $query = $this->db->query($sql, array($payheadId));
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }
}