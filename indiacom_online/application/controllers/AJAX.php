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
        $this->load->model('ajax_model');
    }

    public function fetchOrganisationNames()
    {
        $keyword = $this->input->post('data');
        echo $this->ajax_model->fetchOrganisationNames($keyword);
    }

    public function tracks()
    {
        $eventId = $this->input->post('eventId');
        echo $this->ajax_model->getAllTracks($eventId);
    }

    public function subjects()
    {
        $trackId = $this->input->post('trackId');
        echo $this->ajax_model->getAllSubjects($trackId);
    }
}