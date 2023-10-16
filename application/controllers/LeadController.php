<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadController extends CI_Controller {

	
	
	public function __construct(){
		parent::__construct();

		$this->load->model('leadModel');
		$this->load->helper('global_helper');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->userID=$this->session->userdata('userID');
	}

	public function showLeads(){

		$search_data =array();
		$numPerPages='100';
		//if (isset($_POST['search'])) {
			if($this->input->post('search_by_name') !=''){
				$search_data['leadSearchByName'] =$this->input->post('search_by_name');
			}
			if($this->input->post('search_by_contact') !=''){
				$search_data['leadSearchByContact'] =str_replace(" ", "",$this->input->post('search_by_contact'));
			}
			
			if($this->input->post('search_by_date') !=''){
				$search_data['leadSearchByDate'] =$this->input->post('search_by_date');
			}
			if($this->input->post('search_by_purpose') !=''){
				$search_data['leadSearchByPurpose'] =$this->input->post('search_by_purpose');
			}
			if($this->input->post('search_by_callback') !=''){
				$search_data['leadSearchByCallBack'] =$this->input->post('search_by_callback');
			}

			if($this->input->post('search_by_user') !=''){
				$search_data['leadSearchByUser'] =base64_decode($this->input->post('search_by_user'));
			}

			if ($this->input->post('lead_numOfRecord') !='') {
				$numPerPages=$this->input->post('lead_numOfRecord');
				$search_data['numRecord'] =$this->input->post('lead_numOfRecord');
			}
			
			
			$this->session->set_userdata(array('lead_search' =>$search_data));

			if (isset($_POST['search_leads'])) {
				if($this->input->post('search_by_name') =='' && $this->input->post('search_by_contact') =='' && $this->input->post('search_by_date') =='' && $this->input->post('search_by_purpose') =='' && $this->input->post('search_by_callback') =='' && $this->input->post('search_by_user') ==''){

					$this->session->unset_userdata('lead_search');
					unset($_POST['search']);
				}
			}

			if(isset($_POST['clear_search_leads'])){
				$this->session->unset_userdata('lead_search');
				unset($_POST['search']);
			}
		//}

		$config = array();
       	$config["base_url"] = base_url()."leads";
       	if (isset($_POST['search'])) {
       		$config["total_rows"] = $this->leadModel->count_by_search();
       	}else{
       		$config["total_rows"] = $this->leadModel->record_count();
       	}
       	
		$config["per_page"] = $numPerPages;
		$config["uri_segment"] = 2;
		$config['full_tag_open'] = "<ul class='pagination'>";
	    $config['full_tag_close'] = '</ul>';
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active"><a href="#">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['prev_tag_open'] = '<li>';
	    $config['prev_tag_close'] = '</li>';
	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li>';
	    $config['last_tag_close'] = '</li>';
	    $config['prev_link'] = '<i class="fa fa-angle-double-left"></i>';
	    $config['prev_tag_open'] = '<li>';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '<i class="fa fa-angle-double-right"></i>';
	    $config['next_tag_open'] = '<li>';
	    $config['next_tag_close'] = '</li>';
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		$data["leadsRecords"] =$this->leadModel->getLeads($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		if (isset($_POST['search'])) {
			$data["total_rows"] = count($data["leadsRecords"]);
		}else{
			$data["total_rows"] =  $this->leadModel->record_count();
		}
		
		$projects=$this->leadModel->getProjects();
		$data['users']=$this->leadModel->getUsers();
		$data['projects']=$projects;
		$data['view_page'] = 'leads';
		$this->load->view('partials/template',$data);
	}

	public function addLead(){
		if(isset($_POST)){
			
			$this->form_validation->set_rules("name", "Lead Name", "required");
			$this->form_validation->set_rules("contact", "Contact Number", "required");
			/*$this->form_validation->set_rules("projectID", "Project Name", "required");
			$this->form_validation->set_rules("size", "Size", "required");
			$this->form_validation->set_rules("propertyType", "Type", "required");*/

			if ($this->form_validation->run() == FALSE){
				unset($_POST);
                $this->showLeads();
            }else{


				foreach ($_POST as $key => $value) {
					$$key = $value;
				}
				$contact=str_replace(" ", "", $contact);
				$contact = ltrim($contact, '0');
				$checkContact=$this->leadModel->checkNumAvailability($contact);

				$currentUserCheck=$this->leadModel->contactAddedByCurrentUser($contact);

				if ($currentUserCheck !='0') {
					if ($currentUserCheck->userID == $this->userID && $currentUserCheck->contact == $contact ) {
						$msg='Same number already added by you..!';
						$this->session->set_flashdata('contact_added_already_by_current', $msg);
						unset($_POST);
						redirect(base_url().'leads');
					}
				}
				
				if ($ccode=='') {
					$ccode='92';
				}

				if (!isset($purpose)) {
					$purpose='Not Interested';
				}

				$dataArray = array(
					'userID' 	=> $this->userID,
					'name' 		=> $name,
					'ccode' 	=> $ccode,
					'contact' 	=> $contact,
					'source'	=> $source,
					'purpose'	=> $purpose,
					'created_at'	=> date('Y-m-d'),
					'updated_at'=> date('Y-m-d')
				);

				if(isset($Whatsapp)){
					$dataArray['whatsapp']='yes';
				}
				if(isset($projectID)){
					$dataArray['projectID']=implode(',', $projectID);
				}
				if(isset($typeSizeID)){
					$dataArray['typeSizeID']=$typeSizeID;
				}
				if(isset($propertyType)){
					$dataArray['propertyType']=$propertyType;
				}
				if($location!=''){
					$dataArray['location']= $location;
				}
				if($remarks!=''){
					$dataArray['remarks']= $remarks;
				}
				if($callBackDate!=''){
					$dataArray['callBackDate']= $callBackDate;
				}
				if (isset($token_paid) !='') {
					$dataArray['token_paid']= $token_paid;
				}

				$response=$this->leadModel->insertLead($dataArray);
				
				if($response){
					if ($checkContact !='0') {
						$getDuplication=$this->leadModel->checkNumAvailability($contact);
						
						$usersIdArr=[];
						for($i=0; $i<count($getDuplication); $i++){
							$usersIdArr[]=$getDuplication[$i]->userID;
						}

						$unique_ids=array_unique($usersIdArr);
						
						$usersIdStr=implode(',', $unique_ids);
						$duplicate_ids = array('duplicate_ids' => $usersIdStr);
						for($i=0; $i<count($getDuplication); $i++){
							$this->db->set($duplicate_ids);
							$this->db->where('userID',$getDuplication[$i]->userID);
							$this->db->where('contact',$contact);
							$this->db->update('leads');
						}
						//$userName=strtoupper(memberName($checkContact->userID));
						$msg='Duplicate Lead has been added';
						$this->session->set_flashdata('contact_availability', $msg);
					}
					$this->session->set_flashdata('lead_success', 'Lead Add Successfully');
					redirect(base_url().'leads');

				}else{
					$this->session->set_flashdata('lead_error', 'Something wrong. Error!!');
					redirect(base_url().'leads');
				}
				
				
			}
		}
	}

	public function getLeadMeta(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
		$leadId=$this->input->post('leadId');
		$record=$this->leadModel->getLeadInfo($leadId);

		
		$newArr='';
		$sizeHtml='';
		$tokenPaid='';


		if ($record->projectID!='') {
                              
          $ProjectIDs = explode(',', $record->projectID);
          $num_of_items=count($ProjectIDs);
          $num_count=0;

          foreach ($ProjectIDs as $projectId) {
            
           $newArr .= '<strong>'.getProjectByID($projectId).'</strong>';
           $num_count = $num_count + 1;
            if ($num_count < $num_of_items) {
              $newArr .= " | ";
            }
          }
        }else{
          $newArr = "N/A";
        }

        if ($record->typeSizeID !='') {
        	$sizeHtml='<p class="text-danger"><i class="fa fa-expand"></i>
             	<strong>'.propertyTypeSize($record->typeSizeID).'</strong>
             </p>';
        }

        if ($record->token_paid != NULL) {
        	$sizeHtml='<p class="text-danger"><i class="fa fa-money"></i>
             	<strong>'.number_format($record->token_paid).'</strong>
             </p>';
        }

        $multiBooking=$this->leadModel->getMultiBooking($leadId);
        $multiBookingHtml='';
        $abProject='';
        $abSize='';
        if (count($multiBooking) > 0) {
        	foreach ($multiBooking as $mb) {
	        	if ($mb->purpose=='Booking') {
	        		$abProject=getProjectByID($mb->projectID);
		        	if($mb->typeSizeID != ''){
		        		$abSize=propertyTypeSize($mb->typeSizeID);
		        	}
		        	$multiBookingHtml.='<hr>
		        		<p class="text-default"><i class="fa fa-mobile"></i> +'.$mb->ccode.' '.$mb->contact.' |&nbsp; <i class="fa fa-map-marker"></i> '.$mb->location.'</p>
		            <p><label class="label label-danger">'.$mb->propertyType.'</label></p>
		            <p class="text-danger"><i class="fa fa-building-o"></i>
		             	<strong>'.$abProject.'</strong>
		             </p>
		             <p class="text-danger"><i class="fa fa-expand"></i>
		             	<strong>'.$abSize.'</strong>
		             </p>
		            <p><strong>Remarks:</strong></p>
		            <p>'.$mb->remarks.'</p>';
	        	}else{
	        		$multiBookingHtml.='<hr>
		        		<p class="text-default"><i class="fa fa-mobile"></i> +'.$mb->ccode.' '.$mb->contact.' |&nbsp; <i class="fa fa-map-marker"></i> '.$mb->location.'</p>
		            <p><label class="label label-info">Token</label></p>
		            <p class="text-danger"><i class="fa fa-money"></i><strong>'.number_format($mb->token_paid).'</strong></p>
		            <p><strong>Remarks:</strong></p>
		            <p>'.$mb->remarks.'</p>
		            <div class="row"><div class="col-md-12"><a href="'.base_url().'edit-lead/'.base64_encode($mb->leadID).'?mode=multibooking" class="btn btn-theme02 pull-right"><i class="fa fa-edit"></i> Edit</a></div></div>';
	        	}
        	}
        }
       // ($record->size !='')? propertyTypeSize($record->size):'';

		$html='<h1>'.strtoupper($record->name).'</h1>
            <p class="text-default"><i class="fa fa-mobile"></i> +'.$record->ccode.' '.$record->contact.' |&nbsp; <i class="fa fa-map-marker"></i> '.$record->location.'</p>
            <p><label class="label label-danger">'.$record->propertyType.'</label></p>
            <p class="text-danger"><i class="fa fa-building-o"></i>
             	<strong>'.$newArr.'</strong>
             </p>
             '.$sizeHtml.'
            <p><strong>Remarks:</strong></p>
            <p>'.$record->remarks.'</p>'.$multiBookingHtml.'';

            echo $html;
            exit();
	}

	public function editLead()
	{
		$leadID=base64_decode($this->uri->segment(2));
		$record=$this->leadModel->getLeadInfo($leadID);
		$data['record']=$record;
		$projects=$this->leadModel->getProjects();
		$data['projects']=$projects;
		$data['view_page'] = 'lead-edit';
		$this->load->view('partials/template',$data);
	}

	public function singleLeadData(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
		$leadId=$this->input->post('leadId');
		$record=$this->leadModel->getLeadInfo($leadId);
		
		$mobile_code = substr($record->contact, 0, 3);
		$mobile_number = substr($record->contact, -7);
		$getProjects=$this->leadModel->getProjects();



		$projects='<select class="form-control" name="projectID" onchange="getVal(this);"  required="required">
						<option value="">Select</option>';
		
		foreach ($getProjects as $singleproject) {

			$selected="";
			if($singleproject->projectID == $record->projectID){
				$selected="selected";
			}

               $projects.='<option value="'. $singleproject->projectID.'" '.$selected.'>'.$singleproject->projectName.'</option>';
        }

        $projects.='</select>';

        $propertyType ='<select class="form-control" name="propertyType">';
        	if($record->propertyType=='Residential'){

        		 $propertyType.='<option value="Residential" selected>Residential</option>
                        		<option value="Commercial">Commercial</option>';
        	}
        	if($record->propertyType=='Commercial'){

        		 $propertyType.='<option value="Residential" >Residential</option>
                        		<option value="Commercial" selected>Commercial</option>';
        	}
            $propertyType.='</select>';            
                     

        $purposeRadio="";


    switch($record->purpose) {
        case "Booking":
            $purposeRadio = '<div class="form-group">
                   <label class="col-sm-2 control-label">Purpose</label>
                   <div class="col-sm-8">
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Booking" checked> Booking
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Information"> Information
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Not Interested"> Not Interested
                     </label>
                   </div>
                 </div>';
            break;
        case "Information":
            $purposeRadio = '<div class="form-group">
                   <label class="col-sm-2 control-label">Purpose</label>
                   <div class="col-sm-8">
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Booking" > Booking
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Information" checked> Information
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Not Interested"> Not Interested
                     </label>
                   </div>
                 </div>';
            break;
        case "Not Interested":
            $purposeRadio = '<div class="form-group">
                   <label class="col-sm-2 control-label">Purpose</label>
                   <div class="col-sm-8">
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Booking" > Booking
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Information" > Information
                     </label>
                     <label class="radio-inline">
                       <input type="radio" name="purpose" value="Not Interested" checked> Not Interested
                     </label>
                   </div>
                 </div>';
            break;
        default:
            $purposeRadio = "No radio has been selected";
    }


		$html='<form class="form-horizontal" action="'.base_url().'leadController/updateLead" method="POST">
				<input type="hidden" name="leadID" value="'.base64_encode($record->leadID).'">
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Name</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="name" value="'.$record->name.'"  required="required">
                   </div>
                 </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Contact</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" name="ccode" value="'.$record->ccode.'" readonly="readonly">
                    </div>
                    <div class="col-sm-6">
                     <input type="tel" class="form-control" name="contact" value="'.$record->contact.'" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group">
                   <label class="col-sm-2 control-label">Project</label>
                   <div class="col-sm-8">
                     '.$projects.'
                   </div>
                 </div>
                 <div class="form-group" id="selectedsize">
                   <label class="col-sm-2 control-label">Size</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="size" value="'.$record->size.'"  readonly>
                   </div>
                 </div>
                 <span id="jq_projectSize2"></span>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Type</label>
                   <div class="col-sm-8">
                     '. $propertyType.'
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Client Location</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="location" value="'.$record->location.'">
                   </div>
                 </div>
                 '.$purposeRadio.'
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Remarks</label>
                   <div class="col-sm-8">
                     <textarea class="form-control" name="remarks" rows="4" cols="50">'.$record->remarks.'</textarea>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Call Back</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="callBackDate" value="'.$record->callBackDate.'"  required="required">
                   </div>
                   <div class="row">
                      <div class="col-sm-12">
                        <small class="col-sm-offset-2 col-sm-8 text-muted"><b>Date Formate:</b>YYYY-MM-DD</small>
                      </div>
                 </div>
                 </div>
                 <div class="form-group">
                   <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" name="lead_submit" class="btn btn-theme">Submit</button>
                   </div>
                 </div>
               </form>';

            echo $html;
            exit();
	}

	public function updateLead(){


		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		$leadID=base64_decode($leadID);

		$contact=str_replace(" ", "", $contact);

		if ($ccode=='') {
			$ccode='92';
		}

		if (!isset($purpose)) {
			$purpose='Not Interested';
		}

		$dataArray = array(
			'userID' 	=> $this->userID,
			'name' 		=> $name,
			'ccode' 	=> $ccode,
			'contact' 	=> $contact,
			'source'	=> $source,
			'purpose'	=> $purpose,
			'updated_at'=> date('Y-m-d')
		);

		if(isset($Whatsapp)){
			$dataArray['whatsapp']='yes';
		}
		if(isset($projectID)){
			$dataArray['projectID']=implode(',', $projectID);
		}
		if(isset($typeSizeID)){
			$dataArray['typeSizeID']=$typeSizeID;
		}
		if(isset($propertyType)){
			$dataArray['propertyType']=$propertyType;
		}

		if($location!=''){
			$dataArray['location']= $location;
		}
		if($remarks!=''){
			$dataArray['remarks']= $remarks;
		}
		if($callBackDate!=''){
			$dataArray['callBackDate']= $callBackDate;
		}
		$this->db->set($dataArray);
		$this->db->where('leadID',$leadID);
		$this->db->update('leads');


		if ($this->db->affected_rows() == '1') {
    		$this->session->set_flashdata('leadUpdated_success', 'Update Successfully');
			redirect(base_url().'leads');
		} else {
    		$this->session->set_flashdata('leadUpdated_error', 'Some error in updating');
			redirect(base_url().'leads');
		}
	}

	public function getSizes(){
		$id=$this->input->post('id');
		$type=$this->input->post('type');

		$sizes=$this->leadModel->projectSizes($id,$type);
		//$sizes=explode(',', $sizes->size);

		$html ='<div class="form-group">
                   <label class="col-sm-2 control-label">Size</label>
                   <div class="col-sm-8">
                     <select class="form-control" name="typeSizeID" required>
                     	<option value="">Select</option>';
        foreach ($sizes as $size) {
        	$html .='<option value="'.$size->typeID.'">'.$size->typeSize.'</option>';
        	
        }

        $html .='	</select>
                  </div>
                </div>';
        echo $html;
	}

	public function deleteLead($leadID){
		$this->db->where('leadID',$leadID);
		$respons=$this->db->delete('leads');
		if ($respons=='1'){
			$this->session->set_flashdata('delete_success', 'Lead has been delete');
			redirect(base_url().'leads');
		}
		else{
			$this->session->set_flashdata('delete_error', 'Somthing wrong. Error!!');
			redirect(base_url().'leads');
		}
	}

	// Export data in CSV format 
	public function exportCSV(){ 

		$numPerPages='100';
		if (!empty($this->session->userdata('lead_search')['numRecord'])) {
			$numPerPages=$this->session->userdata('lead_search')['numRecord'];
		}

	   // file name 
	   $filename = 'PortalLeads_'.date('d-m-Y').'_'.time().'.csv'; 
	   header("Content-Description: File Transfer"); 
	   header("Content-Disposition: attachment; filename=$filename"); 
	   header("Content-Type: application/csv; ");
	   
	   	// get data 
	   	$config = array();
       	$config["base_url"] = base_url()."leads";
       	$config["total_rows"] = $this->leadModel->record_count();
		$config["per_page"] = $numPerPages;
		$config["uri_segment"] = 2;
		
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
	   	$leadData = $this->leadModel->exportLeads($config["per_page"], $page);


	   // file creation 
	   $file = fopen('php://output', 'w');
	 
	   $header = array("Name","Code","Contact","Location","Project","Purpose","Date"); 
	   fputcsv($file, $header);
	   foreach ($leadData as $key=>$line){ 
	     fputcsv($file,$line); 
	   }
	   fclose($file); 
	   exit; 
	}


	public function anotherBooking(){

		if ($_POST) {
			foreach ($_POST as $key => $value) {
				$$key=$value;
			}

			$contact=str_replace(" ", "", $contact);
			$dataArray = array(
				'userID' 	=> $this->userID,
				'name' 		=> $name,
				'ccode' 	=> $ccode,
				'contact' 	=> $contact,
				'source'	=> $source,
				'purpose'	=> $purpose,
				'multiBookingLead'	=> $leadID,
				'created_at'	    => date('Y-m-d'),
				'updated_at' => date('Y-m-d')
			);

			if(isset($Whatsapp)){
				$dataArray['whatsapp']='yes';
			}
			if(isset($projectID)){
				$dataArray['projectID']=$projectID;
			}
			if(isset($typeSizeID)){
				$dataArray['typeSizeID']=$typeSizeID;
			}
			if(isset($propertyType)){
				$dataArray['propertyType']=$propertyType;
			}
			if($location!=''){
				$dataArray['location']= $location;
			}
			if($remarks!=''){
				$dataArray['remarks']= $remarks;
			}
			if (isset($token_paid) !='') {
				$dataArray['token_paid']= $token_paid;
			}


			if($this->db->insert('leads',$dataArray)){
				$this->session->set_flashdata('another_booking_success', 'Another booking against added '.$name.' ( '.$contact.' )');
				redirect(base_url().'leads');
			}else{
				$this->session->set_flashdata('another_booking_error', 'Something wrong. Error!!');
				redirect(base_url().'leads');
			}
		}

		$projects=$this->leadModel->getProjects();
		$data['projects']=$projects;
		$data['view_page']='another-booking';
		$this->load->view('partials/template',$data);

	}
}
