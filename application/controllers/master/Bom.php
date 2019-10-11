<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Bom extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('bom_model');
    }

    public function index()
    {
        $this->load->view('master/bom/list_view');
    }

    public function add(){
        $this->load->view('master/bom/add_form');
    }
}
?>