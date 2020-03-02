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
}