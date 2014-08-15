<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 8/10/14
 * Time: 1:59 PM
 */
class AddNewsModel extends CI_Model
{
    private $dbCon;
    public function __construct()
    {
        $this->dbCon = $this->load->database('default', TRUE);
    }

    public function insertNews($newsArray)
    {
        $this->dbCon->insert('news_master', $newsArray);
    }

    public function getEventNames()
    {
        $this -> dbCon -> select('event_id, event_name');
        $query = $this -> dbCon -> get('event_master');
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

        $query = $this -> dbCon -> query($sql);

        if($query -> num_rows() == 0)
            return 1;
        $news_id_array = $query ->  row_array();
        $news_id = $news_id_array['news_id'] + 1;
        return $news_id;
    }



}