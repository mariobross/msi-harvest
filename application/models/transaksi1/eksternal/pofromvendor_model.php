<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pofromvendor_model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    public function showPofromvendor(){
		$query	=	$this->db->query('SELECT * FROM `t_grpo_header` WHERE `plant`="WMSIBSST"');
		$arr 		=	array();
		$status		= 	'';
		$log		= 	'';
		
		if($query->num_rows() > 0){
			$SQLdata = $query->result();
			foreach($SQLdata as $data){
				
				$query2	=	$this->db->query('SELECT admin_realname FROM d_admin WHERE admin_id = "'.$data->id_user_input.'"');
				if($query2->num_rows() > 0){
					$createdBy = $query2->result();
				}
				$query3	=	$this->db->query('SELECT admin_realname FROM d_admin WHERE admin_id = "'.$data->id_user_approved.'"');
				if($query3->num_rows() > 0){
					$approvedBy = $query3->result();
				}
				if($data->status == '2'){
				   $status = 'Approved';
				}else{
				   $status = 'Not Approved';
			    }
				if($data->back == '0' && $data->grpo_no !='' && $data->grpo_no !='C'){
				   $log = 'Integrated';
				}else{
				   $log = 'Not Integrated';
			    }
			   
				array_push($arr,
					array(
						"id"			=>	$data->id_grpo_header,
						"gr_no"			=>	$data->grpo_no,
						"po_no"			=>	$data->po_no,
						"vendor_code"	=>	$data->kd_vendor,
						"vendor_name"	=>	$data->nm_vendor,
						"dev_date"		=>	$data->delivery_date,
						"pos_date"		=>	$data->posting_date,
						"status"		=>	$status,
						"created_by"	=>	$createdBy[0]->admin_realname,
						"app_by"		=>	$approvedBy[0]->admin_realname,
						"last_modif"	=>	$data->lastmodified,
						"log"			=>	$log
					)
				);
			}
			return $arr;
		}else{
			return FALSE;
		}	
	}
}