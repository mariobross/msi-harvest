<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index(){
		$this->load->view('template/header');
		$this->load->view('login');
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
