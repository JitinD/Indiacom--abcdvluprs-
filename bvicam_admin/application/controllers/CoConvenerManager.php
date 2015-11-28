<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/22/15
 * Time: 12:56 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class CoConvenerManager extends BaseController
{
    private $coConvenerRoleName = "Co-Convener";

    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "CoConvenerManager";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH."views/pages/$this->controllerName/".$page.'.php'))
        {
            show_404();
        }

        $sidebarData['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view("pages/$this->controllerName/".$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {

    }

    public function load()
    {
        if(!$this->checkAccess("load"))
            return;
        $page = "index";
        $this->load->model('role_model');
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->load->model('track_model');

        $roleId = $this->role_model->getRoleId($this->coConvenerRoleName);
        if(!$roleId)
            die("$this->coConvenerRoleName role is not defined!");
        $this->data['coConveners'] = $this->user_model->getUsersByRole($roleId);
        $this->data['events'] = $this->event_model->getAllActiveEvents();
        $this->data['coConvenerTrack'] = array();
        foreach($this->data['events'] as $event)
        {
            $this->data['tracks'][$event->event_id] = $this->track_model->getAllTracks($event->event_id);
            foreach($this->data['coConveners'] as $coConvener)
            {
                $this->data['coConvenerTrack'][$coConvener->user_id][$event->event_id] = $this->track_model->getCoConvenerTrackByEvent($event->event_id, $coConvener->user_id);
            }
        }

        $this->index($page);
    }

    public function setTrackCoConvener_AJAX()
    {
        if(!$this->checkAccess("setTrackCoConvener_AJAX", false))
        {
            echo "access problem";
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('track_model');
        $this->form_validation->set_rules('userId', "User Id", 'required');
        $this->form_validation->set_rules('trackId', "Track Id", 'required');
        if($this->form_validation->run())
        {
            $userId = $this->input->post('userId');
            $trackId = $this->input->post('trackId');
            $userRoles = $this->user_model->getUserRoles($userId);
            $coConvenerRoleId = $this->role_model->getRoleId($this->coConvenerRoleName);
            $isCoConvener = false;
            foreach($userRoles as $role)
            {
                if($role->role_id == $coConvenerRoleId)
                {
                    $isCoConvener = true;
                    break;
                }
            }
            if($isCoConvener)
            {
                $this->track_model->setTrackCoConvener($trackId, $userId);
                echo true;
                return;
            }
        }
        echo "form validation problem";
        return;
    }
}