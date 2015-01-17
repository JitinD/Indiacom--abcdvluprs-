<?php

    class Transactions extends CI_Controller
    {
        private $data = array();

        public function __construct()
        {
            parent::__construct();
            $this -> load -> model('transaction_model');
            $this->load->library('form_validation');
            //$this->load->helper(array('form', 'url'));
        }

        public function index($page = "Transactions")
        {
            require(dirname(__FILE__).'/../config/privileges.php');
            require(dirname(__FILE__).'/../utils/ViewUtils.php');
            $this->load->model('access_model');
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                show_404();
            }

            if(isset($privilege['Page']['FinalPaperReviewer'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['FinalPaperReviewer'][$page]))
            {
                $this->load->view('pages/unauthorizedAccess');
                return;
            }

            $this -> data['user_id'] = $_SESSION[APPID]['user_id'];

            $this->form_validation->set_rules('remarks', 'Remarks', '');

            if($this -> form_validation -> run())
            {
                    $update_data = array(
                                            'is_verified' => $this -> input -> post('verification_category'),
                                            'transaction_remarks' => $this -> input -> post('remarks')
                                        );
                    $transaction_id = $this -> input -> post('trans_id');

                    if($this -> transaction_model -> verifyDetails($update_data, $transaction_id))
                        $this -> data['message'] = "Successful. Records have been updated";
                    else
                        $this -> data['message'] = "Sorry, there is some problem. Try again later";

            }

            $this -> data['transactions'] = $this -> transaction_model -> getTransactions();

            $this->data['navbarItem'] = pageNavbarItem($page);
            $this->load->view('templates/header', $this->data);
            $this->load->view('templates/sidebar');
            $this->load->view('pages/'.$page, $this->data);
            $this->load->view('templates/footer');
        }
    }