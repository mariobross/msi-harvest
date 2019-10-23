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
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Good Receipt PO from Vendor</legend>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label"><b>Data SAP per Tanggal/Jam</b></label>
												<div class="col-lg-9"><b>Belum ada data</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Order Entry</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">40471 - PO2019100000815( PR ->1709 )</option>
														<option value="">40472 - PO2019100840815( PR ->1710 )</option>
														<option value="">40473 - PO2019100984815( PR ->1711 )</option>
														<option value="">40474 - PO2019100000815( PR ->1712 )</option>
														<option value="">40475 - PO2019143300815( PR ->1713 )</option>
													</select>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Order Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="DF2019086000050">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Code</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="TH.NT2P1363">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Name</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="Pijar Mas, CV">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Delivery Date</label>
												<div class="col-lg-9 input-group date">
													<input type="text" class="form-control" id="delivDate">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Goods Receipt Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="(Auto Number after Posting to SAP)">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="WMSICKST - Cikarang">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="WMSICKST - MSI Cikarang">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="Not Approved">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">All</option>
														<option value="">RM MAT Office</option>
														<option value="">Exp. Stationary</option>
													</select>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9">
													<input type="text" value="07-10-2019" class="form-control">
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
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
							</div>
							<div class="card-body">
								<table id="table-manajemen" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th style="text-align: left">*</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>Outstanding Qty</th>
											<th>Gr Qty</th>
											<th>Uom</th>
											<th>Remark</th>
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
                            rr=`<input type="text" class="form-control">`;
                            return rr;
                        }},
                        {"data":"uom"},
						{"data":"qc", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="text" class="form-control" id="chk_${data}" value="">`;
                            return rr;
                        }},
                    ]
				});
				
				const date = new Date();
				const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
				var optSimple = {
					format: 'mm-dd-yyyy',
					todayHighlight: true,
					orientation: 'bottom right',
					autoclose: true,
					container: '#delivDate'
				};
				$('#delivDate').datepicker(optSimple);
				$('#delivDate').datepicker( 'setDate', today );
            });
        
        </script>
	</body>
</html>