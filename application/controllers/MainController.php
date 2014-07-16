<?php
/**
 * Created by PhpStorm.
 * User: Jitin
 * Date: 15/7/14
 * Time: 1:56 PM
 */

class MainController extends CI_Controller
{
    public function viewPage($page = "index")
    {
        if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['page'] = $this->getLogicalName($page); // Capitalize the first letter

        $this->load->view('templates/header');
        $this->load->view('templates/navbar', $data);
        $this->load->view('templates/banner');
        $this->load->view('templates/quickLinks');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

    private function getLogicalName($pageFileName)
    {
        switch($pageFileName)
        {
            case "index" :
                return "Home";
            case "aboutIndiacom":
                return "About INDIACom";
            default:
                return "";
        }
    }
}