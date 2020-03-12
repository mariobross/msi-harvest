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
												<label class="col-lg-3 col-form-label">ID Transaksi Test</label>
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
													<input type="text" class="form-control" value="<?= $plant ?>" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $storage_location ?>" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="Not Approved" readOnly>
												</div>
											</div>

											<!-- <div class="form-group row">
												<label class="col-lg-3 col-form-label">Request Reason</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="rr" name="rr">
														<option value="">Select Item</option>
														<?php foreach($request_reasons as $key=>$val):?>
															<option value="<?=$val?>"><?=$val?></option>
														<?php endforeach;?>
													</select>
												</div>
                                            </div> -->

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
                                                    <input type="text" class="form-control" id="deliveDate" readonly="">
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
                                                    <input type="text" class="form-control" id="createdDate" readonly="">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" name="save" id="save" onclick="addDatadb()">Save <i class="icon-pencil5 ml-2"></i></button>
												<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)">Approve SAP<i class="icon-paperplane ml-2"></i></button>
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
														<!-- <th>Min Stock</th> -->
														<!-- <th>Outstanding Total</th> -->
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
														<td><input type="text" class="form-control  qty" name="qty[]" id="qty" style="width:100%" autocomplete="off"></td>
														<td></td>
														<td></td>
														<!-- <td></td> -->
														<!-- <td></td> -->
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
				"paging":false,
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
			$('#createdDate').datepicker();

			$('#deliveDate').datepicker(optSimple);
			$('#deliveDate').datepicker();
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
				"4":`<input type="text" class="form-control qty" id="gr_qty_${count}" value="" style="width:100%" autocomplete="off">`,
				"5":"",
				"6":"",
				// "7":"",
				// "8":""
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
			const requestToOutlet = $('#rto').val();
			table = document.getElementById("tblWhole").rows[no].cells;
			$.post(
				"<?php echo site_url('transaksi2/sr/getdataDetailMaterialSelect')?>",{ MATNR:id, RTO:requestToOutlet },(res)=>{
					matSelect = JSON.parse(res);
					// console.log(matSelect['dataOnHand']);
					let onHand = matSelect['dataOnHand'] ? matSelect['dataOnHand'][0].OnHand : 0;
					matSelect['data'].map((val)=>{
						table[3].innerHTML = val.MAKTX;
						table[5].innerHTML = val.UNIT;
						table[6].innerHTML = onHand == '.000000' ? 0 : onHand;
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

		// function getAddMaterial(count){
		// 	let dataMaterialLocal = JSON.parse(localStorage.getItem('tmpDataMaterial'));
		// 	const select = $('#selectDetailMatrial');
		// 	// let getTable = $("#tblWhole").DataTable();
		// 	// let count = getTable.rows().count() + 1;
		// 	// let select = $('.dt_'+count);
		// 	console.log(select);
		// 	dataMaterialLocal.forEach((val)=>{
		// 		// console.log(val.MATNR);
		// 		// $("<option />", {value:val.MATNR, text:val.MAKTX +' - '+ val.MATNR+' - '+val.UNIT	}).appendTo(select);
		// 		select.append(`<option>test</option>`);
		// 	})

		// }

		function showMatrialDetailData(requestReason='', matrialGroup='', requestToOutlet='', select){
			console.log(select);
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
					localStorage.setItem('tmpDataMaterial', JSON.stringify(optData));
					
					optData.forEach((val)=>{						
						$("<option />", {value:val.MATNR, text:val.MAKTX +' - '+ val.MATNR+' - '+val.UNIT	}).appendTo(select);
					})
				}
			});			
		}

		function addDatadb(id_approve=''){
			if($('.qty').val() ==''){
				alert('Quantity harus di isi');
				return false;
			}
			
			const matrialGroup= document.getElementById('materialGroup').value;
			const requestToOutlet= document.getElementById('rto').value;
			const delivDate= document.getElementById('deliveDate').value;
			const createDate= document.getElementById('createdDate').value;
			const approve = id_approve;
			const tbodyTable = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let uom =[];
			let validateQty = true;
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					if(td.eq(4).find('input').val() == '' || td.eq(4).find('input').val() == null){
						validateQty = false
					}
					matrialNo.push(td.eq(2).find('select').val()); 
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
					uom.push(td.eq(5).text());
				})
			if(!validateQty){
				alert('Quantity harus di isi');
				return false;
			}


			$.post("<?php echo site_url('transaksi2/sr/addData')?>", {
				 matGrp: matrialGroup, reqToOutlet: requestToOutlet, appr: approve, dateDeliv: delivDate, dateCreate: createDate, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, detQty: qty, detUom: uom,
			}, function(res){location.reload(true);});
		}
	
	</script>
	</body>
</html>