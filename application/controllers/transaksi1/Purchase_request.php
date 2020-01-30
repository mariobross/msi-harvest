<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_request extends CI_Controller{
    public function __construct()
    {
        # code...
        parent::__construct();
        $this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->load->library('l_general');

        // load model
        $this->load->model('transaksi1/purchase_model', 'pr_model');
    }

    public function index()
    {
        # code...
        $this->load->view("transaksi1/eksternal/purchase_request/list_view");
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

        $rs = $this->pr_model->t_pr_headers($date_from2, $date_to2, $status);
		$data = array();
		
		// print_r($rs[0]);
		$status_string='';

        foreach($rs as $key=>$val){
			if($val['status'] =='1'){
				$status_string= 'Not Apporeed';
			}else if($val['status'] =='2'){
				$status_string= 'Apporeed';
			}else{
				$status_string= 'Cancel';
			}

            $nestedData = array();
            $nestedData['id_pr_header'] = $val['id_pr_header'];
            $nestedData['pr_no'] = $val['pr_no'];
            $nestedData['created_date'] = date("d-m-Y",strtotime($val['created_date']));
            $nestedData['delivery_date'] = date("d-m-Y",strtotime($val['delivery_date']));
            $nestedData['request_reason'] = $val['request_reason'];
            $nestedData['status'] = $status_string; 
            $nestedData['created_by'] = $val['user_input'];
            $nestedData['approved_by'] = $val['user_approved'];
            $nestedData['last_modified'] = date("d-m-Y",strtotime($val['lastmodified']));
            $nestedData['po_print'] = '';
            $nestedData['po'] = '';
            $nestedData['back'] = $val['back'] =='1'?'Integrated':'Not Integrated';
            $nestedData['status_real'] = $val['status'];
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
         $this->load->view('transaksi1/eksternal/purchase_request/add_view');
     }

     public function edit(){
        $this->load->view('transaksi1/eksternal/purchase_request/edit_view');
    }

    public function printpdf()
	{
		$id_pr_header = $this->uri->segment(4);
		$data['data'] = $this->pr_model->tampil($id_pr_header);

		// print_r($data);
		// die();
		
		ob_start();
		$content = $this->load->view('transaksi1/eksternal/purchase_request/printpdf_view',$data);
		$content = ob_get_clean();		
		// $this->load->library('html2pdf');
		require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'F4', 'en');
			$html2pdf->setTestTdInOnePage(false);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('print.pdf');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
    }
    
    public function printpdfPO()
	{
		$id_pr_header = $this->uri->segment(4);
		$data['data'] = $this->pr_model->tampil($id_pr_header);

		// print_r($data);
		// die();
		
		ob_start();
		$content = $this->load->view('transaksi1/eksternal/purchase_request/printpdfPO_view',$data);
		$content = ob_get_clean();		
		// $this->load->library('html2pdf');
		require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'F4', 'en');
			$html2pdf->setTestTdInOnePage(false);
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('print PO.pdf');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
	}

	public function excel()
	{
		$id_pr_header = $this->uri->segment(4);
		$data['data'] = $this->pr_model->tampil($id_pr_header);
		
		ob_start();
	   	$this->load->view('transaksi1/eksternal/purchase_request/printexcel_view',$data);
		
		
	}
 
}
?>