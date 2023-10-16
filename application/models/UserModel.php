<?php 

class UserModel extends CI_Model {

	public function username_availability($username){
		$this->db->where('username',$username);
		$query=$this->db->get('users');
		if($query->num_rows() > 0){
			return 'true';
		}else{
			return 'false';
		}
	}

	public function insertRegistartion($data){
		if ($this->db->insert('users',$data)) {
			return true;
		}
	}

	public function allUsers($limit,$start){
		$this->db->select('*');
		$this->db->from('users');

		if (!empty($this->session->userdata('user_search')['name'])) {
			$this->db->like('firstName',$this->session->userdata('user_search')['name'],'both');
			$this->db->or_like('lastName',$this->session->userdata('user_search')['name'],'both');
		}
		if (!empty($this->session->userdata('user_search')['contact'])) {
			$this->db->like('contact',$this->session->userdata('user_search')['contact'],'both');
		}
		$this->db->limit($limit,$start);
		$this->db->order_by('userID','DESC');
		$records=$this->db->get()->result();
		return $records;
	}

	public function getUserMeta($userID){
		$this->db->select('*');
		$this->db->where('userID',$userID);
		$this->db->from('users');
		$rec=$this->db->get()->row();
		return $rec;
	}

	public function updateUser($userID,$data){
		$this->db->set($data);
		$this->db->where('userID',$userID);
		$this->db->update('users');

		if ($this->db->affected_rows() == '1') {
    		return true;
		} else {
    		return false;
		}

	}

	public function resetPassword($userID,$data){
		$this->db->set($data);
		$this->db->where('userID',$userID);
		$this->db->update('users');

		if ($this->db->affected_rows() == '1') {
    		return true;
		} else {
    		return false;
		}
	}

	public function record_count() {
		return $this->db->count_all("users");
	}

	public function getSingleUserData($userID,$limit, $start){
		$this->db->select('*');
		$this->db->from('leads');
		if (!empty($this->session->userdata('single_user_search')['searchByPurpose'])) {
			$this->db->where('purpose', $this->session->userdata('single_user_search')['searchByPurpose']);
		}
		if (!empty($this->session->userdata('single_user_search')['searchByDateFrom']) && !empty($this->session->userdata('single_user_search')['searchByDateTo'])) {
			$from=$this->session->userdata('single_user_search')['searchByDateFrom'];
			$to=$this->session->userdata('single_user_search')['searchByDateTo'];

			$from=date("Y-m-d",strtotime($from));
			$to=date("Y-m-d",strtotime($to));
			$this->db->where('created_at >=', $from);
			$this->db->where('created_at <=', $to);
		}
		$this->db->where('userID',$userID);
		$this->db->limit($limit, $start);
		$this->db->order_by('leadID','DESC');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function user_info($userID){
		$this->db->select('firstName,lastName,contact,image,userType,gender');
		$this->db->where('userID',$userID);
		$this->db->from("users");
		return $this->db->get()->row();
	}

	public function count_leads($userID){
		$this->db->where('userID',$userID);
		$this->db->from("leads");
		return $this->db->count_all_results();
	}

	public function count_bookings($userID){
		$this->db->where('userID',$userID);
		$this->db->where('purpose','Booking');
		$this->db->from("leads");
		return $this->db->count_all_results();
	}

	public function bookingCurrentMonth($userID){
		$startDate = new DateTime();
		$startDate->modify( 'first day of this month' );

		$currentDate=date( 'Y-m-d');

		$this->db->select('leadID');
		$this->db->from('leads');
		$this->db->where("created_at BETWEEN '" . $startDate->format( 'Y-m-d' ) . "' AND '" . $currentDate . "' ");
		$this->db->where('userID',$userID);
		$this->db->where('purpose','Booking');
		$rec=$this->db->get()->result();

		return count($rec);
	}
}
?>