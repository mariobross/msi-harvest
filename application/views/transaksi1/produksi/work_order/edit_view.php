<!DOCTYPE html>
<html lang="en">
	<head>
		<?php  $this->load->view("_template/head.php")?>
		<style>
			th{
				text-align:center;
			}
			td{
				text-align:center;
			}
		</style>
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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Produksi</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Produksi</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="selectItem">
														<option value="">Select Item</option>
														<option value="1">Pilih 1</option>
														<option value="2">Pilih 2</option>
													</select>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Qty Produksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Suggest Qty : 1.0000)" >
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">UOM</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readOnly>
												</div>
											</div>

											<div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="postDate">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" id="btnCancel">Cancel<i class="icon-paperplane ml-2"></i></button>
												<!-- <button type="submit" class="btn btn-success">Approve SAP<i class="icon-paperplane ml-2"></i></button> -->
                                            </div>

											
                                        </fieldset>
                                    </div>
                                </div>
								<br>
								<div class="row">
									<div class="col-md-12" style="overflow: auto" >
										<table class="table table-bordered table-striped" id="tblWhole">
											<thead>
												<tr>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>QC</th>
													<th>On Hand</th>
													<th>Min Stock</th>
													<th>Oustanding Total</th>
													<th>Cancel</th>
												</tr>
											</thead>
										</table>
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

			$('#postDate').datepicker();

			let table = $("#tblWhole").DataTable({
				"ordering":false
				});			
		});
		</script>
	</body>
</html>