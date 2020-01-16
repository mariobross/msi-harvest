<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grfromkitchensentul_model extends CI_Model {

  function __construct() {
    parent:: __construct();

    $this->msi_sap = $this->load->database('msi_sap', TRUE);
  }

  public function getDataPoKitchen_Header($fromDate,$toDate,$status)
  {
      $this->db->from('t_grpodlv_header');
      $this->db->join('m_outlet', 'm_outlet.OUTLET = t_grpodlv_header.plant');
      $this->db->where('plant','T.DFRHTM');

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
      $query = $this->db->get();
      // echo $this->db->last_query();
      // die();
      $ret = $query->result_array();
      return $ret;
  }

  function sap_grpodlv_headers_select_slip_number($slipNumberHeader = "", $ItmsGrpNam = ""){
    $response = NULL;
    
    $this->msi_sap->select("OWTQ.U_DocNum as VBELN, 
                            convert(date, OWTQ.DocDate) as DELIV_DATE, 
                            OWTQ.ToWhsCode, 
                            OITM.ItmsGrpCod as DISPO, 
                            OITM.InvntryUom as VRKME, 
                            WTQ1.LineNum as Item, 
                            OWTQ.U_DocNum + ' - '+ NNM1.SeriesName + RIGHT('00000' + CONVERT(varchar, DocNum), 6) AS Doc_Num, 
                            OWTQ.ToWhsCode as PLANT, 
                            OWHS.WhsName as Outlet, 
                            OWHS.WhsName, 
                            WTQ1.ItemCode as Material_Code, 
                            OITM.ItemName as Material_Desc, 
                            WTQ1.Quantity as TF_QTY, 
                            WTQ1.unitMsr as UOM, 
                            OWTQ.Filler,
                            OITB.ItmsGrpNam,OITB.ItmsGrpNam");
    $this->msi_sap->from('OWTQ');
    $this->msi_sap->join('WTQ1','OWTQ.DocEntry = WTQ1.DocEntry','inner');
    $this->msi_sap->join('OITM','OITM.ItemCode = WTQ1.ItemCode','inner');
    $this->msi_sap->join('OWHS','OWTQ.ToWhsCode = OWHS.WhsCode','inner');
    $this->msi_sap->join('NNM1','OWTQ.Series=NNM1.Series','inner');
    $this->msi_sap->join('OITB','OITM.ItmsGrpCod = OITB.ItmsGrpCod','inner');

    $this->msi_sap->where('OWTQ.ToWhsCode', 'T.DFRHTM');
    
    if(empty($slipNumberHeader) && empty($ItmsGrpNam)) {
      $this->msi_sap->where('OWTQ.U_DocNum is NOT NULL', NULL, FALSE);
    } else if(!empty($slipNumberHeader) && empty($ItmsGrpNam)) {
      $this->msi_sap->where('OWTQ.U_DocNum',(int)$slipNumberHeader);
    } else if(!empty($slipNumberHeader) && !empty($ItmsGrpNam)){

      if($ItmsGrpNam == 'all'){
        $this->msi_sap->where('OWTQ.U_DocNum', (int)$slipNumberHeader);
      } else {
        $this->msi_sap->where('OWTQ.U_DocNum', (int)$slipNumberHeader);
        $this->msi_sap->where('OITB.ItmsGrpNam', $ItmsGrpNam);
      }
      
    } else {}
    
    $query = $this->msi_sap->get();
    
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
      
      $this->msi_sap->from('WTR1');
      $this->msi_sap->where('DocEntry', $base);
      $this->msi_sap->where('LineNum', $item);

      $query = $this->msi_sap->get();

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

      // $this->msi_sap->from('WTR1');

      $this->msi_sap->select("OWTR.DocEntry VBELN,
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
      $this->msi_sap->from('OWTR');
      $this->msi_sap->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
      $this->msi_sap->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
      $this->msi_sap->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
      $this->msi_sap->join('NNM1','OWTR.Series=NNM1.Series','inner');

      $this->msi_sap->where('ToWhsCode',$plant);
      $this->msi_sap->where('(OpenQty-U_grqty_web) >', 0);
      $this->msi_sap->where('OWTR.CANCELED','N');
      $this->msi_sap->where('OWTR.U_Reverse','N');
      $this->msi_sap->where('OWTR.U_Stat',0); //buat ngilangin notifikasi

      $query = $this->msi_sap->get();

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
      $this->msi_sap->where('DOcEntry', $DOcEntry);
      if($this->msi_sap->update('OWTR', $data))
        return TRUE;
      else
        return FALSE;
    }

    function Update_U_grqty_web_WTR1($data, $DOcEntry, $LineNum) {
      
      $this->msi_sap->where('DOcEntry', $DOcEntry);
      $this->msi_sap->where('LineNum', $LineNum);

      if($this->msi_sap->update('WTR1', $data))
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
        $filler=Array('WMSISTBS','WMSISTFG','WMSISTPR','WMSISTQC','WMSISTRM','WMSISTTR','WDFGSYBS','WDFGSYFG','WDFGSYPR','WDFGSYRM','WDFGSYQC','WDFGSTRM');
																									
        $this->msi_sap->select("OWTR.DocEntry VBELN, 
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
        $this->msi_sap->from('OWTR');
        $this->msi_sap->join('WTR1','OWTR.DocEntry = WTR1.DocEntry','inner');
        $this->msi_sap->join('OITM','WTR1.ItemCode = OITM.ItemCode','inner');
        $this->msi_sap->join('OWHS','OWHS.WhsCode = OWTR.Filler','inner');
        $this->msi_sap->join('NNM1','OWTR.Series=NNM1.Series','inner');
        $this->msi_sap->where('OWTR.ToWhsCode', 'WMSITJST');
        $this->msi_sap->where('OWTR.CANCELED', 'N');
        $this->msi_sap->where('OWTR.U_Reverse', 'N');
        $this->msi_sap->where('OWTR.U_Stat', '0');
        $this->msi_sap->where_in('Filler',$filler);
        
        // if(!empty($do_no)) {
        //     $this->db->where('t0.U_DocNum',$do_no);
        // }
        // if(!empty($do_item)) {
        //     $this->db->where('t1.LineNum',$do_item);
        // }
        // if(empty($do_no)&&empty($do_item)) {
        // }

        $query = $this->msi_sap->get();
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
          $doitems = $this->sap_grpodlv_headers_select_slip_number($do_no);
            //$doitems = $this->sap_grpodlv_headers_select_by_kd_do("",$do_no);
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
  
        // $kd_plant = $this->session->userdata['ADMIN']['plant'];
        $this->db->from('m_item_group');
        $this->db->where('kdplant', 'T.DFRHTM');
    
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
}