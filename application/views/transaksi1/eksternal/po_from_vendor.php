
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<span class="breadcrumb-item active">Dashboard</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">

				<!-- Form inputs -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Purchase Request (PR)</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						
							<fieldset class="mb-3">

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Purchase Order Number </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="1537 Pilih Ulang Purchase Order & Jenis Material">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Vendor Code </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="TH.NT01A0370">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Vendor Name</label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="Aztech Pandu Persada PT">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Delivery Date</label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="27-01-2019">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-2">Goods Receipt Number </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="(Auto Number after Posting SAP)">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Outlet </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="WMSIASST - Alam Sutra">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Storage Location </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="WMSIASST - MSI Alam Sutra">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Status </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="Not Approved">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Material Group </label>
									<div class="col-lg-10">
										<input type="text" class="form-control" readonly value="All">
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-form-label col-lg-2">Posting Date </label>
									<div class="col-lg-10">
										<input class="form-control" type="date" name="date">
									</div>
								</div>
							</fieldset>

							<div class="text-right">
								<button class="btn btn-success" onclick="save()">Save <i class="icon-paperplane ml-2"></i></button>
								<button class="btn btn-primary" onclick="approve()">Approve <i class="icon-pencil5 ml-2"></i></button>
							</div>
						
					</div>
				</div>
				<!-- /form inputs -->
				
				<!-- Basic datatable -->
				<div class="card">

					<table class="table datatable-basic">
						<thead>
							<tr>
								<th>Material No</th>
								<th>Material Desc</th>
								<th>Outstanding QTY</th>
								<th>GR QTY</th>
								<th>Uom</th>
								<th>QC</th>
								<th>Outstanding Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>FFR0005</td>
								<td>Kiwi</td>
								<td>5.00</td>
								<td><input type="text" class="form-control" value="5.00"></td>
								<td>1kg</td>
								<td><input type="text" class="form-control"></td>
								<td>0.00</td>
							</tr>
							<tr>
								<td>FFR0002</td>
								<td>Strawberry Grade B</td>
								<td>5.00</td>
								<td><input type="text" class="form-control" value="5.00"></td>
								<td>1kg</td>
								<td><input type="text" class="form-control"></td>
								<td>0.00</td>
							</tr>
							<tr>
								<td>FVG0075</td>
								<td>Sawi Putih</td>
								<td>10.00</td>
								<td><input type="text" class="form-control" value="10.00"></td>
								<td>1kg</td>
								<td><input type="text" class="form-control"></td>
								<td>0.00</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- /basic datatable -->

			</div>
			<!-- /content area -->
			
			<script>
			function save (){
				swal("Data telah tersimpan!", "Klik untuk kembali ke dashboard!", "success");
			}
			function approve (){
				swal("Data telah diapprove!", "Klik untuk kembali ke dashboard!", "success");
			}
			</script>