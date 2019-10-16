<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Grnopo extends CI_Controller{
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
        
        $this->load->view("transaksi1/eksternal/grnopo/list_view");
    }

    public function showAllData(){
        $dt= array(
            array(
                "no" => "209",
                "action" => "209",
                "id" => "209",
                "grnopo" => "1274441",
                "posting_date"=>"28-08-2018",
                "status"=> "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "209",
                "action" => "209",
                "id" => "209",
                "grnopo" => "1274441",
                "posting_date"=>"28-08-2018",
                "status"=> "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "209",
                "action" => "209",
                "id" => "209",
                "grnopo" => "1274441",
                "posting_date"=>"28-08-2018",
                "status"=> "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "209",
                "action" => "209",
                "id" => "209",
                "grnopo" => "1274441",
                "posting_date"=>"28-08-2018",
                "status"=> "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "209",
                "action" => "209",
                "id" => "209",
                "grnopo" => "1274441",
                "posting_date"=>"28-08-2018",
                "status"=> "Approved",
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
         $this->load->view('transaksi1/eksternal/grnopo/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/eksternal/grnopo/edit_view');
    }
}
?>