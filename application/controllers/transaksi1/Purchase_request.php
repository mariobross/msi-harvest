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
                "no" => "4711",
                "action" => "4711",
                "id" => "4711",
                "item_no" => "1AWPI004",
                "item_description"=>"Manggo Samer 60 x 40 (WP)",
                "posting_date"=> "30-05-2018",
                "status" => "Not Approved",
                "created_by"=>"Admin Outlet Bintaro (AT)",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "last_modified" => "2018-05-31 08:16:41",
                "receipt_number"=>"15995",
                "issue_number" => "16624",
                "log"=> "Integrated"
            ),
            array(
                "no" => "4711",
                "action" => "4711",
                "id" => "4711",
                "item_no" => "1AWPI004",
                "item_description"=>"Manggo Samer 60 x 40 (WP)",
                "posting_date"=> "30-05-2018",
                "status" => "Not Approved",
                "created_by"=>"Admin Outlet Bintaro (AT)",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "last_modified" => "2018-05-31 08:16:41",
                "receipt_number"=>"15995",
                "issue_number" => "16624",
                "log"=> "Integrated"
            ),
            array(
                "no" => "4711",
                "action" => "4711",
                "id" => "4711",
                "item_no" => "1AWPI004",
                "item_description"=>"Manggo Samer 60 x 40 (WP)",
                "posting_date"=> "30-05-2018",
                "status" => "Not Approved",
                "created_by"=>"Admin Outlet Bintaro (AT)",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "last_modified" => "2018-05-31 08:16:41",
                "receipt_number"=>"15995",
                "issue_number" => "16624",
                "log"=> "Integrated"
            ),
            array(
                "no" => "4711",
                "action" => "4711",
                "id" => "4711",
                "item_no" => "1AWPI004",
                "item_description"=>"Manggo Samer 60 x 40 (WP)",
                "posting_date"=> "30-05-2018",
                "status" => "Not Approved",
                "created_by"=>"Admin Outlet Bintaro (AT)",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "last_modified" => "2018-05-31 08:16:41",
                "receipt_number"=>"15995",
                "issue_number" => "16624",
                "log"=> "Integrated"
            ),
            array(
                "no" => "4711",
                "action" => "4711",
                "id" => "4711",
                "item_no" => "1AWPI004",
                "item_description"=>"Manggo Samer 60 x 40 (WP)",
                "posting_date"=> "30-05-2018",
                "status" => "Not Approved",
                "created_by"=>"Admin Outlet Bintaro (AT)",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "last_modified" => "2018-05-31 08:16:41",
                "receipt_number"=>"15995",
                "issue_number" => "16624",
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