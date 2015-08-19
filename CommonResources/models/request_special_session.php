<?php

class Request_special_session extends CI_Model{
	
	private $table = 'special_session_request';
	
	function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	public function insertSpecialSessionSubject($member_id, $track_name, $aim){
		$data = array(
		   'title' => $track_name ,
		   'aim' => $aim ,
		   'member_id' => $member_id
		);

		$this->db->insert($this->table, $data); 
		return $this->db->insert_id();
	}
	
	public function insertSpecialSessionAOC($sid, $name){
		$data = array(
		   'sid' => $sid ,
		   'name' => $name
		);
	
		$this->db->insert('area_of_coverage', $data); 
		return $this->db->affected_rows();
	}
	
	public function insertSpecialSessionTPC($sid, $name){
		$data = array(
		   'sid' => $sid ,
		   'name' => $name
		);

		$this->db->insert('technical_programme_committee', $data); 
		return $this->db->affected_rows();
	}

	public function get_special_session($member_id){
		$condition = array(
			'member_id' => $member_id
		);

		$query = $this->db->get_where($this->table, $condition);
		return $query->result();
	}

	public function get_special_session_by_sid($sid){
		$condition = array(
			'sid' => $sid
		);

		$query = $this->db->get_where($this->table, $condition);
		return $query->result();
	}

	public function get_aoc($sid){
		$condition = array(
			'sid' => $sid
		);

		$query = $this->db->get_where('area_of_coverage', $condition);
		return $query->result();
	}

	public function get_tpc($sid){
		$condition = array(
			'sid' => $sid
		);

		$query = $this->db->get_where('technical_programme_committee', $condition);
		return $query->result();
	}

	public function updateChairPersonProfile($sid, $profile){
		$data = array(
			'profile' => $profile
		);

		$this->db->where('sid', $sid);
		$query = $this->db->update($this->table, $data);
		$retVal= false;
		if($this->db->affected_rows()>0){
			$retVal = true;
		}
		return $retVal;
	}


}


?>