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

      $reck=$temp[0]['WhsName'];
      $reck_loc=$temp[0]['Location'];

    $DocEntry=$row['pr_no'];
	 
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
    <td colspan="2" align="center"><span class="style6">PURCHASE ORDER</span></td>
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
    <td width="116">No PO</td>
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
    <td>Delivery To</td>
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
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="44%" border="1" align="center">
  <tr>
    <td width="23"  align="center" bgcolor="#FFFFFF"><strong>No</strong></td>
    <td width="75" align="center" bgcolor="#FFFFFF"><strong>Item No.</strong></td>
    <td width="208" align="center" bgcolor="#FFFFFF"><strong>Item Description</strong></td>
    <td width="54"  align="center" bgcolor="#FFFFFF"><strong>Uom</strong></td>
    <td width="47" align="center" bgcolor="#FFFFFF"><strong>Qty</strong></td>
    <td width="95" align="center" bgcolor="#FFFFFF"><strong>Price</strong></td>
    <td width="127" align="center" bgcolor="#FFFFFF"><strong>Total</strong></td>
  </tr>
  
   <?php
    $no = 1;
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('A.ItemCode,A.Dscription,A.Price,A.unitMsr,A.Quantity,A.LineTotal,A.DocEntry,C.DiscSum,C.VatSum,C.DocTotal');
    $SAP_MSI->from('POR1 A');
    $SAP_MSI->join('PRQ1 B','A.BaseRef=B.DocEntry','inner');
    $SAP_MSI->join('OPOR C','A.DocEntry=C.DocEntry','inner');
    $SAP_MSI->where('B.DocEntry',$DocEntry);
    $SAP_MSI->group_by("A.ItemCode,A.Dscription,A.unitMsr,A.Price,A.Quantity,A.LineTotal,A.DocEntry,C.DiscSum,C.VatSum,C.DocTotal");
    $query = $SAP_MSI->get();
    // echo $SAP_MSI->last_query();
    $s = $query->result_array();

while($s)
{	
    // print_r($temp);
?>
  <tr>
 
    <td height="15" align="center"><span class="style8"><?php echo $no++; ?></span></td>
    <td><span class="style8">&nbsp;<?php echo $s['ItemCode']; ?></span></td>
    <td align="left"><span class="style8">&nbsp;<?php echo $s['Dscription']; ?></span></td>
    <td align="center"><span class="style8">&nbsp;<?php echo $s['unitMsr']; ?></span></td>
    <td align="right"><span class="style8">&nbsp;
      <?php 
	echo "Rp. ".$s['Quantity']; ?>
    &nbsp;&nbsp;</span></td>
    <td align="right"><span class="style8"><?php echo $s['Price']; ?></span></td>
    <td align="right"><span class="style8">
      <?php
	echo $s['LineTotal'];
	?>
&nbsp;    </span></td>
  </tr>
       <?php
	   $Diskon=$s[0]['DiscSum'];
	   $Ppn=$s[0]['VatSum'];
       $Grand=$s[0]['DocTotal'];
       
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
  </tr>
  <tr>
    <td colspan="5" rowspan="4"><em>Remark :</em></td>
    <td height="15">Subtotal</td>
    <td align="right"><span class="style8"><b>
    <?php
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('A.DocEntry');
    $SAP_MSI->from('POR1 A');
    $SAP_MSI->join('PRQ1 B','A.BaseRef=B.DocEntry','inner');
    $SAP_MSI->where('B.DocEntry',$DocEntry);
    $query = $SAP_MSI->get();
    $po1 = $query->result_array();

    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('SUM(LineTotal) as total');
    $SAP_MSI->from('POR1');
    $SAP_MSI->where('DocEntry',$po1[0]['DocEntry']);
    $query = $SAP_MSI->get();
    $po2 = $query->result_array();

    echo $po2[0]['total'];

	?></b></span></td>
  </tr>
  <tr>
    <td height="15">Discount</td>
   <td align="right"><span class="style8"><b><?php echo $Diskon; ?></b></span></td>
  </tr>
  <tr>
    <td height="15">PPn</td>
     <td align="right"><span class="style8"><b><?php echo $Ppn; ?></b></span></td>
  </tr>
  <tr>
    <td height="15"><strong>Grand Total</strong></td>
     <td align="right"><span class="style8"><b><?php echo $Grand; ?></b></span></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="799" border="1"   style="border-collapse:collapse;" align="center">
  <tr>
    <td width="187" align="center" scope="col">Prepared By :</td>
    <td width="187" align="center" scope="col">Verified by :</td>
    <td width="196" align="center" scope="col">Approved 1 by :</td>
    <td width="201" align="center" scope="col">Approved 2 by :</td>
  </tr>
  <tr>
  <?php
    $SAP_MSI = $this->load->database('SAP_MSI', TRUE);
    $SAP_MSI->select('Originator,UserApprove1,UserApprove2');
    $SAP_MSI->from('V_Purchase');
    $SAP_MSI->where('DocEntry',$po1[0]['DocEntry']);
    $query = $SAP_MSI->get();
    $app = $query->result_array();
	
	?>
    <td align="center" valign="bottom">(<?php echo $app[0]['Originator'];?>)</td>
    <td height="115" align="center" valign="bottom">(<?php echo $data[0]['user_approved'];?>)</td>
    <td align="center" valign="bottom">(HOD)</td>
    <td align="center" valign="bottom">(Director)</td>
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
