<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_model extends CI_Model{

    function __construct(){
        parent::__construct(); 
    }

    function getAllData(){
        return $this->$_table;
    }
}