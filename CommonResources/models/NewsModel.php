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

    public function record_count() {
        return $this->db->count_all("news_master");
    }

    public function fetch_news($limit, $start) {
        date_default_timezone_set('Asia/Calcutta');
        $date = date('Y/m/d h:i:s a', time());
        $this->db->limit($limit, $start);
        $this ->db->where('news_event_id',1);
        $this -> db-> where('news_publish_date <=',$date);
        $this->db->order_by('news_publish_date', "desc");
        $query = $this->db->get("news_master");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getStickyNews()
    {
        date_default_timezone_set('Asia/Calcutta');
        $date = date('Y/m/d h:i:s a', time());
        $default_sticky_date='1970-01-01 00:00:00.000000';
        $this -> db -> select('news_title,news_description_url,news_publish_date');
        $this ->db->where('news_event_id',1);
        $this-> db ->where('news_sticky_date !=',$default_sticky_date);
        $this -> db-> where('news_publish_date <=',$date);
        $this->db->where('news_sticky_date >=',$date);
        $this->db->order_by('news_publish_date', "desc");
        $query = $this -> db -> get('news_master');
        $stickyNews= $query -> result();
        return $stickyNews;
    }

    public function  getOtherNews()
    {
        date_default_timezone_set('Asia/Calcutta');
        $date = date('Y/m/d h:i:s a', time());
        $default_sticky_date='1970-01-01 00:00:00.000000';
        $this -> db -> select('news_title,news_description_url,news_publish_date');
        $this-> db ->where('news_sticky_date',$default_sticky_date);
        $this ->db->where('news_event_id',1);
        $this -> db-> where('news_publish_date <=',$date);
        $this->db->order_by('news_publish_date', "desc");
        $query = $this -> db -> get('news_master');
        $otherNews= $query -> result();
        return $otherNews;
    }

    public function getNewsForHome()
    {
        $count=5;
        $stickyNews=$this->getStickyNews();
        $otherNews=$this->getOtherNews();
        $newsMerged=array_merge($stickyNews,$otherNews);
        $news=array_slice($newsMerged,0,$count);
        return $news;

    }

}