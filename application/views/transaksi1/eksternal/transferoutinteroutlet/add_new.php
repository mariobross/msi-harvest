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
					<form action="#" method="POST">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Transfer Out Inter Outlet</legend>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label"><b>Data SAP per Tanggal/Jam</b></label>
												<div class="col-lg-9"><b>Data tidak ditemukan.</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Store Room Request (SR) Number</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">86514</option>
													</select>
													<a href="#">Pilih ulang SR No dan Jenis Material</a>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer Slip Number</label>
												<div class="col-lg-9"><input type="text" class="form-control" readonly="" value="(Auto Number after Posting to SAP).">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="WMSICKST - Cikarang">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Transit Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="WMSICKST - MSI Cikarang">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Request To</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="T.WMSIHI - Transit The Harvest Harapan Indah Bekasi">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">All</option>
													</select>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="16-10-2019">
												</div>
											</div>
											
											<div class="form-group row">
												<div class="col-lg-12 text-right">
													<div class="text-right">
														<button type="submit" class="btn btn-primary">Save <i class="icon-pencil5 ml-2"></i></button>
														<button type="submit" class="btn btn-success">Approve <i class="icon-paperplane ml-2"></i></button>
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
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Transfer Out Inter Outlet</legend>
							</div>
							<div class="card-body">
								<div class="col-md-12 mb-2">
									<div class="text-left">
										<input type="button" class="btn btn-primary" value="Add" id="addTable"> 
										<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
									</div>
								</div>
								<table id="tblWhole" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th style="text-align: left">*</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>In WHS Quantity</th>
											<th>Outstanding Qty</th>
											<th>Quantity</th>
											<th>Uom Reg.</th>
											<th>Uom</th>
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
                var table = $("#tblWhole").DataTable({
					"ordering":false
				});
				count = 1;

				$("#addTable").on('click', function() {
					table.row.add([
						count,
						`<select class="form-control form-control-select2" data-live-search="true">
							<option value="">Select Item</option>
							<option value="1">Pilih 1</option>
							<option value="2">Pilih 2</option>
						</select>`,
						``,
						'',
						'',
						'<input type="text" name="qty[]" id="qty[]">',
						'',
						''
					]).draw(false);
					count++;
				});
				$("#addTable").click();
            });
        
        </script>
	</body>
</html>