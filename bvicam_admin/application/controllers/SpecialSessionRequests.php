<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/1/14
 * Time: 11:43 PM
 */

class SpecialSessionRequests extends CI_Controller
{
    private $data = array();
    public function __construct()
    {
        parent::__construct();
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        $sidebarData['controllerName'] = $controllerName = "PaymentsManager";
        $folder='SpecialSessions';
        if ( ! file_exists(APPPATH."views/pages/$folder/".$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page']['SpecialSessionRequests'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['SpecialSessionRequests'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $this->data['loadableComponents'] = $this->access_model->getLoadableDashboardComponents($privilege['Page']);
        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $sidebarData);
        $this->load->view("pages/$folder/".$page, $this->data);
        $this->load->view('templates/footer');
    }
	
	
	public function view_sessions()
    {
		$this->load->model('track_model');
        $page = "view_sessions";
        $this->data['titles'] = $this->track_model->getAllTracks(1);
        $this->index($page);
    }
	
	public function view_sessions_requests()
    {
		$this->load->model('ss_track_model');
        $page = "view_sessions_requests";
        $this->data['titles'] = $this->ss_track_model->getAllTracks();
        $this->index($page);
    }
	
	private function add_special_session_handle()
    {
        $this->load->library('form_validation');
        $this->load->model('track_model');
        $this->form_validation->set_rules('track_number', "Track Number", "required|numeric");
        $this->form_validation->set_rules('track_name', "Track Name", "required|alpha_dash");
		$retVal = false;
		if($this->form_validation->run()){
			$number = $this->input->post('track_number');
			$name = $this->input->post('track_name');
	
			if($this->track_model->addTrack($number, $name) > 0){
				$retVal = true;
			} else{
				$retVal = false;
			}			
		}	
		return $retVal;
    }
	
	public function add_sessions()
    {
		$this->load->helper(array('form', 'url'));
		$this->load->model('track_model');
        $page = "add_sessions";
		
		if(isset($_POST['submit'])){
			if($this->add_special_session_handle()){
				$_SESSION[APPID]['message'] = "Track Added succesfully!";
			} else{
				$_SESSION[APPID]['message'] = "Technical Error occured!";
			}
		}
        $this->index($page);
    }
	
    public function verify()
    {
		$this->load->model('ss_track_model');
        $page = "verify_sessions_tracks";
        $this->data['titles'] = $this->ss_track_model->getAllUnverifiedTracks();
        $this->index($page);
    }
	
	public function verify_submit($id)
    {
		$this->load->model('ss_track_model');
		$page = 'verify_request_fail';
        if($this->ss_track_model->verify_request($id) > 0){
			$page = "verify_request_success";
		} else{
			$page = "verify_request_fail";
		}
        $this->index($page);
    }

    public function load()
    {
        $page = "session_details";
        $this->index($page);
    }

    
}