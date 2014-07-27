<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/27/14
 * Time: 9:45 AM
 */
class AllNewsModel extends CI_Model
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
}