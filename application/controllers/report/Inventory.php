<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller
{
    public function __construct()
    {
        # code...
        parent::__construct();

        // load model
        // $this->load->model("");
        $this->load->library('form_validation');
    }

    public function index()
    {
        # code...
        $this->load->view("report/inventory_view");
    }
}
?>