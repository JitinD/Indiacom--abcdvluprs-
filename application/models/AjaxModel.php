<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 7/21/14
 * Time: 12:57 PM
 */

class AjaxModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function fetchOrganisationNames($keyword)
    {
        $sql = "select organization_name from organization_master where organization_name like '".$keyword."%' limit 0,100";
        $query = $this->db->query($sql);
        $response = "";
        if($query->num_rows() > 0)
        {
            $response = '<ul class="listAJAX">';
            foreach($query->result() as $row)
            {
                $str = strtolower($row->organization_name);
                $start = strpos($str,$keyword);
                $end   = similar_text($str,$keyword);
                $last = substr($str,$end,strlen($str));
                $first = substr($str,$start,$end);

                $final = '<span class="boldAJAX">'.$first.'</span>'.$last;

                $response .= '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
            }
            $response .= "</ul>";
        }
        else
            $response = false;
        return $response;
    }
}