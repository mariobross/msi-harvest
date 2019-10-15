<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Integration extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('integration_model');
    }

    public function index()
    {
        $this->load->view('master/integration_log/list_view');
    }

    public function add(){
        $this->load->view('master/integration_log/add_form');
    }
	
	public function edit(){
        $this->load->view('master/integration_log/edit_form');
    }
	
	public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "modul" => "Good Issue",
            "message"=>"Quantity falls into negative inventory [IGE1.ItemCode][line: 42]",
            "error_time"=> "2019-10-13 21:35:04",
            "trans_id"=> "42377"
           ),
		   array(
            "no" => "2",
            "modul" => "Good Issue from Production",
            "message"=>"Quantity falls into negative inventory [IGE1.ItemCode][line: 2]",
            "error_time"=> "2019-10-12 14:49:09",
            "trans_id"=> "1449245"
           ),
		   array(
            "no" => "3",
            "modul" => "Good Issue",
            "message"=>"Quantity falls into negative inventory [IGE1.ItemCode][line: 28]",
            "error_time"=> "2019-10-09 21:25:04",
            "trans_id"=> "42159"
           ),
		   array(
            "no" => "4",
            "modul" => "Good Issue",
            "message"=>"Quantity falls into negative inventory [IGE1.ItemCode][line: 26]",
            "error_time"=> "2019-10-07 19:55:05",
            "trans_id"=> "41939"
           ),
		   array(
            "no" => "5",
            "modul" => "Good Issue from Whole Outlet",
            "message"=>"Quantity falls into negative inventory [IGE1.ItemCode][line: 1]",
            "error_time"=> "2019-10-06 20:04:06",
            "trans_id"=> "138497"
           ),
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
	
	public function goodIssueData(){
       $dt= array(
           array(
            "no" => "1",
            "issue_no" => "TH-FGB003",
            "material"=>"Tuna Fish Bun ",
            "whs_qty"=> "12.00",
            "qty"=> "3.00",
            "uom"=> "pcs",
            "reason"=> "Outlet Sales ",
            "other_reason"=> ""
           ),
		   array(
            "no" => "2",
            "issue_no" => "TH-FGB018",
            "material"=>"Cheese Croissant  ",
            "whs_qty"=> "9.00",
            "qty"=> "3.00",
            "uom"=> "pcs",
            "reason"=> "Outlet Sales ",
            "other_reason"=> ""
           ),
		   array(
            "no" => "3",
            "issue_no" => "TH-FGB014",
            "material"=>"Chocolate Cheese-TH ",
            "whs_qty"=> "7.00",
            "qty"=> "3.00",
            "uom"=> "pcs",
            "reason"=> "Outlet Sales ",
            "other_reason"=> ""
           ),
		   array(
            "no" => "4",
            "issue_no" => "TH-FGB022",
            "material"=>"Peach Danish ",
            "whs_qty"=> "10.00",
            "qty"=> "3.00",
            "uom"=> "pcs",
            "reason"=> "Outlet Sales ",
            "other_reason"=> ""
           ),
		   array(
            "no" => "5",
            "issue_no" => "TH-FGB020",
            "material"=>"Strawberry Danish ",
            "whs_qty"=> "8.00",
            "qty"=> "3.00",
            "uom"=> "pcs",
            "reason"=> "Outlet Sales ",
            "other_reason"=> ""
           ),
		   
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }
}
?>