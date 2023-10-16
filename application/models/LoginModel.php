<?php 

class LoginModel extends CI_Model {

	public function can_login($username)
	{
		$this->db->where('username',$username);
		$this->db->from('users');
		$query= $this->db->get();

		$row=$query->row();
		if($query->num_rows() > 0){

			return $row;

		}else{
			return '0';
		}	
	}

	public function checkStatus($username){
		$this->db->select('status');
		$this->db->from('users');
		$this->db->where('username',$username);
		$query= $this->db->get();
		$row=$query->row();
		return $row;
	}

	public function getLeadStatistics(){
		$this->db->select('COUNT(leadID) as leads,created_at,COUNT(case purpose when "Booking" then 1 else null end) as booking');
		$this->db->from('leads');
		if($this->userID !='1' && $this->session->userdata('userType') !='HR'){
			$this->db->where('userID',$this->userID);
		}
		//$this->db->where('YEAR(dated)','2019');
		$this->db->group_by('MONTH(created_at)');
		$result=$this->db->get()->result();
		return $result;
	}

	public function getPurposeStatistics(){
		$this->db->select('COUNT(purpose) as cat, purpose');
		$this->db->from('leads');
		if($this->userID !='1' && $this->session->userdata('userType') !='HR'){
			$this->db->where('userID',$this->userID);
		}
		$this->db->group_by('purpose');
		$result=$this->db->get()->result();
		return $result;
	}
}
?>