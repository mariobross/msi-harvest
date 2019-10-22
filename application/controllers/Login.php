<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index(){
		$this->load->view('login');
	}

	public function userLogin(){
		$name = $_POST['name'];
		$password = $_POST['password'];

		if($name == 'admin' && $password =='admin'){
			echo base_url('msi/dashboard');
		}else{
			echo 0;
		}
	}
	
	public function forgotPassword(){
		$this->load->library('session'); 
        $this->load->helper('url'); 
		
		$name = $_POST['name'];

		if($name != ''){
			$this->session->set_flashdata('forgotpassword','correct');
			redirect(base_url('login'));
		}else{
			$this->session->set_flashdata('forgotpassword','wrong');
			redirect(base_url('login'));
		}
	}
	
	public function logout(){
		session_destroy();
		if(isset($this->session->userdata['user'])){
			redirect(base_url());
		}else{
			redirect(base_url());
		}
		
	}
}
