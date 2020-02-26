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

        $inventoryData = $this->inv_model->getData($itemGroup, $fromDate, $toDate, $warehouse);

        $dt = array();
        $no = 1;
        if($inventoryData){
            foreach($inventoryData as $key=>$val){
                $item = $val['itemcode'];
                $netedData = [];
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

                $total_in = number_format($qty_ck['qty_ck'] + $qty_po['qty_po'] + $qty_fo['qty_fo'] + $qty_produc['qty_produc'] + $qty_wc['qty_wc'] + $qty_nonpo['qty_nonpo'] + $qty_retin['qty_retin']);
                
                $nestedData['qty_ck'] = $qty_ck ? $qty_ck['qty_ck'] : '';
                $nestedData['qty_po'] = $qty_po ? $qty_po['qty_po'] : '';
                $nestedData['qty_fo'] = $qty_fo ? $qty_fo['qty_fo'] : '';
                $nestedData['qty_produc'] = $qty_produc ? $qty_produc['qty_produc'] : '';
                $nestedData['qty_wc'] = $qty_wc ? $qty_wc['qty_wc'] : '';
                $nestedData['qty_nonpo'] = $qty_nonpo ? $qty_nonpo['qty_nonpo'] : '';
                $nestedData['qty_retin'] = $qty_retin ? $qty_retin['qty_retin'] : '';
                $nestedData['total_in'] = $total_in;

                $qty_to = $this->inv_model->qty_to($item, $fromDate, $toDate);
                $qty_produc_out = $this->inv_model->qty_produc_out($item, $fromDate, $toDate);
                $qty_wc_out = $this->inv_model->qty_wc_out($item, $fromDate, $toDate);
                $qty_waste = $this->inv_model->qty_waste($item, $fromDate, $toDate);
                $qty_ro = $this->inv_model->qty_ro($item, $fromDate, $toDate);
                $total_out = $qty_ck['qty_to'] + $qty_produc_out['qty_produc_out'] + $qty_wc_out['qty_wc_out'] + $qty_waste['qty_waste'] + $qty_ro['qty_ro'];

                $nestedData['qty_sales'] = '';
                $nestedData['qty_to'] = $qty_to ? $qty_ck['qty_to'] : '';
                $nestedData['qty_produc_out'] = $qty_produc_out ? $qty_produc_out['qty_produc_out'] : '';
                $nestedData['qty_wc_out'] = $qty_wc_out ? $qty_wc_out['qty_wc_out'] : '';
                $nestedData['qty_waste'] = $qty_waste ? $qty_waste['qty_waste'] : '';
                $nestedData['qty_ro'] = $qty_ro ? $qty_ro['qty_ro'] : '';
                $nestedData['total_out'] = $total_out;

                $nestedData['subtotal'] = $val['stock_awal'] + $total_in - $total_out;

                $dt[] = $nestedData;
                $no++;
            }
        }
        $json_data = array(
            "data" => $dt
        );
        echo json_encode($json_data) ;

        // print_r($itemGroup.'/'.$fromDate.'----'.$toDate.'/'.$warehouse);
    }
}
?>