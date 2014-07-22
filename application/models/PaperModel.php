<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/22/14
 * Time: 12:59 PM
 */

class PaperModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($paperDetails = array())
    {

    }
}