<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grfromkitchensentul_model extends CI_Model {

  function __construct() {
    parent:: __construct();

    // $this->msi_sap = $this->load->database('msi_sap', TRUE);
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
  }

  public function getDataPoKitchen_Header($fromDate,$toDate,$status)
  {
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
      $this->db->from('t_grpodlv_header');
      $this->db->join('m_outlet', 'm_outlet.OUTLET = t_grpodlv_header.plant');
      $this->db->where('plant',$kd_plant);

      if((!empty($fromDate)) || (!empty($toDate))){

        if( (!empty($fromDate)) || (!empty($toDate)) ) {
            $this->db->where("posting_date BETWEEN '$fromDate' AND '$toDate'");
        }else if( (!empty($fromDate))) {
            $this->db->where("posting_date >= '$fromDate'");
        } else if( (!empty($toDate))) {
            $this->db->where("posting_date <= '$toDate'");
        }

      }

      if((!empty($status))){
          $this->db->where('status', $status);
      }
      $this->db->order_by('id_grpodlv_header','DESC');
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      $ret = $query->result_array();
      return $ret;
  }

  function sap_grpodlv_headers_select_slip_number($slipNumberHeader = "", $ItmsGrpNam = ""){
    $response = NULL;
    $kd_plant = $this->session->userdata['ADMIN']['plant'];
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE); 
    $sub_query = $SAP_MSI->select('WhsCode')
        ->from('OWHS')
        ->where('U_CENTRALKITCHEN','Y')
        ->get()
        ->result_array();
      // $sub_query = $SAP_MSI->get_compiled_select();
    $filler=[];
    foreach($sub_query as $key=>$val){
      array_push($filler, $val['WhsCode']);
    }
    $SAP_MSI->select("OWTQ.DocEntry as VBELN, 
                            convert(date, OWTQ.DocDate) as DELIV_DATE, 
                            OWTQ.ToWhsCode, 
                            OITM.ItmsGrpCod as DISPO, 
                            OITM.InvntryUom as VRKME, 
                            WTQ1.LineNum as Item, 
                            NNM1.SeriesName + RIGHT('00000' + CONVERT(varchar, DocNum), 6) AS Doc_Num,
                            OWTQ.ToWhsCode as PLANT, 
                            OWHS.WhsName as Outlet, 
                            OWHS.WhsName, 
                            WTQ1.ItemCode as Material_Code, 
                            OITM.ItemName as Material_Desc, 
                            WTQ1.OpenCreQty as TF_QTY, 
                            WTQ1.unitMsr as UOM, 
                            OWTQ.Filler,
                            OITB.ItmsGrpNam,OITB.ItmsGrpNam");
    $SAP_MSI->from('OWTQ');
    $SAP_MSI->join('WTQ1','OWTQ.DocEntry = WTQ1.DocEntry','inner');
    $SAP_MSI->join('OITM','OITM.ItemCode = WTQ1.ItemCode','inner');
    $SAP_MSI->join('OWHS','OWTQ.ToWhsCode = OWHS.WhsCode','inner');
    $SAP_MSI->join('NNM1','OWTQ.Series=NNM1.Series','inner');
    $SAP_MSI->join('OITB','OITM.ItmsGrpCod = OITB.ItmsGrpCod','inner');

    $SAP_MSI->where('OWTQ.ToWhsCode', $kd_plant);
    $SAP_MSI->where('WTQ1.OpenCreQty >', 0);
    $SAP_MSI->where_in('Filler', $filler);
    
    if(empty($slipNumberHeader) && empty($ItmsGrpNam)) {
      // $SAP_MSI->where('OWTQ.U_DocNum is NOT NULL', NULL, FALSE);
    } else if(!empty($slipNumberHeader) && empty($ItmsGrpNam)) {
      $SAP_MSI->where('OWTQ.DocEntry',(int)$slipNumberHeader);
    } else if(!empty($slipNumberHeader) && !empty($ItmsGrpNam)){

      if($ItmsGrpNam == 'all'){
        $SAP_MSI->where('OWTQ.DocEntry', (int)$slipNumberHeader);
      } else {
        $SAP_MSI->where('OWTQ.DocEntry', (int)$slipNumberHeader);
        $SAP_MSI->where('OITB.ItmsGrpNam', $ItmsGrpNam);
      }
      
    } else {}
    
    $query = $SAP_MSI->get();
    // echo $SAP_MSI->last_query();
    // die();
    
    $k=1;
    foreach ($query->result_array() as $row)
    {
      $response[$k] = $row;
      $k++;
    }
    return $response;

  }

    function id_grpodlv_plant_new_select($id_outlet,$posting_date="") {

      // if (empty($posting_date))
      //    $posting_date=$this->m_general->posting_date_select_max();
      // if (empty($id_outlet))
      //    $id_outlet=$this->session->userdata['ADMIN']['plant'];

      $this->db->select_max('id_grpodlv_plant');
      $this->db->from('t_grpodlv_header');
      $this->db->where('plant', $id_outlet);
      $this->db->where('DATE(posting_date)', $posting_date);
      // if (!empty($id_grpodlv_header)) {
      // $this->db->where('id_grpodlv_header <> ', $id_grpodlv_header);
      // }
      $query = $this->db->get();

      if(($query)&&($query->num_rows() > 0)) {
        $grpodlv = $query->row_array();
        $id_grpodlv_outlet = $grpodlv['id_grpodlv_plant'] + 1;
      }	else {
        $id_grpodlv_outlet = 1;
      }

      return $id_grpodlv_outlet;
    }

    function getDataQtyU_grqty_web($base, $item){
      $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
      $SAP_MSI->from('WTR1');
      $SAP_MSI->where('DocEntry', $base);
      $SAP_MSI->where('LineNum', $item);

      $query = $SAP_MSI->get();

      if(($query)&&($query->num_rows() > 0))
        return $query->row_array();
      else
        return FALSE;
        
    }
    

    function grpodlv_header_insert($data){

      //return 1;
      if($this->db->insert('t_grpodlv_header', $data)){
        return $this->db->insert_id();
      } else {
        return FALSE;
      }

    }

    function grpodlv_detail_insert($data) {
      //return 1;
      if($this->db->insert('t_grpodlv_detail', $data)){
        return $this->db->insert_id();
      } else {
        return FALSE;
      }
    }

    function sap_grpodlv_details_select_by_do_and_item($do_no,$item) {
      
      if (empty($this->session->userdata['do_nos'])) {
          $doitem = $this->sap_do_select_all("",$do_no,$item);
      } else {
          $do_nos = $this->session->userdata['do_nos'];
          $k = 1;
          $count = count($do_nos);
          for ($i=1;$i<=$count;$i++) {
            if(($do_nos[$i]['VBELN']==$do_no)&&($do_nos[$i]['POSNR']==$item)){
              $doitem[1] = $do_nos[$i];
              break;
            }
          }
      }

      if (count($doitem) > 0) {
        return $doitem[1];
      }
      else {
        return FALSE;
      }

    }

    public function sap_do_select_all($kd_plant="",$do_no="",$do_item="") { 

      // $SAP_MSI->from('WTR1');
      $SAP_MSI = $this->load->database('SAP_MSI', TRUE);

      $SAP_MSI->select("OWTR.DocEntry VBELN,
                              OWTR.DocDate DELIV_DATE,
                              OWTR.ToWhsCode,
                              WTR1.LineNum POSNR, 
                              SeriesName + RIGHT('00000' + CONVERT(varchar, DocNum), 6) AS Doc_Num,
                              OITM.ItmsGrpCod DISPO, 
                              WTR1.ItemCode MATNR, 
                              Dscription MAKTX, 
                              (OpenQty-U_grqty_web) LFIMG, 
                              OITM.InvntryUom VRKME, 
                              WTR1.LineNum item, 
                              ToWhsCode PLANT");
      $SAP_MSI->from('OWTR');
      $SAP_MSI->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
      $SAP_MSI->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
      $SAP_MSI->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
      $SAP_MSI->join('NNM1','OWTR.Series=NNM1.Series','inner');

      $SAP_MSI->where('ToWhsCode',$plant);
      $SAP_MSI->where('(OpenQty-U_grqty_web) >', 0);
      $SAP_MSI->where('OWTR.CANCELED','N');
      $SAP_MSI->where('OWTR.U_Reverse','N');
      $SAP_MSI->where('OWTR.U_Stat',0); //buat ngilangin notifikasi

      $query = $SAP_MSI->get();

      if(($query)&&($query->num_rows() > 0)) {
        
        $DELV_OUTS = $query->result_array();
        $count = count($DELV_OUTS)-1;
        
        for ($i=0;$i<=$count;$i++) {
          $poitems[$i+1] = $DELV_OUTS[$i];
        }
        
        return $poitems;
            
      } else {
        return FALSE;
      }

    
    } 


    function grpodlv_header_select($id_grpodlv_header) {
      
      $this->db->from('t_grpodlv_header');
      $this->db->where('id_grpodlv_header', $id_grpodlv_header);

      $query = $this->db->get();

      if(($query)&&($query->num_rows() > 0))
        return $query->row_array();
      else
        return FALSE;
    }

    function grpodlv_details_select($id_grpodlv_header) {
      
      $this->db->from('t_grpodlv_detail');
      $this->db->where('id_grpodlv_header', $id_grpodlv_header);
      $this->db->order_by('id_grpodlv_detail');
  
      $query = $this->db->get();
      
      if(($query)&&($query->num_rows() > 0))
        return $query->result_array();
      else
        return FALSE;

    }
    
    function Update_StatOwtr($data, $DOcEntry) {
      $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
      $SAP_MSI->where('DOcEntry', $DOcEntry);
      if($SAP_MSI->update('OWTR', $data))
        return TRUE;
      else
        return FALSE;
    }

    function Update_U_grqty_web_WTR1($data, $DOcEntry, $LineNum) {
      $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
      $SAP_MSI->where('DOcEntry', $DOcEntry);
      $SAP_MSI->where('LineNum', $LineNum);

      if($SAP_MSI->update('WTR1', $data))
        return TRUE;
      else
        return FALSE;

    }

    function grpodlv_header_update($data) {
      $this->db->where('id_grpodlv_header', $data['id_grpodlv_header']);
      if($this->db->update('t_grpodlv_header', $data))
        return TRUE;
      else
        return FALSE;
    }

    function grpodlv_detail_update($data) {
      $this->db->where('id_grpodlv_detail', $data['id_grpodlv_detail']);
      if($this->db->update('t_grpodlv_detail', $data))
        return TRUE;
      else
        return FALSE;
    }
    
    function getHeadDeatForPrint($ID){

      $query = $this->db->query('SELECT a.do_no, Date_format(a.posting_date, "%d %M %Y") posting_date, a.grpodlv_no, Date_format(a.lastmodified,"%d %M %Y")  lastmodified,b.material_no,b.material_desc,b.uom,b.outstanding_qty,b.gr_quantity,a.plant ,a.id_user_approved  FROM t_grpodlv_header a JOIN t_grpodlv_detail b ON a.id_grpodlv_header = b.id_grpodlv_header
        where a.id_grpodlv_header ="'.$ID.'"');
      
      return $query;

    }
    function sap_grpodlv_headers_select_by_kd_do($kd_plant="",$do_no="",$do_item="")
    {
        $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
        $filler=Array('WMSISTBS','WMSISTFG','WMSISTPR','WMSISTQC','WMSISTRM','WMSISTTR','WDFGSYBS','WDFGSYFG','WDFGSYPR','WDFGSYRM','WDFGSYQC','WDFGSTRM');
																									
        $SAP_MSI->select("OWTR.DocEntry VBELN, 
                            OWTR.DocDate DELIV_DATE, 
                            OWTR.ToWhsCode, 
                            WTR1.LineNum POSNR, 
                            SeriesName + RIGHT('00000' + CONVERT(varchar, DocNum), 6) AS Doc_Num, 
                            OITM.ItmsGrpCod DISPO, 
                            WTR1.ItemCode MATNR, 
                            Dscription MAKTX, 
                            (OpenQty-U_grqty_web) LFIMG, 
                            OITM.InvntryUom VRKME, 
                            WTR1.LineNum item, 
                            ToWhsCode PLANT");
        $SAP_MSI->from('OWTR');
        $SAP_MSI->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
        $SAP_MSI->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
        $SAP_MSI->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
        $SAP_MSI->join('NNM1','OWTR.Series=NNM1.Series','inner');
        $SAP_MSI->where('OWTR.ToWhsCode', 'WMSITJST');
        $SAP_MSI->where('OWTR.CANCELED', 'N');
        $SAP_MSI->where('OWTR.U_Reverse', 'N');
        $SAP_MSI->where('OWTR.U_Stat', '0');
        $SAP_MSI->where_in('Filler',$filler);
        
        // if(!empty($do_no)) {
        //     $this->db->where('t0.U_DocNum',$do_no);
        // }
        // if(!empty($do_item)) {
        //     $this->db->where('t1.LineNum',$do_item);
        // }
        // if(empty($do_no)&&empty($do_item)) {
        // }

        $query = $SAP_MSI->get();
        $ret = $query->result_array();
        return $ret;

        // if(($query)&&($query->num_rows() > 0)) {
        //     $dos = $query->result_array();
        //     $count = count($dos);
        //     for ($i=0;$i<=$count-1;$i++) {
        //         $do[$i+1] = $dos[$i];
        //     }
        //     return $do;
        // } else {
        //     return FALSE;
        // }
    }

    function sap_grpodlv_details_select_by_do_no($do_no)
    {
        if (empty($this->session->userdata['do_nos'])) {          
          $doitems= $this->sap_grpodlv_headers_select_slip_number($do_no);
          // $doitems = $doitem->result_array();
        } else {
            $do_nos = $this->session->userdata['do_nos'];
            $count = count($do_nos);
            for ($i=1;$i<=$count;$i++) {
              if ($do_nos[$i]['VBELN']==$do_no){
                $doitems[1] = $do_nos[$i];
                break;
              }
            }
        }
        
        $count = count($doitems);
        if ($count > 0) {
            $k=1;
            for($i=1;$i<=$count;$i++) {
              $doitems[$i]['id_grpodlv_h_detail'] = $k;
              $k++;
            }
        } else {
          unset($doitems);
        }

        return $doitems;
    }

    function sap_item_groups_select_all() {
  
        $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->from('m_item_group');
        $this->db->where('kdplant', $kd_plant);
    
        $query = $this->db->get();
        if(($query)&&($query->num_rows() > 0)) {
            $item_groups = $query->result_array();
          $count = count($item_groups);
          $k = 0;
          for ($i=0;$i<=$count-1;$i++) {
            $item_group[$k] = $item_groups[$i];
            $k++;
          }
          return $item_group;
        } else {
          return FALSE;
        }
    }

    
    function sap_grpodlv_select_item_group_do($do_no)
    {
        $doitems = $this->sap_grpodlv_details_select_by_do_no($do_no);
        $item_groups = $this->sap_item_groups_select_all();
        
        // return count($item_groups);
        
        // $count = count($item_groups);
        // $count_do = count($doitems);

        $k = 1;        
        foreach($item_groups as $igroups){
          
          foreach($doitems as $item){ 

            if( $igroups['DISPO'] == (int)$item['DISPO']){
              $item_groups_filter[$k] = $igroups['DSNAM'];
              $k++;
              break;
            }

          }

        }
        
        if(count($item_groups_filter) > 0){
          $item_groups_filter = array_unique($item_groups_filter);
          return $item_groups_filter;
        } else {
          return FALSE;
        }
        
        //$k = 1;
        // for ($i=1;$i<=$count;$i++) {

        //   for($j=1;$j<=$count_do;$j++) {

        //     if ($doitems[$j]['DISPO'] == (int)$item_groups[$i]['DISPO']) {
        //       $item_groups_filter[$k] = $item_groups[$i]['DSNAM'];
        //       $k++;
        //       break;
        //     }

        //   }

        // }

        
        // if (count($item_groups_filter) > 0) {
        //   $item_groups_filter = array_unique($item_groups_filter);
        //   return $item_groups_filter;
        // }
        // else {
        //   return FALSE;
        // }

    }

  function grpodlv_header_delete($id){
    if($this->grpodlv_details_delete($id)){
      $this->db->where('id_grpodlv_header', $id);
      if($this->db->delete('t_grpodlv_header'))
          return TRUE;
      else
          return FALSE;
    }
  }

  function grpodlv_details_delete($id){
    $this->db->where('id_grpodlv_header', $id);
    if($this->db->delete('t_grpodlv_detail'))
      return TRUE;
    else
      return FALSE;
  }

}