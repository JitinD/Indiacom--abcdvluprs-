<?php 


class SS_track_model extends CI_Model{

	private $table = 'special_session_request';

	public function __construct()
    {
        $this->load->database();
    }
	
	public function getAllTracks(){
		$this->db->select('special_session_request.*, member_master.member_name as name, member_master.member_mobile as phone, member_master.member_email as email, organization_master.organization_name');
		$this->db->from($this->table);
		$this->db->join('member_master', 'member_master.member_id = special_session_request.member_id');
		$this->db->join('organization_master', 'organization_master.organization_id = member_master.member_organization_id');

		$query = $this->db->get();
		return $query->result();
	}
	
	public function getTracks($id){
		$this->db->select('special_session_request.*, member_master.member_name as name, member_master.member_salutation as sal');
		$this->db->from($this->table);
		$this->db->join('member_master', 'member_master.member_id = special_session_request.member_id');
		$this->db->where('sid',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getAllUnverifiedTracks(){
		$this->db->select('special_session_request.*, member_master.member_name as name, member_master.member_mobile as phone');
		$this->db->from($this->table);
		$this->db->join('member_master', 'member_master.member_id = special_session_request.member_id');
		$this->db->where('verified', 0);
		$query = $this->db->get();
		return $query->result();
	}

	public function verify_request($id){
		$data = array(
					'verified' => 1
				);

		$this->db->where('sid', $id);
		$this->db->update($this->table, $data); 
		if($this->db->affected_rows()){
			
			$track = $this->getTracks($id);			
			$name = "";
			$name.= $track->sal;
			$name.= " ";
			$name.= $track->name;
			$name.="-";
			$name.=$track->title;
			
			$d = array(
				'subject_name' => $name,
				'subject_track_id' => 5
			);
			$this->db->insert('subject_master', $d);
			return true;
		} else{
			return false;
		}
	}
	
}


?>