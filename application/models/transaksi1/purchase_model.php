<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {
    function t_pr_headers($date_from2, $date_to2, $status){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('t_prnew_header.*,(select admin_realname from d_admin where admin_id = t_prnew_header.id_user_input) as user_input, (select admin_realname from d_admin where admin_id = t_prnew_header.id_user_approved) as user_approved ');
        $this->db->from('t_prnew_header');
        $this->db->where('t_prnew_header.plant',$kd_plant);
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

        $this->db->order_by('id_pr_header', 'desc');

        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $ret = $query->result_array();
        return $ret;

    }

    function tampil($id_pr_header)
	{
        $this->db->select('a.pr_no, a.created_date, a.delivery_date,b.material_no,b.material_desc,b.uom,b.requirement_qty requirement_qty,b.price,a.plant, (select admin_realname from d_admin where admin_id = a.id_user_approved) as user_approved');
        $this->db->from('t_prnew_header a');
        $this->db->join('t_pr_detail b','a.id_pr_header = b.id_pr_header');
        $this->db->where('a.id_pr_header', $id_pr_header);
		
		$query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        $ret = $query->result_array();
        return $ret;
	}
    
}