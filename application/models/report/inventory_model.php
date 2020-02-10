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
}