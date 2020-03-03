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
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Good Receipt PO from Vendor</legend>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label"><b>Data SAP per Tanggal/Jam</b></label>
												<div class="col-lg-9"><b>Belum ada data</b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Order Entry</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" name="poOrderEntry" id="poOrderEntry" onchange="getDataHeader(this.value)">
														<option value="">None selected</option>
														<?php foreach($po_no as $key=>$value):?>
															<option value="<?=$key?>"><?=$value?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>

											<div id='form1' style="display:none">
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Order Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Input Purchase Order Number" readonly=""  name="poOrderNumber" id="poOrderNumber">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Code</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Input Vendor Code Number" readonly=""  name="vendorCode" id="vendorCode">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Name</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Input Vendor Name" readonly=""  name="nameVendor" id="nameVendor">
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
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Goods Receipt Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readonly="" value="" name="grNumber" id="grNumber">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="<?= $plant ?>" name="outlet" id="outlet">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readonly="" value="<?= $storage_location ?>" name="storageLocation" id="storageLocation">
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
														<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)" >Approve <i class="icon-paperplane ml-2" ></input></i>
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
								<table id="table-manajemen" class="table table-striped " style="width:100%">
									<thead>
										<tr>
											<th style="text-align: left">*</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>Outstanding Qty</th>
											<th>Gr Qty</th>
											<th>Uom</th>
											<th>Remark</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
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
			
			function getDataHeader(poNumber){
				$.post("<?php echo site_url('transaksi1/pofromvendor/getDataPoHeader');?>",{poNumberHeader: poNumber},(data)=>{
					
					const value = JSON.parse(data);

					// console.log(value.data);
					const year = value.data.DELIV_DATE.substring(0,4);
					const bln =  value.data.DELIV_DATE.substring(6,4);
					const day =  value.data.DELIV_DATE.substring(8,6);
					const date = day+'-'+bln+'-'+year;

					
					
					$("#poOrderNumber").val(value.data.DOCNUM);
					$('#vendorCode').val(value.data.VENDOR);
					$('#nameVendor').val(value.data.VENDOR_NAME);
					$("#delivDate").val(date);

					// for combobox
					var objCombo = $('#MatrialGroup option').length;
					if(objCombo > 0){
						$('#MatrialGroup > option').remove();
					}
					var cboMatrialGroup = $('#MatrialGroup');
					cboMatrialGroup.html('<option value="">-</option><option value="all">All</option>');

					$.each(value.dataOption,(val, text)=>{
						cboMatrialGroup.append(`<option value="${text}">${text}</option>`)
					})
					cboMatrialGroup.change(()=>{
						$("#form2").removeClass('hide');
						$("#form3").removeClass('hide');
					})
					var obj = $('#table-manajemen tbody tr').length;

					if(obj>0){
						var tables = $('#table-manajemen').DataTable();

						tables.destroy();
           				$("#table-manajemen > tbody > tr").remove();
					}

					var tbodyTable = $('#table-manajemen tbody');
					value.dataTable.forEach(function(val){
						const qtyOutstanding = parseInt(val.BSTMG).toFixed(4);
						tbodyTable.append(`<tr>
												<td>${val.no}</td>
												<td>${val.MATNR}</td>
												<td>${val.MAKTX}</td>
												<td>${qtyOutstanding}</td>
												<td><input type="text" class="form-control" name="grOutstanding" id="grOutstanding" required></td>
												<td>${val.BSTME}</td>
												<td><input type="text" class="form-control" name="qc_${val.no}" id="qc_${val.no}"></td>
											</tr>`);
					})


					$("#form1").css('display', '');


					$('#table-manajemen').DataTable({
                    "ordering":false, "paging":false
					});

				})
			}

			function addDatadb(id_approve = ''){
				if($('#grOutstanding').val() ==''){
					alert('Gr Quatity harus di isi');
					return false;
				}

				poEntry 	= $('#poOrderEntry').val();
				poNumber 	= $('#poOrderNumber').val();
				kdVendor 	= $('#vendorCode').val();
				nmVendor 	= $('#nameVendor').val();
				grNumber 	= $('#grNumber').val();
				outlet 		= $('#outlet').val();
				sLocation 	= $('#storageLocation').val();
				stts 		= $('#status').val();
				matrialGrp 	= $('#MatrialGroup').val();
				pstDate 	= $('#postingDate').val();
				delvDate 	= $('#delivDate').val();
				approve		= id_approve;

				splitDate = pstDate.split('-');
				dayPostingDate = splitDate[0];
				monthPostingDate = splitDate[1];
				yearPostingDate = splitDate[2];
				posDate= `${yearPostingDate}/${monthPostingDate}/${dayPostingDate}`;

				splitdelvDate = delvDate.split('-');
				dayDeliveryDate = splitdelvDate[0];
				monthDeliveryDate = splitdelvDate[1];
				yearDeliveryDate = splitdelvDate[2];
				delDate= `${yearDeliveryDate}/${monthDeliveryDate}/${dayDeliveryDate}`;

				postingDate = new Date(posDate);
				deliverDate = new Date(delDate);
				if(postingDate > deliverDate){
					alert('Tanggal Posting tidak boleh lebih besar dari Tanggal Delivery');
					return false;
				}
				

				table = $('#table-manajemen > tbody');

				let grQty=[];
				let remark=[];
				let validasiRemark = true;
				let validasiQty = true;
				table.find('tr').each(function(i, el){
					let td = $(this).find('td');
					if(td.eq(6).find('input').val() == ''){
						validasiRemark = false;
					}
					if(parseInt(td.eq(4).find('input').val(),10) > parseInt(td.eq(3).text(),10)){
							validasiQty = false;
						}
					grQty.push(td.eq(4).find('input').val());
					remark.push(td.eq(6).find('input').val());	
				})
				if(!validasiRemark){
					alert('Remark Tidak boleh Kosong, Harap di isi');
					return false;
				}
				if(!validasiQty){
					alert('Gr Quantity Tidak boleh lebih besar dari Outstanding quantity');
					return false;
				}

				$.post("<?php echo site_url('transaksi1/pofromvendor/addData')?>",
					{
						poNo:poEntry, docnum:poNumber, kd_vendor:kdVendor, nm_vendor:nmVendor, grpo_no:grNumber, plant:outlet, storage_location:sLocation, status:stts, item_group_code:matrialGrp, posting_date:pstDate, delivery_date:delvDate, detail_grQty: grQty,  remark: remark, app: approve
					},
					function(res){
						location.reload(true);
					}
				);

			}
        
        </script>
	</body>
</html>