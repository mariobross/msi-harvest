<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Transferininteroutlet extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }

    public function index()
    {
        $this->load->view('transaksi1/eksternal/transferininteroutlet/list_view');
    }
	
	public function add()
    {
        $this->load->view('transaksi1/eksternal/transferininteroutlet/add_new');
    }
	
	public function edit()
    {
        $this->load->view('transaksi1/eksternal/transferininteroutlet/edit_view');
    }
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "item_no" => "AT-MBP0001",
            "item_desc"=>"Box 10x20-AT (Active)",
            "gi_qty"=> "200.00",
            "gr_qty"=> "200.00",
            "rcv_qty"=> "",
            "uom"=> "pcs",
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
	
	public function showEditData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "AT-MBP0001",
            "material_desc"=>"Box 10x20-AT (Active)",
            "gi_qty"=> "200.00",
            "gr_qty"=> "200.00",
            "uom"=> "pcs",
            "cancel"=> "variance",
            "val"=> "",
            "variance"=> "0.00",
           ),
		   array(
            "no" => "2",
            "material_no" => "AT-MBP0029",
            "material_desc"=>"Polly Bag Small 2018-AT (Active)",
            "gi_qty"=> "200.00",
            "gr_qty"=> "200.00",
            "uom"=> "pcs",
			"cancel"=> "variance",
            "val"=> "",
            "variance"=> "0.00",
           ),
		   array(
            "no" => "3",
            "material_no" => "AT-MBP0009",
            "material_desc"=>"Underliner 10x20 @1pcs/pcs-AT (Active)",
            "gi_qty"=> "200.00",
            "gr_qty"=> "200.00",
            "uom"=> "pcs",
			"cancel"=> "variance",
            "val"=> "",
            "variance"=> "0.00",
           ),
		   array(
            "no" => "4",
            "material_no" => "AT-MBP0010",
            "material_desc"=>" 	Underliner 20x20 @1pcs/pcs-AT (Active)",
            "gi_qty"=> "100.00",
            "gr_qty"=> "100.00",
            "uom"=> "pcs",
			"cancel"=> "variance",
            "val"=> "",
            "variance"=> "0.00",
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
			"tf_in_number" => "8649",
			"sr_req_number"=>"6329",
			"tf_no_slip"=>"6329",
			"delivery_outlet"=>"WDFGCKST - Cikini",
			"delivery_date"=> "03-05-2018",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"user"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"cancel"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_in_number" => "8649",
			"sr_req_number"=>"6329",
			"tf_no_slip"=>"6329",
			"delivery_outlet"=>"WDFGCKST - Cikini",
			"delivery_date"=> "03-05-2018",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"user"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"cancel"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_in_number" => "8649",
			"sr_req_number"=>"6329",
			"tf_no_slip"=>"6329",
			"delivery_outlet"=>"WDFGCKST - Cikini",
			"delivery_date"=> "03-05-2018",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"user"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"cancel"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_in_number" => "8649",
			"sr_req_number"=>"6329",
			"tf_no_slip"=>"6329",
			"delivery_outlet"=>"WDFGCKST - Cikini",
			"delivery_date"=> "03-05-2018",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"user"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"cancel"=> "Integrated"
           ),
		   array(
            "no" => "4711",
			"action" => "4711",
			"id" => "4711",
			"tf_in_number" => "8649",
			"sr_req_number"=>"6329",
			"tf_no_slip"=>"6329",
			"delivery_outlet"=>"WDFGCKST - Cikini",
			"delivery_date"=> "03-05-2018",
			"posting_date"=> "03-05-2018",
			"tf_out_to_outlet"=> "WDFGCPST-Ciputat",
			"status" => "Approved",
			"user"=>"Admin Outlet Bintaro (AT)",
			"approved_by"=> "Admin Outlet Bintaro (AT)",
			"last_modified" => "2018-05-31 08:16:41",
			"cancel"=> "Integrated"
           ),
		   
		   
        ); 
        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>