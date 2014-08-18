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
        $this->load->model('UserModel');
        $this->load->model('EventModel');
        $this->load->model('RoleModel');
    }

    private function index($page)
    {
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
        $page = "index";
        $this->data['users'] = $this->UserModel->getAllUsersInclDirty();
        $this->index($page);
    }

    public function newUser()
    {
        $page = "newUser";
        $this->data['events'] = $this->EventModel->getAllEvents();
        $this->data['roles'] = $this->RoleModel->getAllRoles();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userEmail', 'Email Id', 'required');
        $this->form_validation->set_rules('userName', 'Name', 'required');
        $this->form_validation->set_rules('userPassword', 'Password', 'required');

        if($this->form_validation->run())
        {
            $userDetails = array(
                'user_name' => $this->input->post('userName'),
                'user_email' => $this->input->post('userEmail'),
                'user_password' => $this->input->post('userPassword')
            );
            $this->UserModel->addUser($userDetails);
            $userInfo = $this->UserModel->getUserInfoByEmail($userDetails['user_email']);
            $events = $this->input->post('events');
            $roles = $this->input->post('roles');
            foreach($events as $key=>$event)
            {
                $this->UserModel->assignEventRoleToUser($userInfo->user_id, $event, $roles[$key]);
            }
        }
        else
            $this->index($page);
    }

    public function viewUser($userId)
    {
        $page = "viewUser";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('event', "Event", 'required');
        $this->form_validation->set_rules('role', "Role", 'required');

        if($this->form_validation->run())
        {
            $this->UserModel->assignEventRoleToUser($userId, $this->input->post('event'), $this->input->post('role'));
        }
        $this->data['userInfo'] = $this->UserModel->getUserInfo($userId);
        $this->data['userEventsAndRoles'] = $this->UserModel->getUserEventsAndRoles($userId);
        $this->data['events'] = $this->EventModel->getAllEvents();
        $this->data['roles'] = $this->RoleModel->getAllRoles();
        $this->index($page);
    }

    public function enableUser($userId)
    {
        $this->load->helper('url');
        $this->UserModel->enableUser($userId);
        redirect('UserManager/load');
    }

    public function disableUser($userId)
    {
        $this->load->helper('url');
        $this->UserModel->disableUser($userId);
        redirect('UserManager/load');
    }

    public function enableUserEventRole($userId, $eventId, $roleId)
    {
        $this->load->helper('url');
        $this->UserModel->enableUserEventRole($userId, $eventId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }

    public function disableUserEventRole($userId, $eventId, $roleId)
    {
        $this->load->helper('url');
        $this->UserModel->disableUserEventRole($userId, $eventId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }

    public function deleteUserEventRole($userId, $eventId, $roleId)
    {
        $this->load->helper('url');
        $this->UserModel->deleteUserEventRole($userId, $eventId, $roleId);
        redirect("UserManager/viewUser/$userId");
    }
}