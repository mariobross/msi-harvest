<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Integration extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        //load model
        // $this->load->model('integration_model');
    }

    public function index()
    {
        $this->load->view('master/integration_log/list_view');
    }

    public function add(){
        $this->load->view('master/integration_log/add_form');
    }
}
?>