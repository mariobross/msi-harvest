<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Wo extends CI_Controller{
    public function __construct()
    {
        parent::__construct();

        // load model
        // $this->load->model("");
		$this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index(){
		
        $this->load->view("transaksi1/produksi/work_order/list_view");
		
	}
	
	public function showAllData(){
		
		header('Content-Type: application/json');
		
		$this->load->model('transaksi1/produksi/wo_model');
		
        echo $this->wo_model->showList();
    }

     public function add()
     {
         # code...
         $this->load->view('transaksi1/produksi/work_order/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/produksi/work_order/edit_view');
    }
 
}
?>