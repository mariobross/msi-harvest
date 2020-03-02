<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Returnout extends CI_Controller{
    public function __construct()
    {
        # code...
        parent::__construct();
        $this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }

        // load model
        // $this->load->model("");
        $this->load->library('form_validation');

        $this->load->model('transaksi1/returnOut_model', 'retOut_model');
    }

    public function index()
    {
        # code...
        
        $this->load->view("transaksi1/eksternal/returnout/list_view");
    }

    public function showAllData(){
        $fromDate = $this->input->post('fDate');
        $toDate = $this->input->post('tDate');
        $status = $this->input->post('stts');

        $date_from2;
        $date_to2;

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

        $rs = $this->retOut_model->getDataReturnOut_Header($date_from2, $date_to2, $status);
		$data = array();
		
		// print_r($rs[0]);
        $status_string='';
        $log = '';

        foreach($rs as $key=>$val){
			if($val['status'] =='1'){
				$status_string= 'Not Apporeed';
			}else if($val['status'] =='2'){
				$status_string= 'Apporeed';
			}else{
				$status_string= 'Cancel';
            }
            
            if ($val['back'] == 0 && $val['gisto_dept_no'] !='' && $val['gisto_dept_no'] !='C')
            {
                $log = "Integrated";
            }else if ($val['back'] == 1 && ($val['gisto_dept_no'] =='' || $val['gisto_dept_no'] =='C'))
            {
                $log = "Not Integrated";
            }else if ($val['back'] == 0 &&  $val['gisto_dept_no'] =='C')
            {
                $log ="Close Document";
            }

            $nestedData = array();
            $nestedData['id_gisto_dept_header'] = $val['id_gisto_dept_header'];
            $nestedData['gisto_dept_no'] = $val['gisto_dept_no'];
            $nestedData['posting_date'] = date("d-m-Y",strtotime($val['posting_date']));
            $nestedData['receiving_plant'] = $val['receiving_plant'].' - '.$val['receiving_plant_name'];
            $nestedData['status'] = $val['status'];
            $nestedData['status_string'] = $status_string; 
            $nestedData['user_input'] = $val['user_input'];
            $nestedData['user_approved'] = $val['user_approved'];
            $nestedData['lastmodified'] = $val['lastmodified'];
            $nestedData['log'] = $log;
            $data[] = $nestedData;

        }

        $json_data = array(
            "recordsTotal"    =>  10, 
            "recordsFiltered" => 12,
            "data"            => $data 
        );
        echo json_encode($json_data);
     }

     public function add()
     {
         # code...
         $this->load->view('transaksi1/eksternal/returnout/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/eksternal/returnout/edit_view');
    }
}
?>