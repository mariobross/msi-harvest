<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller{
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
        $this->load->model('transaksi1/stock_model', 'st_model');
    }

    public function index()
    {
        # code...
        
        $this->load->view("transaksi1/stock_outlet/stock/list_view");
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

        $rs = $this->st_model->t_opname_headers($date_from2, $date_to2, $status);
		$data = array();
		
		// print_r($rs[0]);
		$status_string='';

        foreach($rs as $key=>$val){
			if($val['status'] =='1'){
				$status_string= 'Not Approved';
			}else if($val['status'] =='2'){
				$status_string= 'Approved';
			}else{
				$status_string= 'Cancel';
			}

            $nestedData = array();
            $nestedData['id_opname_header'] = $val['id_opname_header'];
            $nestedData['opname_no'] = $val['opname_no'];
            $nestedData['created_date'] = date("d-m-Y",strtotime($val['created_date']));
            $nestedData['posting_date'] = date("d-m-Y",strtotime($val['posting_date']));
            $nestedData['request_reason'] = $val['request_reason'];
            $nestedData['status'] = $status_string; 
            $nestedData['created_by'] = $val['user_input'];
            $nestedData['approved_by'] = $val['user_approved'];
            $nestedData['last_modified'] = date("d-m-Y",strtotime($val['lastmodified']));
            $nestedData['to_plant'] = $val['to_plant'];
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

    public function add(){
        # code...
        $object['request_reason'] = ['Pastry', 'Cake Shop', 'Store', 'Bar'];
		$object['matrialGroup'] = $this->st_model->showMatrialGroup();
		$object['plant'] = $this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];
    	$object['storage_location'] = $this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];
    
        $this->load->view('transaksi1/stock_outlet/stock/add_view', $object);
    }

    public function addData(){
        $plant = $this->session->userdata['ADMIN']['plant'];
        $storage_location = $this->session->userdata['ADMIN']['storage_location'];
        $plant_name = $this->session->userdata['ADMIN']['plant_name'];
        $storage_location_name = $this->session->userdata['ADMIN']['storage_location_name'];
        $admin_id = $this->session->userdata['ADMIN']['admin_id'];

        $opname_header['posting_date'] = $this->l_general->str_to_date($this->input->post('postDate'));
        $opname_header['status'] = $this->input->post('appr')? $this->input->post('appr') : '1';
        $opname_header['item_group_code'] = $this->input->post('matGroup');
        $opname_header['created_date'] = date('Y-m-d');
        $opname_header['plant'] = $plant;
        $opname_header['plant_name'] = $plant_name;
        $opname_header['storage_location_name'] = $storage_location_name ;
        $opname_header['storage_location'] = $storage_location ;
        $opname_header['id_opname_plant'] = $this->st_model->id_opname_plant_new_select($opname_header['plant'],$opname_header['created_date']);
        $opname_header['id_user_input'] = $admin_id;
        $opname_header['opname_no'] = '';
        $opname_header['id_user_approved'] = $this->input->post('appr')? $admin_id : 0;

        $opname_details['material_no'] = $this->input->post('detMatrialNo');
        $count = count($opname_details['material_no']);

        // print_r($count);
        if($id_opname_header= $this->st_model->opname_header_insert($opname_header)){
            $input_detail_success = false;
            for($i =0; $i < $count; $i++){
                $opname_detail['id_opname_header'] = $id_opname_header;
                $opname_detail['id_opname_h_detail'] = $i+1;
                $opname_detail['material_no'] = $this->input->post('detMatrialNo')[$i];
                $opname_detail['material_desc'] = $this->input->post('detMatrialDesc')[$i];
                $opname_detail['requirement_qty'] = $this->input->post('detQty')[$i];
                $opname_detail['uom'] = $this->input->post('detUom')[$i];

                if($this->st_model->opname_detail_insert($opname_detail))
                $input_detail_success = TRUE;
            }
        }

        if($input_detail_success){
            return $this->session->set_flashdata('success', "Purchase Request Telah Terbentuk");
        }else{
            return $this->session->set_flashdata('failed', "Purchase Request Gagal Terbentuk");
        }
    }

    public function edit(){
        $id_opname_header = $this->uri->segment(4);
        $object['plant_name'] = $this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];
		$object['storage_location_name'] = $this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];
		$object['data'] = $this->st_model->opname_header_select($id_opname_header);
		$object['opname_header']['id_opname_header'] = $id_opname_header;

        if($object['data']['status'] == '1'){
            $object['opname_header']['status_string'] = 'Not Approved';                              
        }else if($object['data']['status'] == '2'){
            $object['opname_header']['status_string'] = 'Approved';
        }else{
            $object['opname_header']['status_string'] = 'Cancel';
		}
		
        $object['opname_header']['posting_date'] = $object['data']['posting_date'];
        $object['opname_header']['opname_no'] = $object['data']['opname_no'];
        $object['opname_header']['request_reason'] = $object['data']['request_reason'];
        $object['opname_header']['item_group_code'] = $object['data']['item_group_code'];
        $object['opname_header']['status'] = $object['data']['status'];
        $this->load->view('transaksi1/stock_outlet/stock/edit_view', $object);
    }

    public function showStockDetail(){
        $id_opname_header = $this->input->post('id');
        $stts = $this->input->post('status');
        $rs = $this->st_model->opname_details_select($id_opname_header);
        $dt = array();
        $i = 1;
        if($rs){
            foreach($rs as $key=>$value){
                $nestedData=array();
                $nestedData['id_opname_detail'] = $value['id_opname_detail'];
                $nestedData['no'] = $i;
                $nestedData['material_no'] = $value['material_no'];
                $nestedData['material_desc'] = $value['material_desc'];
                $nestedData['requirement_qty'] = $value['requirement_qty'];
                $nestedData['status'] = $stts; 
                $dt[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
                "data" => $dt
            );
            echo json_encode($json_data) ;
    }
    
    function getdataDetailMaterial(){
		$item_group_code = $this->input->post('matGroup');
		
		if($item_group_code == 'all'){
			$data = $this->st_model->sap_item_groups_select_all_grnonpo();
		}else{
			$data = $this->st_model->sap_items_select_by_item_group($item_group, 'stock');
		}
        echo json_encode($data);

	}
	
	function getdataDetailMaterialSelect(){
        $itemSelect = $this->input->post('MATNR');
        
        $dataMatrialSelect = $this->st_model->sap_item_groups_select_all_grnonpo($itemSelect);

        echo json_encode($dataMatrialSelect);
        
    }
    
    public function chageDataDB(){
        $id_opname_header = $this->input->post('idopname_header');
        $sum = count($this->input->post('idopname_detail'));
        $succes_update_detail = false;
        for($i = 0; $i < $sum; $i++){
            $opname_detail['id_opname_detail'] = $this->input->post('idopname_detail')[$i];
            $opname_detail['requirement_qty'] = $this->input->post('qty')[$i];
            if($this->st_model->changeUpdateToDb($opname_detail))
            $succes_update_detail = true;
        }

        if($succes_update_detail){
            return $this->session->set_flashdata('success', "Stock Opname Berhasil di Update");
        }else{
            return $this->session->set_flashdata('failed', "Stock Opname Gagal di Update");
        } 
    }
    
    public function addDataUpdate(){
        $admin_id = $this->session->userdata['ADMIN']['admin_id'];

        $opname_header['id_opname_header'] = $this->input->post('idopname_header');
        $opname_header['posting_date'] = $this->l_general->str_to_date($this->input->post('postDate'));
        $opname_header['status'] = $this->input->post('appr')? $this->input->post('appr') : '1';
        $opname_header['id_user_approved'] = $this->input->post('appr')? $admin_id : 0;
        
        $opname_detail['material_no'] = $this->input->post('detMatrialNo');
        $count = count($opname_detail['material_no']);
        if($this->st_model->opname_header_update($opname_header)){
            $update_detail_success = false;
            if($this->st_model->opname_details_delete($opname_header['id_opname_header'])){
                for($i =0; $i < $count; $i++){
                    $opname_detail['id_opname_header'] = $opname_header['id_opname_header'];
                    $opname_detail['id_opname_h_detail'] = $i+1;
                    $opname_detail['material_no'] = $this->input->post('detMatrialNo')[$i];
                    $opname_detail['material_desc'] = $this->input->post('detMatrialDesc')[$i];
                    $opname_detail['requirement_qty'] = $this->input->post('detQty')[$i];

                    if($this->st_model->opname_detail_insert($opname_detail))
                    $update_detail_success = TRUE;
                }
            }
        }

        if($update_detail_success){
            return $this->session->set_flashdata('success', "Stock Opname Berhasil di Update");
        }else{
            return $this->session->set_flashdata('failed', "Stock Opname Gagal di Update");
        }
    }

    public function deleteData(){
        $id_opname_header = $this->input->post('deleteArr');
        $deleteData = false;
        foreach($id_opname_header as $id){
            if($this->st_model->t_opname_header_delete($id))
            $deleteData = true;
        }
        
        if($deleteData){
            return $this->session->set_flashdata('success', "Stock Opname Berhasil dihapus");
        }else{
            return $this->session->set_flashdata('failed', "Stock Opname Gagal dihapus");
        }
    }
    
    function printpdf(){
		$id_opname_header = $this->uri->segment(4);
		$data['data'] = $this->st_model->tampil($id_opname_header);

		// print_r($data);
		// die();
		
		ob_start();
		$content = $this->load->view('transaksi1/stock_outlet/stock/printpdf_view',$data);
		$content = ob_get_clean();		
		// $this->load->library('html2pdf');
		require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'A4', 'en');
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
 
}
?>