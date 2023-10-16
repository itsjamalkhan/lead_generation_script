<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportController extends CI_Controller {

	
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('global_helper');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('reportsModel');
		$this->userID=$this->session->userdata('userID');
		$this->userType=$this->session->userdata('userType');
	}

	public function showReports(){

		$search_data =array();
		$numPerPages='100';
		//if (isset($_POST['search'])) {
			if($this->input->post('search_by_day') !=''){
				$search_data['reportByDay'] =$this->input->post('search_by_day');
			}
			if($this->input->post('search_by_booking') !=''){
				$search_data['reportByBooking'] =$this->input->post('search_by_booking');
				unset($search_data['reportByDay']);
			}

			if($this->input->post('search_date_from') !='' && $this->input->post('search_date_to') !=''){
				$search_data['reportByDateFrom'] =$this->input->post('search_date_from');
				$search_data['reportByDateTo'] =$this->input->post('search_date_to');
				unset($search_data['reportByDay']);
				unset($search_data['reportByBooking']);
			}
			

			if ($this->input->post('lead_numOfRecord') !='') {
				$numPerPages=$this->input->post('lead_numOfRecord');
				$search_data['numRecord'] =$this->input->post('lead_numOfRecord');
			}
			
			
		$this->session->set_userdata(array('report_search' =>$search_data));

		if (isset($_POST['search_reports'])) {
			if($this->input->post('search_by_day') =='' && $this->input->post('search_by_booking') =='' && $this->input->post('search_date_from') =='' && $this->input->post('search_date_to') ==''){

				$this->session->unset_userdata('report_search');
				unset($_POST['search_reports']);
			}
		}

		if(isset($_POST['clear_search_reports'])){
			$this->session->unset_userdata('report_search');
				unset($_POST['search_reports']);
		}
		$config = array();
       	$config["base_url"] = base_url()."reports";
       	if (isset($_POST['search'])) {
       		$config["total_rows"] = $this->reportsModel->count_by_search();
       	}else{
       		$config["total_rows"] = $this->reportsModel->record_count();
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

		$data["leadsRecords"] =$this->reportsModel->getLeads($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		if (isset($_POST['search_reports'])) {
			$data["total_rows"] = count($data["leadsRecords"]);
		}else{
			$data["total_rows"] =  $this->reportsModel->record_count();
		}

		$data['totalLeads']=$this->reportsModel->record_count();
		$data['lastMonthBooking']=$this->reportsModel->getLastMonthBooking();
		$data['currentMonthBooking']=$this->reportsModel->getCurrentMonthBooking();
		$data['getByPupose']=$this->reportsModel->getByPupose();
		$mostBookingsBy=$this->reportsModel->mostBookingsBy();


		$highest = array_reduce($mostBookingsBy, function ($a, $b) {
				return @$a['leads'] > $b['leads'] ? $a : $b;
			});
		$highestLastMonthBooking=$this->reportsModel->highestLastMonthBooking($highest['userID']);

		$data['mostBookingsBy']=$highest;
		$data['highestLastMonthBooking']=$highestLastMonthBooking;

		$data['view_page'] = 'reporting';
		$this->load->view('partials/template',$data);
	}

	public function dailyReports(){
		if ($_POST) {
			

			foreach ($_POST as $key => $value) {
				$$key=$value;
			}

			$inboundStr=implode(',', $inbound);
			$outboundStr=implode(',', $outbound);
			$posts_mediumStr=implode(',', $posts_medium);

			header('Content-Type: application/json');
			$facebook = ['likes'=>$fb_likes, 'comments'=>$fb_comments, 'share'=>$fb_share, 'tag'=>$fb_tag];
			$instagram = ['likes'=>$insta_likes, 'comments'=>$insta_comments, 'share'=>$insta_share, 'tag'=>$insta_tag];
			$youtube = ['likes'=>$yt_likes, 'comments'=>$yt_comments, 'share'=>$yt_share, 'tag'=>$yt_tag];
			$website = ['likes'=>$web_likes, 'comments'=>$web_comments, 'share'=>$web_share, 'tag'=>$web_tag];
			$own = ['email'=>$own_email, 'sms'=>$own_sms, 'whatsapp'=>$own_whatsapp, 'other'=>$own_other];

			$facebookJson=json_encode($facebook);
			$instagramJson=json_encode($instagram);
			$youtubeJson=json_encode($youtube);
			$websiteJson=json_encode($website);
			$ownJson=json_encode($own);

			$dataArray = array(
				'userID' 	=> $this->userID,
				'visits' 	=> $visits,
				'deals' 	=> $deals,
				'inbound' 	=> $inboundStr,
				'total_inbound' 	=> $total_inbound,
				'outbound' 	=> $outboundStr,
				'total_outbound' => $total_outbound,
				'posts_medium' => $posts_mediumStr,
				'total_posts' => $total_posts,
				'facebook_activity' => $facebookJson,
				'insta_activity' => $instagramJson,
				'youtube_activity' => $youtubeJson,
				'website_activity' => $websiteJson,
				'own_activity' => $ownJson,
				'created_at' => date('Y-m-d'),
				'updated_at' => date('Y-m-d')
			);
			$response=$this->reportsModel->insertDailyReport($dataArray);
			if ($response) {
				$this->session->set_flashdata('reporting_success', 'Report Add Successfully');
					redirect(base_url().'daily-report');
			}else{
				$this->session->set_flashdata('reporting_error', 'Something wrong. Error!!');
					redirect(base_url().'daily-report');
			}
		}

		if ($this->userID=='1' || $this->userType=='HR'){

			$config = array();
	       	$config["base_url"] = base_url()."daily-report";
	       	$config["total_rows"] = $this->reportsModel->dailyReportRecord_count();
			$config["per_page"] = '100';
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
			$data["links"] = $this->pagination->create_links();
			$data['reporting']=$this->reportsModel->getReporting($config["per_page"], $page);
		}
		$data['todayReport']=$this->reportsModel->getTodaysReport($this->userID);
		/*echo "<pre>";
		print_r($data['todayReport']);
		exit();*/
		$projects=$this->reportsModel->getProjects();
		$data['projects']=$projects;
		$data['view_page']='report/dailyReports';
		$this->load->view('partials/template',$data);
	}

	public function getReportMeta(){
		$id=$this->input->post('id');
		$report=$this->reportsModel->getReportByID($id);
		$leads=$this->reportsModel->getLeadsByID($report->userID,$report->created_at);

		$visits=($report->visits !=" ")?$report->visits:"0";
		$deals=($report->deals !=" ")?$report->deals:"0";
		$total_inbound=($report->total_inbound !=" ")?$report->total_inbound:"0";
		$total_outbound=($report->total_outbound !=" ")?$report->total_outbound:"0";
		$total_posts=($report->total_posts !=" ")?$report->total_posts:"0";

		// Facebook Activity
		$facebookArr=json_decode($report->facebook_activity,true);
		$fb_likes=($facebookArr['likes'] !='')?$facebookArr['likes']:'0';
		$fb_comments=($facebookArr['comments'] !='')?$facebookArr['comments']:'0';
		$fb_share=($facebookArr['share'] !='')?$facebookArr['share']:'0';
		$fb_tag=($facebookArr['tag'] !='')?$facebookArr['tag']:'0';

		// Instagram Activity
		$instagramArr=json_decode($report->insta_activity,true);
		$insta_likes=($instagramArr['likes'] !='')?$instagramArr['likes']:'0';
		$insta_comments=($instagramArr['comments'] !='')?$instagramArr['comments']:'0';
		$insta_share=($instagramArr['share'] !='')?$instagramArr['share']:'0';
		$insta_tag=($instagramArr['tag'] !='')?$instagramArr['tag']:'0';

		// Youtube Activity
		$youtubeArr=json_decode($report->youtube_activity,true);
		$yt_likes=($youtubeArr['likes'] !='')?$youtubeArr['likes']:'0';
		$yt_comments=($youtubeArr['comments'] !='')?$youtubeArr['comments']:'0';
		$yt_share=($youtubeArr['share'] !='')?$youtubeArr['share']:'0';
		$yt_tag=($youtubeArr['tag'] !='')?$youtubeArr['tag']:'0';

		// Website Activity
		$websiteArr=json_decode($report->website_activity,true);
		$web_likes=($websiteArr['likes'] !='')?$websiteArr['likes']:'0';
		$web_comments=($websiteArr['comments'] !='')?$websiteArr['comments']:'0';
		$web_share=($websiteArr['share'] !='')?$websiteArr['share']:'0';
		$web_tag=($websiteArr['tag'] !='')?$websiteArr['tag']:'0';

		// Own Activity
		$ownArr=json_decode($report->own_activity,true);
		$own_email=($ownArr['email'] !='')?$ownArr['email']:'0';
		$own_sms=($ownArr['sms'] !='')?$ownArr['sms']:'0';
		$own_whatsapp=($ownArr['whatsapp'] !='')?$ownArr['whatsapp']:'0';
		$own_other=($ownArr['other'] !='')?$ownArr['other']:'0';

		$projectHTML='';
		if ($report->posts_medium !='') {
			$expProject=explode(',', $report->posts_medium);
			for ($i=0; $i<count($expProject) ; $i++) { 
				$projectHTML.='<span class="posts_medium">'.getProjectByID($expProject[$i]).'</span>';
			}
		}else{
			$projectHTML='No Post';
		}
		
		$total_posts=($projectHTML =="No Post")? "0": $total_posts;
		
		

		$html='
		<div class="col-md-12">
            <div class="row">
              <div class="col-md-8">
                <p style="font-size:20px;font-weight:900;">'.$report->firstname.' '.$report->lastname.'</>
                <p><strong>Username:</strong> '.$report->username.'</p>
                <p><strong>Contact:</strong> '.$report->contact.'</p>
                
              </div>
              <div class="col-md-4">
              	<p style="font-size:16px;font-weight:900;color:#000;"><i class="fa fa-calendar"></i> '.date('d M, Y',strtotime($report->created_at)).'</p>
                <table class="table table-bordered">
                  <tr>
                    <th>Client Visits</th>
                    <td>'.$visits.'</td>
                  </tr>
                  <tr>
                    <th>Client Deals</th>
                    <td>'.$deals.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p style="font-size: 16px; font-weight: 900;">Incoming Calls</p>
                <table class="table table-bordered">
                  <tr>
                    <th>From</th>
                    <td>'.$report->inbound.'</td>
                  </tr>
                  <tr>
                    <th>Total Calls</th>
                    <td>'.$total_inbound.'</td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <p style="font-size: 16px; font-weight: 900;">Outgoing Calls</p>
                <table class="table table-bordered">
                  <tr>
                    <th>To</th>
                    <td>'.$report->outbound.'</td>
                  </tr>
                  <tr>
                    <th>Total Calls</th>
                    <td>'.$total_outbound.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <p style="font-size: 16px; font-weight: 900;">Post on Social Media, OLX, Other Websites</p>
                <table class="table table-bordered">
                  <tr>
                    <th>Projects</th>
                    <td>'.$projectHTML.'</td>
                  </tr>
                  <tr>
                    <th>Total Post</th>
                    <td>'.$total_posts.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <p style="font-size: 16px; font-weight: 900;">Activity on SKY MAREKTING & PROPERTY NEWS</p>
                <table class="table table-bordered">
                  <tr>
                    <th>Platforms</th>
                    <th>Likes</th>
                    <th>Comments</th>
                    <th>Shares</th>
                    <th>Tags</th>
                    
                  </tr>
                  <tr>
                    <th>Facebook</th>
                    <td>'.$fb_likes.'</td>
                    <td>'.$fb_comments.'</td>
                    <td>'.$fb_share.'</td>
                    <td>'.$fb_tag.'</td>
                  </tr>
                  <tr>
                    <th>Instagram</th>
                    <td>'.$insta_likes.'</td>
                    <td>'.$insta_comments.'</td>
                    <td>'.$insta_share.'</td>
                    <td>'.$insta_tag.'</td>
                  </tr>
                  <tr>
                    <th>Youtube</th>
                    <td>'.$yt_likes.'</td>
                    <td>'.$yt_comments.'</td>
                    <td>'.$yt_share.'</td>
                    <td>'.$yt_tag.'</td>
                  </tr>
                  <tr>
                    <th>Web Blog</th>
                    <td>'.$web_likes.'</td>
                    <td>'.$web_comments.'</td>
                    <td>'.$web_share.'</td>
                    <td>'.$web_tag.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p style="font-size: 16px; font-weight: 900;">Your Own Activity</p>
                <table class="table table-bordered">
                  <tr>
                    <th>Emails</th>
                    <td>'.$own_email.'</td>
                  </tr>
                  <tr>
                    <th>Send SMS</th>
                    <td>'.$own_sms.'</td>
                  </tr>
                  <tr>
                    <th>Whatsapp</th>
                    <td>'.$own_whatsapp.'</td>
                  </tr>
                  <tr>
                    <th>Other</th>
                    <td>'.$own_other.'</td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <p style="font-size: 16px; font-weight: 900;">Portal Leads</p>
                <table class="table table-bordered">
                  <tr>
                    <th>Leads Add</th>
                    <td>'.$leads[0]->leads.'</td>
                  </tr>
                  <tr>
                    <th>Booking</th>
                    <td>'.$leads[0]->booking.'</td>
                  </tr>
                </table>
              </div>
            </div>
         </div>';
         echo $html;
         exit();
	}

	public function editdailyReports(){
		$id=base64_decode($this->uri->segment(2));

		$this->db->where('id',$id);
		$rec=$this->db->get('dailyreporting')->row();
		$projects=$this->reportsModel->getProjects();
		$data['projects']=$projects;
		$data['report']=$rec;
		$data['view_page']='report/edit-dailyReport';
		$this->load->view('partials/template',$data);
	}

	public function updateDailyReport(){

		foreach ($_POST as $key => $value) {
			$$key=$value;
		}

		$decode_id=base64_decode($id);

		$inboundStr=implode(',', $inbound);
		$outboundStr=implode(',', $outbound);
		$posts_mediumStr=implode(',', $posts_medium);

		header('Content-Type: application/json');
		$facebook = ['likes'=>$fb_likes, 'comments'=>$fb_comments, 'share'=>$fb_share, 'tag'=>$fb_tag];
		$instagram = ['likes'=>$insta_likes, 'comments'=>$insta_comments, 'share'=>$insta_share, 'tag'=>$insta_tag];
		$youtube = ['likes'=>$yt_likes, 'comments'=>$yt_comments, 'share'=>$yt_share, 'tag'=>$yt_tag];
		$website = ['likes'=>$web_likes, 'comments'=>$web_comments, 'share'=>$web_share, 'tag'=>$web_tag];
		$own = ['email'=>$own_email, 'sms'=>$own_sms, 'whatsapp'=>$own_whatsapp, 'other'=>$own_other];

		$facebookJson=json_encode($facebook);
		$instagramJson=json_encode($instagram);
		$youtubeJson=json_encode($youtube);
		$websiteJson=json_encode($website);
		$ownJson=json_encode($own);

		$dataArray = array(
			'userID' 	=> $this->userID,
			'visits' 	=> $visits,
			'deals' 	=> $deals,
			'inbound' 	=> $inboundStr,
			'total_inbound' 	=> $total_inbound,
			'outbound' 	=> $outboundStr,
			'total_outbound' => $total_outbound,
			'posts_medium' => $posts_mediumStr,
			'total_posts' => $total_posts,
			'facebook_activity' => $facebookJson,
			'insta_activity' => $instagramJson,
			'youtube_activity' => $youtubeJson,
			'website_activity' => $websiteJson,
			'own_activity' => $ownJson,
			'updated_at' => date('Y-m-d')
		);

		$this->db->set($dataArray);
		$this->db->where('id',$decode_id);
		$this->db->update('dailyreporting');

		if ($this->db->affected_rows() == '1') {
    		$this->session->set_flashdata('update_daily_report_success', 'Update Successfully');
			redirect(base_url().'daily-report');
		} else {
    		$this->session->set_flashdata('update_daily_report_error', 'Some error in updating');
			redirect(base_url().'daily-report');
		}
	}

	function GeneratePdf(){
		$this->load->library('pdf');
		$id=$_GET['id'];
		$report=$this->reportsModel->getReportByID($id);
		$leads=$this->reportsModel->getLeadsByID($report->userID,$report->dated);

		$visits=($report->visits !=" ")?$report->visits:"0";
		$deals=($report->deals !=" ")?$report->deals:"0";
		$total_inbound=($report->total_inbound !=" ")?$report->total_inbound:"0";
		$total_outbound=($report->total_outbound !=" ")?$report->total_outbound:"0";
		$total_posts=($report->total_posts !=" ")?$report->total_posts:"0";

		// Facebook Activity
		$facebookArr=json_decode($report->facebook_activity,true);
		$fb_likes=($facebookArr['likes'] !='')?$facebookArr['likes']:'0';
		$fb_comments=($facebookArr['comments'] !='')?$facebookArr['comments']:'0';
		$fb_share=($facebookArr['share'] !='')?$facebookArr['share']:'0';
		$fb_tag=($facebookArr['tag'] !='')?$facebookArr['tag']:'0';

		// Instagram Activity
		$instagramArr=json_decode($report->insta_activity,true);
		$insta_likes=($instagramArr['likes'] !='')?$instagramArr['likes']:'0';
		$insta_comments=($instagramArr['comments'] !='')?$instagramArr['comments']:'0';
		$insta_share=($instagramArr['share'] !='')?$instagramArr['share']:'0';
		$insta_tag=($instagramArr['tag'] !='')?$instagramArr['tag']:'0';

		// Youtube Activity
		$youtubeArr=json_decode($report->youtube_activity,true);
		$yt_likes=($youtubeArr['likes'] !='')?$youtubeArr['likes']:'0';
		$yt_comments=($youtubeArr['comments'] !='')?$youtubeArr['comments']:'0';
		$yt_share=($youtubeArr['share'] !='')?$youtubeArr['share']:'0';
		$yt_tag=($youtubeArr['tag'] !='')?$youtubeArr['tag']:'0';

		// Website Activity
		$websiteArr=json_decode($report->website_activity,true);
		$web_likes=($websiteArr['likes'] !='')?$websiteArr['likes']:'0';
		$web_comments=($websiteArr['comments'] !='')?$websiteArr['comments']:'0';
		$web_share=($websiteArr['share'] !='')?$websiteArr['share']:'0';
		$web_tag=($websiteArr['tag'] !='')?$websiteArr['tag']:'0';

		// Own Activity
		$ownArr=json_decode($report->own_activity,true);
		$own_email=($ownArr['email'] !='')?$ownArr['email']:'0';
		$own_sms=($ownArr['sms'] !='')?$ownArr['sms']:'0';
		$own_whatsapp=($ownArr['whatsapp'] !='')?$ownArr['whatsapp']:'0';
		$own_other=($ownArr['other'] !='')?$ownArr['other']:'0';

		$projectHTML='';
		if ($report->posts_medium !='') {
			$expProject=explode(',', $report->posts_medium);
			for ($i=0; $i<count($expProject) ; $i++) { 
				$projectHTML.='<span style="background: #ffa700;color: #fff;padding: 3px 5px;margin-right: 5px;border-radius: 3px;">'.getProjectByID($expProject[$i]).'</span>';
			}
		}else{
			$projectHTML='No Post';
		}
		
		$total_posts=($projectHTML =="No Post")? "0": $total_posts;
		
		

		$html='
		<div style="font-family:Arial, Helvetica, sans-serif; margin-bottom:10px;">
			<h2 style="text-align:center;margin-bottom:0px;">SKY MARKETING</h2>
			<p style="text-align:center;margin-top:2px;">Daily Base Tracker Sheet</p>
		</div>
		<div style="padding:15px; border: 1px solid #ccc;font-family:Arial, Helvetica, sans-serif;" >
            <div style="width: 100%;overflow: auto; padding-bottom: 15px;">
              <div style="width: 60%; float: left;">
                <p style="font-size:20px;font-weight:900;">'.$report->firstname.' '.$report->lastname.'</p>
                <p><strong>Username:</strong>'.$report->username.'</p>
                <p><strong>Contact:</strong> '.$report->contact.'</p>
              </div>
              <div style="width: 40%; float: left;">
                <p style="font-size:16px;font-weight:900;color:#000;"><img src="'.base_url().'assets/img/calendar.png" style="width:18px;height:18px;">  '.date('d M, Y',strtotime($report->dated)).'</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">Client Visits</th>
                    <td style="border:1px solid #ccc;text-align: center;">'.$visits.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">Client Deals</th>
                    <td style="border:1px solid #ccc;text-align: center;">'.$deals.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear:both"></div>
            <div style="width: 100%;overflow: auto; border-top: 1px solid #999; padding-top: 15px;padding-bottom: 15px;">
              <div style="width: 49%; float: left;">
                <p style="font-size: 16px; font-weight: 900;">Incoming Calls</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;padding: 5px;">From</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$report->inbound.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">Total Calls</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$total_inbound.'</td>
                  </tr>
                </table>
              </div>
              <div style="width: 49%; float: right;">
                <p style="font-size: 16px; font-weight: 900;">Outgoing Calls</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">To</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$report->outbound.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">Total Calls</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$total_outbound.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear:both"></div>
            <div style="width: 100%;overflow: auto; border-top: 1px solid #999; padding-top: 15px;padding-bottom: 15px;">
              <div>
                 <p style="font-size: 16px; font-weight: 900;">Post on Social Media, OLX, Other Websites</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Project</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$projectHTML.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Total Posts</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$total_posts.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear:both"></div>
            <div style="width: 100%;overflow: auto; border-top: 1px solid #999; padding-top: 15px;padding-bottom: 15px;">
              <div>
                <p style="font-size: 16px; font-weight: 900;"> Activity on SKY MAREKTING & PROPERTY NEWS</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Platforms</th>
                    <th style="border:1px solid #ccc;padding:5px;">Likes</th>
                    <th style="border:1px solid #ccc;padding:5px;">Comments</th>
                    <th style="border:1px solid #ccc;padding:5px;">Shares</th>
                    <th style="border:1px solid #ccc;padding:5px;">Tags</th>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Facebook</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$fb_likes.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$fb_comments.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$fb_share.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$fb_tag.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Instagram</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$insta_likes.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$insta_comments.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$insta_share.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$insta_tag.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Youtube</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$yt_likes.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$yt_comments.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$yt_share.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$yt_tag.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding:5px;">Website Blog</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$web_likes.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$web_comments.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$web_share.'</td>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$web_tag.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear:both"></div>
            <div style="width: 100%;overflow: auto; border-top: 1px solid #999; padding-top: 15px;">
              <div style="width: 49%; float: left;">
                <p style="font-size: 16px; font-weight: 900;">Your Own Activity</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;padding: 5px;">Email</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$own_email.'</td>
                    <th style="border:1px solid #ccc;padding: 5px;">SMS</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$own_sms.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;padding: 5px;">Whatsapp</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$own_whatsapp.'</td>
                    <th style="border:1px solid #ccc;padding: 5px;padding: 5px;">Other</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$own_other.'</td>
                  </tr>
                </table>
              </div>
              <div style="width: 49%; float: right;">
                <p style="font-size: 16px; font-weight: 900;">Portal Leads</p>
                <table style="border:1px solid #ccc; width: 100%;">
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">Add Leads</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$leads[0]->leads.'</td>
                  </tr>
                  <tr>
                    <th style="border:1px solid #ccc;padding: 5px;">Booking</th>
                    <td style="border:1px solid #ccc;padding-left: 5px;">'.$leads[0]->booking.'</td>
                  </tr>
                </table>
              </div>
            </div>
            <div style="clear:both"></div>
          </div>';
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$filename=$report->firstname.'-'.$report->lastname.'-'.date('d-M-Y',strtotime($report->dated)).'-'.time().'.pdf';
		$this->pdf->stream("$filename", array("Attachment"=>0));
		exit(0);	
	}


	public function byMonthReport(){
		/*$this->db->select('COUNT(leadID) as leads,dated,COUNT(case purpose when "Booking" then 1 else null end) as booking');
		$this->db->from('leads');
		//$this->db->where('YEAR(dated)','2019');
		$this->db->group_by('MONTH(dated)');
		$result=$this->db->get()->result();*/

		$this->db->select('COUNT(purpose) as cat, purpose');
		$this->db->from('leads');
		//$this->db->where('YEAR(dated)','2019');
		$this->db->group_by('purpose');
		$result=$this->db->get()->result();

		echo "<pre>";
		print_r($result);
		exit();
	}

	public function getdateto(){
		$this->db->select('leadID,created_at');
		$rec=$this->db->get('leads')->result();
		
		foreach ($rec as $r) {
			
			$data = array(
				'updated_at' => date('Y-m-d',strtotime($r->created_at)),
			);

			$this->db->set($data);
			$this->db->where('leadID',$r->leadID);
			$this->db->update('leads');
			if ($this->db->affected_rows() == '1') {
				echo "Lead ".$r->leadID." has been updated<br>";
			}else{
				echo "Error on ".$r->leadID;
			}
		}
	}
}