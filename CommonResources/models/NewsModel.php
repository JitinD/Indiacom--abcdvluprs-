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

//    public function record_count() {
//        return $this->db->count_all("news_master");
//    }
//
//    public function fetch_news($limit, $start) {
//        date_default_timezone_set('Asia/Calcutta');
//        $date = date('Y/m/d h:i:s a', time());
//        $this->db->limit($limit, $start);
//        $this ->db->where('news_event_id',1);
//        $this -> db-> where('news_publish_date <=',$date);
//        $this->db->order_by('news_publish_date', "desc");
//        $query = $this->db->get("news_master");
//
//        if ($query->num_rows() > 0) {
//            foreach ($query->result() as $row) {
//                $data[] = $row;
//            }
//            return $data;
//        }
//        return array();
//        //return false;
//    }
//
//    public function getStickyNews()
//    {
//        date_default_timezone_set('Asia/Calcutta');
//        $date = date('Y/m/d h:i:s a', time());
//        $default_sticky_date='1970-01-01 00:00:00.000000';
//        $this -> db -> select('news_title,news_description_url,news_publish_date');
//        $this ->db->where('news_event_id',1);
//        $this-> db ->where('news_sticky_date !=',$default_sticky_date);
//        $this -> db-> where('news_publish_date <=',$date);
//        $this->db->where('news_sticky_date >=',$date);
//        $this->db->order_by('news_publish_date', "desc");
//        $query = $this -> db -> get('news_master');
//        //$stickyNews= $query -> result();
//        //return $stickyNews;
//    }
//
//    public function  getOtherNews()
//    {
//        date_default_timezone_set('Asia/Calcutta');
//        $date = date('Y/m/d h:i:s a', time());
//        $default_sticky_date='1970-01-01 00:00:00.000000';
//        $this -> db -> select('news_title,news_description_url,news_publish_date');
//        $this-> db ->where('news_sticky_date',$default_sticky_date);
//        $this ->db->where('news_event_id',1);
//        $this -> db-> where('news_publish_date <=',$date);
//        $this->db->order_by('news_publish_date', "desc");
//        $query = $this -> db -> get('news_master');
//        //$otherNews= $query -> result();
//        //return $otherNews;
//    }
//
//    public function getNewsForHome()
//    {
//        $count=5;
//        $stickyNews=$this->getStickyNews();
//        $otherNews=$this->getOtherNews();
//        $newsMerged=array_merge($stickyNews,$otherNews);
//        $news=array_slice($newsMerged,0,$count);
//        return $news;
//
//    }
//
//    /*News model for admin side*/
//    public function insertNews($newsArray)
//    {
//        $this->db->insert('news_master', $newsArray);
//    }
//
//    public function getEventNames()
//    {
//        $this -> db -> select('event_id, event_name');
//        $query = $this -> db -> get('event_master');
//        if ($query->num_rows() > 0) {
//            foreach ($query->result() as $row) {
//                $data[] = $row;
//            }
//            return $data;
//        }
//    }
//
//
//    public function assignNewsId()
//    {
//        $sql = "SELECT max(cast(`news_id` as UNSIGNED))as `news_id` from `news_master`";
//
//        //$this -> db -> select('max(cast(member_id as UNSIGNED)');
//        //$this->db->order_by("member_id", "desc");
//
//        $query = $this -> db -> query($sql);
//
//        if($query -> num_rows() == 0)
//            return 1;
//        $news_id_array = $query ->  row_array();
//        $news_id = $news_id_array['news_id'] + 1;
//        return $news_id;
//    }
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
        if(!$query)
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
        if(!$query)
            throw new SelectException("Error fetching published news", mysql_error(), mysql_errno());
        return $query->result();
    }
}