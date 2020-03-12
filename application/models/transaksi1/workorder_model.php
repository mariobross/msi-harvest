<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Workorder_model extends CI_Model {

  public function getDataWoVendor_Header($fromDate='', $toDate='', $status=''){
	  $arr 		=	array();
	  $kd_plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->from('t_produksi_header');
      $this->db->where('plant', $kd_plant);
      if((!empty($fromDate)) || (!empty($toDate))){
          if( (!empty($fromDate)) || (!empty($toDate)) ) {
			  $this->db->where("posting_date BETWEEN '$fromDate' AND '$toDate'");
		  } else if( (!empty($fromDate))) {
			  $this->db->where("posting_date >= '$fromDate'");
		  } else if( (!empty($toDate))) {
			  $this->db->where("posting_date <= '$toDate'");
		  }
	  }
	  if((!empty($status))){
		  $this->db->where('status', $status);
	  }
	  //$this->db->where('plant', 'WMSISNST');
	  $this->db->order_by('id_produksi_header', 'asc');
	  $query = $this->db->get();
	  $ret = $query->result_array();
	  $issue = '';
	  $created = '';
	  $approved = '';
	  $back = '';
	
	  foreach($ret as $data){
	    $query2	=	$this->db->query('SELECT doc_issue FROM t_produksi_detail WHERE  id_produksi_header = "'.$data['id_produksi_header'].'"');
		if($query2->num_rows() > 0){
			$dataSQL2 		= $query2->result_array();
			if(count($dataSQL2) != 0){
				$issue = $dataSQL2[0]['doc_issue'];
			}
		}
		$query3	=	$this->db->query('SELECT admin_realname FROM d_admin WHERE admin_id = "'.$data['id_user_input'].'"');
		if($query3->num_rows() > 0){
			$dataSQL3 		= $query3->result_array();
			if(count($dataSQL3) != 0){
				$created = $dataSQL3[0]['admin_realname'];
			}
		}
		$query4	=	$this->db->query('SELECT admin_realname FROM d_admin WHERE admin_id = "'.$data['id_user_approved'].'"');
		if($query4->num_rows() > 0){
			$dataSQL4 		= $query4->result_array();
			if(count($dataSQL4) != 0){
				$approved = $dataSQL4[0]['admin_realname'];
			}
		}
		$log = $data['back'];
		$po = $data['produksi_no'];
		if ($log==0 && $po !='' && $po !='C'){
			$back = "Integrated";
		}else if ($log==1 && ($po =='' || $po =='C')){
			$back = "Not Integrated";
		}else if ($log==0 &&  $po =='C'){
			$back = "Close Document";
		}
		array_push($arr,
			array(
				"id_produksi_header"		=>	$data['id_produksi_header'],
				"id_produksi_plant"			=>	$data['id_produksi_plant'],
				"posting_date"				=>	$data['posting_date'],
				"produksi_no"				=>	$data['produksi_no'],
				"plant"						=>	$data['plant'],
				"plant_name"				=>	$data['plant_name'],
				"storage_location"			=>	$data['storage_location'],
				"storage_location_name"		=>	$data['storage_location_name'],
				"created_date"				=>	date("d-m-Y",strtotime($data['created_date'])),
				"kode_paket"				=>	$data['kode_paket'],
				"nama_paket"				=>	$data['nama_paket'],
				"qty_paket"					=>	$data['qty_paket'],
				"status"					=>	$data['status'] =='1'?'Not Approved':'Approved',
				"id_user_input"				=>	$data['id_user_input'],
				"id_user_approved"			=>	$data['id_user_approved'],
				"id_user_cancel"			=>	$data['id_user_cancel'],
				"filename"					=>	$data['filename'],
				"lastmodified"				=>	date("d-m-Y",strtotime($data['lastmodified'])),
				"num"						=>	$data['num'],
				"uom_paket"					=>	$data['uom_paket'],
				"issue"						=>	$issue,
				"created_by"				=>	$created,
				"approved_by"				=>	$approved,
				"back"						=>	$back
			)
		);
      }
	  return $arr;
  }
  
  function wo_header_delete($id_wo_header){
    if($this->wo_details_delete($id_wo_header)){
		$this->db->where('id_produksi_header', $id_wo_header);
		if($this->db->delete('t_produksi_header'))
			return TRUE;
		else
			return FALSE;
    }
  }
  
  function wo_details_delete($id_wo_header) {
	$this->db->where('id_mpaket_header', $id_wo_header);
	if($this->db->delete('m_mpaket_detail_temp'))
		return TRUE;
	else
		return FALSE;
  }
  
  function wo_header_select($id_wo_header){
	$arr 	=	array();
    $this->db->from('t_produksi_header');
    $this->db->where('id_produksi_header', $id_wo_header);
    $query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->row_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_valid($material_no){
	$SAP_MSI = $this->load->database('SAP_MSI', TRUE);
	$SAP_MSI->select('OITM.validFor,OITB.DecreasAc');
	$SAP_MSI->from('OITM');
	$SAP_MSI->join('OITB','OITM.ItmsGrpCod = OITB.ItmsGrpCod');
	$SAP_MSI->where('ItemCode',$material_no);
	$query = $SAP_MSI->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_quantity($kode_paket,$material_no){
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$this->db->select('quantity,quantity_paket');
	$this->db->from('m_mpaket_detail');
	$this->db->join('m_mpaket_header','m_mpaket_detail.id_mpaket_header = m_mpaket_header.id_mpaket_header');
	$this->db->where('m_mpaket_header.kode_paket', $kode_paket);
	$this->db->where('m_mpaket_header.plant', $kd_plant);
	$this->db->where('m_mpaket_detail.material_no', $material_no);
	$query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_onhand($material_no){
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$SAP_MSI = $this->load->database('SAP_MSI', TRUE);
	$SAP_MSI->select("OnHand,MinStock");
	$SAP_MSI->from('OITW');
	$SAP_MSI->where('ItemCode',$material_no);
	$SAP_MSI->where('WhsCode',$kd_plant);
	$query = $SAP_MSI->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_itemcodebom($kode_paket,$material_no){
	$SAP_MSI = $this->load->database('SAP_MSI', TRUE);
	$SAP_MSI->select("T1.U_SubsName as NAME,T1.U_ItemCodeBOM,T1.U_SubsQty,T1.U_SubsCode,T1.Code");
	$SAP_MSI->from('@MSI_ALT_ITM_HDR T0');
	$SAP_MSI->join('@MSI_ALT_ITM_DTL T1','T1.Code = T0.Code');
	$SAP_MSI->where('T0.Code',$material_no);
	$SAP_MSI->where('T1.U_ItemCodeBOM',$kode_paket);
	$query = $SAP_MSI->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  } 
  
  function wo_detail_openqty($material_no){
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
	$SAP_MSI = $this->load->database('SAP_MSI', TRUE);
	$SAP_MSI->select("SUM(OpenQty) as OpenQty");
	$SAP_MSI->from('WTQ1');
	$SAP_MSI->where('ItemCode',$material_no);
	$SAP_MSI->where('WhsCode',$kd_plant);
	$query = $SAP_MSI->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_item(){
	$this->db->select('MATNR,MAKTX');
	$this->db->from('m_item');
	$query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_uom($material_no){
	$this->db->select('UNIT');
	$this->db->from('m_item');
	$this->db->where('MATNR', $material_no);
	$query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_ucaneditqty($kode_paket,$material_no){
	$SAP_MSI = $this->load->database('SAP_MSI', TRUE);
	$SAP_MSI->select("U_CanEditQty as CanEditQty");
	$SAP_MSI->from('ITT1');
	$SAP_MSI->where('Code',$kode_paket);
	$SAP_MSI->where('Father',$material_no);
	$query = $SAP_MSI->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function sap_wo_headers_select_by_item(){
	$SAP_MSI = $this->load->database('SAP_MSI', TRUE);
	$SAP_MSI->select("T0.Code,T1.ItemName,T0.U_Locked");
	$SAP_MSI->from('OITT T0');
	$SAP_MSI->join('OITM T1','T1.ItemCode = T0.Code');
	//$SAP_MSI->where('T0.U_Locked !=', NULL);
	$query = $SAP_MSI->get();
	// echo $SAP_MSI->last_query();
	// die();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_detail_select($id_wo_header){
	$this->db->from('t_produksi_detail');
    $this->db->where('id_produksi_header', $id_wo_header);
	$this->db->order_by('id_produksi_detail');
	$query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function wo_details_input_select($kode_paket){
	$this->db->select('a.id_mpaket_header,a.id_mpaket_h_detail,a.material_no,a.material_desc,a.quantity,a.uom');
	$this->db->from('m_mpaket_detail a');
	$this->db->join('m_mpaket_header b','a.id_mpaket_header=b.id_mpaket_header');
    $this->db->where('b.kode_paket', $kode_paket);
    $this->db->where('b.plant', 'WMSIASST');
	$query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
		return $query->result_array();
    }else{
      return FALSE;
    }
  }
  
  function posting_date_select_max() {
    $this->db->select_max('posting_date');
    $this->db->from('t_posinc_header');
    $this->db->where('plant', 'WMSISNST');
    $this->db->where('status', 2);

    $query = $this->db->get();
    if ($query) {
      $posting_date = $query->row_array();
    }
    if(!empty($posting_date['posting_date'])) {
        $oneday = 60 * 60 * 24;
            $posting_date = date("Y-m-d H:i:s", strtotime($posting_date['posting_date'])+ $oneday);
            return $posting_date;
    }	else {
          return date("Y-m-d H:i:s");
    }
  }
  
	function id_produksi_plant_new_select($id_outlet,$posting_date="",$id_produksi_header="") {

        if (empty($posting_date))
           $posting_date=$this->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_produksi_plant');
		$this->db->from('t_produksi_header');
		$this->db->where('plant', $id_outlet);
		$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_produksi_header)) {
    	  $this->db->where('id_produksi_header <> ', $id_produksi_header);
        }

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0)) {
			$produksi = $query->row_array();
			$id_produksi_outlet = $produksi['id_produksi_plant'] + 1;
		}	else {
			$id_produksi_outlet = 1;
		}

		return $id_produksi_outlet;
	}
  
  function wo_details_select($id_wo_header,$kode_paket,$qty_paket){
	$arr 	=	array();
	$this->db->from('t_produksi_detail');
    $this->db->where('id_produksi_header', $id_wo_header);
	$this->db->order_by('id_produksi_detail');
	$query = $this->db->get();
	$ret = $query->result_array();
	return $ret;
	
	$i = 1;
	$querySAP = array();
	$querySAP2 = array();
	foreach($ret as $data){
		
		//$querySAP = $this->wo_details_delete($data['material_no']);
		$querySAP = $this->wo_detail_valid('1ACRG004');
		if(count($querySAP)>0){
			$validFor = $querySAP[0]['validFor'];
			$decreasAc = $querySAP[0]['DecreasAc'];
		}
		
		//$qty = $this->wo_detail_quantity($kode_paket,$data['material_no']);
		$qty = $this->wo_detail_quantity('1ACO158','FDY0020');
		$quantity = $qty[0]['quantity'];
		$quantity_paket = $qty[0]['quantity_paket'];
		$resqty=$quantity*$qty_paket/$quantity_paket;
		
		//$onhand = $this->wo_detail_onhand($data['material_no']);
		$onhand = $this->wo_detail_onhand('FDY0020');
		
		//$querySAP2 = $this->wo_detail_itemcodebom($kode_paket,$data['material_no']);
		$querySAP2 = $this->wo_detail_itemcodebom('FDY0020','1ACO158');
		$descolumn = '';
		
		//$openqty = $this->wo_detail_openqty($data['material_no']);
		$openqty = $this->wo_detail_openqty('FDG0907');
		
		//$ucaneditqty = $this->wo_detail_ucaneditqty($kode_paket,$data['material_no']);
		$ucaneditqty = $this->wo_detail_ucaneditqty('FDY0020','1ACO158');
		$qtyeditucan = $ucaneditqty[0]['CanEditQty'];
		$matqty = '';
		if($quantity_paket > 0){
			$matqty = '<input style="text-align:right;" type="text" value="'.number_format($resqty, 4, '.', '').'" class="error_number prodqty" size="8">';
		}else{
			$matqty = '<div class="matqty" style="text-align:right;">'.number_format($resqty, 4, '.', '').'</div>';
		}
		
		$openqty = $this->wo_detail_item();
		$qtyopen = '';
		
		$select = '<select class="form-control form-control-select2 select2-hidden-accessible" data-live-search="true" name="status" id="status" tabindex="-1" aria-hidden="true">
						<option value="'.$data['material_no'].'" matqty="'.number_format($resqty, 4, '.', ',').'" matdesc="'.$data['material_desc'].'">'.$data['material_desc'].'</option>';
						foreach($querySAP2 as $dt){
							if($dt['U_ItemCodeBOM'] = $data['material_no']){
								$select .= '<option value="'.$dt['Code'].'" matqty="'.number_format($dt['U_SubsQty'], 4, '.', ',').'" matdesc="'.$dt['NAME'].'">'.$dt['NAME'].'</option>';
							}
						}
		$select .= '</select>';
		
		foreach($querySAP2 as $_querySAP2){
			if($_querySAP2['U_ItemCodeBOM'] = $data['material_no']){
				$descolumn = $select;
			}else{
				$descolumn = $data['material_no'];
			}
		}
		
		foreach($openqty as $_openqty){
			if($_openqty['U_ItemCodeBOM'] = $data['material_no']){
				$qtyopen = $select;
			}else{
				$qtyopen = $data['material_no'];
			}
		}
		$nestedData=array();
		$nestedData['no'] = $i;
		$nestedData['id_produksi_detail'] = $data['id_produksi_detail'];
		$nestedData['id_produksi_header'] = $data['id_produksi_header'];
		$nestedData['material_no'] = $data['material_no'];
		$nestedData['material_desc'] = $data['material_desc'];
		$nestedData['qty'] = $data['qty'];
		$nestedData['uom'] = $data['uom'];
		$nestedData['OnHand'] = $data['OnHand'];
		$nestedData['MinStock'] = $data['MinStock']; 
		$nestedData['OpenQty'] = $data['OpenQty'];
		$nestedData['doc_issue'] = $data['doc_issue'];
		$nestedData['validFor'] = $validFor;
		$nestedData['decreasAc'] = $decreasAc;
		$nestedData['descolumn'] = $descolumn;
		$nestedData['matQty'] = $matqty;
		$arr[] = $nestedData;
        $i++;
	}
	return $arr;
  }

}