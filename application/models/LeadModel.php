<?php 

class LeadModel extends CI_Model {

	public function getLeads($limit, $start){
		$this->db->select('*');
		$this->db->from('leads');
		if (!empty($this->session->userdata('lead_search')['leadSearchByName'])) {
			$this->db->like('name',$this->session->userdata('lead_search')['leadSearchByName'],'both');
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByContact'])) {
			$this->db->like('contact',$this->session->userdata('lead_search')['leadSearchByContact'],'both');
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByDate'])) {
			$this->db->where('created_at',$this->session->userdata('lead_search')['leadSearchByDate']);
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByPurpose'])) {
			$this->db->where('purpose',$this->session->userdata('lead_search')['leadSearchByPurpose']);
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByCallBack'])) {
			$this->db->where('callBackDate',$this->session->userdata('lead_search')['leadSearchByCallBack']);
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByUser'])) {
			$this->db->where('userID',$this->session->userdata('lead_search')['leadSearchByUser']);
		}
		$this->db->limit($limit, $start);
		if($this->userID !='1'){
			$this->db->where('userID',$this->userID);
		}
		$this->db->where('multiBookingLead','0');
		$this->db->order_by('leadID','DESC');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function per_Leads(){
		$this->db->select('leadID');
		$this->db->from('leads');
		$this->db->where('userID',$this->userID);
		$rec=$this->db->get();
		return $rec->result();

	}

	public function getUsers()
	{
		$query=$this->db->select('userID,firstName,lastName')->from('users')->order_by("firstName", "asc")->get()->result();
		return $query;
	}


	public function getProjects(){
		$this->db->select('projectID,projectName');
		$this->db->from('projects');
		$this->db->where('status','active');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function projectSizes($id,$type){
		$this->db->select('typeID,typeSize,dimensionWidth,dimensionHeight');
		$this->db->where('projectID',$id);
		$this->db->where('typeName',$type);
		$this->db->from('propertytype');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function checkNumAvailability($contact)
	{
		$query=$this->db->query('SELECT leadID,userID FROM leads WHERE contact='.$contact);
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return '0';
		}
	}

	public function contactAddedByCurrentUser($contact)
	{
		$query=$this->db->query('SELECT leadID,userID,contact FROM leads WHERE contact='.$contact);
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return '0';
		}
	}

	public function insertLead($data){
		if($this->db->insert('leads',$data)){
			return true;
		}
	}

	public function getLeadInfo($leadId){
		$this->db->select('*');
		$this->db->where('leadID',$leadId);
		$this->db->from('leads');
		$rec=$this->db->get();
		return $rec->row();
	}

	public function getMultiBooking($leadId){
		$this->db->select('*');
		$this->db->where('multiBookingLead',$leadId);
		$this->db->from('leads');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function count_by_search(){
		$this->db->select('*');
		$this->db->from('leads');
		if (!empty($this->session->userdata('lead_search')['leadSearchByName'])) {
			$this->db->like('name',$this->session->userdata('lead_search')['leadSearchByName'],'both');
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByContact'])) {
			$this->db->like('contact',$this->session->userdata('lead_search')['leadSearchByContact'],'both');
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByDate'])) {
			$this->db->where('create_at',$this->session->userdata('lead_search')['leadSearchByDate']);
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByPurpose'])) {
			$this->db->where('purpose',$this->session->userdata('lead_search')['leadSearchByPurpose']);
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByCallBack'])) {
			$this->db->where('callBackDate',$this->session->userdata('lead_search')['leadSearchByCallBack']);
		}
		if (!empty($this->session->userdata('lead_search')['leadSearchByUser'])) {
			$this->db->where('userID',$this->session->userdata('lead_search')['leadSearchByUser']);
		}
		//$this->db->limit($limit, $start);
		if($this->userID !='1'){
			$this->db->where('userID',$this->userID);
		}
		$this->db->order_by('leadID','DESC');
		$rec=$this->db->get();
		return count($rec->result());
	}

	public function record_count() {
		if ($this->userID =='1') {
			return $this->db->count_all("leads");
		}else{
			$this->db->where('userID',$this->userID);
			$this->db->from("leads");
			return $this->db->count_all_results();
		}
		
	}

	public function exportLeads($limit, $start){

		$this->db->select('leads.name,leads.ccode,leads.contact,leads.location,projects.projectName,leads.purpose,leads.create_at');
		$this->db->from('leads');
		$this->db->join('projects', 'leads.projectID = projects.projectID','left');
		$this->db->limit($limit, $start);
		if($this->userID !='1'){
			$this->db->where('leads.userID',$this->userID);
		}
		$this->db->order_by('leadID','DESC');
		$rec=$this->db->get();
		return $rec->result_array();	
	}
}
?>