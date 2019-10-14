<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sr extends CI_Controller{
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
        $this->load->view("transaksi2/sr/list_view");
    }

    public function showAllData(){
        $dt= array(
            array(
                "no" => "1208",
                "action" => "1208",
                "id" => "1208",
                "date" => "5431",
                "item_no"=>"WDFGAMST - Ampera",
                "item_description"=> "12-05-2018",
                "quatity" => "14-05-2018",
                "status" => "Order",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "receipt_number" => "Manager Outlet Bintaro (AT)",
                "issue_number"=>"2018-05-14 19:54:50",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1208",
                "action" => "1208",
                "id" => "1208",
                "date" => "5431",
                "item_no"=>"WDFGAMST - Ampera",
                "item_description"=> "12-05-2018",
                "quatity" => "14-05-2018",
                "status" => "Order",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "receipt_number" => "Manager Outlet Bintaro (AT)",
                "issue_number"=>"2018-05-14 19:54:50",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1208",
                "action" => "1208",
                "id" => "1208",
                "date" => "5431",
                "item_no"=>"WDFGAMST - Ampera",
                "item_description"=> "12-05-2018",
                "quatity" => "14-05-2018",
                "status" => "Order",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "receipt_number" => "Manager Outlet Bintaro (AT)",
                "issue_number"=>"2018-05-14 19:54:50",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1208",
                "action" => "1208",
                "id" => "1208",
                "date" => "5431",
                "item_no"=>"WDFGAMST - Ampera",
                "item_description"=> "12-05-2018",
                "quatity" => "14-05-2018",
                "status" => "Order",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "receipt_number" => "Manager Outlet Bintaro (AT)",
                "issue_number"=>"2018-05-14 19:54:50",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1208",
                "action" => "1208",
                "id" => "1208",
                "date" => "5431",
                "item_no"=>"WDFGAMST - Ampera",
                "item_description"=> "12-05-2018",
                "quatity" => "14-05-2018",
                "status" => "Order",
                "created_by"=>"Approved",
                "approved_by"=> "Admin Outlet Bintaro (AT)",
                "receipt_number" => "Manager Outlet Bintaro (AT)",
                "issue_number"=>"2018-05-14 19:54:50",
                "log"=> "Integrated"
            )
         ); 
 
         $data = [
             "data"=> $dt
         ];
         
         echo json_encode($data);
     }
 
}
?>