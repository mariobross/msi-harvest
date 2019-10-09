<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index(){
		/*if($_POST){
			if($_POST['type']=='login'){
				$sign_val	=	$this->main_model->signin($_POST);
				if($sign_val == false){
					echo '<pre>';
					print_r($sign_val);
					echo '</pre>';
				}else{
					$this->session->set_userdata(
						array(
							'user'	=>	array(
											'name'		=>	$sign_val->name,
											'userid'	=>	$sign_val->id
										)
						)
					);
					echo "Success";
				}
			}
		}else{ 
			if(isset($this->session->userdata['user'])){
				redirect(base_url('/msi'));
			}else{*/
				$this->load->view('template/header');
				$this->load->view('login');
		  //}
		//}
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
