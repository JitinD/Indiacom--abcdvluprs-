<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 2:21 PM
 */

class DeskManager extends CI_Controller
{
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    private function index($page)
    {
        $this->load->model('access_model');
        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');

        if ( ! file_exists(APPPATH.'views/pages/DeskManager/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page']['DeskManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['DeskManager'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/DeskManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function home()
    {
        $page = "index";

        $this->load->library('form_validation');

        $this->index($page);
    }

    public function viewPaperAuthorsPayments($paper_id)
    {
        $this -> load -> model('paper_model');
        $this -> load -> model('submission_model');

        $this -> data['paperInfo'] = $this -> paper_model -> getPaperDetails($paper_id);

        $members_array = $this -> submission_model -> getAllAuthorsOfPaper($paper_id);
    }

    public function viewAuthorPapersPayments($member_id)
    {

    }
}


