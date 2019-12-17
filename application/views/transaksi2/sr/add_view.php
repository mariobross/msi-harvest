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
		
	<link href="<?php echo base_url('/files/');?>assets/css/components.min.css" rel="stylesheet" type="text/css">	
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
                    <form action="#" method="POST">
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Tambah Store Room Request (SR)</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Store Room Reques(SR) Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="WMSITJST - Tajur" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="WMSITJST - MSI Tajur" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Not Approved" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Request Reason</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="rr" name="rr">
														<option value="">Select Item</option>
														<?php foreach($request_reasons as $key=>$val):?>
															<option value="<?=$val?>"><?=$val?></option>
														<?php endforeach;?>
													</select>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="materialGroup" name="materialGroup">
														<option value="">Select Item</option>
														<option value="all">All</option>
														<?php foreach($matrialGroup as $key=>$val):?>
															<option value="<?=$val['ItmsGrpNam']?>"><?=$val['ItmsGrpNam']?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Request To Outlet</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="rto" name="rto" onchange="showMatrialDetail(this.value)">
														<option value="">Select Item</option>
														<?php foreach($plants as $key=>$val):?>
															<option value="<?=$val['OUTLET']?>"><?=$val['OUTLET_NAME1'].'('.$val['OUTLET'].')'?></option>
														<?php endforeach;?>
													</select>
												</div>
                                            </div>

											
											<div id='form1' style="display:none">
                                            
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Delivery Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="deliveDate">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Created Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="createdDate">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" name="save" id="save" onclick="addDatadb()">Save <i class="icon-pencil5 ml-2"></i></button>
												<button type="submit" class="btn btn-success">Approve SAP<i class="icon-paperplane ml-2"></i></button>
                                            </div>

											
                                        </fieldset>
                                    </div>
                                </div>
								</div>
                                </div>
								<div id='form2' style="display:none">
								<div class="card">
									<div class="card-body">
										
										<div class="row">
										<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
										<div class="col-md-12" style="overflow: auto">
											<table class="table table-striped" id="tblWhole">
											<div class="col-md-12 mb-2">
												<div class="text-left">
													<input type="button" class="btn btn-primary" value="Add" id="addTable" onclick="onAddrow()"> 
													<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
												</div>
											</div>
												<thead>
													<tr>
														<th></th>
														<th>No</th>
														<th>Material No</th>
														<th>Material Desc</th>
														<th>Quantity</th>
														<th>UOM</th>
														<th>On Hand</th>
														<th>Min Stock</th>
														<th>Outstanding Total</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><input type="checkbox" id="record"/></td>
														<td>1</td>
														<td width="35%">
															<select class="form-control form-control-select2" data-live-search="true" id="matrialGroup" onchange="setValueTable(this.value,1)">
																<option value="">Select Item</option>
															</select>
														</td>
														<td width="40%"></td>
														<td><input type="text" class="form-control" name="qty[]" id="qty" style="width:100%"></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</div>
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
		var table ='';
		$(document).ready(function(){
			table = $("#tblWhole").DataTable({
				"ordering":false,
				drawCallback: function() {
					$('.form-control-select2').select2();
				}
			});

			$("#deleteRecord").click(function(){
				let deleteidArr=[];
				let getTable = $("#tblWhole").DataTable();
				$("input:checkbox[class=check_delete]:checked").each(function(){
					deleteidArr.push($(this).val());
				})

				// mengecek ckeckbox tercheck atau tidak
				if(deleteidArr.length > 0){
					var confirmDelete = confirm("Do you really want to Delete records?");
					if(confirmDelete == true){
						// console.log(getTable);
						$("input:checked").each(function(){
							getTable.row($(this).closest("tr")).remove().draw();
						});
					}
				}
				
			});

			checkcheckbox = () => {
				let totalChecked = 0;
				$(".check_delete").each(function(){
					if($(this).is(":checked")){
						totalChecked += 1;
					}
				});
			}

			const date = new Date();
			const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
			var optSimple = {
				format: 'dd-mm-yyyy',
				todayHighlight: true,
				orientation: 'bottom right',
				autoclose: true
			};
			$('#createdDate').datepicker(optSimple);
			$('#createdDate').datepicker( 'setDate', today );

			$('#deliveDate').datepicker(optSimple);
			$('#deliveDate').datepicker( 'setDate', today );
		});

		function onAddrow(){
			let getTable = $("#tblWhole").DataTable();
			count = getTable.rows().count() + 1;
			let elementSelect = document.getElementsByClassName(`dt_${count}`);
			const requestReason = $('#rr').val();
			const matrialGroup = $('#materialGroup').val();
			const requestToOutlet = $('#rto').val();

			
			// console.log(optSelect);
			
			getTable.row.add({
				"0":`<input type="checkbox" class="check_delete" id="chk_${count}" value="${count}">`,
				"1":count,
				"2":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
								<option value="">Select Item</option>
								${showMatrialDetailData(requestReason, matrialGroup, requestToOutlet, elementSelect)}
							</select>`,
				"3":"",
				"4":`<input type="text" class="form-control" id="gr_qty_${count}" value="" style="width:100%">`,
				"5":"",
				"6":"",
				"7":"",
				"8":""
				}).draw();
				count++;

			tbody = $("#tblWhole tbody");
			tbody.on('change','.testSelect', function(){
				tr = $(this).closest('tr');
				no = tr[0].rowIndex;
				id = $('.dt_'+no).val();
				setValueTable(id,no);
			});
		}

		function setValueTable(id,no){
			table = document.getElementById("tblWhole").rows[no].cells;
			$.post(
				"<?php echo site_url('transaksi2/sr/getdataDetailMaterialSelect')?>",{ MATNR:id },(res)=>{
					matSelect = JSON.parse(res);
					matSelect.map((val)=>{
						table[3].innerHTML = val.MAKTX;
						table[5].innerHTML = val.UNIT
					})
				}
			)
		}

		function showMatrialDetail(){
			const requestReason = $('#rr').val();
			const matrialGroup = $('#materialGroup').val();
			const requestToOutlet = $('#rto').val();
			const select = $('#matrialGroup');
			// select.addClass("form-control-select2")
			showMatrialDetailData(requestReason, matrialGroup, requestToOutlet, select);		

			$("#form1").css('display', '');
			$("#form2").css('display', '');
		}

		function showMatrialDetailData(requestReason='', matrialGroup='', requestToOutlet='', select){
			$.ajax({
				url: "<?php echo site_url('transaksi2/sr/getdataDetailMaterial');?>",
				type: "POST",
				data: {
					reqReason: requestReason, 
					matGroup: matrialGroup, 
					reqToOutlet: requestToOutlet
				},
				success:function(res) {
					optData = JSON.parse(res);
					optData.forEach((val)=>{
						// console.log(val.MATNR);
						$("<option />", {value:val.MATNR, text:val.MAKTX +' - '+ val.MATNR+' - '+val.UNIT	}).appendTo(select);
					})
				}
			});			
		}

		function addDatadb(){
			const requestRespon= document.getElementById('rr').value;
			const matrialGroup= document.getElementById('materialGroup').value;
			const requestToOutlet= document.getElementById('rto').value;
			const delivDate= document.getElementById('deliveDate').value;
			const createDate= document.getElementById('createdDate').value;
			const tbodyTable = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let uom =[];
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					// console.log(td.eq(2).find('select').val());	
					matrialNo.push(td.eq(2).find('select').val()); 
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
					uom.push(td.eq(5).text());
				})


			// console.log(requestRespon,'-',matrialGroup,'-',requestToOutlet,'-',delivDate,'-',createDate, matrialNo.join('/'), matrialDesc.join('^'), qty.join('%'), uom.join('*'));
			$.post("<?php echo site_url('transaksi2/sr/addData')?>", {
				reqRes: requestRespon, matGrp: matrialGroup, reqToOutlet: requestToOutlet, dateDeliv: delivDate, dateCreate: createDate, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, detQty: qty, detUom: uom,
			}, function(res){location.reload(true);;});
		}
	
	</script>
	</body>
</html>