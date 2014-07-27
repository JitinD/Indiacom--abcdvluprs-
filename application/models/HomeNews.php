<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/26/14
 * Time: 2:23 PM
 */
class HomeNews extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getStickyNews()
    {
        date_default_timezone_set('Asia/Calcutta');
        $date = date('Y/m/d h:i:s a', time());
        $this -> db -> select('news_title,news_description_url,news_publish_date');
        $this-> db ->where('news_sticky_date IS NOT NULL');
        $this ->db->where('news_event_id',1);
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
        $this -> db -> select('news_title,news_description_url,news_publish_date');
        $this-> db ->where('news_sticky_date IS NULL');
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