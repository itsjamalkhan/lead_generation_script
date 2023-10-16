<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('loginModel');
		$this->userID=$this->session->userdata('userID');
	}

	public function index(){

		$leadStatistics=$this->loginModel->getLeadStatistics();
		$leadPurpose=$this->loginModel->getPurposeStatistics();
		//echo "<pre>";print_r(count($leadStatistics));exit();
		$data['linechart']=$leadStatistics;
		$data['piechart']=$leadPurpose;
		$data['view_page'] = 'index';
		$this->load->view('partials/template',$data);
	}

	public function profile(){
		$userID=base64_decode($this->uri->segment(2));
		$record=$this->db->select('*')->from('users')->where('userID',$userID)->get()->row();
		$data['record'] = $record;
		$data['view_page'] = 'profile';
		$this->load->view('partials/template',$data);
	}

	public function update_profile_image(){

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
                redirect(base_url().'profile/'.$_POST['userID']);
            }
            $this->upload->do_upload('staff_picture');
            $image_name = $this->upload->data();
            $req['image']=$image_name['file_name'];
            $this->db->set($req);
			$this->db->where('userID',$userID);
			$this->db->update('users');

			redirect(base_url().'profile/'.$_POST['userID']);
		}
		
	}

	public function update_profile_info(){
		foreach ($_POST as $key => $value) {
			$$key = $value;
		}

		$data = array(
			'firstName' =>$firstName, 
			'lastName' => $lastName,
			'contact' => $contact, 
			'username' =>$username, 
			'joiningDate' =>$joiningDate, 
		);

		if(isset($_POST['password'])){
			$this->form_validation->set_rules("password", "Password", "required|min_length[6]|max_length[15]");
			if ($this->form_validation->run() == FALSE){
				unset($_POST);
				$this->session->set_flashdata('updating_msg', validation_errors());
                redirect(base_url().'profile/'.base64_encode($this->userID));
            }
            else{
				$password = password_hash($password , PASSWORD_DEFAULT);
				$data['password']=$password;
			}
		}

		$this->db->set($data);
		$this->db->where('userID',$this->userID);
		$this->db->update('users');

		if ($this->db->affected_rows() == '1') {
    		$this->session->set_flashdata('updating_success','Update Successfully');
            redirect(base_url().'profile/'.base64_encode($this->userID));
		}else{
    		$this->session->set_flashdata('updating_error', 'Somthing wrong. Error!!');
            redirect(base_url().'profile/'.base64_encode($this->userID));
		}
	}

}
