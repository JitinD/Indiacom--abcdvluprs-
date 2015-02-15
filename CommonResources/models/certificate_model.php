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
}
