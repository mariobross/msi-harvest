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
        $trans_type = 'gist';
	
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1, MAKTX, UNIT');
		$this->db->from('m_item');
		$this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
		$this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
		$this->db->where('transtype', $trans_type);
        $this->db->where('m_item_group.kdplant',$kd_plant);

        if($item_group != 'all'){
            $this->db->where('m_item_group.DSNAM', $item_group);
        }
        if($itemSelect!=""){
            $this->db->where('m_item.MATNR', $itemSelect);
        }

        $query = $this->db->get();
        
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

    function gisto_dept_header_select($gisto_dept_header) {
        $this->db->from('t_gisto_dept_header');
        $this->db->where('id_gisto_dept_header', $gisto_dept_header);
  
        $query = $this->db->get();
  
        if(($query)&&($query->num_rows() > 0))
          return $query->row_array();
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
}