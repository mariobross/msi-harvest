<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grnonpo_model extends CI_Model {

    public function getDataGrNonPo_Header($fromDate='', $toDate='', $status=''){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->from('t_grnonpo_header');
        $this->db->where('plant',$kd_plant);

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

        $this->db->order_by('id_grnonpo_header', 'desc');
        $query = $this->db->get();
        //   echo $this->db->last_query();
        //   die();
        $ret = $query->result_array();
        return $ret;
    }

    function grnonpo_header_select($id_grnonpo_header) {
        $this->db->select('*, (SELECT OUTLET_NAME1 FROM m_outlet where OUTLET = t_grnonpo_header.plant) PLANT_NAME_NEW, (SELECT STOR_LOC_NAME FROM m_outlet where STOR_LOC = t_grnonpo_header.storage_location) STOR_LOC_NAME, (SELECT COST_CENTER_TXT FROM m_outlet where COST_CENTER = t_grnonpo_header.cost_center)COST_CENTER_NAME');
		$this->db->from('t_grnonpo_header');
		$this->db->where('id_grnonpo_header', $id_grnonpo_header);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
    }
    
    function grnonpo_details_select($id_grnonpo_header) {
		$this->db->from('t_grnonpo_detail');
        $this->db->where('id_grnonpo_header', $id_grnonpo_header);

            $query = $this->db->get();
            // echo $this->db->last_query();

            if(($query)&&($query->num_rows() > 0))
                return $query->result_array();
            else
                return FALSE;
    }

    function sap_item_groups_select_all_grnonpo() {
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $trans_type = 'grnonpo';
        $this->db->select('m_item.*,DSNAM');
        $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
        $this->db->from('m_item');
        $this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
        $this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
        $this->db->where('transtype', $trans_type);
        $this->db->where('m_item_group.kdplant',$kd_plant);
        
        $item_groups = $this->db->get();
        // echo $this->db->last_query();
        
        if ($item_groups->num_rows() > 0) {
          return $item_groups->result_array();
        } else {
          return FALSE;
        }
    }
    
    function sap_items_select_by_item_group($item_group, $trans_type) {
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
		$this->db->select('MAKTX,m_item.MATNR,MEINS,UNIT');
     	$this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1, SPACE(1) AS DistNumber');
		$this->db->from('m_item');
        $this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
        $this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
        $this->db->where('transtype', $trans_type);
		$this->db->where('m_item_group.kdplant',$kd_plant);
      	$this->db->where('m_item_group.DSNAM', $item_group);

		$query = $this->db->get();
        
        if(($query)&&($query->num_rows() > 0)) {
			return $query->result_array();
		}	else {
			return FALSE;
		}
    }
    
    function getDataMaterialGroupSelect($itemSelect){
        $trans_type = 'stdstock';
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        if(($itemSelect != '') || ($itemSelect != null)){
            $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,space(0) as DSNAM');
            $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
            $this->db->from('m_item');
            $this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
            $this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
            $this->db->where('transtype', $trans_type);
            $this->db->where('m_item_group.kdplant', $kd_plant );
            $this->db->where('m_item.MATNR',$itemSelect);

            $this->db->limit(100);
            $query = $this->db->get();
            return $query->result_array();
        }else{
            return false;
        }
    }

    function grnonpo_detail_insert($data) {
		if($this->db->insert('t_grnonpo_detail', $data))
			return $this->db->insert_id();
		else 
			return FALSE;
    }

    function grnonpo_header_update($data){
        $this->db->where('id_grnonpo_header', $data['id_grnonpo_header']);
        if($this->db->update('t_grnonpo_header', $data))
			return TRUE;
		else
			return FALSE;
    }

    function grnonpo_details_delete($id_grnonpo_header) {
		$this->db->where('id_grnonpo_header', $id_grnonpo_header);
		if($this->db->delete('t_grnonpo_detail'))
			return TRUE;
		else
			return FALSE;
    }

    function id_grnonpo_plant_new_select($id_outlet,$created_date="",$id_grnonpo_header="") {

        if (empty($created_date))
           $created_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
           $id_outlet=$this->session->userdata['ADMIN']['plant'];

		$this->db->select_max('id_grnonpo_plant');
		$this->db->from('t_grnonpo_header');
		$this->db->where('plant', $id_outlet);
	  	$this->db->where('DATE(posting_date)', $created_date);
        if (!empty($id_grnonpo_header)) {
    		$this->db->where('id_grnonpo_header <> ', $id_grnonpo_header);
        }

		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$stdstock = $query->row_array();
			$id_stdstock_outlet = $stdstock['id_grnonpo_plant'] + 1;
		}	else {
			$id_stdstock_outlet = 1;
		}

		return $id_stdstock_outlet;
    }

    function getReturnFrom($ro){
        $this->db->select('plant,m_outlet.OUTLET_NAME1');
        $this->db->from('t_gisto_dept_header');
        $this->db->join('m_outlet','m_outlet.OUTLET=t_gisto_dept_header.plant');
        $this->db->where('gisto_dept_no', $ro);

            $query = $this->db->get();
            // echo $this->db->last_query();

            if(($query)&&($query->num_rows() > 0))
                return $query->result_array();
            else
                return FALSE;
    }

    public function sap_do_select_all($kd_plant="",$do_no="",$do_item=""){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);

        $SAP_MSI->select('U_TransFor');
        $SAP_MSI->from('OWHS');
        $SAP_MSI->where('WhsCode',$kd_plant);
        $querySAP = $SAP_MSI->get();
        $ret = $querySAP->result_array();
        $plant=$ret[0]['U_TransFor'];

        $SAP_MSI->select("OWTR.DocEntry VBELN, OWTR.DocDate DELIV_DATE, OWTR.ToWhsCode, WTR1.LineNum POSNR,
							OITM.ItmsGrpCod DISPO, WTR1.ItemCode MATNR, Dscription MAKTX, (OpenQty-U_grqty_web) LFIMG , unitMsr VRKME, WTR1.LineNum item, U_grqty_web, OWHS.WhsCode RETURN_FROM, OWHS.WhsName RETURN_FROM_NAME,
                            (SELECT WhsCode FROM OWHS where WhsCode = '$kd_plant')PLANT,
                            (SELECT  WhsName FROM OWHS where WhsCode = '$kd_plant')PLANT_NAME");
        $SAP_MSI->from('OWTR');
        $SAP_MSI->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
        $SAP_MSI->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
        $SAP_MSI->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
        $SAP_MSI->where_in('ToWhsCode',$plant);
        $SAP_MSI->where('U_Stat <>',1);
        $SAP_MSI->where('U_Retur =',1); 
        $SAP_MSI->where('(OpenQty-U_grqty_web) >', 0);
        $SAP_MSI->where('OWTR.U_Reverse','N');

        if((!empty($do_no))){
            $SAP_MSI->where('OWTR.DocEntry', $do_no);
        }

        $query = $SAP_MSI->get();
        // echo $SAP_MSI->last_query();
        // die();
        
        if($query->num_rows() > 0) {
            $DELV_OUTS = $query->result_array();
           $count = count($DELV_OUTS)-1;
            for ($i=0;$i<=$count;$i++) {
              $poitems[$i+1] = $DELV_OUTS[$i];
            }
            return $poitems;
        } else {
        return FALSE;
        } 

    }

    function sap_retin_header_select_by_do_no($do_no) {

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
    
    function sap_retin_select_item_group_do($do_no) {
        $doitems = $this->sap_retin_details_select_by_do_no($do_no);
        $item_groups = $this->sap_item_groups_select_all();
        $count = count($item_groups);
        $count_do = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          for($j=1;$j<=$count_do;$j++) {
            if ($doitems[$j]['DISPO']==$item_groups[$i]['DISPO']){
              $item_groups_filter[$k]['DSNAM'] = $item_groups[$i]['DSNAM'];
              $item_groups_filter[$k]['DISPO'] = $item_groups[$i]['DISPO'];
              $k++;
              break;
            }
          }
        }
        
        if (count($item_groups_filter) > 0) {
          $item_groups_filter = array_unique($item_groups_filter, SORT_REGULAR );
          return $item_groups_filter;
        }
        else {
          return FALSE;
        }
    }
    
    function sap_retin_details_select_by_do_no($do_no) {
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
            $doitems[$i]['id_retin_h_detail'] = $i;
          }
          return $doitems;
        }
        else {
          unset($doitems);
          return FALSE;
        }
    }
    
    function sap_retin_details_select_by_do_and_item_group($do_no,$item_group_code) {
        $doitems = $this->sap_retin_details_select_by_do_no($do_no);
        $count = count($doitems);
        $k = 1;
        for ($i=1;$i<=$count;$i++) {
          if ($doitems[$i]['DISPO']==$item_group_code){
            $doitem[$k] = $doitems[$i];
            $k++;
          }
        }
        if (count($doitem) > 0) {
          return $doitem;
          echo "<pre>";
          print_r($doitem);
          echo "</pre>";
        }
        else {
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

    function showMatrialGroup(){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('ItmsGrpNam');
        $SAP_MSI->from('OITB');

        $query = $SAP_MSI->get();
        $ret = $query->result_array();
        return $ret;
    }

    function getDataMaterialGroup($item_group_code ='all'){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $trans_type = 'grnonpo';
        $this->db->distinct();
        $this->db->select('m_item.MATNR,m_item.MAKTX,m_item.DISPO,m_item.UNIT,m_item_group.DSNAM');
        $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
        $this->db->from('m_item');
        $this->db->join('m_map_item_trans','m_map_item_trans.MATNR = m_item.MATNR','inner');
        $this->db->join('m_item_group','m_item_group.DISPO = m_item.DISPO','inner');
        $this->db->where('transtype', $trans_type);
        $this->db->where('m_item_group.kdplant',$kd_plant);
        
        $this->db->limit(10000);
        if($item_group_code !='all'){
            $this->db->where('m_item_group.DSNAM', $item_group_code);
        }

        $query = $this->db->get();
        // echo $this->db->last_query();
        
        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }
  
    function cancelHeaderGrNonPo($data){
        // print_r($data);
        // die();
        $this->db->set('status', '3');
        $this->db->where('id_grnonpo_header', $data['id_grnonpo_header']);
        if($this->db->update('t_grnonpo_header')){
            return TRUE;
            
        }else{
            return FALSE;
        }
    }

    function cancelDetailsGrNonPo($data){
        $this->db->set('ok_cancel', '1');
        $this->db->where('id_grnonpo_detail', $data);
        if($this->db->update('t_grnonpo_detail')){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function t_grnonpo_header_delete($id_grnonpo_header){
        if($this->t_grnonpo_details_delete($id_grnonpo_header)){
            $this->db->where('id_grnonpo_header', $id_grnonpo_header);
            if($this->db->delete('t_grnonpo_header'))
                return TRUE;
            else
                return FALSE;
        }
    }

    function t_grnonpo_details_delete($id_grnonpo_header) {
        $this->db->where('id_grnonpo_header', $id_grnonpo_header);
        if($this->db->delete('t_grnonpo_detail'))
            return TRUE;
        else
            return FALSE;
    }

    function id_retin_plant_new_select($id_outlet,$posting_date="",$id_retin_header="") {

        if (empty($posting_date))
            $posting_date=$this->m_general->posting_date_select_max();
        if (empty($id_outlet))
            $id_outlet=$this->session->userdata['ADMIN']['plant'];
  
        $this->db->select_max('id_retin_plant');
        $this->db->from('t_retin_header');
        $this->db->where('plant', $id_outlet);
        $this->db->where('DATE(posting_date)', $posting_date);
        if (!empty($id_retin_header)) {
            $this->db->where('id_retin_header <> ', $id_retin_header);
        }
        $query = $this->db->get();
  
        if($query->num_rows() > 0) {
            $retin_out = $query->row_array();
            $id_retin_outlet = $retin_out['id_retin_plant'] + 1;
        }else {
            $id_retin_outlet = 1;
        }
        return $id_retin_outlet;
    }

    function sap_retin_details_select_by_do_and_item($do_no,$item) {
        if (empty($this->session->userdata['do_nos'])) {
            $doitem = $this->sap_do_select_all("",$do_no,$item);
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $k = 1;
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
              if(($do_nos[$i]['VBELN']==$do_no)&&($do_nos[$i]['POSNR']==$item)){
                $doitem[1] = $do_nos[$i];
                break;
              }
            }
        }

        if (count($doitem) > 0) {
          return $doitem[1];
        }
        else {
          return FALSE;
        }
    }
    
    function u_grqty_web($po_no,$line){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('U_grqty_web');
        $SAP_MSI->from('WTR1');
        $SAP_MSI->where('DocEntry',$po_no);
        $SAP_MSI->where('LineNum',$line);
        $querySAP = $SAP_MSI->get();
        $ret = $querySAP->result_array();

        if (count($ret) > 0){
            return $ret[0]['U_grqty_web'];
        }else{
            return "none";
        }
    }

    function updateOwtrStat($no, $po_no){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->set('U_Stat', $no);
        $SAP_MSI->where('DOcEntry', $po_no);
        if($SAP_MSI->update('OWTR'))
          return TRUE;
        else
          return FALSE;
    }

    function grnonpo_header_insert($data) {
		if($this->db->insert('t_grnonpo_header', $data))
			return $this->db->insert_id();
		else
			return FALSE;
    }

    function grnonpo_details_insert($data) {
		if($this->db->insert('t_grnonpo_detail', $data))
			return $this->db->insert_id();
		else
			return FALSE;
    }

    function tampil($id_retin_header){
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
        $this->db->where('a.id_retin_header',$id_retin_header);

        $query = $this->db->get();
        // echo $this->db->last_query();

        return $query->result_array();
    }

    function sap_item_select_by_item_code($item_code) {
        // $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('m_item.*,m_uom.UomCode as UNIT1');
        $this->db->select('(REPLACE(m_item.MATNR,REPEAT("0",(12)),SPACE(0))) AS MATNR1');
        $this->db->from('m_item');
//		$this->db->join('m_mapping_item','m_mapping_item.MATNR = m_item.MATNR','inner');
        $this->db->join('m_uom','m_uom.UomEntry = m_item.UNIT','left');
        $this->db->where('m_item.MATNR', $item_code);
//		$this->db->where('m_mapping_item.kdplant',$kd_plant);
        $query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
            return $query->row_array();
        }	else {
            return FALSE;
        }
    } 

}