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

        $this -> load -> model('paper_model');//paper
        $this -> load -> model('subject_model');//subject
        $this -> load -> model('track_model');//track
        $this -> load -> model('event_model');//event
        $this -> load -> model('submission_model');
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

        $this->form_validation->set_rules('searchvalue', 'Search value', 'required');


        if($this->form_validation->run())
        {
            $this -> load -> helper('url');

            $search_by = $this -> input -> post('searchby');
            $search_value = $this -> input -> post('searchvalue');

            //redirect('/DeskManager/viewPaperAuthorsPayments/'.$search_value);

            switch($search_by)
            {
                case 'MemberID':    redirect('/DeskManager/viewAuthorPapersPayments/'.$search_value);
                                    break;

                case 'PaperID':     redirect('/DeskManager/viewPaperAuthorsPayments/'.$search_value);
                                    break;
            }

        }


        $this->index($page);
    }

    private function getPaperInfo($paper_id)
    {
        $this->data['paperDetails'] = $this->paper_model->getPaperDetails($paper_id);
        $this->data['subjectDetails'] = $this->subject_model->getSubjectDetails($this->data['paperDetails']->paper_subject_id);
        $this->data['trackDetails'] = $this->track_model->getTrackDetails($this->data['subjectDetails']->subject_track_id);
        $this->data['eventDetails'] = $this->event_model->getEventDetails($this->data['trackDetails']->track_event_id);
        $this->data['submissions'] = $this->submission_model->getSubmissionsByAttribute('submission_paper_id', $paper_id);

    }

   /* private function getMemberPaymentsRecord($member_id, $paper_id = null)
    {
        $this->load->model('payment_model');
        $is_paper_id_given = false;

        $member_payments_array = $this -> payment_model -> getPayments($member_id, $paper_id);

        if($paper_id)
            $is_paper_id_given = true;

        foreach($member_payments_array as $member_payments)
        {
            $payable_class = $member_payments -> payment_payable_class;
            $waiveoff_amount = $member_payments -> waiveoff_amount;
            $discount_type = $member_payments -> payment_discount_type;
            $paid_amount = $member_payments -> paid_amount;

            if(!$paper_id)
                $paper_id = $member_payments -> submission_paper_id;

            $paper_details = $this->paper_model->getPaperDetails($paper_id);
            $paper_title = $paper_details -> paper_title;

            $this -> load -> model('payable_class_model');
            $this -> load -> model('discount_model');

            $payable_class_details = $this -> payable_class_model -> getPayableClassDetails($payable_class);

            $payable_amount = $payable_class_details -> payable_class_amount;
            $discount_amount = 0;

            if($discount_type)
            {
                $discount_details = $this -> discount_model -> getDiscountDetails($discount_type);
                $discount_amount = $payable_amount * ($discount_details -> discount_type_amount);
            }

            $pay_amount = $payable_amount - ($waiveoff_amount + $discount_amount);
            $due_amount = $pay_amount - $paid_amount;

            if($is_paper_id_given)
                $member_payments_record[$member_id] =  array('PaperID' => $paper_id, 'Title' => $paper_title, 'MemberID' => $member_id, 'Payable' => $payable_amount, 'Waive' => $waiveoff_amount, 'Discount' => $discount_amount, 'Pay' => $pay_amount, 'Paid' => $paid_amount, 'Due' => $due_amount);
            else
                $member_payments_record[$paper_id] =  array('PaperID' => $paper_id, 'Title' => $paper_title, 'MemberID' => $member_id, 'Payable' => $payable_amount, 'Waive' => $waiveoff_amount, 'Discount' => $discount_amount, 'Pay' => $pay_amount, 'Paid' => $paid_amount, 'Due' => $due_amount);

        }

        return $member_payments_array;
    }*/

    public function viewPaperAuthorsPayments($paper_id)
    {
        $page = "paperAuthorsPayments";

        $this -> getPaperInfo($paper_id);

        $this -> load -> model('payment_model');
        $paper_payments_array = $this -> payment_model -> getPaperPayments($paper_id);

        if($paper_payments_array)
        {
            foreach($paper_payments_array as $index => $paper_record)
            {
                if($paper_record -> payment_payable_class)
                {
                    $payable_class = $paper_record -> payment_payable_class;
                    $waiveoff_amount = $paper_record -> waiveoff_amount;
                    $discount_type = $paper_record -> payment_discount_type;
                    $paid_amount = $paper_record -> paid_amount;

                    $this -> load -> model('payable_class_model');
                    $this -> load -> model('discount_model');

                    $payable_class_details = $this -> payable_class_model -> getPayableClassDetails($payable_class);
                    $payable_amount = $payable_class_details -> payable_class_amount;

                    $discount_amount = 0;

                    if($discount_type)
                    {
                        $discount_details = $this -> discount_model -> getDiscountDetails($discount_type);
                        $discount_amount = $payable_amount * ($discount_details -> discount_type_amount);
                    }

                    $pay_amount = $payable_amount - ($waiveoff_amount + $discount_amount);
                    $due_amount = $pay_amount - $paid_amount;

                    if($due_amount == 0)
                        $status = "Paid";
                    else
                        $status = "Incomplete Payment";

                }
                else
                {
                    $payable_amount = "-";
                    $waiveoff_amount = "-";
                    $discount_amount = "-";
                    $pay_amount = "-";
                    $paid_amount = "-";
                    $due_amount = "-";
                    $status = "Not Paid";
                }

                $member_id = $paper_record -> submission_member_id;

                $this -> load -> model('member_model');
                $member_details = $this -> member_model -> getMemberInfo($member_id);
                $member_name = $member_details['member_name'];

                $paper_payments_record[$member_id] =  array('MemberID' => $member_id, 'Name' => $member_name, 'Payable' => $payable_amount, 'Waive' => $waiveoff_amount, 'Discount' => $discount_amount, 'Pay' => $pay_amount, 'Paid' => $paid_amount, 'Due' => $due_amount, 'Status' => $status);
            }

            $this -> data['paper_payments_record'] = $paper_payments_record;
        }

        $this -> index($page);
    }

    public function viewAuthorPapersPayments($member_id)
    {

        $page = "authorPapersPayments";

        $this->load->model('payment_model');
        $member_payments_array = $this -> payment_model -> getMemberPayments($member_id);

        if($member_payments_array)
        {
            foreach($member_payments_array as $member_payments)
            {
                if($member_payments -> payment_payable_class)
                {
                    $payable_class = $member_payments -> payment_payable_class;
                    $waiveoff_amount = $member_payments -> waiveoff_amount;
                    $discount_type = $member_payments -> payment_discount_type;
                    $paid_amount = $member_payments -> paid_amount;

                    $this -> load -> model('payable_class_model');
                    $this -> load -> model('discount_model');


                    $payable_class_details = $this -> payable_class_model -> getPayableClassDetails($payable_class);
                    $payable_amount = $payable_class_details -> payable_class_amount;

                    $discount_amount = 0;

                    if($discount_type)
                    {
                        $discount_details = $this -> discount_model -> getDiscountDetails($discount_type);
                        $discount_amount = $payable_amount * ($discount_details -> discount_type_amount);
                    }

                    $pay_amount = $payable_amount - ($waiveoff_amount + $discount_amount);
                    $due_amount = $pay_amount - $paid_amount;

                    if($due_amount == 0)
                        $status = "Paid";
                    else
                        $status = "Incomplete Payment";

                }
                else
                {
                    $payable_amount = "-";
                    $waiveoff_amount = "-";
                    $discount_amount = "-";
                    $pay_amount = "-";
                    $paid_amount = "-";
                    $due_amount = "-";
                    $status = "Not Paid";
                }

                $paper_id = $member_payments -> submission_paper_id;
                $paper_details = $this->paper_model->getPaperDetails($paper_id);
                $paper_title = $paper_details -> paper_title;

                $member_payments_record[$paper_id] =  array('PaperID' => $paper_id, 'Title' => $paper_title, 'MemberID' => $member_id, 'Payable' => $payable_amount, 'Waive' => $waiveoff_amount, 'Discount' => $discount_amount, 'Pay' => $pay_amount, 'Paid' => $paid_amount, 'Due' => $due_amount, 'Status' => $status);
            }


            $this -> load -> model('member_model');
            $this -> data['member_info'] = $this -> member_model -> getMemberInfo($member_id);
            $this -> data['member_payments_record'] = $member_payments_record;
        }

        $this -> index($page);
    }
}


