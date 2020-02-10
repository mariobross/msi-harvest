<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Onhand extends CI_Controller{
    public function __construct()
    {
        # code...
        parent::__construct();

        $this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
        // load model
        $this->load->model("report/onhand_model","onh_model");
        
        $this->load->library('form_validation');
        $this->load->library('l_general');
    }

    public function index()
    {
        # code...
        $object['itemGroup'] = $this->onh_model->item_group();
        $this->load->view("report/onhand_view",$object);
    }
}
?>