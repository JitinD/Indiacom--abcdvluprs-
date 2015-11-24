<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/11/14
 * Time: 8:31 PM
 */

require_once(dirname(__FILE__) . "/../../../CommonResources/Base/BaseController.php");

class UserManager extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->controllerName = "UserManager";
        require(dirname(__FILE__).'/../config/privileges.php');
        $this->privileges = $privilege;
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $this->controllerName;
        $sidebarData['links'] = $this->setSidebarLinks();
        if ( ! file_exists(APPPATH.'views/pages/UserManager/'.$page.'.php'))
        {
            show_404();
        }
        $this->data['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($this->privileges['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view('pages/UserManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    private function setSidebarLinks()
    {
        $links['newUser'] = "Create New User";
        $links['load'] = "View All Users";
        return $links;
    }

    public function load()
    {
        if(!$this->checkAccess("load"))
            return;
        $this->load->model('user_model');
        $page = "index";
        $this->data['users'] = $this->user_model->getAllUsersInclDirty();
        $this->data['registrars'] = $this->user_model->getRegistrarUsers();
        $this->index($page);
    }

    public function newUser()
    {
        if(!$this->checkAccess("newUser"))
            return;
        $page = "newUser";
        $this->load->model('role_model');
        $this->load->model('user_model');
        $this->load->model('application_model');
        $applications = $this->application_model->getAllApplications();
        foreach($applications as $app)
        {
            $this->data['applications'][$app->application_id] = $app->application_name;
        }
        $this->data['roles'] = $this->role_model->getAllRoles();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userEmail', 'Email Id', 'required');
        $this->form_validation->set_rules('userName', 'Name', 'required');
        $this->form_validation->set_rules('userPassword', 'Password', 'required');

        if($this->form_validation->run())
        {
            $this->load->helper('url');
            $userDetails = array(
                'user_name' => $this->input->post('userName'),
                'user_email' => $this->input->post('userEmail'),
                'user_password' => $this->input->post('userPassword'),
                'user_registrar' => $_SESSION[APPID]['user_id']
            );
            try
            {
                $this->user_model->addUser($userDetails);
                $userInfo = $this->user_model->getUserInfoByEmail($userDetails['user_email']);
                $reviewerRoleId = $this->role_model->getRoleId("Reviewer");
                $roles = $this->input->post('roles');
                if(in_array($reviewerRoleId, $roles))
                {

                }
                foreach($roles as $role)
                {
                    $this->user_model->assignRoleToUser($userInfo->user_id, $role);
                }
                redirect('/UserManager/load/');
            }
            catch (InsertException $ex)
            {
                redirect('/ErrorController/index/' . $ex->getCode());
            }
        }
        else
        {
            $this->index($page);
        }
    }

    public function viewUser($userId)
    {
        if(!$this->checkAccess("viewUser"))
            return;
        $page = "viewUser";
        $this->load->model('role_model');
        $this->load->model('user_model');
        $this->load->model('application_model');
        $applications = $this->application_model->getAllApplications();
        foreach($applications as $app)
        {
            $this->data['applications'][$app->application_id] = $app->application_name;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role', "Role", 'required');

        if($this->form_validation->run())
        {
            $this->user_model->assignRoleToUser($userId, $this->input->post('role'));
        }
        $this->data['userInfo'] = $this->user_model->getUserInfo($userId);
        $this->data['userRoles'] = $this->user_model->getUserRoles($userId);
        $this->data['roles'] = $this->role_model->getAllRoles();
        $this->index($page);
    }

    public function enableUser($userId)
    {
        if(!$this->checkAccess("enableUser"))
            return;
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->user_model->enableUser($userId);
        redirect('UserManager/load');
    }

    public function disableUser($userId)
    {
        if(!$this->checkAccess("disableUser"))
            return;
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->user_model->disableUser($userId);
        redirect('UserManager/load');
    }

    public function deleteUser($userId)
    {
        if(!$this->checkAccess("deleteUser"))
            return;
        $this->load->model('user_model');
        $this->load->helper('url');
        try
        {
            $this->user_model->deleteUserMappings($userId);
            $this->user_model->deleteUser($userId);
            redirect('UserManager/load');
        }
        catch(DeleteException $ex)
        {
            redirect('/ErrorController/index/' . $ex->getCode());
        }
    }

    public function enableUserRole($userId, $roleId)
    {
        if(!$this->checkAccess("enableUserRole"))
            return;
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->user_model->enableUserRole($userId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }

    public function disableUserRole($userId, $roleId)
    {
        if(!$this->checkAccess("disableUserRole"))
            return;
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->user_model->disableUserRole($userId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }

    public function deleteUserRole($userId, $roleId)
    {
        if(!$this->checkAccess("deleteUserRole"))
            return;
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->user_model->deleteUserRole($userId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }
}