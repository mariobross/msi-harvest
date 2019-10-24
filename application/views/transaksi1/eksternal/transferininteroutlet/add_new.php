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
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Transfer In Inter Outlet</legend>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9"><input type="text" class="form-control" readonly="" value="">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label"><i>SR Number — Transfer In Inter Outlet</i></label>
												<div class="col-lg-9">
													<select class="form-control">
														<option value="94897" selected>94897</option>
													</select>
													<a href="#">Pilih ulang SR Number</a>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer Out No</label>
												<div class="col-lg-9"><input type="text" class="form-control" readonly="" value="200352">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer In Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="(Auto Number after Posting to SAP)">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="WDFGBNST - Bintaro">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Transit Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer to Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="WDFGAMPM - Ampera - PM">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Delivery Date</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="16-10-2019">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="Not Approved">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="All">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="17-10-2019">
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
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Transfer In Inter Outlet</legend>
							</div>
							<div class="card-body">			
								<table id="table-transferininteroutlet" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Item No</th>
											<th>Item Desc</th>
											<th>SR Qty</th>
											<th>TF Qty</th>
											<th>Rcv Qty</th>
											<th>UOM</th>
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
                $('#table-transferininteroutlet').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/transferininteroutlet/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
                        {"data":"item_no"},
                        {"data":"item_desc"},
                        {"data":"gi_qty"},
                        {"data":"gr_qty"},
						{"data":"rcv_qty", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="text" class="form-control" value="${data}">`;
                            return rr;
                        }},
						{"data":"uom"},
                    ]
                });
            });
        
        </script>
	</body>
</html>