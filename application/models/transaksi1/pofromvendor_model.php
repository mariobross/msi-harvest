<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pofromvendor_model extends CI_Model {

  public function getDataPoVendor_Header($fromDate='', $toDate='', $status=''){
      $this->db->from('t_grpo_header');
      $this->db->join('m_outlet', 'm_outlet.OUTLET = t_grpo_header.plant');
      $this->db->where('plant','WMSITJST');
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
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      $ret = $query->result_array();
      return $ret;
  }

  public function sap_grpo_headers_select_by_kd_vendor($kd_vendor="",$kd_plant="",$po_no="",$po_item="")
  {
    # code...
    $this->db->select('EBELN,EBELP,VENDOR,VENDOR_NAME,
                      MATNR,MAKTX,BSTMG,BSTME,
                      MATKL,DISPO,UNIT,UNIT_STEXT,DELIV_DATE,DOCNUM');
    $this->db->from('zmm_bapi_disp_po_outstanding');
    $this->db->where('PLANT','WMSITJST');
    $this->db->where('BSTMG >',0);
    
    if(!empty($po_no)) {
        $this->db->where('EBELN',$po_no);
    }
    if(!empty($po_item)) {
        $this->db->where('EBELP',$po_item);
    }
    if(empty($po_no)&&empty($po_item)) {
    }

    $query = $this->db->get();

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
  
    // $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $this->db->from('m_item_group');
        $this->db->where('kdplant', 'WMSITJST');

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
    // $id_outlet = $this->session->userdata['ADMIN']['plant'];
    $this->db->select_max('posting_date');
    $this->db->from('t_posinc_header');
    $this->db->where('plant', 'WMSITJST');
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
}