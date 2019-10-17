<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Spoiled extends CI_Controller{
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
        
        $this->load->view("transaksi1/stock_outlet/spoiled/list_view");
    }

    public function showAllData(){
        $dt= array(
            array(
                "no" => "202",
                "action" => "202",
                "id" => "202",
                "date" => "118892",
                "item_no"=>"28-08-2018",
                "item_description"=> "Approved"
            ),
            array(
                "no" => "202",
                "action" => "202",
                "id" => "202",
                "date" => "118892",
                "item_no"=>"28-08-2018",
                "item_description"=> "Approved"
            ),
            array(
                "no" => "202",
                "action" => "202",
                "id" => "202",
                "date" => "118892",
                "item_no"=>"28-08-2018",
                "item_description"=> "Approved"
            ),
            array(
                "no" => "202",
                "action" => "202",
                "id" => "202",
                "date" => "118892",
                "item_no"=>"28-08-2018",
                "item_description"=> "Approved"
            ),
            array(
                "no" => "202",
                "action" => "202",
                "id" => "202",
                "date" => "118892",
                "item_no"=>"28-08-2018",
                "item_description"=> "Approved"
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
         $this->load->view('transaksi1/stock_outlet/spoiled/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/stock_outlet/spoiled/edit_view');
    }
 
}
?>