<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TransferIn_model extends CI_Model {

    function t_grsto_headers($fromDate='', $toDate='', $status=''){
        $this->db->select('t_grsto_header.*, (SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET = t_grsto_header.delivery_plant) AS OUTLET_NAME1, (SELECT admin_realname FROM d_admin WHERE admin_id = t_grsto_header.id_user_input) AS user_input, (SELECT admin_realname FROM d_admin WHERE admin_id = t_grsto_header.id_user_approved) AS user_approved');
        $this->db->from('t_grsto_header');
        $this->db->where('t_grsto_header.plant','WMSIASST');

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

        $this->db->order_by('id_grsto_header', 'desc');

        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $ret = $query->result_array();
        return $ret;
    }

    public function sap_do_select_all($kd_plant="",$do_no="",$do_item=""){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);

        $SAP_MSI->select('U_TransFor'); 
        $SAP_MSI->from('OWHS');
        $SAP_MSI->where('WhsCode', 'WMSISNST');
        $CON1 = $SAP_MSI->get();
        $CON1Result = $CON1->result_array();
        $plant = $CON1Result[0]["U_TransFor"];
        
        $this->db->query('SET @num=0');
		    $this->db->select('po_no EBELN, gistonew_out_no  MBLNR, plant SUPPL_PLANT, STOR_LOC_NAME SPLANT_NAME, posting_date DELIV_DATE, DISPO, id_gistonew_out_h_detail EBELP, MATNR, MAKTX, (gr_quantity-receipt) BSTMG, uom BSTME,(@num := @num + 1) as NUMBER, gr_quantity as TFQUANTITY');
  	    $this->db->from('t_gistonew_out_header');
		    $this->db->join('t_gistonew_out_detail','t_gistonew_out_detail.id_gistonew_out_header = t_gistonew_out_header.id_gistonew_out_header','inner');
		    $this->db->join('m_item','m_item.MATNR = t_gistonew_out_detail.material_no','inner');
		    $this->db->join('m_outlet','m_outlet.outlet = t_gistonew_out_header.plant','inner');
		    $this->db->where('receiving_plant',$plant);
  	    $this->db->where('status',2);
     	  $this->db->where('po_no != ""');
		    $this->db->where('gistonew_out_no != ""');
		    $this->db->where('gistonew_out_no != "C"');
		    $this->db->where('(gr_quantity-receipt) > 0');
		    $this->db->where('close = 0');
        $this->db->where('plant != "05WHST"');

        if((!empty($do_no))){
          $this->db->where('po_no', $do_no);
      }
         
       $query = $this->db->get();
      //  echo $this->db->last_query();
      //  die();

  	    if($query->num_rows() > 0) {
        //if (count($PO_STO_OUTS) > 0) {
          $PO_STO_OUTS = $query->result_array();
          $count = count($PO_STO_OUTS)-1;
          for ($i=0;$i<=$count;$i++) {
            $poitems[$i+1] = $PO_STO_OUTS[$i];
          }

          return $poitems;
        } else {
          return FALSE;
        }
    }

    function sap_grsto_details_select_by_do_no($do_no) {
        if (empty($this->session->userdata['do_nos'])) {
            $doitems = $this->sap_do_select_all("",$do_no);
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $k = 1;
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
                if ($do_nos[$i]['VBELN']==$do_no){
                    $doitems[$k] = $do_nos[$i];
                    $k++;
                }
            }
        }

        $count = count($doitems);
        if ($count > 0) {
            for($i=1;$i<=$count;$i++) {
                $doitems[$i]['id_gistonew_out_h_detail'] = $i;
            }
        return $doitems;
        }
        else {
            unset($doitems);
            return FALSE;
        }
    }

    function getQtySR($pr_no,$material_no){
      $doitems = $this->sap_do_select_all("",$pr_no);
      $this->db->select('id_stdstock_header'); 
      $this->db->from('t_stdstock_header');
      $this->db->where('pr_no', $pr_no);

      $query = $this->db->get();
      $con = $query->result_array();
      $id_stdstock_header = $con[0]["id_stdstock_header"];
      
      $this->db->select('requirement_qty'); 
      $this->db->from('t_stdstock_detail');
      $this->db->where('id_stdstock_header', $id_stdstock_header);
      $this->db->where('material_no',$material_no);

      $queryDetail = $this->db->get();
      $conDetail = $queryDetail->result_array();
  
      if($conDetail){
        return $conDetail;
      }else{
        return false;
      }
    }


    function sap_grsto_details_select_by_do_and_item_group($do_no,$item_group_code) {
        $doitems = $this->sap_grsto_details_select_by_do_no($do_no);
        $count = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          if ($doitems[$i]['DISPO']==$item_group_code){
            $doitem[$k] = $doitems[$i];
            $k++;
          }
        }
        if (count($doitems) > 0) {
          return $doitems;
          echo "<pre>";
          print_r($doitems);
          echo "</pre>";
        }
        else {
          return FALSE;
        }
    }
    
    function sap_gistonew_out_select_item_group_do($do_no) {
        $doitems = $this->sap_grsto_details_select_by_do_no($do_no);
        $item_groups = $this->sap_item_groups_select_all();
        $count = count($item_groups);
        $count_do = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          for($j=1;$j<=$count_do;$j++) {
            if ($doitems[$j]['DISPO']==$item_groups[$i]['DISPO']){
              $item_groups_filter[$k]["DSNAM"] = $item_groups[$i]['DSNAM'];
              $item_groups_filter[$k]["DISPO"] = $item_groups[$i]['DISPO'];
              $k++;
              break;
            }
          }
        }
        if (count($item_groups_filter) > 0) {
          $item_groups_filter = array_unique($item_groups_filter);
          return $item_groups_filter;
        }
        else {
          return FALSE;
        }
    }
    
    function id_stdstock_plant_new_select($id_outlet,$posting_date="",$id_grsto_header="") {

      if (empty($posting_date))
          $posting_date=$this->m_general->posting_date_select_max();
      if (empty($id_outlet))
          $id_outlet=$this->session->userdata['ADMIN']['plant'];

      $this->db->select_max('id_grsto_plant');
      $this->db->from('t_grsto_header');
      $this->db->where('plant', $id_outlet);
	  	$this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grsto_header)) {
    		  $this->db->where('id_grsto_header <> ', $id_grsto_header);
        }
      $query = $this->db->get();

      if($query->num_rows() > 0) {
        $gistonew_out = $query->row_array();
        $id_stdstock_outlet = $gistonew_out['id_grsto_plant'] + 1;
      }	else {
        $id_stdstock_outlet = 1;
      }
      return $id_stdstock_outlet;
    }

    function cekQty($po_no,$material_no){
      $this->db->select('A.receipt,A.var');
      $this->db->from('t_gistonew_out_detail A');
      $this->db->join('t_gistonew_out_header B','A.id_gistonew_out_header=B.id_gistonew_out_header');
      $this->db->where('B.po_no', $po_no);
      $this->db->where('A.material_no', $material_no);
      
      $query=$this->db->get();
      $cekQtyR = $query->result_array();
      if($query->num_rows() > 0) {
        return $cekQtyR;
      }else{
        return FALSE;
      }

    }

    function update_grstonew_out_detail($data){
      $receipt = $data['receipt'];
      $var = $data['var'];
      $po_no = $data['po_no'];
      $material_no = $data['material_no'];
      $sql = "update t_gistonew_out_detail as A 
                join t_gistonew_out_header as B
                on A.id_gistonew_out_header = B.id_gistonew_out_header
              SET A.receipt = $receipt , var = $var
              WHERE A.material_no = '". $material_no ."' AND B.po_no = '". $po_no ."'";
        $query =  $this->db->query($sql);
        if($query)
        // echo $this->db->last_query();
          return TRUE;
        else
          return FALSE;
    }

    function grsto_header_insert($data) {
		if($this->db->insert('t_grsto_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
    }

    function grsto_detail_insert($data) {
    if($this->db->insert('t_grsto_detail', $data))
			return $this->db->insert_id();
		else 
			return FALSE;
    }

    function getDataMaterialGroupSelect($po_no, $itemSelect){
      $plant = 'WMSISTRM';
      $SAP_MSI = $this->load->database('SAP_MSI', TRUE);

      $dataHeader = $this->sap_do_select_all('',$po_no, $itemSelect);
      for($i = 1; $i <= count($dataHeader); $i++){
        $SAP_MSI->select('OnHand'); 
        $SAP_MSI->from('OITW');
        $SAP_MSI->where('WhsCode', 'WMSISNST');
        $SAP_MSI->where('ItemCode', $dataHeader[$i]['MATNR']);

        $query = $SAP_MSI->get();
        $inwhs = $query->result_array();

        $dataHeader[$i]['In_Whs_Qty'] = $inwhs[0]['OnHand'];
      }
      return $dataHeader;
    }

    function in_whs_qty($plant,$item_code){
      $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
      $SAP_MSI->select('OnHand'); 
      $SAP_MSI->from('OITW');
      $SAP_MSI->where('WhsCode', $plant);
      $SAP_MSI->where('ItemCode', $item_code);

      $query = $SAP_MSI->get();
      $inwhs = $query->result_array();
      return $inwhs;
    }

    function grsto_header_update($data){
      $this->db->where('id_grsto_header', $data['id_grsto_header']);
        if($this->db->update('t_grsto_header', $data))
          return TRUE;
        else
          return FALSE;
    }

    function grsto_details_delete($id_grsto_header) {
      $this->db->where('id_grsto_header', $id_grsto_header);
      if($this->db->delete('t_grsto_detail'))
        return TRUE;
      else
        return FALSE;
    }

  function sap_grpo_details_select_by_po_no($po_no) {
    if (empty($this->session->userdata['grpo_nos'])) {
        $poitems = $this->sap_grpo_headers_select_by_kd_vendor("","",$po_no);
    } else {
        $po_nos = $this->session->userdata['grpo_nos'];
        $k = 1;
        $count = count($po_nos);
        for ($i=1;$i<=$count;$i++) {
          if ($po_nos[$i]['EBELN']==$po_no){
            $poitems[$k] = $po_nos[$i];
            $k++;
          }
        }
    }
    $count = count($poitems);
    if ($count > 0) {
      for($i=1;$i<=$count;$i++) {
        $poitems[$i]['id_grpo_h_detail'] = $i;
      }
      return $poitems;
    }
    else {
      unset($poitems);
      return FALSE;
    }
  }
  
    function sap_item_groups_select_all() {
      // $kd_plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->from('m_item_group');
          $this->db->where('kdplant', 'WMSISNST');

      $query = $this->db->get();
      if(($query)&&($query->num_rows() > 0)) {
          $item_groups = $query->result_array();
      $count = count($item_groups);
      $k = 1;
      for ($i=0;$i<=$count-1;$i++) {
          $item_group[$k] = $item_groups[$i];
          $k++;
      }
      return $item_group;
      } else {
      return FALSE;
      }
    }

    function sap_grsto_header_select_by_do_no($do_no) {

        if (empty($this->session->userdata['do_nos'])) {
            $doheader = $this->sap_do_select_all("",$do_no);
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
              if ($do_nos[$i]['VBELN']==$do_no){
                $doheader[1] = $do_nos[$i];
                break;
              }
            }
        }

        if (count($doheader) > 0) {
          return $doheader[1];
        }
        else {
          unset($doitems);
          return FALSE;
        }
    }
    
    function grsto_header_select($id_grsto_header){
        $this->db->select('t_grsto_header.*,(select STOR_LOC_NAME from m_outlet where OUTLET = t_grsto_header.plant) as plant_name_new, (select STOR_LOC_NAME from m_outlet where OUTLET = t_grsto_header.storage_location) as storage_location_name_new, (select STOR_LOC_NAME from m_outlet where OUTLET = t_grsto_header.delivery_plant) as delivery_plant_name_new');
        $this->db->from('t_grsto_header');
        // $this->db->join('m_outlet', 'm_outlet.OUTLET = t_grsto_header.to_plant');
        $this->db->where('id_grsto_header', $id_grsto_header);
        // $this->db->where('t_grsto_header.plant','WMSISNST');
        
        $query = $this->db->get();
    
        if(($query)&&($query->num_rows() > 0)){
          return $query->row_array();
        }else{
          return FALSE;
        }
    }

    function stdstock_details_select($id_grsto_header) {
		$this->db->from('t_grsto_detail');
        $this->db->where('id_grsto_header', $id_grsto_header);
        // $this->db->where('ok_cancel', '0');
            $this->db->order_by('id_grsto_detail');

            $query = $this->db->get();
            // echo $this->db->last_query();

            if(($query)&&($query->num_rows() > 0))
                return $query->result_array();
            else
                return FALSE;
    }

    function cancelHeaderPoFromVendor($data){
        $this->db->set('status', '3');
        $this->db->where('id_grsto_header', $data['id_grsto_header']);
        if($this->db->update('t_grsto_header')){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function cancelDetailsPoFromVendor($data){
        $this->db->set('ok_cancel', '1');
        $this->db->where('id_grsto_detail', $data);
        if($this->db->update('t_grsto_detail')){
            return TRUE;
        }else{
            return FALSE;
        }
    }

  function sap_grpo_select_item_group_po($po_no) {
    $poitems = $this->sap_grpo_details_select_by_po_no($po_no);
    $item_groups = $this->sap_item_groups_select_all();
    $count = count($item_groups);
    $count_po = count($poitems);
    $k = 1;
    for ($i=1;$i<=$count;$i++) {
      for($j=1;$j<=$count_po;$j++) {
        if ($poitems[$j]['DISPO']==$item_groups[$i]['DISPO']){
          $item_groups_filter[$k] = $item_groups[$i]['DSNAM'];
          $k++;
          break;
        }
      }
    }
    if (count($item_groups_filter) > 0) {
      $item_groups_filter = array_unique($item_groups_filter);
      return $item_groups_filter;
    }
    else {
      return FALSE;
    }
  }

  function grpo_header_select($id_grpo_header){
    $this->db->from('t_grpo_header');
    $this->db->where('id_grpo_header', $id_grpo_header);
    
    $query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
      return $query->row_array();
    }else{
      return FALSE;
    }
  }

  function grpo_details_select($id_grpo_header) {
		$this->db->from('t_grpo_detail');
    $this->db->where('id_grpo_header', $id_grpo_header);
    $this->db->where('ok_cancel', '0');
		$this->db->order_by('id_grpo_detail');

		$query = $this->db->get();

		if(($query)&&($query->num_rows() > 0))
			return $query->result_array();
		else
			return FALSE;
  }

  function posting_date_select_max() {
    // $id_outlet = $this->session->userdata['ADMIN']['plant'];
    $this->db->select_max('posting_date');
    $this->db->from('t_posinc_header');
    $this->db->where('plant', 'WMSISNST');
    $this->db->where('status', 2);
  //		$this->db->where('waste_no is not null AND waste_no <> "" ');

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
  
  function id_grpo_plant_new_select($id_outlet,$posting_date="",$id_grpo_header="") {

    if (empty($posting_date))
       $posting_date=$this->posting_date_select_max();
    if (empty($id_outlet))
       $id_outlet=$this->session->userdata['ADMIN']['plant'];

    $this->db->select_max('id_grpo_plant');
    $this->db->from('t_grpo_header');
    $this->db->where('plant', $id_outlet);
    $this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_grpo_header)) {
        $this->db->where('id_grpo_header <> ', $id_grpo_header);
        }

    $query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)) {
      $grpo = $query->row_array();
      $id_grpo_outlet = $grpo['id_grpo_plant'] + 1;
    }	else {
      $id_grpo_outlet = 1;
    }

    return $id_grpo_outlet;
  }

  function grpo_header_insert($data) {
		if($this->db->insert('t_grpo_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
  }
  
  function grpo_detail_insert($data) {
    if($this->db->insert('t_grpo_detail', $data))
      return $this->db->insert_id();
		else
			return FALSE;
  }

  function grpo_header_update($data) {
    $this->db->set('posting_date', $data['posting_date']);
		$this->db->where('id_grpo_header', $data['id_grpo_header']);
    if($this->db->update('t_grpo_header', $data))
      return TRUE;
		else
			return FALSE;
  }
  
  function grpo_detail_update($data) {
		$this->db->where('id_grpo_detail', $data['id_grpo_detail']);
    if($this->db->update('t_grpo_detail', $data))
			return TRUE;
		else
			return FALSE;
	}
  
    function t_grsto_header_delete($id_grsto_header){
        if($this->t_grsto_details_delete($id_grsto_header)){
            $this->db->where('id_grsto_header', $id_grsto_header);
            if($this->db->delete('t_grsto_header'))
                return TRUE;
            else
                return FALSE;
        }
    }

    function t_grsto_details_delete($id_grsto_header) {
        $this->db->where('id_grsto_header', $id_grsto_header);
        if($this->db->delete('t_grsto_detail'))
            return TRUE;
        else
            return FALSE;
    }

    function tampil($id_grsto_header){
      $this->db->select('a.gistonew_out_no,a.po_no,a.posting_date,b.material_no,b.material_desc,b.uom,b.gr_quantity,b.num,a.plant,a.receiving_plant,(SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET=a.plant) as NAME1, (SELECT OUTLET FROM m_outlet WHERE TRANSIT=a.receiving_plant) as PLANT_REC,
      (SELECT OUTLET_NAME1 FROM m_outlet WHERE TRANSIT=a.receiving_plant) as PLANT_REC_NAME');
      $this->db->from('t_grsto_header a');
      $this->db->join('t_grsto_detail b','a.id_grsto_header = b.id_grsto_header','left');
      $this->db->where('a.id_grsto_header',$id_grsto_header);

      $query = $this->db->get();

      return $query->result_array();
	}
}