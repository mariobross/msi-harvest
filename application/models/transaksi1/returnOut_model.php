<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnOut_model extends CI_Model {

    public function getDataReturnOut_Header($fromDate='', $toDate='', $status=''){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('*, (SELECT admin_realname FROM d_admin WHERE admin_id = t_gisto_dept_header.id_user_input) AS user_input, (SELECT admin_realname FROM d_admin WHERE admin_id = t_gisto_dept_header.id_user_approved) AS user_approved');
        $this->db->from('t_gisto_dept_header');
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

        $this->db->order_by('id_gisto_dept_header', 'desc');
        $query = $this->db->get();
        //   echo $this->db->last_query();
        //   die();
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

    function showOutlet(){
        $this->db->from('m_outlet');
        $this->db->where('LEFT(outlet,1) <> "T" ');
        $this->db->order_by("OUTLET", "asc");

        $query = $this->db->get();
        $ret = $query->result_array();
        return $ret;
    }

    function sap_items_select_by_item_group($item_group="", $itemSelect="") {
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('t0.ItemCode as MATNR1,t0.ItemName as MAKTX,t0.ItmsGrpCod as DISPO,t0.BuyUnitMsr as UNIT,t1.ItmsGrpNam as DSNAM');
        $SAP_MSI->from('OITM  t0');
        $SAP_MSI->join('oitb t1','t1.ItmsGrpCod = t0.ItmsGrpCod','inner');
        $SAP_MSI->where('validFor', 'Y');
        $SAP_MSI->where('t0.InvntItem', 'Y');

        if($item_group != 'all'){
            $SAP_MSI->where('t1.ItmsGrpNam ', $item_group);
        }
        if($itemSelect!=""){
            $SAP_MSI->where('t0.ItemCode', $itemSelect);
        }

        $query = $SAP_MSI->get();
        
        if(($query)&&($query->num_rows() > 0)) {
            return $query->result_array();
        }else {
            return FALSE;
        }
    }
    
    function getDataInWhsQty($itemSelect,$reqPlant){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('OnHand');
        $SAP_MSI->from('OITW');
        $SAP_MSI->where('WhsCode', $reqPlant); 
        $SAP_MSI->where('ItemCode', $itemSelect);

        $query = $SAP_MSI->get();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function posting_date_select_max() {
        $id_outlet = $this->session->userdata['ADMIN']['plant'];
        $this->db->select_max('posting_date');
        $this->db->from('t_posinc_header');
        $this->db->where('plant', $id_outlet);
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

    function id_gisto_dept_plant_new_select($id_outlet,$posting_date="",$id_gisto_dept_header="") {
        if (empty($posting_date))
           $posting_date=$this->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];
    
           $this->db->select_max('id_gisto_dept_plant');
           $this->db->from('t_gisto_dept_header');
           $this->db->where('plant', $id_outlet);
           $this->db->where('DATE(posting_date)', $posting_date);
           if (!empty($id_gisto_dept_header)) {
             $this->db->where('id_gisto_dept_header <> ', $id_gisto_dept_header);
           }
    
        $query = $this->db->get();
    
        if($query->num_rows() > 0) {
			$gisto_dept = $query->row_array();
			$id_gisto_dept_outlet = $gisto_dept['id_gisto_dept_plant'] + 1;
		}	else {
			$id_gisto_dept_outlet = 1;
		}

		return $id_gisto_dept_outlet;
    }

    function gisto_dept_header_insert($data) {
		if($this->db->insert('t_gisto_dept_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
    }
    
    function gisto_dept_detail_insert($data) {
        if($this->db->insert('t_gisto_dept_detail', $data))
            return $this->db->insert_id();
        else
            return FALSE;
    }

    function retout_header_update($data) {
        $this->db->where('id_gisto_dept_header', $data['id_gisto_dept_header']);
        if($this->db->update('t_gisto_dept_header', $data))
          return TRUE;
        else
          return FALSE;
    }

    function gisto_dept_header_select($gisto_dept_header) {
        $this->db->select('t_gisto_dept_header.*, (select STOR_LOC_NAME from m_outlet where OUTLET = t_gisto_dept_header.plant) as plant_name_new, (select STOR_LOC_NAME from m_outlet where OUTLET = t_gisto_dept_header.storage_location) as storage_location_name');
        $this->db->from('t_gisto_dept_header');
        $this->db->where('id_gisto_dept_header', $gisto_dept_header);
  
        $query = $this->db->get();
  
        if(($query)&&($query->num_rows() > 0))
          return $query->row_array();
        else
          return FALSE;
    }

    function gisto_dept_details_select($id_gisto_dept_header) {
		$this->db->from('t_gisto_dept_detail');
        $this->db->where('id_gisto_dept_header', $id_gisto_dept_header);

        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows() > 0))
            return $query->result_array();
        else
            return FALSE;
    }

    function gisto_dept_header_delete($id){
        if($this->gisto_dept_details_delete($id)){
          $this->db->where('id_gisto_dept_header', $id);
          if($this->db->delete('t_gisto_dept_header'))
              return TRUE;
          else
              return FALSE;
        }
    }

    function gisto_dept_details_delete($id){
        $this->db->where('id_gisto_dept_header', $id);
        if($this->db->delete('t_gisto_dept_detail'))
            return TRUE;
        else
            return FALSE;
    }

    function cancelHeaderReturnOut($data){
        $this->db->set('status', '3');
        $this->db->where('id_gisto_dept_header', $data['id_gisto_dept_header']);
        if($this->db->update('t_gisto_dept_header')){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function cancelDetailsReturnOut($data){
        $this->db->set('ok_cancel', '1');
        $this->db->where('id_gisto_dept_detail', $data);
        if($this->db->update('t_gisto_dept_detail')){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function tampil($id_retout_header){
        $this->db->select('a.id_user_approved,a.do_no, a.retin_no, a.posting_date,b.material_no,b.material_desc,b.uom,b.gr_quantity,a.plant, 
        (select f.reason from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
        and a.do_no=d.gisto_dept_no
        and d.receiving_plant=a.plant
        and f.material_no=b.material_no ) reason,
        (select D.plant from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
        and a.do_no=d.gisto_dept_no
        and d.receiving_plant=a.plant
        and f.material_no=b.material_no )  FromPlant ,
        (select e.OUTLET_NAME1 from t_gisto_dept_header d, t_gisto_dept_detail f ,m_outlet e where d.id_gisto_dept_header =f.id_gisto_dept_header
        and a.do_no=d.gisto_dept_no
        and d.receiving_plant=a.plant
        and D.plant=e.OUTLET
        and f.material_no=b.material_no )  OUTLET_NAME1,
        (select D.posting_date from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
        and a.do_no=d.gisto_dept_no
        and d.receiving_plant=a.plant
        and f.material_no=b.material_no )  delivery,
        (select f.gr_quantity from t_gisto_dept_header d, t_gisto_dept_detail f where d.id_gisto_dept_header =f.id_gisto_dept_header
        and a.do_no=d.gisto_dept_no
        and d.receiving_plant=a.plant
        and f.material_no=b.material_no ) Qty_Retur, (SELECT admin_realname FROM d_admin WHERE admin_id = a.id_user_approved) nameApproved');
        $this->db->from('t_retin_header a');
        $this->db->join('t_retin_detail b','a.id_retin_header = b.id_retin_header','left');
        $this->db->where('a.id_retin_header',$id_retout_header);

        $query = $this->db->get();
        // echo $this->db->last_query();

        return $query->result_array();
    }
}