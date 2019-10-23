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
                    <form action="#" method="POST">
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Goods Receipt Non PO</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Goods Receipt No.</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Plant</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Cost Center</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="" readOnly>
												</div>
											</div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Not Approved" readOnly>
												</div>
											</div>

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" disabled>
														<option value="">Select Item</option>
														<option value="1">Pilih 1</option>
														<option value="2">Pilih 2</option>
													</select>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="postDate" disabled>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Cancel<i class="icon-paperplane ml-2"></i></button>
												<!-- <button type="submit" class="btn btn-success">Approve SAP<i class="icon-paperplane ml-2"></i></button> -->
                                            </div>

											
                                        </fieldset>
                                    </div>
                                </div>
								</div>
                    </div>
					<div class="card">
                        <div class="card-body">
                            
								<div class="row">
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
									<div class="col-md-12" style="overflow: auto">
										<table class="table table-bordered table-striped" id="tblWhole">
											<thead>
												<tr>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Text</th>
													<th>Cancel</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
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
			
			$('#postDate').datepicker();
		});
		</script>
	</body>
</html>