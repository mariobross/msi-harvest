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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Inventory Audit</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Dari Tanggal</label>
												<div class="col-lg-3 input-group date">
													<input type="text" class="form-control" id="fromDate">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
												<label class="col-lg-2 col-form-label">Sampai Tanggal</label>
												<div class="col-lg-4 input-group date">
													<input type="text" class="form-control" id="toDate">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Warehouse</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">Pilih 1</option>
														<option value="">Pilih 2</option>
														<option value="">Pilih 3</option>
														<option value="">Pilih 4</option>
														<option value="">Pilih 5</option>
													</select>
												</div>
											</div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Group</label>
												<div class="col-lg-9">
												<select class="form-control form-control-select2" data-live-search="true">
														<option value="">Pilih 1</option>
														<option value="">Pilih 2</option>
														<option value="">Pilih 3</option>
														<option value="">Pilih 4</option>
														<option value="">Pilih 5</option>
													</select>
												</div>
											</div>

                                            <div class="text-right">
                                                <button type="button" id="btnSearch" class="btn btn-primary">Search<i class="icon-search4 ml-2"></i></button>
											</div>
											

											
                                        </fieldset>
                                    </div>
								</div>	
							
                            </form>
                        </div>
                    </div>  
					<div class="card" style="display:none" id="crdTable">
						<div class="card-body" >
							<div class="row">
								<div class="col-md-12" style="overflow: auto">
								<fieldset>
									<table class="table table-bordered table-striped" id="tblReportInventory">
										<thead>
											<tr>
												<th rowspan="2">No</th>
												<th rowspan="2">Code</th>
												<th rowspan="2">Description</th>
												<th rowspan="2">Unit</th>
												<th rowspan="2" style="text-align: center">Beginning Stock</th>
												<th colspan="7" style="text-align: center">Qty In</th>
												<th rowspan="2" style="text-align: center">Total In</th>
												<th colspan="6" style="text-align: center">Qty Out</th>
												<th rowspan="2" style="text-align: center">Total Out</th>
												<th rowspan="2">Subtotal</th>
											</tr>
											<tr>
												<th style="text-align: center">GR From CK</th>
												<th style="text-align: center">GR PO</th>
												<th style="text-align: center">GR From Outlet</th>
												<th style="text-align: center">GR Production</th>
												<th style="text-align: center">GR Whole Cake</th>
												<th style="text-align: center">GR No PO</th>
												<th style="text-align: center">GR Return</th>
												<th style="text-align: center">ISSUE Sales</th>
												<th style="text-align: center">ISSUE Transfer Outlet</th>
												<th style="text-align: center">ISSUE Production</th>
												<th style="text-align: center">ISSUE Whole Cake</th>
												<th style="text-align: center">ISSUE Waste Material</th>
												<th style="text-align: center">ISSUE Return Out</th>
											</tr>
										</thead>
									</table>
								<fieldset>	
								</div>
							</div>
						</div>
					</div>                  
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
		<?php  $this->load->view("_template/js.php")?>
		<script>
		$(document).ready(function () {
			$('#fromDate').datepicker();
			$('#toDate').datepicker();

			const crdTable = document.getElementById("crdTable");
			const search = document.getElementById("btnSearch");
			search.addEventListener('click', function () {
				crdTable.style.display = "";
			});
		});
		</script>
	</body>
</html>