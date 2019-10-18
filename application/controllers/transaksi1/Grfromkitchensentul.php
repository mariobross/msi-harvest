<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Grfromkitchensentul extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }

    public function index()
    {
        $this->load->view('transaksi1/eksternal/grfromkitchensentul/list_view');
    }
	
	public function add()
    {
        $this->load->view('transaksi1/eksternal/grfromkitchensentul/add_new');
    }
	
	public function edit()
    {
        $this->load->view('transaksi1/eksternal/grfromkitchensentul/edit_view');
    }
	
	public function showlistData(){
        $dt= array(
            array(
                "no" => "1095",
                "action" => "1095",
                "id" => "1095",
                "transfer_slip_no" => "8968",
                "gr_no"=>"10128",
                "delivery_date"=> "26-05-2018",
                "posting_date"=> "26-05-2018",
                "status" => "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1095",
                "action" => "1095",
                "id" => "1095",
                "transfer_slip_no" => "8968",
                "gr_no"=>"10128",
                "delivery_date"=> "26-05-2018",
                "posting_date"=> "26-05-2018",
                "status" => "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1095",
                "action" => "1095",
                "id" => "1095",
                "transfer_slip_no" => "8968",
                "gr_no"=>"10128",
                "delivery_date"=> "26-05-2018",
                "posting_date"=> "26-05-2018",
                "status" => "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1095",
                "action" => "1095",
                "id" => "1095",
                "transfer_slip_no" => "8968",
                "gr_no"=>"10128",
                "delivery_date"=> "26-05-2018",
                "posting_date"=> "26-05-2018",
                "status" => "Approved",
                "log"=> "Integrated"
            ),
            array(
                "no" => "1095",
                "action" => "1095",
                "id" => "1095",
                "transfer_slip_no" => "8968",
                "gr_no"=>"10128",
                "delivery_date"=> "26-05-2018",
                "posting_date"=> "26-05-2018",
                "status" => "Approved",
                "log"=> "Integrated"
            )
         ); 
 
         $data = [
             "data"=> $dt
         ];
         
         echo json_encode($data);
     }
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00"
           ),
		   array(
            "no" => "2",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00"
           ),
		   array(
            "no" => "3",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00"
           ),
		   array(
            "no" => "4",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00"
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
	
	public function showEditData(){
       $dt= array(
           array(
            "no" => "1",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00",
            "cancel"=> ""
           ),
		   array(
            "no" => "2",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00",
			"cancel"=> ""
           ),
		   array(
            "no" => "3",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00",
			"cancel"=> ""
           ),
		   array(
            "no" => "4",
            "material_no" => "AT-FDG0159",
            "material_desc"=>"Blueberry Jam @5000gr/pail (Almondtree)",
            "quantity"=> "15,000.00",
            "gr_qty"=> "15000.00",
            "uom"=> "pcs",
            "val"=> "",
            "variance"=> "0.00",
			"cancel"=> ""
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>