<!DOCTYPE html>
<html lang="en">
	<head>
		<?php  $this->load->view("_template/head.php")?>
	</head>
	<body>
	<?php  $this->load->view("_template/nav.php")?>
		<div class="page-content">
			<?php  $this->load->view("_template/sidebar.php")?>
			<div class="content-wrapper">
                <!-- <?php  $this->load->view("_template/breadcrumb.php")?> -->
				<div class="content">
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Good Receipt PO from Vendor</legend>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label"><b>Data SAP per Tanggal/Jam</b></label>
												<div class="col-lg-9"><b>Data tidak ditemukan. </b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer Slip Number</label>
												<div class="col-lg-9">
													<b>Saat ini tidak ada nomor Transfer Slip Number.</b>
													<br>
													<i>Anda memiliki 1 Nomor PO yang harus segera diterima dan disetujui.</i>
													<br>
													Silahkan email : <b> sap.helpdesk@ybc.co.id</b>
												</div>
											</div>
											
                                        </fieldset>
                                    </div>
								</div>	
                            </form>
                        </div>
                    </div>                    
					
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
		<?php  $this->load->view("_template/js.php")?>
		<script>
            $(document).ready(function(){
                $('#table-manajemen').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/pofromvendor/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
                        {"data":"material_no"},
                        {"data":"material_desc"},
                        {"data":"quantity"},
						{"data":"gr_qty", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="text" class="form-control" value="${data}">`;
                            return rr;
                        }},
                        {"data":"uom"},
						{"data":"qc", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="text" class="form-control" id="chk_${data}" value="">`;
                            return rr;
                        }},
                    ]
                });
            });
        
        </script>
	</body>
</html>