<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Akses extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('akses_model');
    }

    public function index()
    {
        $this->load->view('master/hak_akses/list_view');
    }

    public function add(){
        $this->load->view('master/hak_akses/add_form');
    }
}
?>