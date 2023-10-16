<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {


	public function __construct(){
		parent::__construct();
		//
		$this->load->library('form_validation');
		$this->load->model('loginModel');
	}

	public function index(){
		if (!empty($this->session->userdata('userID'))){
			redirect(base_url().'dashboard');
		}else{
			$this->load->view('login');
		}
		
	}

	
	public function login_validation(){

		//$this->form_validation->set_rules("user_email", "Email", "required|valid_email");
		$this->form_validation->set_rules("user_password", "Password", "required|min_length[6]|max_length[15]");

		if ($this->form_validation->run() == FALSE){
				unset($_POST);
	      $this->load->view('login');
    	}else{
        	$username=$this->input->post('username');
        	$password=$this->input->post('user_password');

        	
        	$record=$this->loginModel->can_login($username);

        	if ($record !='0') {
        		$check_status=$this->loginModel->checkStatus($username);
        		if ($check_status->status=='active') {
        			$check_Password=password_verify($password,$record->password);
	        		if ($check_Password) {
	        			$session_data = array(
	        						'userID'   	=>$record->userID,
									'firstName' => $record->firstName,
									'lastName'  => $record->lastName,
									'username'     => $record->username,
									'mobile'    => $record->contact,
									'userType'  => $record->userType,
									'image'     => $record->image
								);

						$this->session->set_userdata($session_data);
						redirect(base_url().'leads');
	        		}else{
	        			$this->session->set_flashdata('error','Invalid  Password');
						redirect(base_url().'login');
	        		}
        		}else{
        			$this->session->set_flashdata('error','Account has been blocked');
					redirect(base_url().'login');
        		}

        	}else{
        		$this->session->set_flashdata('error','Invalid Email ');
				redirect(base_url().'login');
        	}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());

	}
}
