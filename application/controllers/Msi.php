<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msi extends CI_Controller {
	
	public function dashboard(){
		//$data['data'] = $this->mentor_model->showMentor2();
		
		$this->load->view('template/header');
		//$this->load->view('admin/mentor',$data);
		$this->load->view('template/navigation');
		$this->load->view('index');
		$this->load->view('template/footer');
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
