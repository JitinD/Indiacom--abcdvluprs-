<?php
/**
 * Created by PhpStorm.
 * User: Kisholoy
 * Date: 8/3/14
 * Time: 11:13 PM
 */

class ErrorController extends CI_Controller
{
    private $errorMsgs = array(
        1 => "Insufficient Privileges",
        2 => "Could not connect to database"
    );
    public function __construct()
    {
        parent::__construct();
    }

    public function errorPage($errorId)
    {
        if(!isset($this->errorMsgs[$errorId]))
        {
            $errorMsg = "Unknown Error";
        }
        else
        {
            $errorMsg = $this->errorMsgs[$errorId];
        }
        echo "MYSQL ERROR: ".mysql_error();
        echo "<br>" . $_SESSION[APPID]['current_role_id'];
        $this->load->view('pages/errorPage', array('page_error' => $errorMsg));
    }
}