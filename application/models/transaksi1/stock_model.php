<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model {
  
  function t_opname_headers($date_from2, $date_to2, $status){
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $this->db->select('t_opname_header.*,(select admin_realname from d_admin where admin_id = t_opname_header.id_user_input) as user_input, (select admin_realname from d_admin where admin_id = t_opname_header.id_user_approved) as user_approved ');
    $this->db->from('t_opname_header');
    $this->db->where('t_opname_header.plant',$kd_plant);
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

    $this->db->order_by('id_opname_header', 'desc');

    $query = $this->db->get();
    // echo $this->db->last_query();
    // die();
    $ret = $query->result_array();
    return $ret;

  }

  function tampil($id_opname_header){
    $this->db->select('a.opname_no,  a.created_date,b.material_no,b.material_desc,b.uom,b.requirement_qty,a.plant, a.id_user_approved,b.num, (select admin_realname from d_admin where admin_id = a.id_user_approved) as user_approved');
    $this->db->from('t_opname_header a');
    $this->db->join('t_opname_detail b','a.id_opname_header = b.id_opname_header');
    $this->db->where('a.id_opname_header', $id_opname_header);
  
    $query = $this->db->get();
    // echo $this->db->last_query();
    // die();
    $ret = $query->result_array();
    return $ret;
  }
  
  function showMatrialGroup(){
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('ItmsGrpNam');
    $SAP_MSI->from('OITB');

    $query = $SAP_MSI->get();
    $ret = $query->result_array();
    return $ret;
  }

  function sap_item_groups_select_all_grnonpo($itemSelect='') {
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('t0.ItemCode as MATNR,t0.ItemName as MAKTX,t0.ItmsGrpCod as DISPO,t0.BuyUnitMsr as UNIT,t1.ItmsGrpNam as DSNAM');
    $SAP_MSI->from('OITM  t0');
    $SAP_MSI->where('validFor', 'Y');
    $SAP_MSI->where('t0.InvntItem', 'Y');
    $SAP_MSI->join('oitb t1','t1.ItmsGrpCod = t0.ItmsGrpCod','inner');

    if($itemSelect != ''){
      $SAP_MSI->where('ItemCode', $itemSelect);
    }
    
    $item_groups = $SAP_MSI->get();
    // echo $this->db->last_query();
    // die();
    
    if ($item_groups->num_rows() > 0) {
      return $item_groups->result_array();
    } else {
      return FALSE;
    }
  }

  function sap_items_select_by_item_group($item_group, $trans_type) {
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('t0.ItemCode as MATNR,t0.ItemName as MAKTX,t0.ItmsGrpCod as DISPO,t0.BuyUnitMsr as UNIT,t1.ItmsGrpNam as DSNAM');
    $SAP_MSI->from('OITM  t0');
    $SAP_MSI->join('oitb t1','t1.ItmsGrpCod = t0.ItmsGrpCod','inner');
    $SAP_MSI->where('validFor', 'Y');
    $SAP_MSI->where('t0.InvntItem', 'Y');
    $SAP_MSI->where('t1.ItmsGrpNam ', $item_group);
    
    $item_groups = $SAP_MSI->get();
    // echo $this->db->last_query();
    
    if ($item_groups->num_rows() > 0) {
      return $item_groups->result_array();
    } else {
      return FALSE;
    }
  }

  function id_opname_plant_new_select($id_outlet,$created_date="",$id_pr_header="") {
    if (empty($created_date))
       $created_date=$this->posting_date_select_max();
    if (empty($id_outlet))
       $id_outlet=$this->session->userdata['ADMIN']['plant'];

    $this->db->select_max('id_pr_plant');
    $this->db->from('t_prnew_header');
    $this->db->where('plant', $id_outlet);
    $this->db->where('DATE(created_date)', $created_date);
    if (!empty($id_pr_header)) {
    $this->db->where('id_pr_header <> ', $id_pr_header);
    }

    $query = $this->db->get();

    if($query->num_rows() > 0) {
      $pr = $query->row_array();
      $id_pr_outlet = $pr['id_pr_plant'] + 1;
    }	else {
      $id_pr_outlet = 1;
    }

    return $id_pr_outlet;
  }

  function posting_date_select_max() {
    $id_outlet = $this->session->userdata['ADMIN']['plant'];
    $this->db->select_max('posting_date');
    $this->db->from('t_posinc_header');
    $this->db->where('plant', $id_outlet);
    $this->db->where('status', 2);
//	$this->db->where('waste_no is not null AND waste_no <> "" ');

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

  function opname_header_insert($data) {
		if($this->db->insert('t_opname_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
  }
  
  function opname_detail_insert($data) {
		if($this->db->insert('t_opname_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
  }
  
  function t_opname_header_delete($id_opname_header){
    if($this->t_opname_details_delete($id_opname_header)){
        $this->db->where('id_opname_header', $id_opname_header);
        if($this->db->delete('t_opname_header'))
            return TRUE;
        else
            return FALSE;
    }
  }

  function t_opname_details_delete($id_opname_header) {
      $this->db->where('id_opname_header', $id_opname_header);
      if($this->db->delete('t_opname_detail'))
          return TRUE;
      else
          return FALSE;
  }

  function opname_header_select($id_opname_header){
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $this->db->from('t_opname_header');
    $this->db->where('id_opname_header', $id_opname_header);
    $this->db->where('plant',$kd_plant);
    
    $query = $this->db->get();

    if(($query)&&($query->num_rows() > 0)){
      return $query->row_array();
    }else{
      return FALSE;
    }
  }

  function opname_details_select($id_opname_header) {
		$this->db->from('t_opname_detail');
      $this->db->where('id_opname_header', $id_opname_header);
      // $this->db->where('ok_cancel', '0');
      $this->db->order_by('id_opname_detail');

      $query = $this->db->get();

      if(($query)&&($query->num_rows() > 0))
        return $query->result_array();
      else
        return FALSE;
  }

  function changeUpdateToDb($data){
    $this->db->where('id_opname_detail', $data['id_opname_detail']);
    if($this->db->update('t_opname_detail', $data))
      return TRUE;
    else
      return FALSE;
  }

  function opname_header_update($data){
    $this->db->where('id_opname_header', $data['id_opname_header']);
    if($this->db->update('t_opname_header', $data))
      return TRUE;
    else
      return FALSE;
  }

  function opname_details_delete($id_opname_header) {
		$this->db->where('id_opname_header', $id_opname_header);
		if($this->db->delete('t_opname_detail'))
			return TRUE;
		else
			return FALSE;
  }    
}