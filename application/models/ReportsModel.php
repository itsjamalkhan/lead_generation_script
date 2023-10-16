<?php 

class ReportsModel extends CI_Model {

	public function getLeads($limit, $start){
		$currentDate=date('Y-m-d');
		$countDays='';
		$countBooking='';
		if (!empty($this->session->userdata('report_search')['reportByDay'])) {
			$countDays=$this->session->userdata('report_search')['reportByDay'];
		}

		if (!empty($this->session->userdata('report_search')['reportByBooking'])) {
			$countBooking=$this->session->userdata('report_search')['reportByBooking'];
		}

		$this->db->select('*');
		$this->db->from('leads');
		if (!empty($this->session->userdata('report_search')['reportByDay'])) {
			if ($countDays =='today') {
				$this->db->where('created_at',$currentDate);
			}else{
				$this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL '.$countDays.' DAY) AND NOW()');
			}	
		}
		if (!empty($this->session->userdata('report_search')['reportByBooking'])) {
			if ($countBooking=='total') {
				$this->db->where('purpose','Booking');
			}else if($countBooking=='today'){
				$this->db->where('created_at',$currentDate);
				$this->db->where('purpose','Booking');
			}else{
				$this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL '.$countBooking.' DAY) AND NOW()');
				$this->db->where('purpose','Booking');
			}
		}
		if (!empty($this->session->userdata('report_search')['reportByDateFrom']) && !empty($this->session->userdata('report_search')['reportByDateTo'])) {
			$from=$this->session->userdata('report_search')['reportByDateFrom'];
			$to=$this->session->userdata('report_search')['reportByDateTo'];

			$from=date("Y-m-d",strtotime($from));
			$to=date("Y-m-d",strtotime($to));
			$this->db->where('created_at >=', $from);
			$this->db->where('created_at <=', $to);
		}
		$this->db->limit($limit, $start);
		$this->db->order_by('leadID','DESC');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function count_by_search(){
		$currentDate=date('Y-m-d');
		$countDays='';
		$countBooking='';
		if (!empty($this->session->userdata('report_search')['reportByDay'])) {
			$countDays=$this->session->userdata('report_search')['reportByDay'];
		}

		if (!empty($this->session->userdata('report_search')['reportByBooking'])) {
			$countBooking=$this->session->userdata('report_search')['reportByBooking'];
		}

		$this->db->select('*');
		$this->db->from('leads');
		if (!empty($this->session->userdata('report_search')['reportByDay'])) {
			if ($countDays =='today') {
				$this->db->where('created_at',$currentDate);
			}else{
				$this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL '.$countDays.' DAY) AND NOW()');
			}	
		}
		if (!empty($this->session->userdata('report_search')['reportByBooking'])) {
			if ($countBooking=='total') {
				$this->db->where('purpose','Booking');
			}else if($countBooking=='today'){
				$this->db->where('created_at',$currentDate);
				$this->db->where('purpose','Booking');
			}else{
				$this->db->where('created_at BETWEEN DATE_SUB(NOW(), INTERVAL '.$countBooking.' DAY) AND NOW()');
				$this->db->where('purpose','Booking');
			}
		}
		if (!empty($this->session->userdata('report_search')['reportByDateFrom']) && !empty($this->session->userdata('report_search')['reportByDateTo'])) {
			$from=$this->session->userdata('report_search')['reportByDateFrom'];
			$to=$this->session->userdata('report_search')['reportByDateTo'];

			$from=date("Y-m-d",strtotime($from));
			$to=date("Y-m-d",strtotime($to));
			$this->db->where('created_at >=', $from);
			$this->db->where('created_at <=', $to);
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

	public function getLastMonthBooking(){
	    $startDate = new DateTime();
		$startDate->modify( 'first day of last month' );
		$endDate   = new DateTime();
		$endDate->modify( 'last day of last month' );

		$this->db->select('leadID');
		$this->db->from('leads');
		$this->db->where("created_at BETWEEN '" . $startDate->format( 'Y-m-d' ) . "' AND '" . $endDate->format( 'Y-m-d') . "' ");
		$this->db->where('purpose','Booking');
		$rec=$this->db->get()->result();

		return count($rec);
	}

	public function getCurrentMonthBooking(){
	    $startDate = new DateTime();
		$startDate->modify( 'first day of this month' );

		$currentDate=date( 'Y-m-d');

		$this->db->select('leadID');
		$this->db->from('leads');
		$this->db->where("created_at BETWEEN '" . $startDate->format( 'Y-m-d' ) . "' AND '" . $currentDate . "' ");
		$this->db->where('purpose','Booking');
		$rec=$this->db->get()->result();

		return count($rec);
	}

	public function getByPupose(){
		$this->db->select('COUNT(leadID) as leads,purpose');
		$this->db->from('leads');
		$this->db->group_by('purpose');
		$rec=$this->db->get()->result();
		return $rec;
	} 

	public function mostBookingsBy(){
		$this->db->select('COUNT(leadID) as leads,userID');
		$this->db->from('leads');
		$this->db->where('purpose','Booking');
		$this->db->group_by('userID');
		$rec=$this->db->get()->result_array();
		return $rec;
	} 

	
	public function highestLastMonthBooking($userID){
		$startDate = new DateTime();
		$startDate->modify( 'first day of last month' );
		$endDate   = new DateTime();
		$endDate->modify( 'last day of last month' );

		$this->db->select('leadID');
		$this->db->from('leads');
		$this->db->where('userID',$userID);
		$this->db->where("created_at BETWEEN '" . $startDate->format( 'Y-m-d' ) . "' AND '" . $endDate->format( 'Y-m-d') . "' ");
		$this->db->where('purpose','Booking');
		$rec=$this->db->get()->result();
		return count($rec);
	}

	public function getProjects(){
		$this->db->select('projectID,projectName');
		$this->db->from('projects');
		$this->db->where('status','active');
		$rec=$this->db->get();
		return $rec->result();
	}

	public function getReporting($limit, $start){
		$this->db->select('report.id, users.firstname, users.lastname,users.contact,users.username, report.created_at');
		$this->db->from('dailyreporting as report');
		$this->db->join('users','users.userID=report.userID','left');
		$this->db->limit($limit, $start);
		$this->db->order_by('id','DESC');
		$rec=$this->db->get();
		return $rec->result();

	} 

	public function insertDailyReport($data){
		if ($this->db->insert('dailyreporting',$data)) {
			return true;
		}else{
			return false;
		}
	}

	public function dailyReportRecord_count() {
		if ($this->userID =='1' || $this->userType=='HR') {
			return $this->db->count_all("dailyreporting");
		}else{
			$this->db->where('userID',$this->userID);
			$this->db->from("dailyreporting");
			return $this->db->count_all_results();
		}
	}

	public function getReportByID($id){
		$this->db->select('report.*, users.firstname, users.lastname,users.username,users.contact');
		$this->db->from('dailyreporting as report');
		$this->db->join('users','users.userID=report.userID','left');
		$this->db->where('id',$id);
		$rec=$this->db->get();
		return $rec->row();
		
	}

	public function getLeadsByID($userID,$dated){
		$this->db->select('COUNT(leadID) as leads,COUNT(case purpose when "Booking" then 1 else null end) as booking');
		$this->db->from('leads');
		$this->db->where('userID',$userID);
		$this->db->where('created_at',date('Y-m-d',strtotime($dated)));
		$result=$this->db->get()->result();
		return $result;
	}

	public function getTodaysReport($userID){
		$today=date('Y-m-d');
		$this->db->select('id,visits,deals,inbound,total_inbound,outbound,total_outbound');
		$this->db->where('userID',$userID);
		$this->db->where('created_at',$today);
		return $this->db->get('dailyreporting')->row();
	}
}

?>