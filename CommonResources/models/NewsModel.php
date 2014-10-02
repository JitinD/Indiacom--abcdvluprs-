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
        return array();
        //return false;
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

    /*News model for admin side*/
    public function insertNews($newsArray)
    {
        $this->db->insert('news_master', $newsArray);
    }

    public function getEventNames()
    {
        $this -> db -> select('event_id, event_name');
        $query = $this -> db -> get('event_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }


    public function assignNewsId()
    {
        $sql = "SELECT max(cast(`news_id` as UNSIGNED))as `news_id` from `news_master`";

        //$this -> db -> select('max(cast(member_id as UNSIGNED)');
        //$this->db->order_by("member_id", "desc");

        $query = $this -> db -> query($sql);

        if($query -> num_rows() == 0)
            return 1;
        $news_id_array = $query ->  row_array();
        $news_id = $news_id_array['news_id'] + 1;
        return $news_id;
    }

}