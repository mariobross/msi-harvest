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
				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success" role="alert">
						<?php echo $this->session->flashdata('success'); ?>
					</div>
				<?php endif; ?>
				<?php if ($this->session->flashdata('failed')): ?>
					<div class="alert alert-danger" role="alert">
						<?php echo $this->session->flashdata('failed'); ?>
					</div>
				<?php endif; ?>
					<form action="" method="POST" id="form_input">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Retur In</legend>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label"><b>Data SAP per Tanggal/Jam</b></label>
												<div class="col-lg-9"><b>Belum ada data</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Retur Out Number</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" name="retOutNumber" id="retOutNumber" onchange="getDataHeader(this.value)">
														<option value="">None selected</option>
														<?php foreach($po_no as $key=>$value):?>
															<option value="<?=$key?>"><?=$value?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>

											<div id='form1' style="display:none">
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Retur In Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readonly=""  name="retInNumber" id="retInNumber">
												</div>
											</div>

											<!-- <div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Code</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Input Vendor Code Number" readonly=""  name="vendorCode" id="vendorCode">
												</div>
											</div>-->
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Retur From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly=""  name="returnFrom" id="returnFrom">
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
											
											<!-- <div class="form-group row">
												<label class="col-lg-3 col-form-label">Goods Receipt Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readonly="" value="" name="grNumber" id="grNumber">
												</div>
											</div> -->
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="hidden" name="toPlant" id="toPlant">
													<input type="text" class="form-control" readonly="" name="outlet" id="outlet">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" name="storageLocation" id="storageLocation">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="hidden" name="status" id="status" value="1" >
													<input type="text" class="form-control" placeholder="" readonly="" value="Not Approved" name="status_string" id="status_string">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" name="MatrialGroup" id="MatrialGroup">
														
													</select>
												</div>
											</div>
											
											</div>

											<div class='hide' id="form2">
											<div class="form-group row" >
											<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9 input-group date">
													<input type="text" class="form-control" id="postingDate">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-lg-12 text-right">
													<div class="text-right">
														<button type="button" class="btn btn-primary" name="save" id="save" onclick="addDatadb()">Save <i class="icon-pencil5 ml-2"></i></button>
														<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)" >Approve <i class="icon-paperplane ml-2" ></i></button>
													</div>
												</div>
											</div>
											</div>
										</fieldset>
									</div>
								</div>	
								
							</div>
						</div>                    
						
						<div class='hide' id="form3">
						<div class="card">
							<div class="card-header">
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
							</div>
							<div class="card-body">
								<table id="tableManajemen" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th style="text-align: left">No</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>Outstanding Qty</th>
											<th>Gr Qty</th>
											<th>Uom</th>
										</tr>
									</thead>
								</table>
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

				const date = new Date();
				const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
				var optSimple = {
					format: 'dd-mm-yyyy',
					todayHighlight: true,
					orientation: 'bottom right',
					autoclose: true
				};
				$('#postingDate').datepicker(optSimple);
				$('#postingDate').datepicker( 'setDate', today );

				$('#delivDate').datepicker(optSimple);
			});
			
			function getDataHeader(roNumber){
				$.post("<?php echo site_url('transaksi1/returnin/getDataRoHeader');?>",{roNumberHeader: roNumber},(data)=>{
					
					const value = JSON.parse(data);

					// console.log(value.data);
					const year = value.data.DELIV_DATE ? value.data.DELIV_DATE.substring(0,4) :'1970';
					const bln =  value.data.DELIV_DATE ? value.data.DELIV_DATE.substring(5,7) : '01';
					const day =  value.data.DELIV_DATE ? value.data.DELIV_DATE.substring(8,10) : '01';
					let date = day+'-'+bln+'-'+year;

					$('#returnFrom').val(value.data.RETURN_FROM+'-'+value.data.RETURN_FROM_NAME);
					$('#outlet').val(value.data.PLANT+'-'+value.data.PLANT_NAME);
					$('#storageLocation').val(value.data.PLANT+'-'+value.data.PLANT_NAME);
					$('#toPlant').val(value.data.ToWhsCode)
					$("#delivDate").val(date);
					const poNo = $("#retOutNumber").val();

					// for combobox
					var objCombo = $('#MatrialGroup option').length;
					if(objCombo > 0){
						$('#MatrialGroup > option').remove();
					}
					var cboMatrialGroup = $('#MatrialGroup');
					cboMatrialGroup.html('<option value="">-</option><option value="all">All</option>');


					$.each(value.dataOption,(val, text)=>{
						$(`<option value="${text.DISPO}">${text.DSNAM}</option>`).appendTo(cboMatrialGroup);
					})

					cboMatrialGroup.change(()=>{
						showMatrialDetailData(cboMatrialGroup.val(),poNo);
						$("#form2").removeClass('hide');
						$("#form3").removeClass('hide');
					})
				})
				$("#form1").css('display', '');
			}

			function showMatrialDetailData(cboMatrialGroup='',poNo){
				const MatrialGroup = cboMatrialGroup;
				
				var obj = $('#tableManajemen tbody tr').length;

				if(obj>0){
					const tables = $('#tableManajemen').DataTable();

					tables.destroy();
					$("#tableManajemen > tbody > tr").remove();
				}

				console.log('test');

				dataTable = $('#tableManajemen').DataTable({
                    "ordering":false,  
					"paging":false,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/returnin/getDetailsReturnIn');?>",
                        "type":"POST",
                        "data":{matrialGroup: MatrialGroup, po_no:poNo}
                    },
                    "columns": [
						{data:"NO"},
						{data:"MATNR"},
						{data:"MAKTX"},
						{data:"LFIMG"},
						{data:"U_grqty_web","className":"dt-center",render:function(data, type, row, meta){
							rr=  `<input type="text" class="form-control gr_qty" id="gr_qty_${row['NO']}" value="${data}">`;
							return rr;
						}},
						{data:"VRKME"}
                    ]
                });
					
			}

			function addDatadb(id_approve = ''){
				if($('.gr_qty').val() ==''){
					alert('Gr Quatity harus di isi');
					return false;
				}

				retOutEntry = $('#retOutNumber').val();
				retFrom 	= $('#returnFrom').val();
				outlet 		= $('#outlet').val();
				sLocation 	= $('#storageLocation').val();
				stts 		= $('#status').val();
				matrialGrp 	= $('#MatrialGroup').val();
				pstDate 	= $('#postingDate').val();
				delvDate 	= $('#delivDate').val();
				to_plant 	= $('#toPlant').val();
				approve		= id_approve;

				table = $('#tableManajemen > tbody');

				let matrialNo =[];
				let matrialDesc =[];
				let outStdQty = [];
				let qty =[];
				let uom =[];
				table.find('tr').each(function(i, el){
					let td = $(this).find('td');
					matrialNo.push(td.eq(1).text()); 
					matrialDesc.push(td.eq(2).text());
					outStdQty.push(parseInt(td.eq(3).text()));
					qty.push(parseInt(td.eq(4).find('input').val()));
					uom.push(td.eq(5).text());	
				})

				$.post("<?php echo site_url('transaksi1/returnin/addData')?>",
					{
						poNo:retOutEntry, returnFrom:retFrom, plant:outlet, storage_location:sLocation, status:stts, item_group_code:matrialGrp, posting_date:pstDate, delivery_date:delvDate, toPlant:to_plant, detMatrialNo: matrialNo, appr: approve, detMatrialDesc: matrialDesc, detOutStdQty: outStdQty, detQty: qty,detUom: uom
					},
					function(res){
						location.reload(true);
					}
				);

			}

            
        
        </script>
	</body>
</html>