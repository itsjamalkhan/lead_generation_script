<?php 

class BookingModel extends CI_Model {

	public function getProjects(){
		$this->db->select('projectID,projectName');
		$this->db->from('projects');
		$this->db->where('status','active');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function getBookingRecord($limit, $start){
		$this->db->select('bookingID,applicantName,applicantGuardian,applicantMobile,applicantCNIC,projectID,typeID,readStatus');
		$this->db->from('onlinebooking');
		if (!empty($this->session->userdata('booking_search')['booking_project'])) {
			$this->db->where('projectID',$this->session->userdata('booking_search')['booking_project']);
		}
		if (!empty($this->session->userdata('booking_search')['booking_contact'])) {
			$this->db->like('applicantMobile',$this->session->userdata('booking_search')['booking_contact'],'both');
		}
		if (!empty($this->session->userdata('booking_search')['booking_cnic'])) {
			$this->db->like('applicantCNIC',$this->session->userdata('booking_search')['booking_cnic'],'both');
		}
		$this->db->order_by('bookingID','desc');
		$this->db->limit($limit, $start);
		$rec=$this->db->get();
		return $rec->result();
	}
	public function record_count() {
		return $this->db->count_all("onlinebooking");
	}

	public function bookingInformation($bookingID){
		$this->db->select('*');
		$this->db->from('onlinebooking');
		$this->db->where('bookingID',$bookingID);
		$rec=$this->db->get();
		return $rec->row();
	}
}
?>