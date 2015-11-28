<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/1/14
 * Time: 11:43 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class RoleManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "RoleManager";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH.'views/pages/RoleManager/'.$page.'.php'))
        {
            show_404();
        }
        $this->data['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view('pages/RoleManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {

    }

    public function sample()
    {
        /*require(dirname(__FILE__).'/../config/privileges.php');
        $this->load->model('sample_model');
        $this->sample_model->sample($privilege);*/
    }

    public function load()
    {
        if(!$this->checkAccess("load"))
            return;
        $this->load->model('role_model');
        $page = "index";
        $this->data['roles'] = $this->role_model->getAllRolesInclDirty();
        $this->index($page);
    }

    public function newRole()
    {
        if(!$this->checkAccess("newRole"))
            return;
        require(dirname(__FILE__) . "/../../../global_config/allPrivileges.php");
        $page = "newRole";
        $this->load->model('role_model');
        $this->load->model('privilege_model');
        $this->load->model('application_model');
        $this->load->model('information_schema_model');
        $this->data['editRole'] = false;
        $this->data['entities'] = $this->information_schema_model->getAllTableNames();
        $this->data['applications'] = $this->application_model->getAllApplications();
        $this->data['modules'] = $allPrivileges;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role_name', "Role Name", "required");
        $this->form_validation->set_rules('application', "Application", "required");

        if($this->form_validation->run())
        {
            $this->load->helper('url');
            $posts = $this->input->post();
            $pids = array();
            foreach($posts as $postName=>$post)
            {
                if($postName == 'role_name')
                {
                    $roleDetails = array(
                        'role_name' => $post,
                        'role_application_id' => $this->input->post('application')
                    );
                    $this->role_model->addRole($roleDetails);
                }
                else if($postName != "submit" && $postName != "application")
                {
                    list($moduleName, $operation) = explode(":", $postName);
                    foreach($allPrivileges[$this->input->post('application')."a"]['Page'][$moduleName][$operation] as $priv)
                    {
                        $pids[] = $priv;
                    }
                }
            }
            $this->role_model->assignPrivileges($roleDetails['role_id'], $pids);
            //$_SESSION['sudo'] = true;
            //$this->role_model->createDbUser($roleDetails['role_name'], $pids);
            //print_r($pids);
            redirect('/RoleManager/load/');
        }
        else
        {
            $this->index($page);
        }
    }

    public function viewRole($roleId)
    {
        if(!$this->checkAccess("viewRole"))
            return;
        require(dirname(__FILE__) . "/../../../global_config/allPrivileges.php");
        $page = "viewRole";
        $this->load->model('role_model');
        $this->load->model('privilege_model');
        $this->load->model('information_schema_model');
        $this->data['roleInfo'] = $this->role_model->getRoleDetails($roleId);
        $this->data['entities'] = $this->information_schema_model->getAllTableNames();
        $this->data['modules'] = $allPrivileges;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('entity', 'Entity', 'required');
        $this->form_validation->set_rules('operation', 'Operation', 'required');

        $rolePrivs = $this->role_model->getRolePrivilegesInclDirty($roleId);
        $privStatus = array();
        $privIds = array();
        if($rolePrivs != null)
        {
            foreach($rolePrivs as $rolePriv)
            {
                $privIds[] = $rolePriv->privilege_id;
                $privStatus[$rolePriv->privilege_id] = $rolePriv->privilege_role_mapper_dirty;
            }
        }
        $this->data['privilegeDetails'] = array();
        $this->data['privilegeDirtyStatus'] = array();
        if($rolePrivs != null)
        {
            $this->data['privilegeDetails'] = $this->privilege_model->getPrivilegeDetails($privIds, "Order By privilege_entity");
            $this->data['privilegeDirtyStatus'] = $privStatus;
        }
        $this->index($page);
    }

    public function enableRolePrivilege_AJAX()
    {
        if(!$this->checkAccess("enableRolePrivilege_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        $this->form_validation->set_rules('privilegeId', 'Privilege Id', 'required');
        if($this->form_validation->run())
        {
            $this->role_model->enablePrivilege($this->input->post('roleId'), $this->input->post('privilegeId'));
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function disableRolePrivilege_AJAX()
    {
        if(!$this->checkAccess("disableRolePrivilege_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        $this->form_validation->set_rules('privilegeId', 'Privilege Id', 'required');
        if($this->form_validation->run())
        {
            $this->role_model->disablePrivilege($this->input->post('roleId'), $this->input->post('privilegeId'));
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function deleteRolePrivilege_AJAX()
    {
        if(!$this->checkAccess("deleteRolePrivilege_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        $this->form_validation->set_rules('privilegeId', 'Privilege Id', 'required');
        if($this->form_validation->run())
        {
            $this->role_model->deletePrivilege($this->input->post('roleId'), $this->input->post('privilegeId'));
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function addRolePrivilege_AJAX()
    {
        if(!$this->checkAccess("addRolePrivilege_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        $this->form_validation->set_rules('privilegeId', 'Privilege Id', 'required');
        if($this->form_validation->run())
        {
            $this->role_model->assignPrivileges($this->input->post('roleId'), array($this->input->post('privilegeId')));
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function disableRole_AJAX()
    {
        if(!$this->checkAccess("disableRole_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        if($this->form_validation->run() && $this->role_model->disableRole($this->input->post('roleId')))
        {
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function enableRole_AJAX()
    {
        if(!$this->checkAccess("enableRole_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        if($this->form_validation->run() && $this->role_model->enableRole($this->input->post('roleId')))
        {
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function deleteRole_AJAX()
    {
        if(!$this->checkAccess("deleteRole_AJAX", false))
        {
            echo false;
            return;
        }
        $this->load->library('form_validation');
        $this->load->model('role_model');
        $this->load->model('database_user_model');
        $this->load->model('user_model');
        $this->form_validation->set_rules('roleId', 'Role Id', 'required');
        if($this->form_validation->run()
            && $this->role_model->deleteAllRolePrivileges($this->input->post('roleId'))
            && $this->user_model->deleteRoleMappings($this->input->post('roleId'))
            && $this->role_model->deleteRole($this->input->post('roleId')))
        {
            echo true;
            return;
        }
        echo false;
        return;
    }

    public function refreshRoleDbUser($roleId)
    {
        /*$this->load->model('role_model');
        $this->load->helper('url');

        $roleInfo = $this->role_model->getRoleDetails($roleId);
        $_SESSION['sudo'] = true;
        $this->role_model->dropDbUser($roleInfo->role_name);

        $privs = $this->role_model->getRolePrivileges($roleId);
        $privileges = array();
        foreach($privs as $priv)
        {
            $privileges[] = $priv->privilege_id;
        }
        $_SESSION['sudo'] = true;
        $this->role_model->createDbUser($roleInfo->role_name, $privileges);
        redirect('/RoleManager/load');*/
    }
}