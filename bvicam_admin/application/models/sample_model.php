<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 9/9/15
 * Time: 7:41 PM
 */

class Sample_model extends CI_Model
{
    public function sample($privilege = array())
    {
        $this->load->database();
        $id = 0;
        foreach($privilege['Page'] as $moduleName => $privs)
        {
            foreach($privs as $operationName => $useless)
            {
                $privDetails = array(
                    "privilege_id" => $id++,
                    "privilege_entity" => $moduleName,
                    "privilege_operation" => $operationName
                );
                echo $moduleName . " - " . $operationName . "<br/>";
                $this->db->insert("privilege_master", $privDetails);
            }
        }
    }
}