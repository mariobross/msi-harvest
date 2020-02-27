<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller
{
    public function __construct()
    {
        # code...
        parent::__construct();

        $this->load->library('auth');  
		if(!$this->auth->is_logged_in()) {
			redirect(base_url());
        }
        // load model
        $this->load->model("report/inventory_model","inv_model");
        
        $this->load->library('form_validation');
        $this->load->library('l_general');
    }

    public function index()
    {
        # code...
        $object['warehouse'] = $this->inv_model->warehouse();
        
        $object['itemGroup'] = $this->inv_model->item_group();
        
        $this->load->view("report/inventory_view", $object);
    }

    public function showAllData(){
        $itemGroup = $this->input->post('item_Group');
        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');
        $warehouse = $this->input->post('whs');
        $draw = intval($this->input->post("draw"));
        $length = intval($this->input->post("length"));
        $start = intval($this->input->post("start"));
        
        $inventoryData = $this->inv_model->getData($itemGroup, $fromDate, $toDate, $warehouse, $length, $start);
               
        $totalInventory = $this->totalData($itemGroup, $fromDate, $toDate, $warehouse);
        $dt = array();
        $no = 1;
        if($inventoryData){
            foreach($inventoryData as $key=>$val){
                
                $item = $val['itemcode'];
                $nestedData = array();
                $nestedData['no'] = $no;
                $nestedData['itemcode'] = $val['itemcode'];
                $nestedData['ItemName'] = $val['ItemName'];
                $nestedData['InvntryUom'] = $val['InvntryUom'];
                $nestedData['stock_awal'] = $val['stock_awal'];

                $qty_ck = $this->inv_model->qty_ck($item, $fromDate, $toDate);
                $qty_po = $this->inv_model->qty_po($item, $fromDate, $toDate);
                $qty_fo = $this->inv_model->qty_fo($item, $fromDate, $toDate);
                $qty_produc = $this->inv_model->qty_produc($item, $fromDate, $toDate);
                $qty_wc = $this->inv_model->qty_wc($item, $fromDate, $toDate);
                $qty_nonpo = $this->inv_model->qty_nonpo($item, $fromDate, $toDate);
                $qty_retin = $this->inv_model->qty_retin($item, $fromDate, $toDate);

                $total_in = number_format($qty_ck[0]['qty_ck'] + $qty_po[0]['qty_po'] + $qty_fo[0]['qty_fo'] + $qty_produc[0]['qty_produc'] + $qty_wc[0]['qty_wc'] + $qty_nonpo[0]['qty_nonpo'] + $qty_retin[0]['qty_retin']);
                
                $nestedData['qty_ck'] = $qty_ck ? $qty_ck[0]['qty_ck'] : '';
                $nestedData['qty_po'] = $qty_po ? $qty_po[0]['qty_po'] : '';
                $nestedData['qty_fo'] = $qty_fo ? $qty_fo[0]['qty_fo'] : '';
                $nestedData['qty_produc'] = $qty_produc ? $qty_produc[0]['qty_produc'] : '';
                $nestedData['qty_wc'] = $qty_wc ? $qty_wc[0]['qty_wc'] : '';
                $nestedData['qty_nonpo'] = $qty_nonpo ? $qty_nonpo[0]['qty_nonpo'] : '';
                $nestedData['qty_retin'] = $qty_retin ? $qty_retin[0]['qty_retin'] : '';
                $nestedData['total_in'] = $total_in;

                $qty_to = $this->inv_model->qty_to($item, $fromDate, $toDate);
                $qty_produc_out = $this->inv_model->qty_produc_out($item, $fromDate, $toDate);
                $qty_wc_out = $this->inv_model->qty_wc_out($item, $fromDate, $toDate);
                $qty_waste = $this->inv_model->qty_waste($item, $fromDate, $toDate);
                $qty_ro = $this->inv_model->qty_ro($item, $fromDate, $toDate);
                $total_out = number_format($qty_to[0]['qty_to'] + $qty_produc_out[0]['qty_produc_out'] + $qty_wc_out[0]['qty_wc_out'] + $qty_waste[0]['qty_waste'] + $qty_ro[0]['qty_ro']);

                $nestedData['qty_sales'] = '';
                $nestedData['qty_to'] = $qty_to ? $qty_to[0]['qty_to'] : '';
                $nestedData['qty_produc_out'] = $qty_produc_out ? $qty_produc_out[0]['qty_produc_out'] : '';
                $nestedData['qty_wc_out'] = $qty_wc_out ? $qty_wc_out[0]['qty_wc_out'] : '';
                $nestedData['qty_waste'] = $qty_waste ? $qty_waste[0]['qty_waste'] : '';
                $nestedData['qty_ro'] = $qty_ro ? $qty_ro[0]['qty_ro'] : '';
                $nestedData['total_out'] = $total_out;
                
                $nestedData['subtotal'] = number_format($val['stock_awal'] + $total_in - $total_out);

                $dt[] = $nestedData;
                $no++;
            }
        }
        $json_data = array(
            "draw" => $draw,
            "recordsTotal" => $totalInventory,
            "recordsFiltered" => $totalInventory,
            "data" => $dt
        );
        echo json_encode($json_data) ;
    }

    function totalData($itemGroup, $fromDate, $toDate, $warehouse){
        $total=$this->inv_model->totalDataInventory($itemGroup, $fromDate, $toDate, $warehouse);
        if($total){
            return $total[0]['num'];
        } else{
            return 0;
        }

    }
}
?>