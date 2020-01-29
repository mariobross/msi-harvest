<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pofromvendor_model extends CI_Model {

  public function getDataPoVendor_Header($fromDate='', $toDate='', $status=''){
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->from('t_grpo_header');
      $this->db->join('m_outlet', 'm_outlet.OUTLET = t_grpo_header.plant');
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

      $this->db->order_by('id_grpo_header', 'desc');
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      $ret = $query->result_array();
      return $ret;
  }

  public function sap_grpo_headers_select_by_kd_vendor($kd_vendor="",$kd_plant="",$po_no="",$po_item="")
  {
    # code...
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    
    $SAP_MSI->select('POR1.DocEntry as EBELN,LineNum as EBELP,OPOR.CardCode as VENDOR, OPOR.CardName as VENDOR_NAME,
    POR1.ItemCode as MATNR,Dscription as MAKTX,OpenQty as BSTMG,
    unitMsr as BSTME, ItmsGrpCod as DISPO,CONVERT(VARCHAR(8),POR1.ShipDate,112) as DELIV_DATE, 
    SeriesName + RIGHT(00000  + CONVERT(varchar, OPOR.DocNum), 5) as DOCNUM');
    $SAP_MSI->from('POR1');
    $SAP_MSI->join('OPOR','POR1.DocEntry = OPOR.DocEntry');
    $SAP_MSI->join('OITM','POR1.ItemCode = OITM.ItemCode');
    $SAP_MSI->join('NNM1','OPOR.Series = NNM1.Series');
    $SAP_MSI->where('WhsCode',$kd_plant);
    $SAP_MSI->where('OPOR.DocStatus' ,'O');
    $SAP_MSI->where('POR1.TrgetEntry is NULL', NULL, TRUE);
    // $SAP_MSI->where('BSTMG >',0);
    
    if(!empty($po_no)) {
        $SAP_MSI->where('POR1.DocEntry',$po_no);
    }
    if(!empty($po_item)) {
        $SAP_MSI->where('LineNum',$po_item);
    }
    if(empty($po_no)&&empty($po_item)) {
    }

    $SAP_MSI->order_by('DOCNUM', 'desc');
    $query = $SAP_MSI->get();
    // echo $SAP_MSI->last_query();
    // die();

    if(($query)&&($query->num_rows() > 0)) {
        $pos = $query->result_array();
        $count = count($pos);
        $k = 1;
        for ($i=0;$i<=$count-1;$i++) {
            $po[$k] = $pos[$i];
            $k++;
        }
        return $po;
    } else {
        return FALSE;
    }
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
  
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $this->db->from('m_item_group');
        $this->db->where('kdplant', $kd_plant);

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
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $this->db->select_max('posting_date');
    $this->db->from('t_posinc_header');
    $this->db->where('plant', $kd_plant);
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
  
  function cancelHeaderPoFromVendor($data){
    $this->db->set('status', '3');
    $this->db->where('id_grpo_header', $data['id_grpo_header']);
    if($this->db->update('t_grpo_header')){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function cancelDetailsPoFromVendor($data){
    $this->db->set('ok_cancel', '1');
    $this->db->where('id_grpo_detail', $data);
    if($this->db->update('t_grpo_detail')){
      return TRUE;
    }else{
      return FALSE;
    }
  }

  function grpo_header_delete($id_grpo_header){
    if($this->grpo_details_delete($id_grpo_header)){
      $this->db->where('id_grpo_header', $id_grpo_header);
      if($this->db->delete('t_grpo_header'))
          return TRUE;
      else
          return FALSE;
      }
  }

  function grpo_details_delete($id_grpo_header) {
  $this->db->where('id_grpo_header', $id_grpo_header);
    if($this->db->delete('t_grpo_detail'))
      return TRUE;
    else
      return FALSE;
  }

  function sap_get_nopp($po_no){
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('A.DocEntry');
    $SAP_MSI->from('PRQ1 A');
    $SAP_MSI->join('POR1 B','B.BaseRef=A.DocEntry');
    $SAP_MSI->where('B.DocEntry',$po_no);
    $query = $SAP_MSI->get();
    $ret = $query->result_array();

    if (count($ret) > 0){
        return $ret[0]['DocEntry'];
      }else{
        return "none";
      }
  }

}