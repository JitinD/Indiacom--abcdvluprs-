<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/11/14
 * Time: 8:31 PM
 */

class UserManager extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('AccessModel');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/UserManager/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page'][$page]) && !$this->AccessModel->hasPrivileges($privilege['Page'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/sidebar');
        $this->load->view('pages/UserManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function load()
    {
        $this->load->model('UserModel');
        $page = "index";
        $this->data['users'] = $this->UserModel->getAllUsersInclDirty();
        $this->data['registrars'] = $this->UserModel->getRegistrarUsers();
        $this->index($page);
    }

    public function newUser()
    {
        $page = "newUser";
        $this->load->model('RoleModel');
        $this->load->model('UserModel');
        $this->load->model('ApplicationModel');
        $applications = $this->ApplicationModel->getAllApplications();
        foreach($applications as $app)
        {
            $this->data['applications'][$app->application_id] = $app->application_name;
        }
        $this->data['roles'] = $this->RoleModel->getAllRoles();
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
                $this->UserModel->addUser($userDetails);
                $userInfo = $this->UserModel->getUserInfoByEmail($userDetails['user_email']);
                $reviewerRoleId = $this->RoleModel->getRoleId("Reviewer");
                $roles = $this->input->post('roles');
                if(in_array($reviewerRoleId, $roles))
                {

                }
                foreach($roles as $role)
                {
                    $this->UserModel->assignRoleToUser($userInfo->user_id, $role);
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
        $page = "viewUser";
        $this->load->model('RoleModel');
        $this->load->model('UserModel');
        $this->load->model('ApplicationModel');
        $applications = $this->ApplicationModel->getAllApplications();
        foreach($applications as $app)
        {
            $this->data['applications'][$app->application_id] = $app->application_name;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('role', "Role", 'required');

        if($this->form_validation->run())
        {
            $this->UserModel->assignRoleToUser($userId, $this->input->post('role'));
        }
        $this->data['userInfo'] = $this->UserModel->getUserInfo($userId);
        $this->data['userRoles'] = $this->UserModel->getUserRoles($userId);
        $this->data['roles'] = $this->RoleModel->getAllRoles();
        $this->index($page);
    }

    public function enableUser($userId)
    {
        $this->load->model('UserModel');
        $this->load->helper('url');
        $this->UserModel->enableUser($userId);
        redirect('UserManager/load');
    }

    public function disableUser($userId)
    {
        $this->load->model('UserModel');
        $this->load->helper('url');
        $this->UserModel->disableUser($userId);
        redirect('UserManager/load');
    }

    public function deleteUser($userId)
    {
        $this->load->model('UserModel');
        $this->load->helper('url');
        try
        {
            $this->UserModel->deleteUserMappings($userId);
            $this->UserModel->deleteUser($userId);
            redirect('UserManager/load');
        }
        catch(DeleteException $ex)
        {
            redirect('/ErrorController/index/' . $ex->getCode());
        }
    }

    public function enableUserRole($userId, $roleId)
    {
        $this->load->model('UserModel');
        $this->load->helper('url');
        $this->UserModel->enableUserRole($userId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }

    public function disableUserRole($userId, $roleId)
    {
        $this->load->model('UserModel');
        $this->load->helper('url');
        $this->UserModel->disableUserRole($userId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }

    public function deleteUserRole($userId, $roleId)
    {
        $this->load->model('UserModel');
        $this->load->helper('url');
        $this->UserModel->deleteUserRole($userId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }
}