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
        // $this->load->library('l_general');
        
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
        
        $rs = $this->wovendor->getDataWoVendor_Header($date_from2, $date_to2, $status);
		
		$json_data = array(
			"status"		=> $status,
            "recordsTotal"    =>  10, 
            "recordsFiltered" =>  12,
            "data"            =>  $rs 
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
		$data = $this->wovendor->wo_detail_uom($material_no);
		if(count($data)>0){
			echo $data[0]['UNIT'];
		}
     }

    public function edit(){
        $id_wo_header = $this->uri->segment(4);
        $object['data'] = $this->wovendor->wo_header_select($id_wo_header);
		
        $object['wo_header']['id_produksi_header'] = $object['data']['id_produksi_header'];
        $object['wo_header']['kode_paket'] = $object['data']['kode_paket'];
        $object['wo_header']['nama_paket'] = $object['data']['nama_paket'];
        $object['wo_header']['qty_paket'] = $object['data']['qty_paket'];
        $object['wo_header']['uom_paket'] = $object['data']['uom_paket'];
        $object['wo_header']['posting_date'] = $object['data']['posting_date'];
        $object['wo_header']['status'] = $object['data']['status'];
		
        $this->load->view('transaksi1/produksi/work_order/edit_view', $object);
    }
	
	public function showDetailEdit(){
        $id_wo_header = $this->input->post('id');
        $kode_paket = $this->input->post('kodepaket');
        $qty_paket = $this->input->post('qtypaket');
        $rs = $this->wovendor->wo_details_select($id_wo_header,$kode_paket,$qty_paket);
		
		$dt = array();
        $i = 1;
        if($rs){
            foreach($rs as $data){
				$queryUOM = $this->wovendor->wo_detail_uom($data['material_no']);
				if(count($queryUOM)>0){
					$uom = $queryUOM[0]['UNIT'];
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
        $rs = $this->wovendor->wo_details_input_select($kode_paket);
		/*echo "<pre>";
		print_r($rs);
		echo "</pre>";
		exit;*/
		
		$dt = array();
        $i = 1;
        if($rs){
            foreach($rs as $data){
		
				//$querySAP = $this->wovendor->wo_detail_valid($data['material_no']);
				$querySAP = $this->wovendor->wo_detail_valid('1ACRG004');
				$validFor = '';
				$decreasAc = '';
				if($querySAP != false){
					$validFor = $querySAP[0]['validFor'];
					$decreasAc = $querySAP[0]['DecreasAc'];
				}
				
				$qty = $this->wovendor->wo_detail_quantity($kode_paket,$data['material_no']);
				$qty_paket = $data['quantity'];
				$quantity = $qty[0]['quantity'];
				$quantity_paket = $qty[0]['quantity_paket'];
				$resqty=$quantity*$qty_paket/$quantity_paket;
				
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
				
				//$ucaneditqty = $this->wovendor->wo_detail_ucaneditqty($kode_paket,$data['material_no']);
				$ucaneditqty = $this->wovendor->wo_detail_ucaneditqty('FDY0020','1ACO158');
				if(count($ucaneditqty)>0){
					$qtyeditucan = $ucaneditqty[0]['CanEditQty'];
				}
				$matqty = '';
				if($quantity_paket > 0){
					$matqty = '<input style="text-align:right;" type="text" value="'.number_format($resqty, 4, '.', '').'" class="error_number prodqty" size="8">';
				}else{
					$matqty = '<div class="matqty" style="text-align:right;">'.number_format($resqty, 4, '.', '').'</div>';
				}
				
				$openitem = $this->wovendor->wo_detail_item();
				$qtyopen = '';
				
				//$queryUOM = $this->wovendor->wo_detail_uom($data['material_no']);
				$queryUOM = $this->wovendor->wo_detail_uom('1ACO158');
				if(count($queryUOM)>0){
					$uom = $queryUOM[0]['UNIT'];
				}
				
				//$querySAP2 = $this->wovendor->wo_detail_itemcodebom($kode_paket,$data['material_no']);
				$querySAP2 = $this->wovendor->wo_detail_itemcodebom('FDY0020','1ACO158');
				
				$select = '<select class="form-control form-control-select2" data-live-search="true" name="status" id="status" tabindex="-1" aria-hidden="true">
								<option value="'.$data['material_no'].'" matqty="'.number_format($resqty, 4, '.', ',').'" matdesc="'.$data['material_desc'].'">'.$data['material_desc'].'</option>';
								foreach($querySAP2 as $_querySAP2){
									if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
										$select .= '<option value="'.$_querySAP2['Code'].'" matqty="'.number_format($_querySAP2['U_SubsQty'], 4, '.', ',').'" matdesc="'.$_querySAP2['NAME'].'">'.$_querySAP2['NAME'].'</option>';
									}
								}
				$select .= '</select>';
				
				$descolumn = '';
				foreach($querySAP2 as $_querySAP2){
					if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
						$descolumn = $select;
					}else{
						$descolumn = $data['material_no'];
					}
				}
				
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
				$nestedData['qty'] = $data['quantity'];
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
 
}
?>