<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProjectController extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('projectModel');
		$this->userID=$this->session->userdata('userID');
	}

	public function showProjects(){
		$records=$this->projectModel->getProjects();
		$data['projects']=$records;
		$data['view_page'] = 'projects';
		$this->load->view('partials/template',$data);
	}

	public function addProject(){
		if($_POST){

			foreach ($_POST as $key => $value) {
				$$key=$value;
			}
			
			$proSizes=implode(',',$size);

			$dataArray= array(
				'projectName' 		=>$projectName, 
				'projectLocation' 	=>$projectLocation, 
				'description' 		=>$description, 
				'size' 				=>$proSizes, 
			);

			$response=$this->projectModel->insertProject($dataArray);
			if($response){
				$this->session->set_flashdata('project_success', 'Account Create Successfully');
				redirect(base_url().'add-project');
			}
			else{
				$this->session->set_flashdata('project_error', 'Somthing wrong. Error!!');
				redirect(base_url().'add-project');
			}
		}
		$data['view_page'] = 'addProject';
		$this->load->view('partials/template',$data);
	}

	public function editProject(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$proID=$this->input->post('proID');
		$record=$this->projectModel->getProjectMeta($proID);
		$html='<form class="form-horizontal" action="'.base_url().'update-project" method="post" enctype="multipart/form-data">
			    <input type="hidden" name="proID" value="'.base64_encode($proID).'">
               	<div class="form-group">
	             	<label class="col-sm-2 control-label">Project Name <span class="text-danger">*</span></label>
		            <div class="col-sm-8">
		               <input type="text" class="form-control" name="projectName" value="'.$record->projectName.'" autofocus required>
		            </div>
	           	</div>
	           	<div class="form-group">
	             	<label class="col-sm-2 control-label">Location <span class="text-danger">*</span></label>
	             	<div class="col-sm-8">
	               		<input type="text" class="form-control" name="projectLocation" value="'.$record->projectLocation.'" required>
	             	</div>
	           	</div>
	           	<div class="form-group">
	             	<label class="col-sm-2 control-label">Description</label>
	             	<div class="col-sm-8">
	               		<textarea class="form-control" name="description" rows="8" max-rows="20">'.$record->description.'</textarea>
	             	</div>
	           	</div>
	           	
	           	<span id="size-section"></span>
               	<div class="form-group">
                 	<div class="col-sm-offset-2 col-sm-8">
                   		<button type="submit" class="btn btn-theme pull-right">Submit</button>
                 	</div>
               	</div>
            </form>';

            echo $html;
            exit();
	}

	public function updateProject(){
		foreach ($_POST as $key => $value) {
			$$key=$value;
		}

		$proID=base64_decode($_POST['proID']);
		$dataArray= array(
				'projectName' 		=>$projectName, 
				'projectLocation' 	=>$projectLocation, 
				'description' 		=>$description,  
			);
		$this->db->set($dataArray);
		$this->db->where('projectID',$proID);
		$this->db->update('projects');

		if($this->db->affected_rows()== '1'){
			$this->session->set_flashdata('project_update_success', 'Lead Add Successfully');
			redirect(base_url().'projects');
		}else{
			$this->session->set_flashdata('project_update_error', 'Something wrong. Error!!');
			redirect(base_url().'projects');
		}
	}

	public function deleteProject(){
		$projectID=base64_decode($this->uri->segment(2));
		$this->db->where('projectID',$projectID);
		$respons=$this->db->delete('projects');
		if ($respons=='1'){
			$this->session->set_flashdata('pro_delete_success', 'Lead has been delete');
			redirect(base_url().'projects');
		}
		else{
			$this->session->set_flashdata('pro_delete_error', 'Somthing wrong. Error!!');
			redirect(base_url().'projects');
		}
	}

	function removeSize(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$sizeStr=$this->db->select('size')->from('projects')->where('projectID',$_POST['proID'])->get()->row();
		$sizeArray=explode(',', $sizeStr->size);

		while (($i = array_search(($_POST['size']), $sizeArray)) !== false) {
			unset($sizeArray[$i]);
		}
		
		$sizes=implode(',', $sizeArray);
		$data=array(
			'size' => $sizes
		);

		$this->db->set($data);
		$this->db->where('projectID',$_POST['proID']);
		$this->db->update('projects');

		if($this->db->affected_rows()== '1'){
			echo '1';
		}else{
			echo '2';
		}
	}

	

	function propertyType(){
		if (isset($_POST['type_submit'])) {
			foreach ($_POST as $key => $value) {
				$$key=$value;
			}

			$dataArray = array(
				'projectID' => $projectID, 
				'typeName' => $typeName, 
				'typeSize' => $typeSize, 
				'dimensionWidth' => $dimensionWidth,
				'dimensionHeight' => $dimensionHeight,
			);

			if ($this->db->insert('propertytype',$dataArray)) {
				$this->session->set_flashdata('type_add_success', 'Add Successfully');
				redirect(base_url().'property-sizes');
			}else{
				$this->session->set_flashdata('type_add_error', 'Add Error');
				redirect(base_url().'property-sizes');
			}
		}
		$projects=$this->projectModel->getProjects();
		$data['projects'] = $projects;

		$propertytype=$this->projectModel->getProType();
		$data['propertytype'] = $propertytype;
		$data['view_page'] = 'propertyType';
		$this->load->view('partials/template',$data);

	}

	public function deleteType(){
		$typeID=base64_decode($this->uri->segment(2));
		$this->db->where('typeID',$typeID);
		$respons=$this->db->delete('propertytype');
		if ($respons=='1'){
			$this->session->set_flashdata('type_delete_success', 'Lead has been delete');
			redirect(base_url().'property-sizes');
		}
		else{
			$this->session->set_flashdata('type_delete_error', 'Somthing wrong. Error!!');
			redirect(base_url().'property-sizes');
		}
	}

	// PAYMENT PLAN METHOD

	function paymentPlan(){

		$planRecord=$this->projectModel->getPlanRecord();
		$projects=$this->projectModel->getProjects();
		$propertytype=$this->projectModel->getProType();

		$data['planRecord'] = $planRecord;
		$data['propertytype'] = $propertytype;
		$data['projects'] = $projects;
		$data['view_page'] = 'paymentPlan';
		$this->load->view('partials/template',$data);
	}

	public function getTypeSizes(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$projectID=$_POST['projectID'];
		$typeName=$_POST['typeName'];
		$typeArray=$this->db->select('typeID,typeSize,dimensionWidth,dimensionHeight')->from('propertytype')->where('projectID',$projectID)->where('typeName',$typeName)->get()->result();

		if (!empty($typeArray)) {

			$html ='<div class="form-group">
	                   <label class="col-sm-2 control-label">Size</label>
	                   <div class="col-sm-8">
	                     <select class="form-control" name="typeID">';
	        foreach ($typeArray as $type) {
	        	$html .='<option value="'.$type->typeID.'">'.$type->typeSize.' ('.$type->dimensionWidth.'" x '.$type->dimensionHeight.'")</option>';
	        	
	        }

	        $html .='	</select>
	                  </div>
	                </div>';
	        echo $html;
	        exit();
    	}
    	else{
    		$emtyRecord='<div class="form-group">
	                   		<label class="col-sm-2 control-label">Size</label>
			                <div class="col-sm-8">
		    					<p style="padding:8px 5px 8px 15px;color:red;border:1px solid #ccc;border-radius:4px;box-shadow:inset 0 1px 1px rgba(0,0,0,.075)">Record Not Found.</p>
		    				</div>
	                	</div>';
	        echo $emtyRecord;
	        exit();
    	}
	}

	public function addPaymentPlan(){
		
		foreach ($_POST as $key => $value) {
			$$key=$value;
		}

		$checkingStatus=$this->projectModel->checkRecord($projectID,$typeID);

		if ($checkingStatus==false) {

			$salesPrice=str_replace(",", "", $salesPrice);
			$memberShipFee=str_replace(",", "", $memberShipFee);
			$installmentAmount=str_replace(",", "", $installmentAmount);

			$dataArray = array(
				'projectID' 	=>$projectID, 
				'typeID' 		=>$typeID, 
				'salesPrice' 	=>$salesPrice, 
				'memberShipFee' =>$memberShipFee, 
				'downpaymentPercent' =>$downpaymentPercent, 
				'installmentAmount' =>$installmentAmount, 
				'numberOfInstallment' =>$numberOfInstallment, 
				'primeLocBetween' =>$primeLocBetween, 
				'primeLocAbove'   =>$primeLocAbove, 
				'fullRebatePercent' =>$fullRebatePercent, 
				'halfRebatePercent' =>$halfRebatePercent,
			);


			if ($this->db->insert('paymentplan',$dataArray)) {
				$this->session->set_flashdata('payment_add_success', 'Add Successfully');
				redirect(base_url().'payment-plan');
			}else{
				$this->session->set_flashdata('payment_add_error', 'Something wrong. Error!!');
				redirect(base_url().'payment-plan');
			}
		}else{
			$this->session->set_flashdata('paymentplan_record_exist', 'Something wrong. Error!!');
			redirect(base_url().'payment-plan');
		}
	}

	function singlepplanData(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$pplanId=$this->input->post('pplanId');

		$pp_rec=$this->db->select('*')->from('paymentplan')->where('pplanId',$pplanId)->get()->row();

		$html='<form class="form-horizontal" action="'.base_url().'update-pplan" method="POST">
				<input type="hidden" name="pplanId" value="'.base64_encode($pplanId).'">
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Sales Price</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownComma" name="salesPrice" required="required" value="'.$pp_rec->salesPrice.'">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Membership Fee</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownComma" name="memberShipFee" required="required" value="'.$pp_rec->memberShipFee.'">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Downpayment %</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="downpaymentPercent" value="'.$pp_rec->downpaymentPercent.'" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Installment Amount</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownComma" name="installmentAmount" required="required" value="'.$pp_rec->installmentAmount.'">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">No. of Installment(s)</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="numberOfInstallment" required="required" value="'.$pp_rec->numberOfInstallment.'">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Prime %age (Between 41" & 99")</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="primeLocBetween" required="required" value="'.$pp_rec->primeLocBetween.'">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Prime %age (Above 100" & above)</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="primeLocAbove" value="'.$pp_rec->primeLocAbove.'" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Full Rebate %</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="fullRebatePercent" required="required" value="'.$pp_rec->fullRebatePercent.'">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-3 control-label">Half Rebate %</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="halfRebatePercent" required="required" value="'.$pp_rec->halfRebatePercent.'">
                   </div>
                 </div>
                 
                 <div class="form-group">
                   <div class="col-sm-offset-9 col-sm-3">
                     <button type="submit" class="btn btn-theme">Submit</button>
                   </div>
                 </div>
               </form>';

               $projectName=getProjectByID($pp_rec->projectID);
               $typeSize=propertyTypeSize($pp_rec->typeID);
               $htmlArray = array(
               	'form' 			=> $html, 
               	'projectName' 	=> $projectName, 
               	'typeSize' 		=> $typeSize, 
               );
               echo json_encode($htmlArray);
               exit();
	}

	function updatePaymentPlan(){
		
		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		$dataArray = array( 
			'salesPrice' 	=>$salesPrice, 
			'memberShipFee' =>$memberShipFee, 
			'downpaymentPercent' =>$downpaymentPercent, 
			'installmentAmount' =>$installmentAmount, 
			'numberOfInstallment' =>$numberOfInstallment, 
			'primeLocBetween' =>$primeLocBetween, 
			'primeLocAbove'   =>$primeLocAbove, 
			'fullRebatePercent' =>$fullRebatePercent, 
			'halfRebatePercent' =>$halfRebatePercent,
		);

		$pplanId=base64_decode($this->input->post('pplanId'));

		$this->db->set($dataArray);
		$this->db->where('pplanId',$pplanId);
		$this->db->update('paymentplan');

		if($this->db->affected_rows()== '1'){
			$this->session->set_flashdata('payment_update_success', 'Add Successfully');
			redirect(base_url().'payment-plan');
		}else{
			$this->session->set_flashdata('payment_update_error', 'Error');
			redirect(base_url().'payment-plan');
		}
	}

	function DeletePaymentPlan(){
		$pplanId=base64_decode($this->uri->segment(2));
		$this->db->where('pplanId',$pplanId);
		$respons=$this->db->delete('paymentplan');
		if ($respons=='1'){
			$this->session->set_flashdata('pplan_delete_success', 'Lead has been delete');
			redirect(base_url().'payment-plan');
		}
		else{
			$this->session->set_flashdata('pplan_delete_error', 'Somthing wrong. Error!!');
			redirect(base_url().'payment-plan');
		}
	}
}
