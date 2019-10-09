<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index(){
		$this->load->view('template/header');
		$this->load->view('login');
	}

	public function userLogin(){
		$name = $_POST['Name'];
		$password = $_POST['Password'];

		if($name == 'admin' && $password =='admin'){
			echo base_url('msi/dashboard');
		}else{
			echo 0;
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
