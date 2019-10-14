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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Onhand Report</legend>
                                                                                        
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
								<br>
								<div class="row">
									<div class="col-md-12" style="overflow: auto">
									<fieldset>
										<table class="table table-bordered table-striped" id="tblReportOnhand" style="display:none">
											<thead>
												<tr>
													<th style="text-align: center">No</th>
													<th style="text-align: center">Code</th>
													<th style="text-align: center">Description</th>
													<th style="text-align: center">On Hand</th>
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
			$('#fromDate').datepicker();
			$('#toDate').datepicker();

			const table = document.getElementById("tblReportOnhand");
			const search = document.getElementById("btnSearch");
			search.addEventListener('click', function () {
				table.style.display = "table";
			});
		});
		</script>
	</body>
</html>