<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookingController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('bookingModel');
		$this->load->library('pagination');
		$this->userID=$this->session->userdata('userID');
	}

	public function bookingView(){
		$projects=$this->bookingModel->getProjects();
		$data['projects']=$projects;
		$this->load->view('online/index',$data);
	}

	public function getTypeSizes(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$projectID=$_POST['projectID'];
		$typeName=$_POST['typeName'];
		$typeArray=$this->db->select('typeID,typeSize,dimensionWidth,dimensionHeight')->from('propertytype')->where('projectID',$projectID)->where('typeName',$typeName)->get()->result();

		

		if (!empty($typeArray)) {

			$html='<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">zoom_out_map</i>
					</span>
					<div class="form-group label-floating">
						<p class="radio-req-msg"></p>
                         <div class="radio">';
                         $i=0;
                         	foreach ($typeArray as $type) {
                         		$html .='<input id="styled-radio-'.$i.'" name="typeID" type="radio" value="'.$type->typeID.'" onchange="getPaymentPlan()">
						    			<label for="styled-radio-'.$i.'" class="radio-label">'.$type->typeSize.' <small class="text-muted">  ('.$type->dimensionWidth.'" x '.$type->dimensionHeight.'")</small></label>';
						    $i++;
                         	}
				$html .= '</div>
                    </div>
				</div>';
	        echo $html;
	        exit();
    	}
    	else{
    		$emtyRecord='<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">zoom_out_map</i>
							</span>
							<div class="form-group label-floating">
		                        <div class="radio">
		    						<p style="padding:8px 5px 8px 15px;color:red;border-bottom:1px solid #ccc;">Record Not Found.</p>
		    					</div>
		    				</div>
	                	</div>';
	        echo $emtyRecord;
	        exit();
    	}
	}

	public function getPPlan(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$typeID=$_POST['typeID'];
		$primLoclength=0;
		if(isset($_POST['primLoclength'])){
			$primLoclength=$_POST['primLoclength'];
		}


		$planrec=$this->db->select('*')->from('paymentplan')->where('typeID',$typeID)->get()->row();


		if (!empty($planrec)) {
			$salesPrice=$planrec->salesPrice;
			$installments=$planrec->installmentAmount;
			if($primLoclength!=0){
				$primeFigure=$primLoclength*$planrec->primeLocAbove;
				$salesPercentage=$salesPrice*$primeFigure / 100;
				$salesPrice=$salesPrice+$salesPercentage;
			}
			$downpayment = $salesPrice * $planrec->downpaymentPercent / 100;
            $downpayment = $downpayment + $planrec->memberShipFee; 

            if($primLoclength!=0){
            	$balance= $salesPrice + $planrec->memberShipFee - $downpayment;
				$installments =$balance / $planrec->numberOfInstallment;
            }

            $balance= $salesPrice + $planrec->memberShipFee - $downpayment;
			$html='<div class="input-group">
					<span class="input-group-addon">
						
					</span>
					<div class="form-group label-floating">
                        <div id="no-more-tables">
		                  <table class="table-striped table-condensed cf">
		                    <thead class="cf">
		                      <tr>
		                        <th class="numeric">Sales Price</th>
		                        <th class="numeric">Membership</th>
		                        <th class="numeric">Total Price</th>
		                        <th class="numeric">Downpayment <small class="text-muted">@'.$planrec->downpaymentPercent.'%</small></th>
		                        <th class="numeric">Balance</th>
		                        <th class="numeric">Per Installment</th>
		                        <th class="numeric">Installment(s)</th>
		                      </tr>
		                    </thead>
		                    <tbody>
		                      <tr>
		                        <td data-title="Sales Price" class="numeric">'.number_format($salesPrice).'</td>
		                        <td data-title="Membership" class="numeric">'.number_format($planrec->memberShipFee).'</td>
		                        <td data-title="Total Price" class="numeric">'.number_format($salesPrice + $planrec->memberShipFee).'</td>
		                        <td data-title="Downpayment" class="numeric">'.number_format($downpayment).'</td>
		                        <td data-title="Balance" class="numeric">'.number_format($balance).'</td>
		                        <td data-title="Per Installment" class="numeric">'.number_format($installments).'</td>
		                        <td data-title="Installment(s)" class="numeric">'.$planrec->numberOfInstallment.'</td>
		                      </tr>
		                    </tbody>
		                  </table>
                		</div>
                    </div>
				</div>';
	        echo $html;
	        exit();
		}else{
    		$emtyRecord='<div class="input-group">
							<span class="input-group-addon">
								
							</span>
							<div class="form-group label-floating">
		                        <div class="radio">
		    						<p style="padding:8px 5px 8px 15px;color:red;border-bottom:1px solid #ccc;">Record Not Found.</p>
		    					</div>
		    				</div>
	                	</div>';
	        echo $emtyRecord;
	        exit();
    	}
	}

	public function addBooking(){
		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		$applicantPhoto='';
		$this->load->library('upload');
		if(!empty($_FILES['applicantPicture'])){
			$appName = preg_replace('/\s+/', '', $applicantName);
			$config1['upload_path'] = './assets/img/booking/applicantPhoto';
        	$config1['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';
        	$config1['max_size'] = '204800';


            $newFileName = $_FILES['applicantPicture']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
           	$filename = $appName.'-'.time().".".$fileExt;
           	$config1['file_name'] = $filename;
             
            $this->upload->initialize($config1);

        	/*if(!$this->upload->do_upload('user_image')) {
                $image_error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('image_error', $image_error);
                redirect(base_url().'add-user');
            }*/
            $this->upload->do_upload('applicantPicture');
            $applicantPhoto = $this->upload->data();
            
		}
		$appCnicfrontdata='';
		$appCnicbackdata='';
		$nomCnicfrontdata='';
		$nomCnicbackdata='';
		$bankReceiptdata='';
		$appName = preg_replace('/\s+/', '', $applicantName);
		if (!empty($_FILES['applicantfront'])) {
			
			$config2['upload_path'] = './assets/img/booking/applicantCNIC';
        	$config2['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';

            $newFileName = $_FILES['applicantfront']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
            $filename = $appName.'-CNICFront-'.time().".".$fileExt;
            $config2['file_name'] = $filename;
             
            $this->upload->initialize($config2);

            $this->upload->do_upload('applicantfront');
            $appCnicfrontdata = $this->upload->data();
            
		}

		if (!empty($_FILES['applicantback'])) {

			$config3['upload_path'] = './assets/img/booking/applicantCNIC';
        	$config3['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';

            $newFileName = $_FILES['applicantback']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
            $filename = $appName.'-CNICBack-'.time().".".$fileExt;
            $config3['file_name'] = $filename;
             
            $this->upload->initialize($config3);

            $this->upload->do_upload('applicantback');
            $appCnicbackdata = $this->upload->data();
            
		}

		if (!empty($_FILES['nomineefront'])) {
			
			$config4['upload_path'] = './assets/img/booking/nomineeCNIC';
        	$config4['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';

            $newFileName = $_FILES['nomineefront']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
            $filename = $appName.'-NomineeCNICFront-'.time().".".$fileExt;
            $config4['file_name'] = $filename;
             
            $this->upload->initialize($config4);
            $this->upload->do_upload('nomineefront');
            $nomCnicfrontdata = $this->upload->data();
            
		}

		if (!empty($_FILES['nomineeback'])) {
			$config5['upload_path'] = './assets/img/booking/nomineeCNIC';
        	$config5['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';

            $newFileName = $_FILES['nomineeback']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
            $filename = $appName.'-NomineeCNICBack-'.time().".".$fileExt;
            $config5['file_name'] = $filename;

            $this->upload->initialize($config5);
            $this->upload->do_upload('nomineeback');
            $nomCnicbackdata = $this->upload->data();
            
		}

		if (!empty($_FILES['bankReceipt'])) {
			$config6['upload_path'] = './assets/img/booking/bank';
        	$config6['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';

            $newFileName = $_FILES['bankReceipt']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
            $filename = $appName.'-bankReceipt-'.time().".".$fileExt;
            $config6['file_name'] = $filename;
             
            $this->upload->initialize($config6);
            $this->upload->do_upload('bankReceipt');
            $bankReceiptdata = $this->upload->data();
            
		}

		$dataArr = array(
			'applicantPicture'  => $applicantPhoto['file_name'], 
			'applicantName'		=> $applicantName, 
			'applicantGuardian' => $applicantGuardian, 
			'applicantMobile' 	=> $applicantMobile, 
			'applicantCNIC' 	=> $applicantCNIC, 
			'applicantAddress' 	=> $applicantAddress, 
			'projectID' 		=> $projectID, 
			'proType'			=> $proType, 
			'typeID'			=> $typeID, 
			'nomineeName'		=> $nomineeName, 
			'nomineeFatherName'	=> $nomineeFatherName, 
			'nomineeCNIC'		=> $nomineeCNIC, 
			'nomineeMobile'		=> $nomineeMobile, 
			'relation'			=> $relation, 
			'applicantIDFront'	=> $appCnicfrontdata['file_name'], 
			'applicantIDBack'	=> $appCnicbackdata['file_name'], 
			'nomineeIDFront'	=> $nomCnicfrontdata['file_name'], 
			'nomineeIDBack'		=> $nomCnicbackdata['file_name'], 
			'bankName'			=> $bankName, 
			'bankReceipts'		=> $bankReceiptdata['file_name'], 
		);

		if (!empty($agentName)) {
			$dataArr['agentName'] = $agentName;
		}
		if (!empty($applicantEmail)) {
			$dataArr['applicantEmail'] = $applicantEmail;
		}
		if (!empty($primeLocations)) {
			$dataArr['primeLocations'] =  implode(',', $primeLocations);
		}


		if ($this->db->insert('onlinebooking',$dataArr)) {

			if(!empty($applicantEmail)){

				$to = 'jamalofficial89@gmail.com';
				$subject = 'online Booking';

				$headers = "From: " . strip_tags($applicantEmail) . "\r\n";
				$headers .= "Reply-To: ". strip_tags($applicantEmail) . "\r\n";
				//$headers .= "CC: susan@example.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

				$message = '<p><strong>Thank you</strong></p> \n <p>Your booking Information against <strong>'.$appName.'</strong>, <strong>'.$applicantMobile.'</strong>,<strong>'.$applicantCNIC.'</strong> has been received. We will contact you soon.</p> \n <p>Regards: <strong>Sky Marketing</strong> </p>';
				mail($to, $subject, $message, $headers);
			}

			redirect(base_url().'thank-you');
		}
	}

	function thankyouPage(){
		$this->load->view('online/thankyou');
	}


	function bookingRecord(){
		
		$search_data =array();
		if (isset($_POST['booking_filter'])) {
			if($this->input->post('projectID') !=''){
				$search_data['booking_project'] =$this->input->post('projectID');
			}
			if($this->input->post('applicantMobile') !=''){
				$search_data['booking_contact'] =$this->input->post('applicantMobile');
			}
			if($this->input->post('applicantCNIC') !=''){
				$search_data['booking_cnic'] =$this->input->post('applicantCNIC');
			}
			
			$this->session->set_userdata(array('booking_search' =>$search_data));
		}

		$config = array();
       	$config["base_url"] = base_url()."booking-record";
       	$config["total_rows"] = $this->bookingModel->record_count();
		$config["per_page"] = 25;
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

		$data['bookingRecord'] =$this->bookingModel->getBookingRecord($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();

		$data['projects']=$this->bookingModel->getProjects();
		$data['view_page'] = 'bookingRecord';
		$this->load->view('partials/template',$data);
	}

	function bookingDetails(){
		$bookingID=base64_decode($this->uri->segment(2));
		$update_status = array('readStatus' =>'yes' );
		
		$this->db->set($update_status);
		$this->db->where('bookingID', $bookingID);
		$this->db->update('onlinebooking');

		$bookingInfo=$this->bookingModel->bookingInformation($bookingID);
		$data['bookingInfo']=$bookingInfo;
		$data['view_page'] = 'booking-single';
		$this->load->view('partials/template',$data);
	}
}
