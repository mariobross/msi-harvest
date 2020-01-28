<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();  
		$this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
	}

	public function dashboard(){
		$this->load->view('index');
	}
	
	public function inpofromvendor(){
		
		$this->load->view('template/header');
		$this->load->view('transaksi1/eksternal/po_from_vendor');
		$this->load->view('template/footer');
	}
	
	public function purchaserequest(){
		
		$this->load->view('template/header');
		$this->load->view('transaksi1/eksternal/purchase_request');
		$this->load->view('template/footer');
	}
	
}
