<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Manajemen extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        
        //load model
        $this->load->model('master/manajemen_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('master/manajemen_pengguna/list_view');
    }

    public function showAllData(){
       $dt= array(
           array(
            "no" => "1",
            "username" => "sx_bogor",
            "nama_lengkap"=>"Manager Bogor",
            "grup_hak_akses"=> "Super Admin"
           ),
           array(
            "no" => "2",
            "username"=> "st_senopati",
            "nama_lengkap"=>"Admin senopati",
            "grup_hak_akses"=> "Super Admin"
           ),
           array(
            "no" => "3",
            "username"=> "sx_cikini",
            "nama_lengkap"=>"Manager Cikini",
            "grup_hak_akses"=> "Super Admin"
           ),
           array(
            "no" => "4",
            "username"=> "st_pi",
            "nama_lengkap"=>"Admin Pondok Indah",
            "grup_hak_akses"=> "Super Admin"
           ),
           array(
            "no" => "5",
            "username"=> "sx_alam",
            "nama_lengkap"=>"Manager Alam Sutera",
            "grup_hak_akses"=> "Super Admin"
           )
        ); 

        $data = [
            "data"=> $dt
        ];
        
        echo json_encode($data);
    }

    public function add(){
        $this->load->view('master/manajemen_pengguna/add_form');
    }

    public function edit(){
        $this->load->view('master/manajemen_pengguna/edit_form');
    }

}
?>