<!DOCTYPE html>
<html lang="en">
	<head>
		<?php  $this->load->view("_template/head.php")?>
		<style>
		.hide{
			display: none;
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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Inventory Audit</legend>
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
															<option value="<?=$val['WhsCode']?>"><?=$val['WhsName'].'-'.$val['WhsCode']?></option>
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
												<button type="button" class="btn btn-primary" onclick="onSearch()">Search<i class="icon-search4  ml-2"></i></button>
											</div>
										</fieldset>
                                    </div>
								</div>	
								<br>
                            </form>
                        </div>
                    </div>  
					<div class="card hide">
						<div class="card-header">
                            <legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List of Onhand Report</legend>
                            <button onclick="printExcel()" class="btn btn-success"> Download To Excel</button>
                            
                        </div>
						<div class="card-body" >
							<div class="row">
								<div class="col-md-12" style="overflow: auto">
								<fieldset>
									<table class="table table-striped" id="tblReportInventory">
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
			const date = new Date();
			const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			var optSimple = {
				format: 'yyyy-mm-dd',
				todayHighlight: true,
				orientation: 'bottom right',
				autoclose: true
			};

			$('#fromDate').datepicker(optSimple);
			$('#toDate').datepicker(optSimple);

			// const table = document.getElementById("tblReportInventory");
			// const search = document.getElementById("btnSearch");
			// search.addEventListener('click', function () {
			// 	table.style.display = "block";
			// });
		});

		function onSearch(){
			$(".card").removeClass('hide');
			
			const fromDate = $('#fromDate').val();
			const toDate = $('#toDate').val();
			const warehouse = $('#warehouse').val();
			const itemGroup = $('#itemGroup').val();

			console.log(warehouse);

			showDataList(itemGroup, fromDate, toDate, warehouse);
		}

		function showDataList(itemGroup, fromDate, toDate, warehouse){
			const obj = $('#tblReportInventory tbody tr').length;

			if(obj > 0){
				const dataTable = $('#tblReportInventory').DataTable();
				dataTable.destroy();
				$('#tblReportInventory > tbody > tr').remove();
				
			}         

			dataTable = $('#tblReportInventory').DataTable({
				"ordering":false,  "paging": true, "searching":true,
				"ajax": {
					"url":"<?php echo site_url('report/inventory/showAllData');?>",
					"type":"POST",
					"data":{item_Group: itemGroup, fromDate:fromDate, toDate:toDate, whs:warehouse}
				},
				"columns": [
					{"data":"no", "className":"dt-center"},
					{"data":"itemcode", "className":"dt-center"},
					{"data":"ItemName", "className":"dt-center"},
					{"data":"InvntryUom", "className":"dt-center"},
					{"data":"stock_awal", "className":"dt-center"},
					{"data":"qty_ck", "className":"dt-center"},
					{"data":"qty_po", "className":"dt-center"},
					{"data":"qty_fo", "className":"dt-center"},
					{"data":"qty_produc", "className":"dt-center"},
					{"data":"qty_wc", "className":"dt-center"},
					{"data":"qty_nonpo", "className":"dt-center"},
					{"data":"qty_retin", "className":"dt-center"},
					{"data":"total_in", "className":"dt-center"},
					{"data":"qty_sales", "className":"dt-center"},
					{"data":"qty_to", "className":"dt-center"},
					{"data":"qty_produc_out", "className":"dt-center"},
					{"data":"qty_wc_out", "className":"dt-center"},
					{"data":"qty_waste", "className":"dt-center"},
					{"data":"qty_ro", "className":"dt-center"},
					{"data":"total_out", "className":"dt-center"},
					{"data":"subtotal", "className":"dt-center"}
				]
			});
		}
		</script>
	</body>
</html>