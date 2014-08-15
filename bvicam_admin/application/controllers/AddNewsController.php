<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 2:00 PM
 */
class AddNewsController extends CI_Controller
{
    private  $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AccessModel');
        $this->load->model('EventModel');
        $this->load->model('NewsModel');
        $this->load->helper(array('form', 'url'));
    }
    private function index($page)
    {

        require(dirname(__FILE__).'/../config/privileges.php');
        require(dirname(__FILE__).'/../utils/ViewUtils.php');
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
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
        $this->load->view('pages/'.$page, $this->data);
        $this->load->view('templates/footer');
    }


    // Upload news description
    public function uploadNewsDescription($fileElem,$eventId,$newsId)
    {
        //$config['upload_path'] = "C:/xampp/htdocs/Indiacom2015/uploads/biodata/".$eventId;
        $config['upload_path'] = dirname(__FILE__)."/../../../uploads/".$eventId;
        $config['allowed_types'] = 'html';
        $config['file_name'] = $newsId . "News";
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($fileElem))
        {
            return false;
        }
        $uploadData = $this->upload->data();

        return $config['upload_path'] . "/" . $config['file_name'] . $uploadData['file_ext'];
    }

    public function addNews()
    {
        $page="addNews";

        $this->data['events']=$this->EventModel->getAllEvents();
         $this->load->library('form_validation');
        $this->form_validation->set_rules('newsTitle', 'News Title', 'required');
       // $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('publisherID', 'Publisher ID', 'required');
        $this->form_validation->set_rules('publishDate', 'Publish Date', 'required');
        $this->form_validation->set_rules('publishTime', 'Publish Time', 'required');
        $this->form_validation->set_rules('event', 'Event', 'required');


        $news_id = $this -> NewsModel -> assignNewsId();

        if(($doc_path =$this->uploadNewsDescription('description',1,$news_id)) == false)
        {
            $this->data['uploadError'] = $this->upload->display_errors();
            $this->db->trans_rollback();
        }

        $publish_date=$this->input->post('publishDate');
        $publish_time=$this->input->post('publishTime');
        $final_pub_date=$publish_date.''.$publish_time;
        $publishing_date=date('Y-m-d H:i:s', strtotime($final_pub_date));

        $sticky_news_date='';
        $sticky_date=$this->input->post('stickyDate');
        $sticky_time=$this->input->post('stickyTime');
        $final_sticky=$sticky_date.''.$sticky_time;
        $sticky_news_date=date('Y-m-d H:i:s', strtotime($final_sticky));





        if($this->form_validation->run())
        {



            $member_record = array(
                    'news_id'               =>      $news_id,
                    'news_title'            =>      $this -> input -> post('newsTitle'),
                    'news_description_url'  =>      $doc_path,
                    'news_publisher_id'     =>      $this -> input -> post('publisherID'),
                    'news_publish_date'     =>      $publishing_date,
                    'news_sticky_date'      =>      $sticky_news_date,
                    'news_event_id'         =>      $this->input->post('event'),
                    'news_attachments_path' =>      1

                );


            $this->NewsModel->insertNews($member_record);
        }

        $this->index($page);
    }

}



