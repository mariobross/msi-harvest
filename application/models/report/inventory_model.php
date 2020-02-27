<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    function warehouse(){
        $notIn = array('01','02','03','IC_DShip');
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('WhsCode,WhsName');
        $SAP_MSI->from('OWHS');
        $SAP_MSI->where('LEFT(WhsCode,2)!=','T.');
        $SAP_MSI->where_not_in('WhsCode',$notIn);

        $query = $SAP_MSI->get();
        $ret = $query->result_array();
        return $ret;
    }

    function item_group(){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('ItmsGrpNam');
        $SAP_MSI->from('OITB');

        $query = $SAP_MSI->get();
        $ret = $query->result_array();
        return $ret;
    }

    function getData($itemGroup, $fromDate, $toDate, $warehouse='',$length,$start){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('c.itemcode,c.ItemName,c.U_Small,c.BVolume BVolume,c.InvntryUom,d.MinStock,d.MaxStock, 
        c.onhand,');
        $SAP_MSI->select("(select sum(b.inqty-b.outqty) from oivl b where C.itemcode=b.ItemCode and b.LocCode=d.WhsCode and b.DocDate < convert(datetime, '$fromDate', 120) ) stock_awal");
        $SAP_MSI->select("(select sum(b.inqty) from oivl b where C.itemcode=b.ItemCode and b.LocCode=d.WhsCode and b.DocDate <= convert(datetime, '$toDate', 120) AND b.DocDate >= convert(datetime, '$fromDate', 120) ) inqty");
        $SAP_MSI->select("(select sum(b.OutQty) from oivl b where C.itemcode=b.ItemCode and b.LocCode=d.WhsCode and b.DocDate <= convert(datetime, '$toDate', 120) AND b.DocDate >= convert(datetime, '$fromDate', 120) ) outqty");
        $SAP_MSI->select("(select sum(inqty-outqty) from oivl b where C.itemcode=b.ItemCode and b.LocCode=d.WhsCode and b.DocDate<= convert(datetime, '$toDate', 120) ) stock_akhir");
        $SAP_MSI->from('oitm c');
        $SAP_MSI->join('OITW d', 'c.ItemCode=d.ItemCode');
        $SAP_MSI->join('oitb e', 'e.itmsgrpcod = c.itmsgrpcod');
        $SAP_MSI->where('d.WhsCode',$kd_plant);
        $SAP_MSI->where('LEFT(d.WhsCode,2)!=','T.');
        $SAP_MSI->where('c.CreateDate >=', $fromDate);
        $SAP_MSI->where('c.CreateDate <=', $toDate);
        if($itemGroup != 'all'){
            $SAP_MSI->where('ItmsGrpNam', $itemGroup);
        }
        $SAP_MSI->group_by('c.ItemCode, d.WhsCode, c.ItemName, c.BVolume, c.U_Small, c.InvntryUom, d.MinStock, d.MaxStock, c.onhand');
        $SAP_MSI->limit($length,$start);
        $query = $SAP_MSI->get();
        // echo $SAP_MSI->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function totalDataInventory($itemGroup, $fromDate, $toDate, $warehouse){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);

        $SAP_MSI->select('COUNT(*) num');
        $SAP_MSI->from('oitm c');
        $SAP_MSI->join('OITW d', 'c.ItemCode=d.ItemCode');
        $SAP_MSI->join('oitb e', 'e.itmsgrpcod = c.itmsgrpcod');
        $SAP_MSI->where('d.WhsCode',$kd_plant);
        $SAP_MSI->where('LEFT(d.WhsCode,2)!=','T.');
        $SAP_MSI->where('c.CreateDate >=', $fromDate);
        $SAP_MSI->where('c.CreateDate <=', $toDate);
        if($itemGroup != 'all'){
            $SAP_MSI->where('ItmsGrpNam', $itemGroup);
        }
        $query = $SAP_MSI->get();
        // echo $SAP_MSI->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;

    }

    // Quantity In start
    function qty_ck($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.gr_quantity) qty_ck');
        $this->db->from('t_grpodlv_header b');
        $this->db->join('t_grpodlv_detail c', 'b.id_grpodlv_header = c.id_grpodlv_header');
        $this->db->where('b.do_no !=', '');
        $this->db->where('b.grpodlv_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.do_no', '%C%');
        $this->db->not_like('b.grpodlv_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_po($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.gr_quantity) qty_po');
        $this->db->from('t_grpo_header b');
        $this->db->join('t_grpo_detail c', 'b.id_grpo_header = c.id_grpo_header');
        $this->db->where('b.po_no !=', '');
        $this->db->where('b.grpo_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.po_no', '%C%');
        $this->db->not_like('b.grpo_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_fo($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.gr_quantity) qty_fo');
        $this->db->from('t_grsto_header b');
        $this->db->join('t_grsto_detail c', 'b.id_grsto_header = c.id_grsto_header');
        $this->db->where('b.po_no !=', '');
        $this->db->where('b.grsto_no !=', '');
        $this->db->where('b.no_doc_gist !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.po_no', '%C%');
        $this->db->not_like('b.grsto_no', '%C%');
        $this->db->not_like('b.no_doc_gist', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_produc($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(b.qty_paket) qty_produc');
        $this->db->from('t_produksi_header b');
        $this->db->where('b.produksi_no !=', '');
        $this->db->where('b.kode_paket', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.produksi_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_wc($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.quantity) qty_wc');
        $this->db->from('m_twtsnew_header b');
        $this->db->join('m_twtsnew_detail c', 'on b.id_twtsnew_header = c.id_twtsnew_header');
        $this->db->where('b.gr_no !=', '');
        $this->db->where('b.gi_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.gr_no', '%C%');
        $this->db->not_like('b.gi_no', '%C%');
        $this->db->where('b.last_update >=', $fromDate);
        $this->db->where('b.last_update <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_nonpo($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.quantity) qty_nonpo');
        $this->db->from('t_grnonpo_header b');
        $this->db->join('t_grnonpo_detail c', 'b.id_grnonpo_header = c.id_grnonpo_header');
        $this->db->where('b.grnonpo_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.grnonpo_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_retin($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.gr_quantity) qty_retin');
        $this->db->from('t_retin_header b');
        $this->db->join('t_retin_detail c', 'b.id_retin_header = c.id_retin_header');
        $this->db->where('b.retin_no !=', '');
        $this->db->where('b.do_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.retin_no', '%C%');
        $this->db->not_like('b.do_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }
    // Quantity In End

    // Quantity Out start
    function qty_to($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.gr_quantity) qty_to');
        $this->db->from('t_gistonew_out_header b');
        $this->db->join('t_gistonew_out_detail c', 'b.id_gistonew_out_header = c.id_gistonew_out_header');
        $this->db->where('b.po_no !=', '');
        $this->db->where('b.gistonew_out_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.gistonew_out_no', '%C%');
        $this->db->not_like('b.po_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_produc_out($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.qty) qty_produc_out');
        $this->db->from('t_produksi_header b');
        $this->db->join('t_produksi_detail c', 'b.id_produksi_header = c.id_produksi_header');
        $this->db->where('b.produksi_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.produksi_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_wc_out($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(b.quantity_paket) qty_wc_out');
        $this->db->from('m_twtsnew_header b');
        $this->db->where('b.gr_no !=', '');
        $this->db->where('b.gi_no !=', '');
        $this->db->where('b.kode_paket', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.gr_no', '%C%');
        $this->db->not_like('b.gi_no', '%C%');
        $this->db->where('b.last_update >=', $fromDate);
        $this->db->where('b.last_update <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_waste($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.quantity) qty_waste');
        $this->db->from('t_waste_header b');
        $this->db->join('t_waste_detail c', 'b.id_waste_header = c.id_waste_header');
        $this->db->where('b.material_doc_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.material_doc_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }

    function qty_ro($itemCode, $fromDate, $toDate){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('SUM(c.gr_quantity) qty_ro');
        $this->db->from('t_gisto_dept_header b');
        $this->db->join('t_gisto_dept_detail c', 'b.id_gisto_dept_header = c.id_gisto_dept_header');
        $this->db->where('b.gisto_dept_no !=', '');
        $this->db->where('b.po_no !=', '');
        $this->db->where('c.material_no', $itemCode);
        $this->db->where('b.plant', $kd_plant);
        $this->db->not_like('b.gisto_dept_no', '%C%');
        $this->db->not_like('b.po_no', '%C%');
        $this->db->where('b.posting_date >=', $fromDate);
        $this->db->where('b.posting_date <=', $toDate);
        
        $query = $this->db->get();
        // echo $this->db->last_query();

        if(($query)&&($query->num_rows()>0))
            return $query->result_array();
		else
			return FALSE;
    }
}