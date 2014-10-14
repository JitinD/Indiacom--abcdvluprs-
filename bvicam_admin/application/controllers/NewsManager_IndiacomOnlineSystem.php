<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/14/14
 * Time: 9:27 PM
 */

require("NewsManager.php");

class NewsManager_IndiacomOnlineSystem extends NewsManager
{
    public function addNewsSubmitHandle()
    {
        parent::addNewsSubmitHandle();
        if(!isset($this->form_validation))
            $this->load->library('form_validation');
        $this->form_validation->set_rules('attachmentName', "Attachment Label", 'required');
        $this->form_validation->set_rules('attachmentUrl', "Attachment Label", 'required');
        $this->form_validation->set_rules('stickyDate', "Sticky Date", 'required');

        if($this->form_validation->run())
        {
            echo "Bye";
            //TODO: Insert entries into indiacom_news_master and indiacom_news_attachments
        }
        else
        {
            echo "Earth";
        }
    }
}