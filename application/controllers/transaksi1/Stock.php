<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller{
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
        
        $this->load->view("transaksi1/stock_outlet/stock/list_view");
    }

    public function showAllData(){
        $dt= array(
            array(
                "no" => "99",
                "action" => "99",
                "id" => "99",
                "date" => "",
                "item_no"=>"09-07-2018",
                "item_description"=> "Not Approved",
                "createdBy" => "Ahmad Faisal",
                "approvedBy" => "-",
                "lastModified" => "2018-07-09 18:01:25",
                "log" => ""

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
         $this->load->view('transaksi1/stock_outlet/stock/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/stock_outlet/stock/edit_view');
    }
 
}
?>