<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sr extends CI_Controller{
    public function __construct()
    {
        # code...
        parent::__construct();

        // load model
        $this->load->model("transaksi2/Sr_model","sr_model");
        
        $this->load->library('form_validation');
        $this->load->library('l_general');
    }

    public function index()
    {
        # code...
        $object['plants'] = $this->sr_model->showOutlet();
        $this->load->view("transaksi2/sr/list_view", $object);
    }

    public function showAllData(){
        $fromDate = $this->input->post('fDate');
        $toDate = $this->input->post('tDate');
        $status = $this->input->post('stts');
        $rto = $this->input->post('reqToOutlet');

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

        $rs = $this->sr_model->stdstock_headers($date_from2, $date_to2, $status,$rto);
        $data = array();

        // print_r($rs);

        foreach($rs as $key=>$val){
            $nestedData = array();
            $nestedData['id_stdstock_header'] = $val['id_stdstock_header'];
            $nestedData['id_stdstock_header'] = $val['id_stdstock_header'];
            $nestedData['id_stdstock_header'] = $val['id_stdstock_header'];
            $nestedData['pr_no'] = $val['pr_no'];
            $nestedData['request_to'] = $val['to_plant'].' - '.$val['OUTLET_NAME1'];
            $nestedData['created_date'] = date("d-m-Y",strtotime($val['created_date']));
            $nestedData['delivery_date'] = date("d-m-Y",strtotime($val['delivery_date']));
            $nestedData['request_reason'] = $val['request_reason'];
            $nestedData['status'] = $val['status'] =='1'?'Not Apporeed':'Approved';
            // $nestedData['status_string'] = $val['status'] =='1'?'Not Apporeed':'Approved';
            $nestedData['admin_realname'] = $val['user_input'];
            $nestedData['admin_realname(1)'] = $val['user_approved'] ? $val['user_approved'] : '-';
            $nestedData['lastmodified'] = date("d-m-Y",strtotime($val['lastmodified']));
            $nestedData['back'] = $val['back'] =='1'?'Integrated':'Not Integrated';
            $nestedData['stts'] = $val['status'];
            // $nestedData['dataInTo'] = $this->sr_model->cekNoSRinTO($val['pr_no']);
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
    $object['request_reasons'] = ['Order', 'Order Tambahan', 'Special Order', 'Big Order'];
    $object['plants'] = $this->sr_model->showOutlet();
    $object['matrialGroup'] = $this->sr_model->showMatrialGroup();
    $object['plant'] = $this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];
    $object['storage_location'] = $this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];
    
    $this->load->view('transaksi2/sr/add_view', $object);
    }


    function getdataDetailMaterial(){
        $item_group_code = $this->input->post('matGroup');
        
        $data = $this->sr_model->getDataMaterialGroup($item_group_code);

        echo json_encode($data);

    }

    function getdataDetailMaterialSelect(){
        $itemSelect = $this->input->post('MATNR');
        
        $dataMatrialSelect = $this->sr_model->getDataMaterialGroupSelect($itemSelect);

        echo json_encode($dataMatrialSelect);
        
    }

    public function addData(){
        $plant = $this->session->userdata['ADMIN']['plant'];
        $storage_location = $this->session->userdata['ADMIN']['storage_location'];
        $plant_name = $this->session->userdata['ADMIN']['plant_name'];
        $storage_location_name = $this->session->userdata['ADMIN']['storage_location_name'];
        $admin_id = $this->session->userdata['ADMIN']['admin_id'];

        $stdstock_header['delivery_date'] = $this->l_general->str_to_date($this->input->post('dateDeliv'));
        $stdstock_header['request_reason'] = $this->input->post('reqRes');
        $stdstock_header['item_group_code'] = $this->input->post('matGrp');
        $stdstock_header['to_plant'] = $this->input->post('reqToOutlet');
        $stdstock_header['created_date'] = $this->l_general->str_to_date($this->input->post('dateCreate'));
        $stdstock_header['plant'] = $plant;
        $stdstock_header['plant_name'] = $plant_name;
        $stdstock_header['storage_location_name'] = $storage_location_name ;
        $stdstock_header['storage_location'] = $storage_location ;
        $stdstock_header['id_stdstock_plant'] = $this->sr_model->id_stdstock_plant_new_select($stdstock_header['plant'],$stdstock_header['created_date']);
        $stdstock_header['status'] = $this->input->post('appr')? $this->input->post('appr') : '1';
        $stdstock_header['id_user_input'] = $admin_id;
        $stdstock_header['pr_no'] = '';
        $stdstock_header['id_user_approved'] = $this->input->post('appr')? $admin_id : 0;

        $stdstock_details['material_no'] = $this->input->post('detMatrialNo');
        $count = count($stdstock_details['material_no']);

        // print_r($count);
        if($id_stdstock_header= $this->sr_model->stdstock_header_insert($stdstock_header)){
            $input_detail_success = false;
            for($i =0; $i < $count; $i++){
                $stdstock_detail['id_stdstock_header'] = $id_stdstock_header;
                $stdstock_detail['id_stdstock_h_detail'] = $i+1;
                $stdstock_detail['requirement_qty'] = $this->input->post('detQty')[$i];
                $stdstock_detail['material_no'] = $this->input->post('detMatrialNo')[$i];
                $stdstock_detail['material_desc'] = $this->input->post('detMatrialDesc')[$i];
                $stdstock_detail['uom'] = $this->input->post('detUom')[$i];

                if($this->sr_model->stdstock_detail_insert($stdstock_detail))
                $input_detail_success = TRUE;
            }
        }

        if($input_detail_success){
            return $this->session->set_flashdata('success', "SR Telah Terbentuk");
        }else{
            return $this->session->set_flashdata('failed', "SR Gagal Terbentuk");
        }
    }

    public function edit(){
        $id_stdstock_header = $this->uri->segment(4);
        $object['plant_name'] = $this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];
        $object['storage_location_name'] = $this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];
        $object['data'] = $this->sr_model->stdstock_header_select($id_stdstock_header);

        $object['stdstock_header']['id_stdstock_header'] = $id_stdstock_header;

        if($object['data']['status'] == '1'){
            $object['stdstock_header']['status_string'] = 'Not Approved';                              
        }else if($object['data']['status'] == '2'){
            $object['stdstock_header']['status_string'] = 'Approved';
        }else{
            $object['stdstock_header']['status_string'] = 'Cancel';
        }
        $object['stdstock_header']['plant'] = $object['data']['plant'];
        $object['stdstock_header']['storage_location'] = $object['data']['storage_location'];
        $object['stdstock_header']['delivery_date'] = $object['data']['delivery_date'];
        $object['stdstock_header']['created_date'] = $object['data']['created_date'];
        $object['stdstock_header']['pr_no'] = $object['data']['pr_no'];
        $object['stdstock_header']['to_plant'] = $object['data']['to_plant'].' - '.$object['data']['OUTLET_NAME1'];
        $object['stdstock_header']['request_reason'] = $object['data']['request_reason'];
        $object['stdstock_header']['item_group_code'] = $object['data']['item_group_code'];
        $object['stdstock_header']['status'] = $object['data']['status'];

        // print_r($object['data']);
        // die();

        $this->load->view('transaksi2/sr/edit_view', $object);
    }

    public function showStdstockDetail(){
        $id_stdstock_header = $this->input->post('id');
        $stts = $this->input->post('status');
        $rs = $this->sr_model->stdstock_details_select($id_stdstock_header);
        $dt = array();
        $i = 1;
        if($rs){
            foreach($rs as $key=>$value){
                $nestedData=array();
                $nestedData['id_stdstock_detail'] = $value['id_stdstock_detail'];
                $nestedData['no'] = $i;
                $nestedData['material_no'] = $value['material_no'];
                $nestedData['material_desc'] = $value['material_desc'];
                $nestedData['requirement_qty'] = $value['requirement_qty'];
                $nestedData['uom'] = $value['uom'];
                $nestedData['OnHand'] = $value['OnHand'];
                $nestedData['MinStock'] = $value['MinStock'];
                $nestedData['OpenQty'] = $value['OpenQty']; 
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

    public function chageDataDB(){
        $id_stdstock_header = $this->input->post('idStdStock_header');
        $sum = count($this->input->post('idStdStock_detail'));
        $succes_update_detail = false;
        for($i = 0; $i < $sum; $i++){
            $stdstock_detail['id_stdstock_detail'] = $this->input->post('idStdStock_detail')[$i];
            $stdstock_detail['requirement_qty'] = $this->input->post('qty')[$i];
            if($this->sr_model->changeUpdateToDb($stdstock_detail))
            $succes_update_detail = true;
        }

        if($succes_update_detail){
            return $this->session->set_flashdata('success', "SR Berhasil di Update");
        }else{
            return $this->session->set_flashdata('failed', "SR Gagal di Update");
        } 
    }

    public function addDataUpdate(){
        $admin_id = $this->session->userdata['ADMIN']['admin_id'];

        $stdstock_header['id_stdstock_header'] = $this->input->post('idStdStock_header');
        $stdstock_header['delivery_date'] = $this->l_general->str_to_date($this->input->post('dateDeliv'));
        $stdstock_header['created_date'] = $this->l_general->str_to_date($this->input->post('dateCreate'));
        $stdstock_header['status'] = $this->input->post('appr')? $this->input->post('appr') : '1';
        $stdstock_header['id_user_approved'] = $this->input->post('appr')? $admin_id : 0;
        
        $stdstock_details['material_no'] = $this->input->post('detMatrialNo');
        $count = count($stdstock_details['material_no']);
        if($this->sr_model->stdstock_header_update($stdstock_header)){
            $update_detail_success = false;
            if($this->sr_model->stdstock_details_delete($stdstock_header['id_stdstock_header'])){
                for($i =0; $i < $count; $i++){
                    $stdstock_details['id_stdstock_header'] = $stdstock_header['id_stdstock_header'];
                    $stdstock_details['id_stdstock_h_detail'] = $i+1;
                    $stdstock_details['material_no'] = $this->input->post('detMatrialNo')[$i];
                    $stdstock_details['material_desc'] = $this->input->post('detMatrialDesc')[$i];
                    $stdstock_details['requirement_qty'] = $this->input->post('detQty')[$i];
                    $stdstock_details['uom'] = $this->input->post('detUom')[$i];

                    if($this->sr_model->stdstock_detail_insert($stdstock_details))
                    $update_detail_success = TRUE;
                }
            }
        }

        if($update_detail_success){
            return $this->session->set_flashdata('success', "SR Berhasil di Update");
        }else{
            return $this->session->set_flashdata('failed', "SR Gagal di Update");
        }
        // print_r( $stdstock_details['material_no']);
    }

    public function deleteData(){
        $id_stdstock_header = $this->input->post('deleteArr');
        $deleteData = false;
        foreach($id_stdstock_header as $id){
            $cek = $this->sr_model->stdstock_header_delete($id);
            if(!$cek){
                $json_data = array(
                    "message"         => 'Dokumen SR sudah ada di Transfer Out',
                    "data"            => $cek 
                );
                echo json_encode($json_data);
            }else{
                $deleteData = true;
                $json_data = array(
                    "data"            => $cek 
                );
                echo json_encode($json_data);
            }
            
        }

        if($deleteData){
            return $this->session->set_flashdata('success', "SR Berhasil dihapus");
        }else{
            return $this->session->set_flashdata('failed', "SR Gagal dihapus");
        }
    }

    public function printpdf()
	{
        
        $id_stdstock_header = $this->uri->segment(4);
		// $this->load->model('m_SR');
		//$this->load->model('m_stdstock');
		//$stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);
        $data['data'] = $this->sr_model->tampil($id_stdstock_header);
        $data['name'] = $this->sr_model->userApproved($data['data'][0]['id_user_approved']);
        
        // print_r($data['name']); 
        // die();
		
		ob_start();
		$content = $this->load->view('transaksi2/sr/store_room',$data);
		$content = ob_get_clean();		
        // $this->load->library('html2pdf/html2pdf.php');
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
 
}
?>