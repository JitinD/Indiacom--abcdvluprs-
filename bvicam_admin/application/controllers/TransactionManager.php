<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 1/26/15
 * Time: 3:01 PM
 */

class TransactionManager extends CI_Controller
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
        if ( ! file_exists(APPPATH.'views/pages/TransactionManager/'.$page.'.php'))
        {
            show_404();
        }
        if(isset($privilege['Page']['TransactionManager'][$page]) && !$this->access_model->hasPrivileges($privilege['Page']['TransactionManager'][$page]))
        {
            $this->load->view('pages/unauthorizedAccess');
            return;
        }

        $this->data['navbarItem'] = pageNavbarItem($page);
        $this->load->view('templates/header', $this->data);
        //$this->load->view('templates/sidebar');
        $this->load->view('pages/TransactionManager/'.$page, $this->data);
        $this->load->view('templates/footer');
    }

    public function newTransaction()
    {
        $this->load->model('transaction_mode_model');
        $this->load->model('currency_model');
        $this->load->helper('url');
        $page = "newTransaction";
        $this->data['transaction_modes'] = $this->transaction_mode_model->getAllTransactionModes();
        $this->data['currencies'] = $this->currency_model->getAllCurrencies();
        if($this->newTransactionSubmitHandle())
            redirect('PaymentsManager/newPayment');
        $this->index($page);
    }

    private function newTransactionSubmitHandle()
    {
        $this->load->model('transaction_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('trans_mode', 'Transaction Mode', 'required');
        $this->form_validation->set_rules('trans_amount', 'Amount', 'required');
        $this->form_validation->set_rules('trans_currency', 'Currency', 'required');
        $this->form_validation->set_rules('trans_bank', 'Bank Name', 'required');
        $this->form_validation->set_rules('trans_no', 'Transaction Number', 'required');
        $this->form_validation->set_rules('trans_date', 'Transaction Date', 'required');
        $this->form_validation->set_rules('trans_memberId', 'Member ID', 'required');

        if($this->form_validation->run())
        {
            $transDetails = array(
                "transaction_member_id" => $this->input->post('trans_memberId'),
                "transaction_bank" => $this->input->post('trans_bank'),
                "transaction_number" => $this->input->post('trans_no'),
                "transaction_mode" => $this->input->post('trans_mode'),
                "transaction_amount" => $this->input->post('trans_amount'),
                "transaction_date" => $this->input->post('trans_date'),
                "transaction_currency" => $this->input->post('trans_currency'),
                "is_verified" => 1,
                "transaction_remarks" => $this->input->post('trans_remarks')
            );
            $this->transaction_model->newTransaction($transDetails);
            $_SESSION[APPID]['transId'] = $this->transaction_model->getTransactionId($transDetails);
            return true;
        }
        return false;
    }

    public function loadUnusedTransactions()
    {
        $page = "index";
        $this->load->model('transaction_model');
        $this->data['transactions'] = $this->transaction_model->getUnusedTransactions();
        $this->data['isUnusedTransactionList'] = true;
        $this->index($page);
    }

    public function load()
    {

    }

    public function viewTransaction($transId)
    {

    }
}