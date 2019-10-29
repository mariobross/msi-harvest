<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Integration_model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    public function showIntegration(){
		$query	=	$this->db->query('SELECT * FROM `error_log` WHERE `Whs`="WMSIBSST"');
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}	
	}
}