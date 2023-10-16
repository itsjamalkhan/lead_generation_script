<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationController extends CI_Controller {

	
	
	public function __construct(){
		parent::__construct();
		$this->load->model('leadModel');
		$this->load->helper('global_helper');
		$this->userID=$this->session->userdata('userID');
	}


	public function enterNotifications()
	{
		$today=date('Y-m-d');


		$leads=$this->db->select('leadID,userID,callBackDate,dated')->from('leads')->where('callBackDate',$today)->get()->result();
		if (count($leads) > 0) {
			$this->db->empty_table('notifications');
			foreach ($leads as $lead) {
				$dataArr = array(
					'leadID'       => $lead->leadID, 
					'userID'       => $lead->userID, 
					'callBackDate' => $lead->callBackDate, 
					'addDate'      => $lead->dated, 
				);

				$this->db->insert('notifications',$dataArr);
			}
		}else{
			exit();

		}
	}

	public function getLeadMeta(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
		$leadId=$this->input->post('leadId');
		$record=$this->leadModel->getLeadInfo($leadId);

		$status = array('status' =>'read');

		$this->db->set($status);
		$this->db->where('leadID',$leadId);
		$this->db->update('notifications');

		
		$newArr='';
		$sizeHtml='';


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
       // ($record->size !='')? propertyTypeSize($record->size):'';

		$html='<h1>'.strtoupper($record->name).'</h1>
            <p class="text-default"><i class="fa fa-mobile"></i> +'.$record->ccode.' '.$record->contact.' |&nbsp; <i class="fa fa-map-marker"></i> '.$record->location.'</p>
            <p><label class="label label-danger">'.$record->propertyType.'</label></p>
            <p class="text-danger"><i class="fa fa-building-o"></i>
             	<strong>'.$newArr.'</strong>
             </p>
             '.$sizeHtml.'
            <h4>Remarks</h4>
            <p>'.$record->remarks.'</p>';

            echo $html;
            exit();
	}


	public function getNotifications()
	{
		$this->db->select('n.leadID,n.callBackDate,n.addDate,n.status, l.name,l.ccode, l.contact,l.purpose,l.source');
    	$this->db->from('notifications as n');
    	$this->db->where('n.userID',$this->userID);
    	$this->db->join('leads as l', 'n.leadID = l.leadID');
    	$rec=$this->db->get();
	    $record = $rec->result();

	    $data['notifications']=$record;
		$data['view_page'] = 'notifications';
		$this->load->view('partials/template',$data);
	}


	public function getEmailTesting()
	{
		$from='skymarketing.isb@gmail.com';
		$to = 'jamalofficial89@gmail.com';
		$subject = 'Cron Job Testing';

		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
		//$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$message = '<p>Testing Lead Portal module by Jamal Ahmad.</p>';
		mail($to, $subject, $message, $headers);
	}


}
