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
        $this->db->select('* ,(select OUTLET_NAME1 from m_outlet where OUTLET = t_stdstock_header.to_plant) as OUTLET_NAME1,(select admin_realname from d_admin where admin_id = t_stdstock_header.id_user_input) as user_input, (select admin_realname from d_admin where admin_id = t_stdstock_header.id_user_approved) as user_approved');
        $this->db->from('t_stdstock_header');
        // $this->db->join('m_outlet', 'm_outlet.OUTLET = t_stdstock_header.to_plant');
        // $this->db->join('d_admin','t_stdstock_header.id_user_input = d_admin.admin_id','left');
        // $this->db->join('d_admin c','t_stdstock_header.id_user_approved = c.admin_id','left');
        $this->db->where('t_stdstock_header.plant','WMSISNST');
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
        // echo $this->db->last_query();
        // die();
        $ret = $query->result_array();
        return $ret;
    }

    function getDataMaterialGroup($item_group_code ='all'){
        $kd_plant = 'WMSISNST';
        $trans_type = 'stdstock';
        $this->db->distinct();
        $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
        $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
        $this->db->from('m_item');
        $this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
        $this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
        $this->db->where('transtype', $trans_type);
        $this->db->where('m_item_group.kdplant', $kd_plant);
        
        $this->db->limit(500);
        if($item_group_code !='all'){
            $this->db->where('m_item_group.DSNAM', $item_group_code);
        }

        $this->db->order_by('MATNR', 'desc');

        $query = $this->db->get();
        // echo $this->db->last_query();
        
        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function getDataMaterialGroupSelect($itemSelect){
        if(($itemSelect != '') || ($itemSelect != null)){
            $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
            $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
            $this->db->from('m_item');
            $this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
            $this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
            $this->db->where('transtype', 'stdstock');
            $this->db->where('m_item_group.kdplant','WMSISNST');
            $this->db->where('m_item.MATNR',$itemSelect);

            // $this->db->limit(10000);
            $query = $this->db->get();
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
        $this->db->from('t_stdstock_header');
        $this->db->join('m_outlet', 'm_outlet.OUTLET = t_stdstock_header.to_plant');
        $this->db->where('id_stdstock_header', $id_stdstock_header);
        $this->db->where('t_stdstock_header.plant','WMSISNST');
        
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
}