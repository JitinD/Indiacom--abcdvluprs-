<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/27/14
 * Time: 9:45 AM
 */
class NewsModel extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function addNews(&$details = array())
    {
        $details['news_id'] = $this->assignNewsId();
        $details['news_publisher_id'] = $_SESSION[APPID]['user_id'];
        $this->db->insert('news_master', $details);
        if(!$this->db->trans_status())
            throw new InsertException("Error adding news", mysql_error(), mysql_errno());
        return $details;

    }

    private function assignNewsId()
    {
        $sql = "Select news_id From news_master Order By news_id Desc Limit 1";
        $query = $this->db->query($sql);
        if(!$this->db->trans_status())
            throw new SelectException("Error assigning news id", mysql_error(), mysql_errno());
        if($query->num_rows() == 0)
            return 1;
        $row = $query->row();
        return $row->news_id + 1;
    }

    public function disableNews($newsId)
    {
        $details = array(
            "news_dirty" => 1
        );
        $this->db->update('news_master', $details, "news_id = $newsId And news_dirty = 0");
        if(!$this->db->trans_status())
            throw new InsertException("Error disabling news", mysql_error(), mysql_errno());
    }

    public function enableNews($newsId)
    {
        $details = array(
            "news_dirty" => 0
        );
        $this->db->update('news_master', $details, "news_id = $newsId And news_dirty = 1");
        if(!$this->db->trans_status())
            throw new InsertException("Error enabling news", mysql_error(), mysql_errno());
    }

    public function deleteNews($newsId)
    {
        $sql = "Delete From news_master Where news_id = ?";
        $query = $this->db->query($sql, array($newsId));
        if(!$this->db->trans_status())
            throw new DeleteException("Error deleting news", mysql_error(), mysql_errno());
    }

    public function getAllNews()
    {
        $sql = "Select * From news_master Where news_dirty=0 Order By news_dor DESC";
        $query = $this->db->query($sql);
        if(!$this->db->trans_status())
            throw new SelectException("Error retrieving news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getAllNewsInclDirty()
    {
        $sql = "Select * From news_master  Order By news_dor DESC";
        $query = $this->db->query($sql);
        if(!$this->db->trans_status())
            throw new SelectException("Error retrieving news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getAllNewsByAppId($appId)
    {
        $sql = "Select * From news_master Where news_application_id=? And news_dirty=0  Order By news_dor DESC";
        $query = $this->db->query($sql, array($appId));
        if(!$this->db->trans_status())
            throw new SelectException("Error retrieving news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getAllNewsInclDirtyByAppId($appId)
    {
        $sql = "Select * From news_master Where news_application_id=?  Order By news_dor DESC";
        $query = $this->db->query($sql, array($appId));
        if(!$this->db->trans_status())
            throw new SelectException("Error retrieving news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getPublishedNewsByAppId($appId, $startNewsDate=null, $limit=null)
    {
        $sql = "SELECT * FROM news_master
                Where news_publish_date < NOW() And news_application_id = ?
                Order By news_publish_date, news_dor DESC";
        $query = $this->db->query($sql, array($appId));
        if(!$this->db->trans_status())
            throw new SelectException("Error fetching published news", mysql_error(), mysql_errno());
        return $query->result();
    }

    public function getNewsDetails($newsId)
    {
        $sql = "Select * From news_master Where news_id=?";
        $query = $this->db->query($sql, array($newsId));
        if(!$this->db->trans_status())
            throw new SelectException("Error fetching news details", mysql_error(), mysql_errno());
        return $query->row();
    }
}