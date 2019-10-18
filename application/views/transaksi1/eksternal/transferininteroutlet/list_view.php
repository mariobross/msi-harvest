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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Transfer Out Inter Outlet</legend>
											
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
												<div class="col-lg-9"><b>200352</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer In Number</label>
												<div class="col-lg-9">
													<i>(Auto Number after Posting to SAP)</i>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													WDFGBNST - Bintaro
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Transit Location</label>
												<div class="col-lg-9">
													WDFGBNST - Bintaro
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Delivery Outlet</label>
												<div class="col-lg-9">
													<b>WDFGAMPM - Ampera - PM</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Delivery Date</label>
												<div class="col-lg-9">
													<b>16-10-2019</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<b>Not Approved</b>
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
								<br>
								
								<table id="table-transferininteroutlet" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th style="text-align: left">*</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>Good Issue Qty</th>
											<th>Actual GR. Qty</th>
											<th>Uom</th>
											<th>Val</th>
											<th>Variance</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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
                $('#table-transferininteroutlet').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/transferininteroutlet/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
                        {"data":"material_no"},
                        {"data":"material_desc"},
                        {"data":"gi_qty"},
						{"data":"gr_qty", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="text" class="form-control" value="${data}">`;
                            return rr;
                        }},
                        {"data":"uom"},
						{"data":"val", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<select class="form-control"><option value="variance" selected>Variance</option><option value="rmbeverage">RM Beverage</option></select>`;
                            return rr;
                        }},
						{"data":"variance", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="text" class="form-control" value="${data}">`;
                            return rr;
                        }},
                    ]
                });
            });
        
        </script>
	</body>
</html>