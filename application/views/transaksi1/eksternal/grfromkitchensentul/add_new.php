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
					<!-- <form action="#"> -->

						<div class="card">
							<div class="card-body">
								
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>GR from Central Kitchen Sentul</legend>
											
											<!-- <div class="form-group row">
												<label class="col-lg-3 col-form-label">Data SAP per Tanggal/Jam</label>
												<div class="col-lg-9">Data tidak ditemukan. 
												</div>
											</div> -->
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9"><input type="text" class="form-control" readonly=""></div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer Slip Number</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" name="slipNumberEntry" id="slipNumberEntry" onchange="getDataHeader(this.value)">
														<option value="" selected>None selected</option>
														<?php foreach($do_no as $value):?>
															<option value="<?php echo $value; ?>">
																<?php echo $value; ?>
															</option>
														<?php endforeach;?>
													</select>
													<!-- <a href="#">Pilih ulang Transfer Slip Number dan Jenis Material</a> -->
												</div>
											</div>
											
											<div id='form1' style="display:none">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Goods Receipt Number</label>
													<div class="col-lg-9"><input type="text" class="form-control" readonly="" value="(Auto Number after Posting to SAP)">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Delivery Date</label>
													<div class="col-lg-9">
														<input type="text" id="DeliveryDate" class="form-control" readonly="" value="04-12-2019">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Outlet From</label>
													<div class="col-lg-9">
														<input type="text" id="OutletFrom" class="form-control" readonly="" value="WDFGBNST - Bintaro">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Store Location</label>
													<div class="col-lg-9">
														<input type="text" id="StoreLocation" class="form-control" readonly="" value="WDFGBNST - Bintaro (T.WDFGBN)">
													</div>
												</div>
												
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Status</label>
													<div class="col-lg-9">
														<input type="text" id="StatusHeader" class="form-control" readonly="" value="Not Approved">
													</div>
												</div>
											
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Material Group</label>
													<div class="col-lg-9">
														
														<select class="form-control form-control-select2" data-live-search="true" name="material_group" id="material_group" onchange="getListData(this.value)">
															
														</select>
													</div>
												</div>
											</div>
											
											<div class='hide' id="form2">
												<div class="form-group row">
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
															
															<button class="btn btn-primary" onclick="btnSave()" id="btnSubmitOnclick">
																Save <i class="icon-pencil5 ml-2"></i>
															</button>

															<button type="submit" class="btn btn-success" onclick="btnSave(2)" id="btnSubmitOnclick2">
																Approve <i class="icon-paperplane ml-2"></i>
															</button>

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
									<table id="tblWhole" class="table table-striped " style="width:100%">
										<thead>
											<tr>
												<th>No</th>
												<th>Material No</th>
												<th>Material Desc</th>
												<th>SR Qty</th>
												<th>TF Qty</th>
												<th>GR Qty</th>
												<th>Uom</th>
												
											</tr>
										</thead>
										
										<tbody id="DetLisItem"></tbody>
                    
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
				
				table = $("#tblWhole").DataTable({
					"ordering":false
				});

			});

			function btnSave(id_approve=''){
				console.log("btnSave")
				document.getElementById("btnSubmitOnclick").disabled = true;
				document.getElementById("btnSubmitOnclick2").disabled = true;
				//document.getElementById('btnSubmitOnclick').value = "Please wait...";
				
				let grHeader = {
					do_no: document.getElementById('slipNumberEntry').value, 
					delivery_date: document.getElementById('DeliveryDate').value,
					plant: 'T.DFRHTM',
					storage_location: document.getElementById('StoreLocation').value,
					posting_date: document.getElementById('postingDate').value,
					id_user_input: 99999,
					item_group_code:  document.getElementById('material_group').value,
					status: id_approve
				}

				table = $('#tblWhole > tbody');

				let grDetail=[];
				let urut = 1;
				let item = 0;
				table.find('tr').each(function(i, el){
					
					let td = $(this).find('td');
					
					const det = {
						id_grpodlv_h_detail: urut,
						item:item,
						material_no: td.eq(1).text(), 
						material_desc: td.eq(2).text(), 
						sr_qty: td.eq(3).text(), 
						tf_qty: td.eq(4).text(), 
						gr_qty: td.eq(5).find('input').val(),
						uom: td.eq(6).text()
					}
					grDetail.push(det);
					urut++;
					item++;
					
				})	

				$.post("<?php echo site_url('transaksi1/grfromkitchensentul/saveDataGR');?>",{
						Header: grHeader,
						Detail: grDetail
					},
					(res)=>{
						console.log(res);
						location.reload(true);
					}
				)
			}	


			function getListData(ItmsGrpNam){

				// console.log(document.getElementById('slipNumberEntry').value)
				// console.log(ItmsGrpNam)
				
				$('#DetLisItem').html('');
				
				let getTable = $("#tblWhole").DataTable();
				
				count = getTable.rows().count() + 1;
				
				if(count > 1) {
					getTable.clear();
				}
				let elementSelect = document.getElementsByClassName(`dt_${count}`);
				// var doNo = $('#srEntry').val();

				$.post("<?php echo site_url('transaksi1/grfromkitchensentul/getDataListHeader');?>",{ItmsGrpNam: ItmsGrpNam, U_DocNum: document.getElementById('slipNumberEntry').value},(data)=>{
					const res = JSON.parse(data);
					//econsole.log(res)
					if(res.hasOwnProperty('data')){

						let i=0;
						for(let key in res.data){ 
							i++;
							var tf_qty = res.data[key].TF_QTY;							

							getTable.row.add({ 
								"0":`${i}`,
								"1":`${res.data[key].Material_Code}`,
								"2":`${res.data[key].Material_Desc}`,
								"3":100,
								"4":`${tf_qty}`,
								"5":`<input type='number' min='1' class='form-control' value="${tf_qty}" /></td>`,
								"6":`${res.data[key].UOM}`,
							}).draw();
						}
					}
					

				})
			}

			function getDataHeader(slipNumber){
				$('#material_group').text('');

				$.post("<?php echo site_url('transaksi1/grfromkitchensentul/getDataslipHeader');?>",{slipNumberHeader: slipNumber},(data)=>{
					
					const value = JSON.parse(data);
					//console.log(value)
					// console.log(value.dataOption)
					if (value){

						$("#form1").css('display', '');
						$("#form2").removeClass('hide');
						$("#form3").removeClass('hide');
						document.getElementById('DeliveryDate').value = value.data[1].DELIV_DATE
						document.getElementById('OutletFrom').value = value.data[1].PLANT + ' - ' + value.data[1].Outlet
						document.getElementById('StoreLocation').value = value.data[1].Filler + ' - ' + value.data[1].WhsName

						let lengthMaterialGroups = value.dataOption;
						
						if(value.hasOwnProperty('dataOption')){

							$('#material_group').append('<option selected>None selected</option>');
							$('#material_group').append('<option value="all">--ALL--</option>');
							for(let key in lengthMaterialGroups){
								$('#material_group').append('<option value="'+lengthMaterialGroups[key]+'">'+lengthMaterialGroups[key]+'</option>');
							}
						}

					}
					
					// const year = value.data.DELIV_DATE.substring(0,4);
					// const bln =  value.data.DELIV_DATE.substring(6,4);
					// const day =  value.data.DELIV_DATE.substring(8,6);
					// const date = day+'-'+bln+'-'+year;

					// $("#doSlipNumber").val(value.data.DOCNUM);
					// $("#delivDate").val(date);

					// // for combobox
					// var objCombo = $('#MatrialGroup option').length;
					// if(objCombo > 0){
					// 	$('#MatrialGroup > option').remove();
					// }
					// var cboMatrialGroup = $('#MatrialGroup');
					// cboMatrialGroup.html('<option value="">-</option><option value="all">All</option>');

					// $.each(value.dataOption,(val, text)=>{
					// 	cboMatrialGroup.append(`<option value="${text}">${text}</option>`)
					// })
					// cboMatrialGroup.change(()=>{
					// 	$("#form2").removeClass('hide');
					// 	$("#form3").removeClass('hide');
					// })
					// var obj = $('#table-manajemen tbody tr').length;

					// if(obj>0){
					// 	var tables = $('#table-manajemen').DataTable();

					// 	tables.destroy();
           			// 	$("#table-manajemen > tbody > tr").remove();
					// }

					// var tbodyTable = $('#table-manajemen tbody');
					// value.dataTable.forEach(function(val){
					// 	const qtyOutstanding = parseInt(val.LFIMG).toFixed(4);
					// 	tbodyTable.append(`<tr>
					// 							<td>${val.no}</td>
					// 							<td>${val.MATNR}</td>
					// 							<td>${val.MAKTX}</td>
					// 							<td>${qtyOutstanding}</td>
					// 							<td><input type="text" class="form-control" name="grOutstanding" id="grOutstanding" required></td>
					// 							<td>${val.VRKME}</td>
					// 							<td><select class="form-control form-control-select2" data-live-search="true">
					// 								<option value="">Select Item</option>
					// 								<option value="1">Variace</option>
					// 								<option value="2">Move</option>
					// 								<option value="3">Lost</option>
					// 							</select></td>
					// 							<td><input type="text" class="form-control" name="variance" id="variance"></td>
					// 						</tr>`);
					// })


					// $("#form1").css('display', '');


					// $('#table-manajemen').DataTable({
                    // 	"ordering":false,  
					// 	"paging": true, 
					// 	"searching":true
					// });

				})
			}
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

			})

        </script>
	</body>
</html>