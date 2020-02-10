<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Onhand_model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    function item_group(){
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $SAP_MSI->select('ItmsGrpNam');
        $SAP_MSI->from('OITB');

        $query = $SAP_MSI->get();
        $ret = $query->result_array();
        return $ret;
    }

}