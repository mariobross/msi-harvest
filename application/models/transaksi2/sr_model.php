<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sr_model extends CI_Model {

    function __construct(){ 
        parent::__construct(); 
        
    } 

    function showOutlet(){
        $this->db->from('m_outlet');
        $this->db->order_by("OUTLET", "asc");
        $this->db->not_like('OUTLET', 'T.','after');

        $query = $this->db->get();
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

    function stdstock_headers($fromDate='', $toDate='', $status='',$rto=''){
        $plant = $this->session->userdata['ADMIN']['plant'];

        $this->db->select('* ,(select OUTLET_NAME1 from m_outlet where OUTLET = t_stdstock_header.to_plant) as OUTLET_NAME1,(select admin_realname from d_admin where admin_id = t_stdstock_header.id_user_input) as user_input, (select admin_realname from d_admin where admin_id = t_stdstock_header.id_user_approved) as user_approved');
        $this->db->from('t_stdstock_header');
        
        $this->db->where('t_stdstock_header.plant', $plant);
        if((!empty($fromDate)) || (!empty($toDate))){
            if( (!empty($fromDate)) || (!empty($toDate)) ) {
            $this->db->where("delivery_date BETWEEN '$fromDate' AND '$toDate'");
          } else if( (!empty($fromDate))) {
            $this->db->where("delivery_date >= '$fromDate'");
          } else if( (!empty($toDate))) {
            $this->db->where("delivery_date <= '$toDate'");
          }
        }
        if((!empty($status))){
            $this->db->where('status', $status);
        }
        if((!empty($rto))){
            $this->db->where('to_plant', $rto);
        }

        $this->db->order_by('id_stdstock_header', 'desc');

        $query = $this->db->get();

        $ret = $query->result_array();
        return $ret;
    }

    function getDataMaterialGroup($item_group_code ='all'){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $trans_type = 'stdstock';
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('t0.ItemCode as MATNR,t0.ItemName as MAKTX,t0.ItmsGrpCod as DISPO,t0.BuyUnitMsr as UNIT,t1.ItmsGrpNam as DSNAM');
        $SAP_MSI->from('OITM  t0');
        $SAP_MSI->where('validFor', 'Y');
        $SAP_MSI->where('InvntItem', 'Y');
        $SAP_MSI->join('oitb t1','t1.ItmsGrpCod = t0.ItmsGrpCod','inner');

        if($item_group_code !='all'){
            $SAP_MSI->where('t1.ItmsGrpNam', $item_group_code);
        }

        $SAP_MSI->order_by('t0.ItemCode', 'desc');

        $query = $SAP_MSI->get();
        // echo $SAP_MSI->last_query();
        // die();
        
        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function getDataMaterialGroupSelect($itemSelect){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        if(($itemSelect != '') || ($itemSelect != null)){
            
            $SAP_MSI->select('t0.ItemCode as MATNR,t0.ItemName as MAKTX,t0.ItmsGrpCod as DISPO,t0.BuyUnitMsr as UNIT,t1.ItmsGrpNam as DSNAM');
            $SAP_MSI->from('OITM  t0');
            $SAP_MSI->where('validFor', 'Y');
            $SAP_MSI->where('InvntItem', 'Y'); 
            $SAP_MSI->where('ItemCode', $itemSelect);
            $SAP_MSI->join('oitb t1','t1.ItmsGrpCod = t0.ItmsGrpCod','inner');

            // $this->db->limit(10000);
            $query = $SAP_MSI->get();
            return $query->result_array();
        }else{
            return false;
        }
    }

    function id_stdstock_plant_new_select($id_outlet,$created_date="",$id_stdstock_header="") {

        if (empty($created_date))
           $created_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_stdstock_plant');
		$this->db->from('t_stdstock_header');
		$this->db->where('plant', $id_outlet);
	  	$this->db->where('DATE(created_date)', $created_date);
        if (!empty($id_stdstock_header)) {
    		$this->db->where('id_stdstock_header <> ', $id_stdstock_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$stdstock = $query->row_array();
			$id_stdstock_outlet = $stdstock['id_stdstock_plant'] + 1;
		}	else {
			$id_stdstock_outlet = 1;
		}

		return $id_stdstock_outlet;
    }
    
    function stdstock_header_insert($data) {
		if($this->db->insert('t_stdstock_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
    }
    
    function stdstock_detail_insert($data) {
		if($this->db->insert('t_stdstock_detail', $data))
			return $this->db->insert_id();
		else 
			return FALSE;
    }
    
    function stdstock_header_select($id_stdstock_header){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->from('t_stdstock_header');
        $this->db->join('m_outlet', 'm_outlet.OUTLET = t_stdstock_header.to_plant');
        $this->db->where('id_stdstock_header', $id_stdstock_header);
        $this->db->where('t_stdstock_header.plant',$kd_plant);
        
        $query = $this->db->get();
    
        if(($query)&&($query->num_rows() > 0)){
          return $query->row_array();
        }else{
          return FALSE;
        }
    }

    function stdstock_details_select($id_stdstock_header) {
		$this->db->from('t_stdstock_detail');
        $this->db->where('id_stdstock_header', $id_stdstock_header);
        // $this->db->where('ok_cancel', '0');
            $this->db->order_by('id_stdstock_detail');

            $query = $this->db->get();

            if(($query)&&($query->num_rows() > 0))
                return $query->result_array();
            else
                return FALSE;
    }

    function changeUpdateToDb($data){
        $this->db->where('id_stdstock_detail', $data['id_stdstock_detail']);
        if($this->db->update('t_stdstock_detail', $data))
			return TRUE;
		else
			return FALSE;
    }

    function stdstock_header_update($data){
        $this->db->where('id_stdstock_header', $data['id_stdstock_header']);
        if($this->db->update('t_stdstock_header', $data))
			return TRUE;
		else
			return FALSE;
    }

    function stdstock_header_delete($id_stdstock_header){
        $this->db->select('pr_no');
        $this->db->from('t_stdstock_header');
        $this->db->where('id_stdstock_header', $id_stdstock_header);
        $query = $this->db->get();
        $dataArr = $query->result_array();
        if($dataArr[0]['pr_no'] != ''){
            if($this->cekNoSRinTO($dataArr[0]['pr_no'])){
                return FALSE;
            }else{
                if($this->stdstock_details_delete($id_stdstock_header)){
                    $this->db->where('id_stdstock_header', $id_stdstock_header);
                    if($this->db->delete('t_stdstock_header'))
                        return TRUE;
                    else
                        return FALSE;
                }

            }
        }else{
            if($this->stdstock_details_delete($id_stdstock_header)){
                $this->db->where('id_stdstock_header', $id_stdstock_header);
                if($this->db->delete('t_stdstock_header'))
                    return TRUE;
                else
                    return FALSE;
            }
        }

        if($this->stdstock_details_delete($id_stdstock_header)){
            $this->db->where('id_stdstock_header', $id_stdstock_header);
            if($this->db->delete('t_stdstock_header'))
                return TRUE;
            else
                return FALSE;
        }
    }

    function stdstock_details_delete($id_stdstock_header) {
		$this->db->where('id_stdstock_header', $id_stdstock_header);
		if($this->db->delete('t_stdstock_detail'))
			return TRUE;
		else
			return FALSE;
    }
    
    function tampil($id_stdstock_header){
        $this->db->select('a.pr_no, a.created_date, a.delivery_date, b.material_no, b.material_desc, b.uom, b.requirement_qty, b.price, a.plant, a.id_user_approved , to_plant, c.OUTLET_NAME1');
        
        $this->db->from('t_stdstock_header a');
        $this->db->join('t_stdstock_detail b','a.id_stdstock_header = b.id_stdstock_header','left');
        $this->db->join('m_outlet c','a.to_plant=c.OUTLET','inner');
        $this->db->where('a.id_stdstock_header', $id_stdstock_header);
        
        $query = $this->db->get();

        return $query->result_array();
    }
    
    function userApproved($id_user_approved=''){
        $this->db->select('admin_realname');
        $this->db->from('d_admin');
        $this->db->where('admin_id',$id_user_approved);

        $query = $this->db->get();

        return $query->result_array();
    }

    function cekNoSRinTO($srNo){
        $this->db->from('t_gistonew_out_header');
        $this->db->where('po_no',$srNo);
        $this->db->where('status','2');
        $query = $this->db->get();
        if(($query)&&($query->num_rows() > 0))
                return TRUE;
            else
                return FALSE;
        // return $query->result_array();
    }
}