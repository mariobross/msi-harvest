<?php defined('BASEPATH') OR exit('No direct script access allowed');

class whole_model extends CI_Model {

    function __construct(){ 
        parent::__construct(); 
        
    } 

    // function showOutlet(){
    //     $this->db->from('m_outlet');
    //     $this->db->order_by("OUTLET", "asc");
    //     $this->db->not_like('OUTLET', 'T.','after');

    //     $query = $this->db->get();
    //     $ret = $query->result_array();
    //     return $ret;
    // }

    // function showMatrialGroup(){
    //     $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    //     $SAP_MSI->select('ItmsGrpNam');
    //     $SAP_MSI->from('OITB');

    //     $query = $SAP_MSI->get();
    //     $ret = $query->result_array();
    //     return $ret;
    // }

    function twtsnew_headers($status=''){
        $plant = $this->session->userdata['ADMIN']['plant'];

        $this->db->select('* ,(select admin_realname from d_admin where admin_id = m_twtsnew_header.id_user_input) as user_input, (select admin_realname from d_admin where admin_id = m_twtsnew_header.id_user_approved) as user_approved');
        $this->db->from('m_twtsnew_header');
        
        $this->db->where('m_twtsnew_header.plant', $plant);
        
        if((!empty($status))){
            $this->db->where('status', $status);
        }

        $this->db->order_by('id_twtsnew_header', 'desc');

        $query = $this->db->get();
        // echo $this->db->last_query();

        $ret = $query->result_array();
        return $ret;
    }

    // function getDataMaterialGroup($item_group_code ='all'){
    //     $kd_plant = $this->session->userdata['ADMIN']['plant'];
    //     $trans_type = 'stdstock';
    //     $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    //     $SAP_MSI->select('t0.ItemCode as MATNR,t0.ItemName as MAKTX,t0.ItmsGrpCod as DISPO,t0.BuyUnitMsr as UNIT,t1.ItmsGrpNam as DSNAM');
    //     $SAP_MSI->from('OITM  t0');
    //     $SAP_MSI->where('validFor', 'Y');
    //     $SAP_MSI->where('InvntItem', 'Y');
    //     $SAP_MSI->join('oitb t1','t1.ItmsGrpCod = t0.ItmsGrpCod','inner');

    //     if($item_group_code !='all'){
    //         $SAP_MSI->where('t1.ItmsGrpNam', $item_group_code);
    //     }

    //     $SAP_MSI->order_by('t0.ItemCode', 'desc');

    //     $query = $SAP_MSI->get();
    //     // echo $SAP_MSI->last_query();
    //     // die();
        
    //     if(($query)&&($query->num_rows()>0))
    //         return $query->result_array();
	// 	else
	// 		return FALSE;
    // }[@YBC_ITM_CC]

    function sap_item_groups_select_all_twts_back() {
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        
        $query = $SAP_MSI->query('SELECT Code MATNR,Name MAKTX FROM [@YBC_ITM_CC]');
        
        if(($query)&&($query->num_rows() > 0)) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function sap_item_select_by_item_code($item_code) {
    //echo $item_code;
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('m_item.*,m_uom.UomCode as UNIT1');
        $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
        $this->db->from('m_item');
        $this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','left');
        $this->db->where('m_item.MATNR', $item_code);
        $query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
            return $query->row_array();
        }	else {
            return FALSE;
        }
    }

    function jumBatch($item,$plant){
        $this->db->select('count(*) jml');
        $this->db->from('m_batch');
        $this->db->where('ItemCode', $item);
        $this->db->where('Whs', $plant);
        $query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
            return $query->row_array();
        }	else {
            return FALSE;
        }
    }

    function twtsnew_header_insert($data) {
		if($this->db->insert('m_twtsnew_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
    }
    
    function twtsnew_detail_insert($data) {
		if($this->db->insert('m_twtsnew_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
	}

    function sap_item_groups_select_all_twts_back_2($kode_item_paket, $MATNR='') {
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        // $kd_plant = $this->session->userdata['ADMIN']['plant'];
        // $this->db->select('m_mwts_detail.material_no AS MATNR1, m_mwts_detail.material_desc AS MAKTX1, m_mwts_detail.quantity AS qty, m_mwts_detail.uom AS UOM');
        // $this->db->from('m_item');
        // $this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
        // $this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','left');
        // $this->db->join('m_mwts_header','m_mwts_header.kode_whi = m_item.MATNR','inner');
        // $this->db->join('m_mwts_detail','m_mwts_detail.id_mwts_header = m_mwts_header.id_mwts_header','inner');
        // $this->db->where('m_mapping_item.kdplant',$kd_plant);   
        // $this->db->where('m_mwts_header.plant',$kd_plant);   
        // $this->db->where('m_mwts_header.kode_whi',$kode_item_paket);
        // if($MATNR != ''){
        //     $this->db->where('m_mwts_detail.material_no',$MATNR);
        // }
        
        $andWhere = ($MATNR != '' )? " AND u_Material = '".$MATNR."'":"";

        $sql = " SELECT Code, u_Material MATNR1, u_description MAKTX1 , u_quantity qty, u_uom UOM FROM [@YBC_ITM_CC_DT] WHERE Code = '".$kode_item_paket."' ". $andWhere;

        $query = $SAP_MSI->query($sql);
         
        if(($query)&&($query->num_rows() > 0)) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function twtsnew_header_select($id_twtsnew_header) {
		$this->db->from('m_twtsnew_header');
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
    }
    
    function twtsnew_details_select($id_twtsnew_header) {
		$this->db->from('m_twtsnew_detail');
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);
		$this->db->order_by('id_twtsnew_detail');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

    function getDataOnHand($itemCode){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('Onhand');
        $SAP_MSI->from('OITW  t0');
        $SAP_MSI->where('ItemCode', $itemCode);
        $SAP_MSI->where('WhsCode', $kd_plant);
        $query = $SAP_MSI->get();
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

    function update_twtsnew_detail($data){
        $this->db->where('id_twtsnew_detail', $data['id_twtsnew_detail']);
        $this->db->where('id_twtsnew_header', $data['id_twtsnew_header']);
        if($this->db->update('m_twtsnew_detail', $data))
			return TRUE;
		else
			return FALSE;
    }

    function update_twtsnew_header($data){
        $this->db->where('id_twtsnew_header', $data['id_twtsnew_header']);
        if($this->db->update('m_twtsnew_header', $data))
			return TRUE;
		else
			return FALSE;
    }

    function twtsnew_header_delete($id_twtsnew_header){
        $this->db->select('back');
        $this->db->from('m_twtsnew_header');
        $this->db->where('id_twtsnew_header', $id_twtsnew_header);
        $query = $this->db->get();
        $dataArr = $query->result_array();
        if($dataArr[0]['back'] != 0){
            
            if($this->twtsnew_details_delete($id_twtsnew_header)){
                $this->db->where('id_twtsnew_header', $id_twtsnew_header);
                if($this->db->delete('m_twtsnew_header'))
                    return TRUE;
                else
                    return FALSE;
            }
            $this->twtsnew_details_delete($id_twtsnew_header);

        }else{
            return FALSE;
        }        
    }

    function twtsnew_details_delete($id_twtsnew_header) {
		$this->db->where('id_twtsnew_header', $id_twtsnew_header);
		if($this->db->delete('m_twtsnew_detail'))
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