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
				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success" role="alert">
						<?php echo $this->session->flashdata('success'); ?>
					</div>
				<?php endif; ?>
				<?php if ($this->session->flashdata('failed')): ?>
					<div class="alert alert-danger" role="alert">
						<?php echo $this->session->flashdata('failed'); ?>
					</div>
				<?php endif; ?>
					<form action="#" method="POST">
					<input type="hidden" name="status" id="status" value="<?=$wo_header['status']?>">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Edit Produksi</legend>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $wo_header['id_produksi_header']?>" id="id_wo_header" nama="id_wo_header">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="WMSISNST - Senopati" id="wo_plant" nama="wo_plant">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Produksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $wo_header['kode_paket'].' - '.$wo_header['nama_paket']?>">
													<input type="hidden" value="<?= $wo_header['kode_paket']?>" id="kode_paket" nama="kode_paket">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">QTY Produksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $wo_header['qty_paket']?>" id="qty_paket" nama="qty_paket">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">UOM</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $wo_header['uom_paket']?>" id="uom_paket" nama="uom_paket">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9 input-group date">
													<input type="text" class="form-control" id="postDate" value="<?= date("d-m-Y", strtotime($wo_header['posting_date']))?>" readonly="" id="posting_date" nama="posting_date">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>	
							</div>
						</div>                    
						
						<div class="card">
							<div class="card-header">
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Work Order</legend>
							</div>
							<div class="card-body">
								<table id="table-manajemen" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th style="text-align: left">No</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>Quantity</th>
											<th>Uom</th>
											<!--<th>QC</th>-->
											<th>On Hand</th>
											<th>Min Stock</th>
											<th>Outstanding Total</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</form>
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
		<?php  $this->load->view("_template/js.php")?>
		<script>
			
            $(document).ready(function(){
				let id_wo_header = $('#id_wo_header').val();
				let kode_paket = $('#kode_paket').val();
				let qty_paket = $('#qty_paket').val();
				let stts = $('#status').val();

                $('#table-manajemen').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/wo/showDetailEdit');?>",
						"data":{ 
							id: id_wo_header, 
							kodepaket:kode_paket,
							qtypaket:qty_paket
						},
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no", "className":"dt-center"},
                        {"data":"material_no", "className":"dt-center"},
                        {"data":"material_desc"},
                        {"data":"qty", "className":"dt-center"},
                        {"data":"uom", "className":"dt-center"},
                        //{"data":"qc", "className":"dt-center"},
                        {"data":"OnHand", "className":"dt-center"},
                        {"data":"MinStock", "className":"dt-center"},
                        {"data":"OpenQty", "className":"dt-center"}
                    ]
                });
            });
        
        </script>
	</body>
</html>