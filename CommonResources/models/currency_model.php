<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/18/15
 * Time: 1:06 AM
 */

class Currency_model extends CI_Model
{
    public $error;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCurrencyName($currencyId)
    {
        $sql = "Select currency_name From currency_master
                Where currency_id = ?";
        $query = $this->db->query($sql, array($currencyId));
        if($query->num_rows() == 0)
            return null;
        $row = $query->row();
        return $row->currency_name;
    }

    public function getCurrencyId($currencyName)
    {
        $sql = "Select currency_id From currency_master
                Where currency_name = ?";
        $query = $this->db->query($sql, array($currencyName));
        if($query->num_rows() == 0)
            return null;
        $row = $query->row();
        return $row->currency_id;
    }

    public function getAllCurrencies()
    {
        $sql = "Select * From currency_master";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0)
            return array();
        return $query->result();
    }

    public function getCurrencyExchangeRateInINR($currencyId)
    {
        $currency = $this->getCurrencyName($currencyId);
        switch($currency)
        {
            case "USD":
                return 60;
            case "INR":
                return 1;
        }
        return 1;
    }
}