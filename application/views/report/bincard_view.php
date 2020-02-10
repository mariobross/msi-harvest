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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Bincard Report</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Dari Tanggal</label>
												<div class="col-lg-3 input-group date">
													<input type="text" class="form-control" id="fromDate" autocomplete="off" readonly>
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
												<label class="col-lg-2 col-form-label">Sampai Tanggal</label>
												<div class="col-lg-4 input-group date">
													<input type="text" class="form-control" id="toDate" autocomplete="off" readonly>
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
													<select class="form-control form-control-select2" data-live-search="true" id="warehouse" name="warehouse">
														<option value="">Select Item</option>
														<?php foreach($warehouse as $key=>$val):?>
															<option value="<?=$val['WhsCode']?>"><?=$val['WhsName']?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Group</label>
												<div class="col-lg-9">
												<select class="form-control form-control-select2" data-live-search="true" id="itemGroup" name="itemGroup">
													<option value="all">--- All ---</option>
													<?php foreach($itemGroup as $key=>$val):?>
														<option value="<?=$val['ItmsGrpNam']?>"><?=$val['ItmsGrpNam']?></option>
													<?php endforeach;?>
												</select>
												</div>
											</div>

                                            <div class="text-right">
                                                <button type="button" id="btnSearch" class="btn btn-primary">Search<i class="icon-search4 ml-2"></i></button>
											</div>
											

											
                                        </fieldset>
                                    </div>
								</div>	
								<br>
								<div class="row">
									<div class="col-md-12" style="overflow: auto">
									<fieldset>
										<table class="table table-bordered table-striped" id="tblReportBincard" style="display:none">
											<thead>
												<tr>
													<th rowspan="2">No</th>
													<th rowspan="2">Code</th>
													<th rowspan="2">Description</th>
													<th colspan="3" style="text-align: center">Qty In</th>
													<th rowspan="2" style="text-align: center">Total In</th>
													<th colspan="2" style="text-align: center">Qty Out</th>
													<th rowspan="2" style="text-align: center">Total Out</th>
												</tr>
												<tr>
													<th style="text-align: center">GR From CK</th>
													<th style="text-align: center">GR From Outlet</th>
													<th style="text-align: center">GR Return</th>
													<th style="text-align: center">ISSUE Transfer Outlet</th>
													<th style="text-align: center">ISSUE Return Out</th>
												</tr>
											</thead>
										</table>
									<fieldset>	
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
		$(document).ready(function () {
			const date = new Date();
			const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			var optSimple = {
				format: 'dd-mm-yyyy',
				todayHighlight: true,
				orientation: 'bottom right',
				autoclose: true
			};

			$('#fromDate').datepicker();
			$('#toDate').datepicker();

			const table = document.getElementById("tblReportBincard");
			const search = document.getElementById("btnSearch");
			search.addEventListener('click', function () {
				table.style.display = "block";
			});
		});
		</script>
	</body>
</html>