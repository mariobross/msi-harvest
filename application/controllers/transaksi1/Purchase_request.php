<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_request extends CI_Controller{
    public function __construct()
    {
        # code...
        parent::__construct();

        // load model
        // $this->load->model("");
        $this->load->library('form_validation');
    }

    public function index()
    {
        # code...
        $this->load->view("transaksi1/eksternal/purchase_request/list_view");
    }

    public function showAllData(){
        $dt= array(
            array(
                "no" => "5242",
                "action" => "5242",
                "id" => "5242",
                "item_no" => "810",
                "item_description"=>"14-10-2019",
                "posting_date"=> "14-10-2019",
                "status" => "Store",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet BSD (TH)",
                "last_modified" => "Manager Outlet BSD (TH)",
                "receipt_number"=>"2019-10-14 13:30:42",
                "issue_number" => "16624",
                "log"=> "Integrated"
            ),
            array(
                "no" => "5304",
                "action" => "5304",
                "id" => "5304",
                "item_no" => "1278",
                "item_description"=>"21-10-2019",
                "posting_date"=> "21-10-2019",
                "status" => "Store",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet BSD (TH)",
                "last_modified" => "Manager Outlet BSD (TH)",
                "receipt_number"=>"2019-10-21 16:45:43",
                "issue_number" => "",
                "log"=> "Integrated"
            )
         ); 
 
         $data = [
             "data"=> $dt
         ];
         
         echo json_encode($data);
     }

     public function add()
     {
         # code...
         $this->load->view('transaksi1/eksternal/purchase_request/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/eksternal/purchase_request/edit_view');
    }
 
}
?>