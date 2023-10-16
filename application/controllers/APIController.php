<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class APIController extends CI_Controller {


	public function __construct(){
		parent::__construct();
		//
		$this->load->library('form_validation');
		$this->load->model('loginModel');
	}

	public function login_validation(){

		if(isset($_REQUEST['username'])){

			$username=strtolower($_REQUEST['username']);
			$password=$_REQUEST['password'];
	    	$username=$username.'@skymarketing.com.pk';
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
									'email'     => $record->email,
									'mobile'    => $record->contact,
									'userType'  => $record->userType,
									'image'     => $record->image
								);

						print_r(json_encode($session_data));
	        		}else{
	        			echo 'Invalid Password';
	        		}
	    		}else{
	    			echo 'Username has been blocked';
	    		}

	    	}else{
	    		echo 'Username not exist';
	    	}
	    }
	}

	public function logout(){
		$this->session->sess_destroy();
		echo "Logout Successfully";
	}
}
