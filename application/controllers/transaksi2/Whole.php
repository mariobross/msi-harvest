<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Whole extends CI_Controller{
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
        $this->load->view("transaksi2/whole/list_view");
    }

    public function showAllData(){
        $dt= array(
            array(
                "no" => "84530",
                "action" => "84530",
                "id" => "84530",
                "date" => "2019-03-29 17:28:42",
                "item_no"=>"1AWPG005",
                "item_description"=> "Double Chocolate 60x40 (Glaze)",
                "quatity" => "1.00",
                "status" => "Not Approved",
                "created_by"=>"Manager Outlet Bintaro (AT)",
                "approved_by"=> "-",
                "receipt_number" => "1254109",
                "issue_number"=>"1296404",
                "log"=> "Not Integrated"
            ),
            array(
                "no" => "84530",
                "action" => "84530",
                "id" => "84530",
                "date" => "2019-03-29 17:28:42",
                "item_no"=>"1AWPG005",
                "item_description"=> "Double Chocolate 60x40 (Glaze)",
                "quatity" => "1.00",
                "status" => "Not Approved",
                "created_by"=>"Manager Outlet Bintaro (AT)",
                "approved_by"=> "-",
                "receipt_number" => "1254109",
                "issue_number"=>"1296404",
                "log"=> "Not Integrated"
            ),
            array(
                "no" => "84530",
                "action" => "84530",
                "id" => "84530",
                "date" => "2019-03-29 17:28:42",
                "item_no"=>"1AWPG005",
                "item_description"=> "Double Chocolate 60x40 (Glaze)",
                "quatity" => "1.00",
                "status" => "Not Approved",
                "created_by"=>"Manager Outlet Bintaro (AT)",
                "approved_by"=> "-",
                "receipt_number" => "1254109",
                "issue_number"=>"1296404",
                "log"=> "Not Integrated"
            ),
            array(
                "no" => "84530",
                "action" => "84530",
                "id" => "84530",
                "date" => "2019-03-29 17:28:42",
                "item_no"=>"1AWPG005",
                "item_description"=> "Double Chocolate 60x40 (Glaze)",
                "quatity" => "1.00",
                "status" => "Not Approved",
                "created_by"=>"Manager Outlet Bintaro (AT)",
                "approved_by"=> "-",
                "receipt_number" => "1254109",
                "issue_number"=>"1296404",
                "log"=> "Not Integrated"
            ),
            array(
                "no" => "84530",
                "action" => "84530",
                "id" => "84530",
                "date" => "2019-03-29 17:28:42",
                "item_no"=>"1AWPG005",
                "item_description"=> "Double Chocolate 60x40 (Glaze)",
                "quatity" => "1.00",
                "status" => "Not Approved",
                "created_by"=>"Manager Outlet Bintaro (AT)",
                "approved_by"=> "-",
                "receipt_number" => "1254109",
                "issue_number"=>"1296404",
                "log"=> "Not Integrated"
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
         $this->load->view('transaksi2/whole/add_view');
     }

     public function edit(){
        $this->load->view('transaksi2/whole/edit_view');
    }
 
}
?>