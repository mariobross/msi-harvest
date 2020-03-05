<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Grfromkitchensentul extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
        $this->load->library('form_validation');
        // $this->load->library('l_general');
        //load model
        $this->load->model('transaksi1/Grfromkitchensentul_model','dokitchen');
    }

    public function index()
    {
        $this->load->view('transaksi1/eksternal/grfromkitchensentul/list_view');
    }
	
	public function add()
    {
        // $data['do_nos'] = $this->dokitchen->sap_grpodlv_headers_select_by_kd_do();
        // if($data['do_nos'] != FALSE) {
		// 	$object['do_no'][0] = '';
		// 	foreach ($data['do_nos'] as $do_no) {
		// 		$object['do_no'][$do_no['VBELN']] = $do_no['VBELN'].' - '.$do_no['Doc_Num'];
		// 	}
        // }
        
        // if(!empty($data['do_no'])) {
		// 	$object['data']['grpodlv_header'] = $this->dokitchen->sap_grpodlv_header_select_by_do_no($data['do_no']);
		// 	$data['delivery_date'] = $object['data']['grpodlv_header']['DELIV_DATE'];
		// 	$data['to_plant'] = $object['data']['grpodlv_header']['PLANT'];
        //     //echo $data['to_plant'];
        //     $data['item_groups'] = $this->dokitchen->sap_grpodlv_select_item_group_do($data['do_no']);

   		// 	$object['item_group_code'][0] = '';
   		// 	$object['item_group_code']['all'] = '==All==';

    	// 	if($data['item_groups'] !== FALSE) {
    	// 		foreach ($data['item_groups'] as $item_group) {
    	// 		   $object['item_group_code'][$item_group] = $item_group;
    	// 		}
    	// 	}
        // }

        $data['do_nos'] = $this->dokitchen->sap_grpodlv_headers_select_slip_number(); 
        $object['do_no']['-'] = '';
        if($data['do_nos'] != FALSE) {
            foreach ($data['do_nos'] as $do_no) {
                $object['do_no'][$do_no['VBELN']] = $do_no['VBELN'] .' - '.$do_no['Doc_Num'];
            }
        }    
        $this->load->view('transaksi1/eksternal/grfromkitchensentul/add_new', $object);
    }

    public function getDataListHeader(){
        $ItmsGrpNam = $this->input->post('ItmsGrpNam');
        $U_DocNum = $this->input->post('U_DocNum');

        $data = $this->dokitchen->sap_grpodlv_headers_select_slip_number($U_DocNum, $ItmsGrpNam);
        
        $json_data = array(
            "data" => $data,
        );
        echo json_encode($json_data) ;
    }

    public function saveDataGR(){

        $plant = $this->session->userdata['ADMIN']['plant'];
        $storage_location = $this->session->userdata['ADMIN']['storage_location'];
        $plant_name = $this->session->userdata['ADMIN']['plant_name'];
        $storage_location_name = $this->session->userdata['ADMIN']['storage_location_name'];
        $admin_id = $this->session->userdata['ADMIN']['admin_id'];

        $input_detail_success = FALSE;

        $Header = $this->input->post('Header');
        $Detail = $this->input->post('Detail');

        $this->db->trans_start();

        $delivery_date = strtotime($Header['delivery_date']);
        $delivery_date = date("Y-m-d", $delivery_date);

        $posting_date = strtotime($Header['posting_date']);
        $posting_date = date("Y-m-d", $posting_date);

        $grpodlv_header['do_no'] = $Header['do_no'];
        $grpodlv_header['delivery_date'] = $delivery_date;
        $grpodlv_header['plant'] = $plant;
        $grpodlv_header['storage_location'] = $storage_location;
        $grpodlv_header['posting_date'] = $posting_date;
        $grpodlv_header['status'] = $Header['status'] ? $Header['status'] : '1';
        $grpodlv_header['id_user_input'] = $Header['id_user_input'];
        $grpodlv_header['item_group_code'] = $Header['item_group_code'];        
        $grpodlv_header['id_grpodlv_plant'] = $this->dokitchen->id_grpodlv_plant_new_select($Header['plant'],$posting_date);

        //echo json_encode($grpodlv_detail);
        if($id_grpodlv_header = $this->dokitchen->grpodlv_header_insert($grpodlv_header)) { 
            
            if(count($Detail)) {

                $grpodlv_detail_to_save['id_grpodlv_header'] = $id_grpodlv_header;

                foreach($Detail as $itemDetail){
                    
                    $grpodlv_detail = $this->dokitchen->sap_grpodlv_details_select_by_do_and_item($Header['do_no'], $itemDetail['item']);


                    $grpodlv_detail_to_save['id_grpodlv_h_detail'] = $itemDetail['id_grpodlv_h_detail']; 
                    $grpodlv_detail_to_save['item'] = $itemDetail['item']; 
                    $grpodlv_detail_to_save['material_no'] = $itemDetail['material_no'];
                    $grpodlv_detail_to_save['material_desc'] = $itemDetail['material_desc'];
                    // $grpodlv_detail_to_save['outstanding_qty'] = $itemDetail['gr_qty'];
                    $grpodlv_detail_to_save['gr_quantity'] = $itemDetail['gr_qty'];
                    $grpodlv_detail_to_save['uom'] = $itemDetail['uom'];
                    $grpodlv_detail_to_save['val'] = '0';
                    $grpodlv_detail_to_save['var'] = '0';
                    $grpodlv_detail_to_save['ok'] = '1';

                    if ($grpodlv_detail['LFIMG'] >= $itemDetail['gr_qty'])
                    {
                        $grpodlv_detail_to_save['outstanding_qty'] = $grpodlv_detail['LFIMG'] - $itemDetail['gr_qty'];
                    }
                    else
                    {
                        $grpodlv_detail_to_save['outstanding_qty'] = $grpodlv_detail['LFIMG'];
                    }

                    $resData = $this->dokitchen->getDataQtyU_grqty_web($Header['do_no'], $itemDetail['item']);                    
                    $gr_qty1=$resData['U_grqty_web'];

                    $outstanding =$grpodlv_detail['LFIMG'];
                    $gr_qty = $gr_qty1 + $itemDetail['gr_qty'];

                    if($this->dokitchen->grpodlv_detail_insert($grpodlv_detail_to_save)) {

                        $input_detail_success = TRUE;

                        if($grpodlv_header['status'] > 1) {

                            if($outstanding == 0){

                                $Update_StatOwtr = array (
                                    'U_Stat'    => 1
                                );
                                $this->dokitchen->Update_StatOwtr($Update_StatOwtr, $Header['do_no']); 
                            }

                            $cekvar = $grpodlv_detail_to_save['outstanding_qty'] + $gr_qty;

                            $Update_U_grqty_web_WTR1 = array (
                                'U_grqty_web' => $cekvar
                            );

                            $this->dokitchen->Update_U_grqty_web_WTR1($Update_U_grqty_web_WTR1, $Header['do_no'], $itemDetail['item']); 
                        }
                    }

                }

            }
            
        }

        $this->db->trans_complete();

        if($input_detail_success){
            return $this->session->set_flashdata('success', "Data Goods Receipt from Central Kitchen  berhasil dimasukkan");
        }else{
            return $this->session->set_flashdata('failed', "Data Goods Receipt from Central Kitchen  tidak berhasil di tambah");
        }

    }

    public function updateDataGR(){

        $IDheader = $this->input->post('IDheader');
        $id_approve = $this->input->post('id_approve');
        $grDetail = $this->input->post('grDetail');
        
        try{

            if($id_approve > 1) {
                $grpodlv_no ='';
                $dataUpdate = array (
                    'id_grpodlv_header'	=>$IDheader,
                    'grpodlv_no'	=>	$grpodlv_no,
                    'status'	=>	'2',
                    'id_user_approved'	=>	1,
                );
            }

            if(count($grDetail)) { 
                foreach($grDetail as $itemDetail){ 
                    $grpodlv_detail_to_update['id_grpodlv_detail'] = $itemDetail['id_grpodlv_detail']; 
                    $grpodlv_detail_to_update['gr_quantity'] = $itemDetail['gr_qty'];
                }
            }
            

            if($this->dokitchen->grpodlv_detail_update($grpodlv_detail_to_update)) { 
                $this->dokitchen->grpodlv_header_update($dataUpdate);

                return $this->session->set_flashdata('success', "Data Goods Receipt from Central Kitchen  berhasil di update");
            } else {

                return $this->session->set_flashdata('failed', "Data Goods Receipt from Central Kitchen  tidak berhasil di update");

            }

        } catch (Exception $e) {
            return $this->session->set_flashdata('failed', $e->getMessage());
        }

    }

 


    public function getDataslipHeader()
    {
        $data = array();
        $dataOption = array();

        $slipNumberHeader = $this->input->post('slipNumberHeader');
        $data = $this->dokitchen->sap_grpodlv_headers_select_slip_number($slipNumberHeader);        
        $dataOption = $this->dokitchen->sap_grpodlv_select_item_group_do($slipNumberHeader);
        

        //$data = $this->dokitchen->sap_grpodlv_headers_select_by_kd_do("",$doNumber);
        

        // $i = 1;
        // foreach($data as $key=>$value){
        //     $nestedData=array();
        //     $nestedData['no'] = $i;
        //     $nestedData['MATNR'] = $value['MATNR'];
        //     $nestedData['MAKTX'] = $value['MAKTX'];
        //     $nestedData['LFIMG'] = $value['LFIMG'];
        //     $nestedData['DISPO'] = $value['DISPO'];
        //     $nestedData['VRKME'] = $value['VRKME'];
        //     $dt[] = $nestedData;
        //     $i++;
        // }

        // if (count($data) > 0) {

        //     $json_data = array(
        //         "data" => $data[1],
        //         "dataOption" => $dataOption,
        //         "dataTable" =>$dt
        //     );
        //     echo json_encode($json_data) ;
        // }

        if (count($data) > 0) {

            $json_data = array(
                "data" => $data,
                "dataOption" => $dataOption,
            );
            
        } else {
            $json_data = array(
                "data" => $data,
                "dataOption" => $dataOption,
            );
        }
        echo json_encode($json_data) ;
    }
	
	public function edit($ID="")
    {

        if($ID != ""){

            $data['gr_list'] = $this->dokitchen->grpodlv_header_select($ID);
            $this->load->view('transaksi1/eksternal/grfromkitchensentul/edit_view', $data);

        }
        
    }

    public function printpdf($IDHeader =""){

        if($IDHeader != ""){
            $data['data'] = $this->dokitchen->getHeadDeatForPrint($IDHeader);
            
            ob_start();
            $content = $this->load->view('transaksi1/eksternal/grfromkitchensentul/printpdf_view',$data);
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
        
    }
	
	public function showlistData(){
        $fromDate = $this->input->post('fDate');
        $toDate = $this->input->post('tDate');
        $status = $this->input->post('stts');
        // echo json_encode($fromDate,$toDate,$status);
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

        
        if($fromDate != '') {
			$year = substr($toDate, 6);
			$month = substr($toDate, 3,2);
			$day = substr($toDate, 0,2);
			$date_to2 = $year.'-'.$day.'-'.$month.' 00:00:00';
        }else{
            $date_to2='';
        }

        $rs = $this->dokitchen->getDataPoKitchen_Header($date_from2,$date_to2,$status);

        $data = array();
        $log = '';
        foreach($rs as $key=>$val){
            $nestedData = array();
            $nestedData['action'] = $val['id_grpodlv_header'];
            $nestedData['id_grpodlv_header'] = $val['id_grpodlv_header'];
            $nestedData['no'] = $val['id_grpodlv_header'];
            // $nestedData['id_grpodlv_header'] = $val['id_grpodlv_header'];
            $nestedData['grpodlv_no'] = $val['grpodlv_no'];
            $nestedData['do_no'] = $val['do_no'];
            $nestedData['delivery_date'] = date('d-m-Y',strtotime($val['delivery_date']));
            $nestedData['posting_date'] = date('d-m-Y',strtotime($val['posting_date']));
            $nestedData['status'] = $val['status'] =='1'?'Not Approved':'Approved';
            $nestedData['id_user_input'] = $val['id_user_input'];
            $nestedData['id_user_approved'] = $val['id_user_approved'];
            $nestedData['lastmodified'] = $val['lastmodified'];
            
            if($val['grpodlv_no'] != '' && $val['grpodlv_no'] != 'C' && $val['back'] == 0){
                $log = 'Integrated';
            }else if($val['back'] == 1 && ($val['grpodlv_no'] == '' || $val['grpodlv_no'] == 'C')){
                $log = 'Not Integrated';
            }else if($val['back'] == 0 && $val['grpodlv_no'] == 'C'){
                $log = 'Close Document';
            }
            $nestedData['integrated'] = $log;
            $nestedData['outlet_name'] = $val['OUTLET_NAME1'];
            $data[] = $nestedData;
        }

        $json_data = array(
            "recordsTotal"    => 10, 
            "recordsFiltered" => 12,
            "data"            => $data
        );
        echo json_encode($json_data);
    }
	
	public function showEditData($ID=""){
        $res = $this->dokitchen->grpodlv_details_select($ID);
        $gr_list_header = $this->dokitchen->grpodlv_header_select($ID);
        
        $recordsTotal = 10;
        $recordsFiltered = 12;
        $data = array();

        if($res) {

            
            $no = 1;
            foreach($res as $val){
                $nestedData = array();
                $nestedData['ID'] = $val['id_grpodlv_detail'];
                $nestedData['material_no'] = $val['material_no'];
                $nestedData['material_desc'] = $val['material_desc'];
                $nestedData['sr_qty'] = $val['gr_quantity']+$no;
                $nestedData['tf_qty'] = $val['outstanding_qty'];
                $nestedData['gr_qty'] = $val['gr_quantity'];
                $nestedData['uom'] = $val['uom'];
                $nestedData['cancel'] = $val['id_grpodlv_detail'];
                $nestedData['status'] = $gr_list_header['status'];
                $data[] = $nestedData;
                $no++;
            }

            $json_data = array(
                "recordsTotal"    => $recordsTotal, 
                "recordsFiltered" => $recordsFiltered,
                "data"            => $data
            );

            
        } else {

            $json_data = array(
                "recordsTotal"    => $recordsTotal, 
                "recordsFiltered" => $recordsFiltered,
                "data"            => $data
            );
            
        }

        echo json_encode($json_data);
    }

    public function deleteData(){
        $id_grpodlv_header = $this->input->post('deleteArr');
        $deleteData = false;
        foreach($id_grpodlv_header as $id){
            $dataHeader = $this->dokitchen->grpodlv_header_select($id);
            if($dataHeader['status'] == '2' || $dataHeader['back'] == 0){
                $deleteData = false;
            }else{
                if($this->dokitchen->grpodlv_header_delete($id))
                $deleteData = true;
            }
        }
        if($deleteData){
            return $this->session->set_flashdata('success', "GR from Central Kitchen Berhasil dihapus");
        }else{
            return $this->session->set_flashdata('failed', "GR from Central Kitchen Gagal dihapus");
        }
    }
}
?>