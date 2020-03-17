<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Goodissue_model extends CI_Model {
    
    public function getDataGI_Header($fromDate='', $toDate='', $status=''){
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->select('*');
        $this->db->from('t_issue_header1');
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
        $this->db->order_by('id_issue_header', 'desc');
        $query = $this->db->get();
        $gi = $query->result_array();
        return $gi;

    }
}