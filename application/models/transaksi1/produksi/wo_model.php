<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wo_model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    public function showList(){
		$this->datatables->select('*');
        $this->datatables->from('t_produksi_header');
        $this->datatables->where('plant', 'WMSIBSST');
		$query = json_decode($this->datatables->generate(),true);
		
		if($query['recordsTotal']>0){
			$arr 		=	array();
			$nestedData = array();
			foreach($query['data'] as $data){
				
				$query2			=	$this->db->query('SELECT admin_realname FROM d_admin WHERE admin_id = "'.$data['id_user_input'].'"');
				if($query2->num_rows() > 0){
					$createdBy 	= $query2->result();
				}
				$query3			=	$this->db->query('SELECT admin_realname FROM d_admin WHERE admin_id = "'.$data['id_user_approved'].'"');
				if($query3->num_rows() > 0){
					$approvedBy 	= $query3->result();
				}
				$query4			=	$this->db->query('SELECT doc_issue FROM t_produksi_detail WHERE id_produksi_header = "'.$data['id_produksi_header'].'"');
				if($query4->num_rows() > 0){
					$docIssue 	= $query4->result();
				}
				if($data['back'] == '0' && $data['produksi_no'] !='' && $data['produksi_no'] != 'C'){
					$log = 'Integrated';
				}else{
					$log = 'Not Integrated';
				}
				$status_string = ($data['status'] == '2') ? 'Approved' : 'Not Approved';
				
				/*$nestedData['id_produksi_header'] = $data['id_produksi_header'];
				$nestedData['kode_paket'] = $data['kode_paket'];
				$nestedData['nama_paket'] = $data['nama_paket'];
				$nestedData['posting_date'] = $data['posting_date'];
				$nestedData['status'] = $status_string;
				$nestedData['user_input'] = $createdBy[0]->admin_realname;
				$nestedData['user_approve'] = $approvedBy[0]->admin_realname;
				$nestedData['lastmodified'] = $data['lastmodified'];
				$nestedData['produksi_no'] = $data['produksi_no'];
				$nestedData['doc_issue'] = $docIssue[0]->doc_issue;
				$nestedData['log'] = $log;
				$data = $nestedData;*/
				
				array_push($nestedData,
					array(
						"id_produksi_header" 	=> $data['id_produksi_header'],
						"kode_paket" 			=> $data['kode_paket'],
						"nama_paket" 			=> $data['nama_paket'],
						"posting_date"			=> $data['posting_date'],
						"status"				=> $status_string,
						"user_input"			=> $createdBy[0]->admin_realname,
						"user_approve"			=> $approvedBy[0]->admin_realname,
						"lastmodified"			=> $data['lastmodified'],
						"produksi_no"			=> $data['produksi_no'],
						"doc_issue"				=> $docIssue[0]->doc_issue,
						"log"					=> $log,
					)
				);
				$arr = array(
						"draw" 				=> $query['draw'],
						"recordsTotal" 		=> $query['recordsTotal'],
						"recordsFiltered" 	=> $query['recordsFiltered'],
						"data"				=>$nestedData
				);
			}
			return json_encode($arr);
		}else{
			return FALSE;
		}	
	}
}