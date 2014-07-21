<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 7/21/14
 * Time: 8:18 PM
 */
require(dirname(__FILE__).'/../config/privileges.php');
require(dirname(__FILE__).'/../utils/ViewUtils.php');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {

    }

    public function submitPaper()
    {
        $page = 'submitpaper';
        if(isset($privileges[$page]) && !$this->AccessModel->hasPrivileges($privileges[$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }
        $data = loginModalInit();
        $data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $data);

        if($this->input->post('submit') == 'submit')
        {
            if($status = $this->uploadPaperDoc('paper_doc'))
            {
                echo "Upload done";
            }
            else
            {
                echo "<br><br><h1>Could Not Upload</h1>";
            }
        }
        else
        {
            $this->load->view('pages/'.$page, $data);
        }

        $this->load->view('templates/footer');
    }

    private function uploadPaperDoc($fileElem)
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf|doc|docx';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        return true;
    }
}