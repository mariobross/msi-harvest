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
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "AT-MBP0001",
            "material_desc"=>"Box 10x20-AT (Active)",
            "gi_qty"=> "200.00",
            "gr_qty"=> "200.00",
            "uom"=> "pcs",
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
            "val"=> "",
            "variance"=> "0.00",
           ),
		   
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>