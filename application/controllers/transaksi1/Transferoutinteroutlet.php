<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Transferoutinteroutlet extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }

    public function index()
    {
        $this->load->view('transaksi1/eksternal/transferoutinteroutlet/list_view');
    }
	
	public function add()
    {
        $this->load->view('transaksi1/eksternal/transferoutinteroutlet/add_new');
    }
	
	public function edit()
    {
        $this->load->view('transaksi1/eksternal/transferoutinteroutlet/edit_view');
    }
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "ATK0216 ",
            "material_desc"=>"",
            "quantity"=> "1.0000",
            "whs_qty"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
			"uom_reg"=> "pcs",
            "cancel"=> ""
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
	
	public function showListData(){
       $dt= array(
           array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_slip_number" => "8649",
			"sr_req_number"=>"6329",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"created_by"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"log"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_slip_number" => "8649",
			"sr_req_number"=>"6329",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"created_by"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"log"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_slip_number" => "8649",
			"sr_req_number"=>"6329",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"created_by"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"log"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_slip_number" => "8649",
			"sr_req_number"=>"6329",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"created_by"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"log"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_slip_number" => "8649",
			"sr_req_number"=>"6329",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"created_by"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"log"=> "Integrated"
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>