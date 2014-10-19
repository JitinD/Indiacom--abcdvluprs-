<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/19/14
 * Time: 10:42 AM
 */

class IndiacomNewsModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function addNews($details = array())
    {
        $this->db->insert('indiacom_news_master', $details);
        if(!$this->db->trans_status())
            throw new InsertException("Error adding indiacom news", mysql_error(), mysql_errno());
    }

    public function addAttachment($newsId, $attachmentDetails = array())
    {
        $attachmentDetails['news_id'] = $newsId;
        $this->db->insert('indiacom_news_attachments', $attachmentDetails);
        if(!$this->db->trans_status())
            throw new InsertException("Error adding attachment", mysql_error(), mysql_errno());
    }

    public function disableNews($newsId)
    {
        $details = array(
            "news_master_dirty" => 1
        );
        $this->db->update('indiacom_news_master', $details, "news_id = $newsId And news_master_dirty = 0");
        if(!$this->db->trans_status())
            throw new InsertException("Error disabling indiacom news", mysql_error(), mysql_errno());
    }

    public function enableNews($newsId)
    {
        $details = array(
            "news_master_dirty" => 0
        );
        $this->db->update('indiacom_news_master', $details, "news_id = $newsId And news_master_dirty = 1");
        if(!$this->db->trans_status())
            throw new InsertException("Error enabling indiacom news", mysql_error(), mysql_errno());
    }

    public function deleteNews($newsId)
    {
        $sql = "Delete From indiacom_news_master Where news_id = ?";
        $query = $this->db->query($sql, array($newsId));
        if(!$query)
            throw new DeleteException("Error deleting indiacom news", mysql_error(), mysql_errno());
    }

    public function getAllNews()
    {
        $sql = "Select * From indiacom_news_master Where news_master_dirty = 0";
        $query = $this->db->query($sql);
        if(!$query)
            throw new SelectException("Error fetching indiacom news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getAllNewsInclDirty()
    {
        $sql = "Select * From indiacom_news_master";
        $query = $this->db->query($sql);
        if(!$query)
            throw new SelectException("Error fetching indiacom news(incl dirty)", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getNewsDetails($newsId)
    {
        $sql = "Select * From indiacom_news_master Where news_id = ?";
        $query = $this->db->query($sql, array($newsId));
        if(!$query)
            throw new SelectException("Error fetching news detail", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getPublishedStickyNews($offset=0, $limit=10)
    {
        $sql = "SELECT news_master.*, indiacom_news_master.*
                FROM news_master
                    JOIN indiacom_news_master ON news_master.news_id = indiacom_news_master.news_id
                Where news_publish_date <= CURDATE() AND (news_sticky_date >= CURDATE())
                Order By news_publish_date DESC
                Limit $offset, $limit";
        $query = $this->db->query($sql);
        if(!$query)
            throw new SelectException("Error fetching published sticky news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getPublishedNonStickyNews($offset=0, $limit=10)
    {
        $sql = "SELECT news_master.*, indiacom_news_master.*
                FROM news_master
                    JOIN indiacom_news_master ON news_master.news_id = indiacom_news_master.news_id
                Where news_publish_date <= CURDATE() AND (news_sticky_date Is NULL OR news_sticky_date < CURDATE())
                Order By news_publish_date DESC
                Limit $offset, $limit";
        $query = $this->db->query($sql);
        if(!$query)
            throw new SelectException("Error fetching published non sticky news", mysql_error(), mysql_errno());
        return $query->result();
    }
}