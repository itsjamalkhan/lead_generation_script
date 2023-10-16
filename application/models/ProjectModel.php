<?php 

class ProjectModel extends CI_Model {

	public function insertProject($data){
		if($this->db->insert('projects',$data)){
			return true;
		}
	}

	public function getProjects(){
		$this->db->select('projectID,projectName,projectLocation,description,size');
		$this->db->from('projects');
		$rec=$this->db->get()->result();
		return $rec;
	}

	public function getProjectMeta($proID){
		$this->db->select('*');
		$this->db->where('projectID',$proID);
		$this->db->from('projects');
		$rec=$this->db->get()->row();
		return $rec;
	}

	public function getProType(){
		$this->db->select('typeID,projectID');
		$this->db->from('propertytype');
		$this->db->group_by('projectID');
		$rec=$this->db->get()->result();
		
		if(count($rec) > 0){

			$typeArray = array();
			foreach ($rec as $record) {
				$proname=getProjectByID($record->projectID);
				$this->db->select('typeID,projectID,typeName,typeSize,dimensionWidth,dimensionHeight');
				$this->db->from('propertytype');
				$this->db->where('projectID',$record->projectID);
				$typeArray[$proname]=$this->db->get()->result();
			}

			return $typeArray;
		}
		else{
			return '0';
		}
	}

	public function getPlanRecord(){
		$this->db->select("projectID,typeID");
		$this->db->from("paymentplan");
		$this->db->group_by('projectID');
		$record=$this->db->get()->result();

		if(count($record) > 0){
			$planArray=array();
			foreach ($record as $rec) {
				$proname=getProjectByID($rec->projectID);
				$this->db->select('type.typeName, type.typeSize, type.dimensionWidth, type.dimensionHeight, plan.pplanId, plan.projectID,plan.typeID, plan.salesPrice, plan.memberShipFee, plan.downpaymentPercent, plan.installmentAmount, plan.numberOfInstallment, plan.primeLocBetween, plan.primeLocAbove, plan.fullRebatePercent, halfRebatePercent');
				$this->db->from('propertytype as type');
				$this->db->join('paymentplan as plan', 'type.typeID = plan.typeID');
				$this->db->where('plan.projectID',$rec->projectID);
				$planArray[$proname]=$this->db->get()->result();
			}
			return $planArray;
		}else{
			return '0';
		}
	}

	public function checkRecord($projectID,$typeID){
		$this->db->select('projectID,typeID');
		$this->db->from('paymentplan');
		$record=$this->db->get()->result();

		$status=false;

		foreach ($record as $rec) {
			if ($rec->projectID == $projectID && $rec->typeID == $typeID) {
				$status=true;
			}
		}
		return $status;
	}
}
?>