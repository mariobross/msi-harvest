<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodissue extends CI_Controller{
    public function __construct()
    {
        # code...
        parent::__construct();

        $this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
        // load model
        $this->load->model('transaksi1/goodissue_model', 'gi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        # code...
        
        $this->load->view("transaksi1/eksternal/goodissue/list_view");
    }

    public function showAllData(){
        $fromDate = $this->input->post('fDate');
        $toDate = $this->input->post('tDate');
        $status = $this->input->post('stts');

        $date_from2;
        $date_to2;

		$status_string='';
        $data = array();

        if($fromDate != '') {
			$year = substr($fromDate, 6);
			$month = substr($fromDate, 3,2);
			$day = substr($fromDate, 0,2);
			$date_from2 = $year.'-'.$day.'-'.$month.' 00:00:00';
        }else{
            $date_from2='';
        }

        if($toDate != '') {
			$year = substr($toDate, 6);
			$month = substr($toDate, 3,2);
			$day = substr($toDate, 0,2);
			$date_to2 = $year.'-'.$day.'-'.$month.' 23:59:59';
        }else{
            $date_to2='';
        }

        $gi = $this->gi_model->getDataGI_Header($date_from2, $date_to2, $status);

        foreach ($gi as $val) {
            if($val['status'] =='1'){
				$status_string= 'Not Approved';
			}elseif($val['status'] =='2'){
				$status_string= 'Approved';
			}else{
				$status_string= 'Cancel';
            }
            $giData = array();
            $giData['id_issue_header'] = $val['id_issue_header'];
            $giData['posting_date'] = date("d-m-Y",strtotime($val['posting_date']));
            $giData['status'] = $val['status'];
            $giData['status_string'] = $status_string; 
            $data[] = $giData;
        }
        // $dt= array(
        //     array(
        //         "no" => "7225",
        //         "action" => "7225",
        //         "id" => "7225",
        //         "issue_no" => "71121",
        //         "posting_date"=>"01-08-2018",
        //         "status"=> "Approved",
        //         "log"=>"Integrated"
        //     ),
        //     array(
        //         "no" => "7225",
        //         "action" => "7225",
        //         "id" => "7225",
        //         "issue_no" => "71121",
        //         "posting_date"=>"01-08-2018",
        //         "status"=> "Approved",
        //         "log"=>"Integrated"
        //     ),
        //     array(
        //         "no" => "7225",
        //         "action" => "7225",
        //         "id" => "7225",
        //         "issue_no" => "71121",
        //         "posting_date"=>"01-08-2018",
        //         "status"=> "Approved",
        //         "log"=>"Integrated"
        //     ),
        //     array(
        //         "no" => "7225",
        //         "action" => "7225",
        //         "id" => "7225",
        //         "issue_no" => "71121",
        //         "posting_date"=>"01-08-2018",
        //         "status"=> "Approved",
        //         "log"=>"Integrated"
        //     ),
        //     array(
        //         "no" => "7225",
        //         "action" => "7225",
        //         "id" => "7225",
        //         "issue_no" => "71121",
        //         "posting_date"=>"01-08-2018",
        //         "status"=> "Approved",
        //         "log"=>"Integrated"
        //     )
        //  ); 
 
         $json_data = array(
            "recordsTotal"    => 10, 
            "recordsFiltered" => 12,
            "data"            => $data 
         );
         echo json_encode($json_data);
     }

     public function add()
     {
         # code...
         $this->load->view('transaksi1/eksternal/goodissue/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/eksternal/goodissue/edit_view');
    }
 
}
?>