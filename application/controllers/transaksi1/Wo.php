<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Wo extends CI_Controller{
     public function __construct(){
		parent::__construct();
		$this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->load->library('l_general');
        
        // load model
        $this->load->model('transaksi1/workorder_model', 'wovendor');
    }

    public function index()
    {
        # code...
        $this->load->view("transaksi1/produksi/work_order/list_view");
    }
	
	public function showListData(){
        $fromDate = $this->input->post('fDate');
        $toDate = $this->input->post('tDate');
		$status = $this->input->post('stts');
		$draw = intval($this->input->post("draw"));
        $length = intval($this->input->post("length"));
        $start = intval($this->input->post("start"));

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
			$date_to2 = $year.'-'.$day.'-'.$month.' 00:00:00';
        }else{
            $date_to2='';
        }
        
		$rs = $this->wovendor->getDataWoVendor_Header($date_from2, $date_to2, $status, $length, $start);
		$totalData = $this->wovendor->getCountDataWoVendor_Header($date_from2, $date_to2, $status);
		
		$data = array();
		$back='';

        foreach($rs as $key=>$val){
			$log = $val['back'];
			$po = $val['produksi_no'];
			if ($log==0 && $po !='' && $po !='C'){
				$back = "Integrated";
			}else if ($log==1 && ($po =='' || $po =='C')){
				$back = "Not Integrated";
			}else if ($log==0 &&  $po =='C'){
				$back = "Close Document";
			}

            $nestedData = array();
			$nestedData['id_produksi_header'] 		= $val['id_produksi_header'];
			$nestedData['id_produksi_plant'] 		= $val['id_produksi_plant'];
			$nestedData['posting_date'] 			= date("d-m-Y",strtotime($val['posting_date']));
			$nestedData['produksi_no'] 				= $val['produksi_no'];
			$nestedData['plant'] 					= $val['plant'];
			$nestedData['plant_name'] 				= $val['plant_name'];
            $nestedData['storage_location'] 		= $val['storage_location'];
			$nestedData['storage_location_name'] 	= $val['storage_location_name'];
			$nestedData['created_date'] 			= date("d-m-Y",strtotime($val['created_date']));
            $nestedData['kode_paket'] 				= $val['kode_paket'];
			$nestedData['nama_paket'] 				= $val['nama_paket'];
			$nestedData['qty_paket'] 				= $val['qty_paket'];
			$nestedData['status'] 					= $val['status'] =='1'?'Not Approved':'Approved';
            $nestedData['id_user_input'] 			= $val['id_user_input'];
			$nestedData['id_user_approved'] 		= $val['id_user_approved'];
			$nestedData['id_user_cancel'] 			= $val['id_user_cancel'];
			$nestedData['filename'] 				= $val['filename'];
			$nestedData['lastmodified'] 			= date("d-m-Y",strtotime($val['lastmodified']));
			$nestedData['num'] 						= $val['num'];
			$nestedData['uom_paket'] 				= $val['uom_paket'];
			$nestedData['issue'] 					= $val['doc_issue'];
            $nestedData['created_by'] 				= $val['created_by'];
            $nestedData['approved_by'] 				= $val['approved_by'];
            $nestedData['back'] 					= $back;
            $data[] = $nestedData;

        }
		
		$json_data = array(
			"draw" => $draw,
            "recordsTotal" => $totalData[0]['num'],
            "recordsFiltered" => $totalData[0]['num'],
            "data"            =>  $data 
        );
		
        echo json_encode($json_data);
    }
	
	public function deleteData(){
        $id_wo_header = $this->input->post('deleteArr');
        $deleteData = false;
        foreach($id_wo_header as $id){
            if($this->wovendor->wo_header_delete($id))
            $deleteData = true;
        }
        
        if($deleteData){
            return $this->session->set_flashdata('success', "Work Order Berhasil dihapus");
        }else{
            return $this->session->set_flashdata('failed', "Work Order Gagal dihapus");
        }
    }

     public function add(){
		$data['wo_codes'] = $this->wovendor->sap_wo_headers_select_by_item();
		
        $object['wo_code']['-'] = '';
        if($data['wo_codes'] != FALSE){
            foreach($data['wo_codes'] as $wo_no){
				$object['wo_code'][$wo_no['Code']] = $wo_no['Code'].' - '.$wo_no['ItemName'];
            }
		}

        $this->load->view('transaksi1/produksi/work_order/add_view',$object);
     }
	 
	 public function wo_header_uom(){
		$material_no = $this->input->post('material_no');
		$data = $this->wovendor->sap_wo_headers_select_by_item($material_no);		
		if(count($data)>0){
			$json_data=array(
				"data" => $data
			);
			echo json_encode($json_data);
		}
     }

    public function edit(){
        $id_wo_header = $this->uri->segment(4);
		$object['data'] = $this->wovendor->wo_header_select($id_wo_header);
		$u_Locked = $this->wovendor->sap_wo_headers_select_by_item($object['data']['kode_paket']);

		
        $object['wo_header']['id_produksi_header'] = $object['data']['id_produksi_header'];
        $object['wo_header']['kode_paket'] = $object['data']['kode_paket'];
        $object['wo_header']['nama_paket'] = $object['data']['nama_paket'];
        $object['wo_header']['qty_paket'] = $object['data']['qty_paket'];
        $object['wo_header']['uom_paket'] = $object['data']['uom_paket'];
        $object['wo_header']['posting_date'] = $object['data']['posting_date'];
		$object['wo_header']['status'] = $object['data']['status'];
		$object['wo_header']['U_Locked'] = $u_Locked[0]['U_Locked'];
		$object['wo_header']['plant'] = $this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];
		
		
        $this->load->view('transaksi1/produksi/work_order/edit_view', $object);
    }
	
	public function showDetailEdit(){
        $id_wo_header = $this->input->post('id');
        $kode_paket = $this->input->post('kodepaket');
        $qty_paket = $this->input->post('qtypaket');
		$rs = $this->wovendor->wo_details_select($id_wo_header,$kode_paket,$qty_paket);
		$object['data'] = $this->wovendor->wo_header_select($id_wo_header);
		$disabled = $object['data']['status'] == 2 ? 'disabled' : '';
		
		$dt = array();
        $i = 1;
        if($rs){
            foreach($rs as $data){
				$queryUOM = $this->wovendor->wo_detail_uom($data['material_no']);
				if(count($queryUOM)>0){
					$uom = $queryUOM[0]['UNIT'];
				}
				$ucaneditqty = $this->wovendor->wo_detail_ucaneditqty($kode_paket,$data['material_no']);
				$querySAP2 = $this->wovendor->wo_detail_itemcodebom($kode_paket,$data['material_no']);
				$select = '<select class="form-control form-control-select2" data-live-search="true" name="descmat" id="descmat" '.$disabled.'>
								<option value="'.$data['material_no'].'" rel="'.$ucaneditqty[0]['CanEditQty'].'" matqty="'.$data['qty'].'" matdesc="'.$data['material_desc'].'">'.$data['material_desc'].'</option>';
								if($querySAP2){
									foreach($querySAP2 as $_querySAP2){
										if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
											$select .= '<option value="'.$_querySAP2['U_SubsCode'].'" 
											rel="'.$ucaneditqty[0]['CanEditQty'].'"
											matqty="'.$_querySAP2['U_SubsQty'] * (float)$qty_paket.'" matdesc="'.$_querySAP2['NAME'].'">'.$_querySAP2['NAME'].'</option>';
										}
									}
								}
				$select .= '</select>';
				$descolumn = '';
				if($querySAP2){
					foreach($querySAP2 as $_querySAP2){
						if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
							$descolumn = $select;
						}else{
							$descolumn = $data['material_no'];
						}
					}
				}else{
					$descolumn = $select;
				}
				
				$nestedData=array();
				$nestedData['no'] = $i;
				$nestedData['id_produksi_detail'] = $data['id_produksi_detail'];
				$nestedData['id_produksi_header'] = $data['id_produksi_header'];
				$nestedData['material_no'] = $data['material_no'];
				$nestedData['material_desc'] = $data['material_desc'];
				$nestedData['qty'] = $data['qty'];
				$nestedData['uom'] = $uom;
				$nestedData['OnHand'] = $data['OnHand'];
				$nestedData['MinStock'] = $data['MinStock']; 
				$nestedData['OpenQty'] = $data['OpenQty'];
				$nestedData['descolumn'] = $descolumn;
				$dt[] = $nestedData;
				$i++;
			}
        }
        $json_data = array(
			"data" => $dt
		);
		echo json_encode($json_data);

    }
	
	public function showDetailInput(){
		$kode_paket = $this->input->post('kode_paket');
		$qty_header = $this->input->post('Qty');
        $rs = $this->wovendor->wo_details_input_select($kode_paket);
		/*echo "<pre>";
		print_r($rs);
		echo "</pre>";
		exit;*/
		
		$dt = array();
        $i = 1;
        if($rs){
            foreach($rs as $data){
		
				$querySAP = $this->wovendor->wo_detail_valid($data['material_no']);
				// $querySAP = $this->wovendor->wo_detail_valid('1ACRG004');
				$validFor = '';
				$decreasAc = '';
				if($querySAP != false){
					$validFor = $querySAP[0]['validFor'];
					$decreasAc = $querySAP[0]['DecreasAc'];
				}
				
				// $qty = $this->wovendor->wo_detail_quantity($kode_paket,$data['material_no']);
				$qty_paket = $data['quantity'];
				
				// $quantity = $qty[0]['quantity'];
				// $quantity_paket = $qty[0]['quantity_paket'];
				// $resqty = $quantity *$qty_paket/$quantity_paket;
				
				$getonhand = $this->wovendor->wo_detail_onhand($data['material_no']);
				$onhand = '';
				$minstock = '';
				if($getonhand != false){
					$onhand = $getonhand[0]['OnHand'];
					$minstock = $getonhand[0]['MinStock'];
				}
				
				$getopenqty = $this->wovendor->wo_detail_openqty($data['material_no']);
				$openqty = '';
				if($getopenqty != false){
					$openqty = $getopenqty[0]['OpenQty'];
				}
				
				$ucaneditqty = $this->wovendor->wo_detail_ucaneditqty($kode_paket,$data['material_no']);
				$getlocked = $this->wovendor->sap_wo_select_locked($kode_paket);

				$getucaneditqty='';
				
				if($getlocked[0]['U_Locked'] != 'N' && $ucaneditqty[0]['CanEditQty'] != 'N'){
					$getucaneditqty = '<input type="text" id="editqty" class="form-control" value="'.$data['quantity'] * (float)$qty_header.'">';
				}else {
					$getucaneditqty = '<input type="text" id="editqty" class="form-control" value="'.$data['quantity'] * (float)$qty_header.'" readonly>';
				}

				// $matqty = '';
				// if($quantity_paket > 0){
				// 	$matqty = '<input style="text-align:right;" type="text" value="'.number_format($resqty, 4, '.', '').'" class="error_number prodqty" size="8">';
				// }else{
				// 	$matqty = '<div class="matqty" style="text-align:right;">'.number_format($resqty, 4, '.', '').'</div>';
				// }
				
				
				
				$queryUOM = $this->wovendor->wo_detail_uom($data['material_no']);
				// $queryUOM = $this->wovendor->wo_detail_uom('1ACO158');
				if(count($queryUOM)>0){
					$uom = $queryUOM[0]['UNIT'];
				}
				
				$querySAP2 = $this->wovendor->wo_detail_itemcodebom($kode_paket,$data['material_no']);
				// $querySAP2 = $this->wovendor->wo_detail_itemcodebom('FDY0020','1ACO158');
				// print($querySAP2);
				
				$select = '<select class="form-control form-control-select2" data-live-search="true" name="descmat" id="descmat">
								<option value="'.$data['material_no'].'" rel="'.$ucaneditqty[0]['CanEditQty'].'" matqty="'.$data['quantity'] * (float)$qty_header.'" matdesc="'.$data['material_desc'].'">'.$data['material_desc'].'</option>';
								if($querySAP2){
									foreach($querySAP2 as $_querySAP2){
										if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
											$select .= '<option value="'.$_querySAP2['U_SubsCode'].'" 
											rel="'.$ucaneditqty[0]['CanEditQty'].'"
											matqty="'.$_querySAP2['U_SubsQty'] * (float)$qty_header.'" matdesc="'.$_querySAP2['NAME'].'">'.$_querySAP2['NAME'].'</option>';
										}
									}
								}
				$select .= '</select>';
				
				$descolumn = '';
				if($querySAP2){
					foreach($querySAP2 as $_querySAP2){
						if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
							$descolumn = $select;
						}else{
							$descolumn = $data['material_no'];
						}
					}
				}else{
					$descolumn = $select;
				}
				
				$openitem = $this->wovendor->wo_detail_item();
				$qtyopen = '';
				foreach($openitem as $_openqty){
					if($_openqty['U_ItemCodeBOM'] = $data['material_no']){
						$qtyopen = $select;
					}else{
						$qtyopen = $data['material_no'];
					}
				}


				$nestedData=array();
				$nestedData['no'] = $i;
				/*$nestedData['doc_issue'] = $data['doc_issue'];
				$nestedData['matQty'] = $matqty;*/
				$nestedData['id_mpaket_header'] = $data['id_mpaket_header'];
				$nestedData['id_mpaket_h_detail'] = $data['id_mpaket_h_detail'];
				$nestedData['material_no'] = $data['material_no'];
				$nestedData['material_desc'] = $data['material_desc'];
				$nestedData['qty'] = $getucaneditqty;
				$nestedData['uom'] = $uom;
				$nestedData['OnHand'] = $onhand; 
				$nestedData['MinStock'] = $minstock; 
				$nestedData['OpenQty'] = $openqty;
				$nestedData['validFor'] = $validFor;
				$nestedData['decreasAc'] = $decreasAc;
				$nestedData['descolumn'] = $descolumn;
				$dt[] = $nestedData;
				$i++;
			}
        }
        $json_data = array(
			"data" => $dt
		);
		echo json_encode($json_data);

	}
	
	public function addData(){
		$produksi_header['plant'] = $this->session->userdata['ADMIN']['plant'];
		$produksi_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
		$produksi_header['posting_date'] = $this->l_general->str_to_date($this->input->post('postDate'));
		$produksi_header['id_produksi_plant'] = $this->wovendor->id_produksi_plant_new_select($this->session->userdata['ADMIN']['plant'],$this->input->post('postDate'));
		$produksi_header['produksi_no'] = '';

		// if(isset($_POST['button']['approve']))
		// 	$produksi_header['status'] = '2';
		// else
		// 	$produksi_header['status'] = '1';

		$produksi_header['status'] = $this->input->post('approve')? $this->input->post('approve') : '1';
		$produksi_header['kode_paket'] = $this->input->post('woNumber');
		$produksi_header['nama_paket'] = $this->input->post('woDesc');
		$produksi_header['qty_paket'] = $this->input->post('qtyProd');
		$produksi_header['uom_paket'] = $this->input->post('uomProd');
		$produksi_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
		$produksi_header['id_user_approved'] = $this->input->post('approve')? $this->session->userdata['ADMIN']['admin_id'] : 0 ;
		$produksi_header['created_date']=date('Y-m-d');
		$produksi_header['back']=1;
		
		/*Batch Number */
		$date=date('ym');
		$batch = $this->wovendor->wo_header_batch($produksi_header['kode_paket'],$this->session->userdata['ADMIN']['plant']);
		if(!empty($batch)){
			$date=date('ym');
			$count1=count($batch) + 1;
			if ($count1 > 9 && $count1 < 100){
				$dg="0";
			}else {
				$dg="00";
			}
			$num=$produksi_header['kode_paket'].$date.$dg.$count1;
			$produksi_header['num'] = $num;
		}else{
			$produksi_header['num'] = '';
		}
		
		$count = count($this->input->post('matrialNo'));
		if($id_produksi_header = $this->wovendor->produksi_header_insert($produksi_header)) {
			$input_detail_success = FALSE;
			for($i = 0; $i < $count; $i++){
				$produksi_detail['id_produksi_header'] = $id_produksi_header;
				$produksi_detail['qty'] = $this->input->post('qty')[$i];
				$produksi_detail['id_produksi_h_detail'] = $i+1;
				$produksi_detail['material_no'] = $this->input->post('matrialNo')[$i];
				$produksi_detail['num'] = '';
				$produksi_detail['material_desc'] = trim($this->input->post('matrialDesc')[$i]);
				$produksi_detail['uom'] = $this->input->post('uom')[$i];
				$produksi_detail['qc'] = '';
				$produksi_detail['OnHand'] = $this->input->post('onHand')[$i];
				$produksi_detail['MinStock'] = $this->input->post('minStock')[$i];
				$produksi_detail['OpenQty'] = $this->input->post('outStandTot')[$i];
				if($this->wovendor->produksi_detail_insert($produksi_detail) ){
					$input_detail_success = TRUE;
				}
			}
		}
        if($input_detail_success){
            return $this->session->set_flashdata('success', "Work Order Telah Terbentuk");
        }else{
            return $this->session->set_flashdata('failed', "Work Order Gagal Terbentuk");
        } 
	}
	

	public function addUpdateData(){
		$id_produksi_header = $this->input->post('id_wo_header');
		$kode_paket 		=$this->input->post('kd_paket');
		$approve 			=$this->input->post('approve');
		$produksi_header['id_produksi_header'] = $id_produksi_header;
		$produksi_header['status'] = $approve ? $approve: "1";
		$produksi_header['id_user_approved'] = $approve? $this->session->userdata['ADMIN']['admin_id'] : 0 ;
		$max = count($this->input->post('matrialNo'));

		$produksi_header_update = $this->wovendor->update_produksi_header($produksi_header);
		$succes_update = false;
		if($produksi_header_update){
			$this->wovendor->wo_details_delete($id_produksi_header);
			for($i=0; $i < $max; $i++){
				$produksi_detail['id_produksi_header'] = $id_produksi_header;
				$produksi_detail['qty'] = $this->input->post('qty')[$i];
				$produksi_detail['id_produksi_h_detail'] = $i+1;
				$produksi_detail['material_no'] = $this->input->post('matrialNo')[$i];
				$produksi_detail['num'] = '';
				$produksi_detail['material_desc'] = $this->input->post('matrialDesc')[$i];
				$produksi_detail['uom'] = $this->input->post('uom')[$i];
				$produksi_detail['qc'] = '';
				$produksi_detail['OnHand'] = $this->input->post('onHand')[$i];
				$produksi_detail['MinStock'] = $this->input->post('minStock')[$i];
				$produksi_detail['OpenQty'] = $this->input->post('outStandTot')[$i];
							
				if($this->wovendor->produksi_detail_insert($produksi_detail) ){
					$succes_update = TRUE;
				}
			}
		}
		if($succes_update){
            return $this->session->set_flashdata('success', "WO Telah Berhasil Terupdate");
        }else{
            return $this->session->set_flashdata('failed', "WO Gagal Terupdate");
        }
	} 
}
?>