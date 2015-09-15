<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/12/15
 * Time: 8:13 PM
 */

class BaseController extends CI_Controller
{
    protected $controllerName;

    protected $data = array();

    protected $privileges = array();

    protected function checkAccess($operationName)
    {
        $this->load->model('access_model');
        if(!isset($this->privileges['Page'][$this->controllerName][$operationName]) || !$this->access_model->hasPrivileges($this->privileges['Page'][$this->controllerName][$operationName]))
        {
            $this->load->view('pages/unauthorizedAccess');
            if(!isset($this->privileges['Page'][$this->controllerName][$operationName]))
                echo "<b>Check application's privileges.php. The entry does not exist in the application's privileges.php</b>";
            return false;
        }
        return true;
    }
}