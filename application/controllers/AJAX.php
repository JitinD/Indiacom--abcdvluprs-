<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/21/14
 * Time: 12:55 PM
 */

class AJAX extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AjaxModel');
    }

    public function fetchOrganisationNames()
    {
        $keyword = $this->input->post('data');
        echo $this->AjaxModel->fetchOrganisationNames($keyword);
    }
}