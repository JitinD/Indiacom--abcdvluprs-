<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/1/14
 * Time: 11:43 PM
 */

class RoleManager extends CI_Controller
{
    private $data = array();
    private $entities = array(
        "database_user",
        "event_master",
        "member_category_master",
        "member_master",
        "news_master",
        "organization_master",
        "paper_latest_version",
        "paper_master",
        "paper_version_master",
        "paper_version_review",
        "privilege_master",
        "privilege_role_mapper",
        "reviewer_master",
        "review_result_master",
        "role_master",
        "subject_master",
        "submission_master",
        "track_master",
        "user_event_role_mapper",
        "user_master"
    );
    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('AccessModel');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/RoleManager/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page']['RoleManager'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page']['RoleManager'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar');
        $this->load->view('pages/RoleManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function load()
    {
        $this->load->model('RoleModel');
        $page = "index";
        $this->data['roles'] = $this->RoleModel->getAllRolesInclDirty();
        $this->index($page);
    }

    public function newRole()
    {
        $page = "newRole";
        $this->load->model('RoleModel');
        $this->load->model('PrivilegeModel');
        $this->data['editRole'] = false;
        $this->data['entities'] = $this->entities;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role_name', "Role Name", "required");

        if($this->form_validation->run())
        {
            $this->load->helper('url');
            $posts = $this->input->post();
            $pids = array();
            foreach($posts as $postName=>$post)
            {
                if($postName == 'role_name')
                {
                    $roleDetails = array('role_name' => $post);
                    $this->RoleModel->addRole($roleDetails);
                }
                else if($postName != "submit")
                {
                    list($entityName, $operation) = explode(":", $postName);
                    $pids[] = $this->PrivilegeModel->newPrivilege(array('privilege_entity' => $entityName, 'privilege_operation' => $operation));
                }
            }
            $this->RoleModel->assignPrivileges($roleDetails['role_id'], $pids);
            $this->RoleModel->createDbUser($roleDetails['role_name'], $pids);
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
        $page = "viewRole";
        $this->load->model('RoleModel');
        $this->load->model('PrivilegeModel');
        $this->data['roleInfo'] = $this->RoleModel->getRoleDetails($roleId);
        $this->data['entities'] = $this->entities;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('entity', 'Entity', 'required');
        $this->form_validation->set_rules('operation', 'Operation', 'required');
        if($this->form_validation->run())
        {
            $privilegeId = $this->PrivilegeModel->newPrivilege(array('privilege_entity' => $this->input->post('entity'), 'privilege_operation' => $this->input->post('operation')));
            if(!$this->RoleModel->assignPrivileges($roleId, array($privilegeId)))
            {
                $this->data['pageError'] = $this->RoleModel->error;
            }
            else
            {
                $this->RoleModel->grantPrivileges($this->data['roleInfo']->role_name, array($privilegeId));
            }
        }

        $rolePrivs = $this->RoleModel->getRolePrivilegesInclDirty($roleId);
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
            $this->data['privilegeDetails'] = $this->PrivilegeModel->getPrivilegeDetails($privIds, "Order By privilege_entity");
            $this->data['privilegeDirtyStatus'] = $privStatus;
        }
        $this->index($page);
    }

    public function enableRolePrivilege($roleId, $privilegeId)
    {
        $this->load->model('RoleModel');
        $this->load->helper('url');
        $this->RoleModel->enablePrivilege($roleId, $privilegeId);
        $roleInfo = $this->RoleModel->getRoleDetails($roleId);
        $this->RoleModel->grantPrivileges($roleInfo->role_name, array($privilegeId));
        redirect('/RoleManager/ViewRole/'.$roleId);
    }

    public function disableRolePrivilege($roleId, $privilegeId)
    {
        $this->load->model('RoleModel');
        $this->load->helper('url');
        $this->RoleModel->disablePrivilege($roleId, $privilegeId);
        $roleInfo = $this->RoleModel->getRoleDetails($roleId);
        $this->RoleModel->revokePrivileges($roleInfo->role_name, array($privilegeId));
        redirect('/RoleManager/ViewRole/'.$roleId);
    }

    public function deleteRolePrivilege($roleId, $privilegeId)
    {
        $this->load->model('RoleModel');
        $this->load->helper('url');
        $this->RoleModel->deletePrivilege($roleId, $privilegeId);
        $roleInfo = $this->RoleModel->getRoleDetails($roleId);
        $this->RoleModel->revokePrivileges($roleInfo->role_name, array($privilegeId));
        redirect('/RoleManager/ViewRole/'.$roleId);
    }

    public function disableRole($roleId)
    {
        $this->load->model('RoleModel');
        $this->load->helper('url');
        $this->RoleModel->disableRole($roleId);
        redirect('/RoleManager/load');
    }

    public function enableRole($roleId)
    {
        $this->load->model('RoleModel');
        $this->load->helper('url');
        $this->RoleModel->enableRole($roleId);
        redirect('/RoleManager/load');
    }

    public function refreshRoleDbUser($roleId)
    {

    }
}