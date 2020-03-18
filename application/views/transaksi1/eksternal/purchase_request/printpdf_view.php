<?php
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    foreach($data as $row) 
    
      $plant = $row['plant'] ;
      $SAP_MSI->select('WhsName,OLCT.Location');
      $SAP_MSI->from('OWHS');
      $SAP_MSI->join('OLCT','OWHS.Location = OLCT.Code','inner');
      $SAP_MSI->where('WhsCode',$plant);
      $query = $SAP_MSI->get();
      $temp = $query->result_array();
      print_r($plant);
      die();
      $reck=$temp[0]['WhsName'];
      $reck_loc=$temp[0]['Location'];

?>
<style type="text/css">
<!--
.style5 {font-size: 10px}
.style6 {
	font-size: 18px;
	font-weight: bold;
}
.style10 {font-size: 24px}
.style8 {font-size: 9px}
.style12 {font-size: 18px}
-->
</style>

<p>&nbsp;</p>
<table width="676"  align="center">
  <tr>
    <td width="373"><u><span class="style10"><span class="style12">____________</span><br />
          <span class="style6">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></td>
    <td colspan="2" align="center"><span class="style6">PURCHASE REQUEST</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="116">No PR</td>
    <td width="165">:&nbsp;<?php echo $row['pr_no'];?></td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>Date</td>
    <td>:&nbsp;<?php $date=$row['created_date'];
	echo substr($date,0,-8);?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>Delivery Date</td>
    <td>:&nbsp;<?php $date2=$row['delivery_date'];
	echo substr($date2,0,-8);?></td>
  </tr>
  <tr>
    <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
    <td>Delivery</td>
    <td>:&nbsp;<strong><?=$reck;?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="44%" border="1" align="center">
  <tr>
    <td width="23" rowspan="2" align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="75" rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Code</strong></td>
    <td width="208" rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Description</strong></td>
    <td width="54" rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Uom</strong></td>
    <td width="47" rowspan="2" align="center" bgcolor="#FFFFFF"><strong>Qty</strong></td>
    <td colspan="3" align="center" bgcolor="#FFFFFF"><strong>Stock</strong></td>
  </tr>
  <tr>
    <td width="69" align="center" bgcolor="#FFFFFF"><strong>Minimum</strong></td>
    <td width="69" align="center" bgcolor="#FFFFFF"><strong>Maximum</strong></td>
    <td width="85" align="center" bgcolor="#FFFFFF"><strong>On Hand</strong></td>
  </tr>
   <?php
   $no = 1;
   $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
foreach($data as $row1) 
{

	
?>
  <tr>
 
    <td height="15" align="center"><span class="style8"><?php echo $no++; ?></span></td>
    <td><span class="style8">&nbsp;<?php echo $mat=$row1['material_no']; ?></span></td>
    <td align="left"><span class="style8">&nbsp;<?php echo $row1['material_desc']; ?></span></td>
    <td align="center"><span class="style8">&nbsp;<?php echo $row1['uom']; ?></span></td>
    <td align="right"><span class="style8">&nbsp;
      <?php $qty=$row1['requirement_qty'];
	echo substr($qty,0,-2); ?>
    &nbsp;&nbsp;</span></td>
    <td align="right"><span class="style8">
      <?php
	  $plant=$row1['plant']; 
	
  
    $SAP_MSI->from('OITW');
    $SAP_MSI->where('ItemCode',$mat);
    $SAP_MSI->where('WhsCode',$plant);
    $query = $SAP_MSI->get();
    $r = $query->result_array();

    //$r=mssql_fetch_array($t);
    $part=$r[0]['MinStock'];
    $max=$r[0]['MaxStock'];
    $onhand=$r[0]['OnHand'];
    
    echo substr($part,0,-4);
	?>
&nbsp;    </span></td>
    <td align="right"><span class="style8"><?php echo substr($max,0,-4); ?>&nbsp;</span></td>
    <td align="right"><span class="style8"> &nbsp;<?php echo substr($onhand,0,-4); ?>&nbsp;</span></td>
  </tr>
       <?php
}
?>

  <tr>
    <td height="15" align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="15" align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td height="69" colspan="8" >Remark :</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="606" border="1"   style="border-collapse:collapse;" align="center">
  <tr>
    <td width="187" align="center" scope="col">Requested by :</td>
    <td width="196" align="center" scope="col">Approved by :</td>
    <td width="201" align="center" scope="col">Verified by :</td>
  </tr>
  <tr>
    <td height="115" align="center" valign="bottom">(User)</td>
    <td align="center" valign="bottom">(<?php echo $data[0]['user_approved'];?>)</td>
    <td align="center" valign="bottom">(Purchasing)</td>
  </tr>
</table>
<p>&nbsp;	</p>
<p>&nbsp;</p>
<div align="justify"></div>
<table width="640" align="center">
  <tr>
    <td width="10"><span class="style5">1.</span></td>
    <td width="618"><span class="style3 style5"> FILLOUT IN DUPLICATE RETAIL YELLOW COPY FOR YOURFILE</span></td>
  </tr>
  <tr>
    <td><span class="style5">2.</span></td>
    <td><span class="style3 style5"> DEPARTEMENT MANAGERS MUST SIGN PRIOR TO ORDERING</span></td>
  </tr>
  <tr>
    <td><span class="style5">3.</span></td>
    <td><span class="style3 style5"> RECEIVING - RED</span></td>
  </tr>
  <tr>
    <td><span class="style5">4.</span></td>
    <td><span class="style3 style5"> USER - BLUE</span></td>
  </tr>
</table>
