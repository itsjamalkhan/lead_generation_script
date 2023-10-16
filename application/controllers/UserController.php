<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('userModel');
		$this->load->library('pagination');
		$this->userID=$this->session->userdata('userID');
	}

	public function showUsers(){

		$search_data =array();
		if (isset($_POST['searchForUser'])) {

			if($this->input->post('user_name') !=''){
				$search_data['name'] =$this->input->post('user_name');
			}
			if($this->input->post('user_number') !=''){
				$search_data['contact'] =$this->input->post('user_number');
			}
			
			$this->session->set_userdata(array('user_search' =>$search_data));
		}

		$config = array();
       	$config["base_url"] = base_url()."users";
       	$config["total_rows"] = $this->userModel->record_count();
		$config["per_page"] = 50;
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

		$data['usersRecord']=$this->userModel->allUsers($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		$data['view_page'] = 'users';
		$this->load->view('partials/template',$data);
	}

	public function addUsers(){
		if($_POST){

			$this->form_validation->set_rules("firstName", "First Name", "required");
			$this->form_validation->set_rules("lastName", "Last Name", "required");
			$this->form_validation->set_rules("username", "Username", "required");
			//$this->form_validation->set_rules("password", "Password", "required|min_length[6]|max_length[15]");
			/*$this->form_validation->set_rules("confirmPassword", "Confirm Password", "required|matches[password]");*/
			$this->form_validation->set_rules('contact', 'Contact Number ', 'required|regex_match[/^[0-9]{11}$/]');

			if ($this->form_validation->run() == FALSE){

				unset($_POST);
                $data['view_page'] = 'addUser';
				$this->load->view('partials/template',$data);
            }
            else{

            	$username=$_POST['username'];
            	$usernameAvailability=$this->userModel->username_availability($username);

            	if($usernameAvailability=='true'){
            		$this->session->set_flashdata('username_availability', 'Email  already in use');
					redirect(base_url().'add-user');
            	}
            	else{

            		foreach ($_POST as $key => $value) {
						$$key=$value;
					}

					$upload_data='';
					$req=array();

					/*if (!empty($_FILES)) {
						$config = array(
			                'upload_path' => './assets/img/users',
			                'allowed_types' => 'gif|jpg|png',
			                'max_size' => '204800',
			                'encrypt_name' => true
			            );
			        	$this->load->library('upload', $config);
			        	if(!$this->upload->do_upload('user_image')) {
			                $image_error = array('error' => $this->upload->display_errors());
			                $this->session->set_flashdata('image_error', $image_error);
			                redirect(base_url().'add-user');
			            }

			            $upload_data = $this->upload->data();
					}*/
					
					$password = password_hash($password , PASSWORD_DEFAULT);
					$req = array(
						'firstName' =>$firstName ,
						'lastName'  =>$lastName ,
						'gender'    =>$gender ,
						'username'     =>$username,
						'password'  =>$password,
						'contact'   =>$contact,
						'userType'  =>$user_type,
					);
					if ($joining!='') {
						$req['joiningDate']=$joining;
					}
					if($upload_data !=''){
						$req['image']=$upload_data['file_name'];
					}
					if($upload_data !=''){
						$req['description']=$description;
					}
					$response=$this->userModel->insertRegistartion($req);
					if($response){
						$this->session->set_flashdata('registration_success', 'Account Create Successfully');
						redirect(base_url().'add-user');
					}
					else{
						$this->session->set_flashdata('registration_error', 'Somthing wrong. Error!!');
						redirect(base_url().'add-user');
					}
            	}
            }
		}else{
			$data['view_page'] = 'addUser';
			$this->load->view('partials/template',$data);
		}
	}
	public function staffProfileEdit(){
		$userID=base64_decode($this->uri->segment(2));
		$record=$this->db->select('*')->from('users')->where('userID',$userID)->get()->row();
		$data['record'] = $record;
		$data['view_page'] = 'staffProfileEdit';
		$this->load->view('partials/template',$data);
	}
	public function update_staff_picture(){

		$userID = base64_decode($this->input->post('userID'));
		if (!empty($_FILES['staff_picture'])) {
			$this->load->library('upload');
			$staffName = memberName($userID);
			$staffName=str_replace(' ', '-', $staffName);
			$config['upload_path'] = './assets/img/users';
        	$config['allowed_types'] = 'gif|jpg|jpeg|png|JPEG|PNG|GIF';
        	$config['max_size'] = '204800';


            $newFileName = $_FILES['staff_picture']['name'];
            $fileExt = @array_pop(explode(".", $newFileName));
           	$filename = $staffName.'-'.time().".".$fileExt;
           	$config['file_name'] = $filename;
             
            $this->upload->initialize($config);

        	if(!$this->upload->do_upload('staff_picture')) {
                $image_error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('image_error', $image_error);
                redirect(base_url().'staff-profile/'.$_POST['userID']);
            }
            //$this->upload->do_upload('staff_picture');
            $image_name = $this->upload->data();
            $req['image']=$image_name['file_name'];
            $this->db->set($req);
			$this->db->where('userID',$userID);
			$this->db->update('users');

			redirect(base_url().'staff-profile/'.$_POST['userID']);
		}
	}

	public function updateUser(){
		foreach ($_POST as $key => $value) {
			$$key=$value;
		}
		$userID=base64_decode($userID);

		$upload_data='';
		$req=array();
		
		$req = array(
			'firstName' =>$firstName ,
			'lastName'  =>$lastName ,
			'gender'  	=>$gender ,
			'username'     =>$username ,
			'contact'  =>$contact,
			'userType'  =>$user_type,
		);
		if ($joining!='') {
			$req['joiningDate']=$joining;
		}
		if($upload_data !=''){
			$req['image']=$upload_data['file_name'];
		}
		if ($description !='') {
			$req['description']=$description;
		}

		$response=$this->userModel->updateUser($userID,$req);
		if($response){
			$this->session->set_flashdata('update_success', 'Update Successfully');
			redirect(base_url().'staff-profile/'.$_POST['userID']);
		}
		else{
			$this->session->set_flashdata('update_error', 'Somthing wrong. Error!!');
			redirect(base_url().'staff-profile/'.$_POST['userID']);
		}
	}

	public function deleteUser($userID){
		$this->db->where('userID',$userID);
		$respons=$this->db->delete('users');
		if ($respons=='1'){
			$this->session->set_flashdata('delete_success', 'Update Successfully');
			redirect(base_url().'users');
		}
		else{
			$this->session->set_flashdata('delete_error', 'Somthing wrong. Error!!');
			redirect(base_url().'users');
		}
	}

	public function password_reset(){
		
		$userID=base64_decode($this->uri->segment(2));

		$password = '123456';
		$password = password_hash($password , PASSWORD_DEFAULT);

		$req['password']=$password;

		$response=$this->userModel->resetPassword($userID,$req);

		if($response){
			$this->session->set_flashdata('resetPass_success', 'Update Successfully');
			redirect(base_url().'staff-profile/'.$this->uri->segment(2));
		}
		else{
			$this->session->set_flashdata('resetPass_error', 'Somthing wrong. Error!!');
			redirect(base_url().'staff-profile/'.$this->uri->segment(2));
		}
	}

	public function check_availability(){
		$username=$this->input->post('username');
		

		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('username',$username);
		$rec=$this->db->get();
		if($rec->num_rows()>0){
			echo "<p class='text-danger'>Username already registered,Please try other name <i class='fa fa-times'></i></p>";
		}else{
			echo "<p class='text-success'>Username availible <i class='fa fa-check'></i></p>";
		}
	}

	public function changeUserStatus()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$status=$_POST['status'];
		$userID=$_POST['userID'];

		$data['status']=$status;

		$this->db->set($data);
		$this->db->where('userID',$userID);
		$this->db->update('users');

		if ($this->db->affected_rows() == '1') {
			if($status=='active'){
				$msg=memberName($userID).' account has been activate';
    			$this->session->set_flashdata('status_active_success', $msg);
							}
			if($status=='block'){
				$msg=memberName($userID).' account has been blocked';
    			$this->session->set_flashdata('status_block_success', $msg);
				
			}
			echo "1";
			exit();
		} else {
    		$this->session->set_flashdata('status_error', 'Some error in updating');
			echo "2";
			exit();
		}
	}


	public function singleUserDetails(){
		$userID=base64_decode($this->uri->segment(2));
		$search_data =array();
		if($this->input->post('search_by_purpose') !=''){
			$search_data['searchByPurpose'] =$this->input->post('search_by_purpose');
		}

		if($this->input->post('search_date_from') !='' && $this->input->post('search_date_to') !=''){
			$search_data['searchByDateFrom'] =$this->input->post('search_date_from');
			$search_data['searchByDateTo'] =$this->input->post('search_date_to');
		}

		
		$this->session->set_userdata(array('single_user_search' =>$search_data));

		if (isset($_POST['search_single_user'])) {
			if($this->input->post('search_by_purpose') =='' && $this->input->post('search_date_from') =='' && $this->input->post('search_date_to') ==''){

			$this->session->unset_userdata('single_user_search');
			unset($_POST['search_single_user']);
			}
		}

		if(isset($_POST['clear_search_single_user'])){
			$this->session->unset_userdata('single_user_search');
			unset($_POST['search_single_user']);
		}

		$config = array();
       	$config["base_url"] = base_url()."user-profile/".$this->uri->segment(2);
       	$config["total_rows"] = $this->userModel->count_leads($userID);
		$config["per_page"] = 50;
		$config["uri_segment"] = 3;
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
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["links"] = $this->pagination->create_links();
		
		$userData=$this->userModel->getSingleUserData($userID,$config["per_page"], $page);
		$data['user_info']=$this->userModel->user_info($userID);
		$data['total_leads']=$this->userModel->count_leads($userID);
		$data['total_bookings']=$this->userModel->count_bookings($userID);
		$data['bookingCurrentMonth']=$this->userModel->bookingCurrentMonth($userID);
		$data['leadsRecords']=$userData;
		$data['view_page'] = 'single-user-details';
		$this->load->view('partials/template',$data);
	}
}
