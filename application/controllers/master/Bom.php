<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Bom extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }

    public function index()
    {
        $this->load->view('master/bom/list_view');
    }
	
	public function edit(){
        $this->load->view('master/bom/edit_form');
    }
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "bom_no" => "FDG0153",
            "bom_description"=>"Rice crispy ",
            "quantity"=> "200.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "2",
            "bom_no" => "FDG0099",
            "bom_description"=>"Gianduia/Hazelnut Paste ",
            "quantity"=> "140.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "3",
            "bom_no" => "FDG0207",
            "bom_description"=>"Chocolate couverture milk @20kg/ctn ",
            "quantity"=> "130.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "4",
            "bom_no" => "FDG0206",
            "bom_description"=>"Chocholate couverture dark @20kg/ctn",
            "quantity"=> "75.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "5",
            "bom_no" => "FDY0075",
            "bom_description"=>"Butter Unsalted Anchor ",
            "quantity"=> "25.00",
            "uom"=> "GR",
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
	
	public function bomItemData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "FDG0153",
            "material_description"=>"Rice crispy ",
            "quantity"=> "200.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "2",
            "material_no" => "FDG0099",
            "material_description"=>"Gianduia/Hazelnut Paste ",
            "quantity"=> "140.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "3",
            "material_no" => "FDG0207",
            "material_description"=>"Chocolate couverture milk @20kg/ctn ",
            "quantity"=> "130.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "4",
            "material_no" => "FDG0206",
            "material_description"=>"Chocholate couverture dark @20kg/ctn",
            "quantity"=> "75.00",
            "uom"=> "GR",
           ),
		   array(
            "no" => "5",
            "material_no" => "FDY0075",
            "material_description"=>"Butter Unsalted Anchor ",
            "quantity"=> "25.00",
            "uom"=> "GR",
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
	
	public function add(){
        $this->load->view('master/bom/add_form');
    }
}
?>