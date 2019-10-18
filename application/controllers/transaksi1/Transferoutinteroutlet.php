<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Transferoutinteroutlet extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }

    public function index()
    {
        $this->load->view('transaksi1/eksternal/transferoutinteroutlet/list_view');
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
            "qc"=> ""
           ),
		   array(
            "no" => "2",
            "material_no" => "EAT0001",
            "material_desc"=>"ABC Alkaline AAA (Active)",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> "",
           ),
		   array(
            "no" => "3",
            "material_no" => "EAT0002 ",
            "material_desc"=>"ABC Battery AA Kecil (Active)",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> "",
           ),
		   array(
            "no" => "4",
            "material_no" => "EAT0007",
            "material_desc"=>"Amplop Cashier Remitance (Active)",
            "quantity"=> "4.0000",
            "gr_qty"=> "4.000",
            "uom"=> "pcs",
            "qc"=> ""
           ),
		   array(
            "no" => "5",
            "material_no" => "EAT0008",
            "material_desc"=>" 	Amplop coklat folio (Active)",
            "quantity"=> "1.0000",
            "gr_qty"=> "1.000",
            "uom"=> "pcs",
            "qc"=> ""
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>