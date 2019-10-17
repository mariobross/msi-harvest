<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Pofromvendor extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }
    public function index()
    {
        $this->load->view('transaksi1/eksternal/pofromvendor/list_view');
    }
	
	public function add()
    {
        $this->load->view('transaksi1/eksternal/pofromvendor/add_new');
    }
	
	public function edit()
    {
        $this->load->view('transaksi1/eksternal/pofromvendor/edit_view');
    }
	
	public function showListData(){
        $dt= array(
            array(
                "no" => "1675",
                "action" => "1675",
                "id" => "1675",
                "gr_no" => "13270",
                "po_no" => "10452",
                "vendor_code"=>"AT.TD01A0019",
                "vendor_name"=> "Artfreshindo",
                "delivery_date" => "07-05-2018",
                "posting_date" => "18-05-2018",
                "status"=> "Approved",
                "created_by"=> "Admin Outlet Bintaro (AT)",
                "approved_by" => "Admin Outlet Bintaro (AT)",
                "last_modified"=>"2018-06-08 16:27:42",
                "log"=> "Integrated"
            ),
			array(
                "no" => "1675",
                "action" => "1675",
                "id" => "1675",
                "gr_no" => "13270",
                "po_no" => "10452",
                "vendor_code"=>"AT.TD01A0019",
                "vendor_name"=> "Artfreshindo",
                "delivery_date" => "07-05-2018",
                "posting_date" => "18-05-2018",
                "status"=> "Approved",
                "created_by"=> "Admin Outlet Bintaro (AT)",
                "approved_by" => "Admin Outlet Bintaro (AT)",
                "last_modified"=>"2018-06-08 16:27:42",
                "log"=> "Integrated"
            ),
			array(
                "no" => "1675",
                "action" => "1675",
                "id" => "1675",
                "gr_no" => "13270",
                "po_no" => "10452",
                "vendor_code"=>"AT.TD01A0019",
                "vendor_name"=> "Artfreshindo",
                "delivery_date" => "07-05-2018",
                "posting_date" => "18-05-2018",
                "status"=> "Approved",
                "created_by"=> "Admin Outlet Bintaro (AT)",
                "approved_by" => "Admin Outlet Bintaro (AT)",
                "last_modified"=>"2018-06-08 16:27:42",
                "log"=> "Integrated"
            ),
			array(
                "no" => "1675",
                "action" => "1675",
                "id" => "1675",
                "gr_no" => "13270",
                "po_no" => "10452",
                "vendor_code"=>"AT.TD01A0019",
                "vendor_name"=> "Artfreshindo",
                "delivery_date" => "07-05-2018",
                "posting_date" => "18-05-2018",
                "status"=> "Approved",
                "created_by"=> "Admin Outlet Bintaro (AT)",
                "approved_by" => "Admin Outlet Bintaro (AT)",
                "last_modified"=>"2018-06-08 16:27:42",
                "log"=> "Integrated"
            ),
			array(
                "no" => "1675",
                "action" => "1675",
                "id" => "1675",
                "gr_no" => "13270",
                "po_no" => "10452",
                "vendor_code"=>"AT.TD01A0019",
                "vendor_name"=> "Artfreshindo",
                "delivery_date" => "07-05-2018",
                "posting_date" => "18-05-2018",
                "status"=> "Approved",
                "created_by"=> "Admin Outlet Bintaro (AT)",
                "approved_by" => "Admin Outlet Bintaro (AT)",
                "last_modified"=>"2018-06-08 16:27:42",
                "log"=> "Integrated"
            ),
			array(
                "no" => "1675",
                "action" => "1675",
                "id" => "1675",
                "gr_no" => "13270",
                "po_no" => "10452",
                "vendor_code"=>"AT.TD01A0019",
                "vendor_name"=> "Artfreshindo",
                "delivery_date" => "07-05-2018",
                "posting_date" => "18-05-2018",
                "status"=> "Approved",
                "created_by"=> "Admin Outlet Bintaro (AT)",
                "approved_by" => "Admin Outlet Bintaro (AT)",
                "last_modified"=>"2018-06-08 16:27:42",
                "log"=> "Integrated"
            ),
			
         ); 
 
         $data = [
             "data"=> $dt
         ];
         
         echo json_encode($data);
     }
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "ATK0216 ",
            "material_desc"=>"Label Tom & Jerry No. 103 @1Pcs/Pcs (Ina",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> "",
            "cancel"=> ""
           ),
		   array(
            "no" => "2",
            "material_no" => "EAT0001",
            "material_desc"=>"ABC Alkaline AAA (Active)",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> "",
			"cancel"=> ""
           ),
		   array(
            "no" => "3",
            "material_no" => "EAT0002 ",
            "material_desc"=>"ABC Battery AA Kecil (Active)",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> "",
			"cancel"=> ""
           ),
		   array(
            "no" => "4",
            "material_no" => "EAT0007",
            "material_desc"=>"Amplop Cashier Remitance (Active)",
            "quantity"=> "4.0000",
            "gr_qty"=> "4.000",
            "uom"=> "pcs",
            "qc"=> "",
			"cancel"=> ""
           ),
		   array(
            "no" => "5",
            "material_no" => "EAT0008",
            "material_desc"=>" 	Amplop coklat folio (Active)",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> "",
			"cancel"=> ""
           ),
		   
        ); 
        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>