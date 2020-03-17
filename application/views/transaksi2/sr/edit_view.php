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
					<input type="hidden" name="status" id="status" value="<?=$stdstock_header['status']?>">
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Edit Store Room Request (SR)</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$stdstock_header['id_stdstock_header']?>" id="id_stdstock_header" nama="id_stdstock_header" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Store Room Reques(SR) Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $stdstock_header['status'] == 2 ? $stdstock_header['pr_no'] :'(Auto Number after Posting to SAP)'?>" id="pr_no" nama="pr_no" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"value="<?= $plant_name?>" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $storage_location_name?>" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $stdstock_header['status_string']?>" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Request To Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $stdstock_header['to_plant']?>" id="rto" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Request Reason</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $stdstock_header['request_reason']?>" id="rr" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $stdstock_header['item_group_code']?>" id="materialGroup" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Delivery Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="deliveDate" value="<?= date("d-m-Y", strtotime($stdstock_header['delivery_date']))?>" <?php if($stdstock_header['status']=='2'):?>readonly=""<?php endif; ?>>
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
                                                    <input type="text" class="form-control" id="createdDate" value="<?= date("d-m-Y", strtotime($stdstock_header['created_date']))?>" <?php if($stdstock_header['status']=='2'):?>readonly=""<?php endif; ?>>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
                                               <button type="button" class="btn btn-primary" name="save" id="save" onclick="<?= ($stdstock_header['status']=='1') ? 'addDatadb()' : 'updateDataDB()'?>"><?= ($stdstock_header['status']=='1') ? 'Save' : 'Change'?> <i class="icon-pencil5 ml-2"></i></button>
											   <?php if($stdstock_header['status']=='2'):?>
													<button type="button" class="btn btn-danger">Delete<i class="icon-trash-alt ml-2"></i></button>
												<?php else :?>
													<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)">Approve<i class="icon-paperplane ml-2"></i></button>
												<?php endif; ?>
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
										<table class="table table-striped" id="tblWhole">
										<?php if($stdstock_header['status']=='1'):?>
											<div class="col-md-12 mb-2">
												<div class="text-left">
													<input type="button" class="btn btn-primary" value="Add" id="addTable" onclick="onAddrow()"> 
													<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
												</div>
											</div>
										<?php endif; ?>
											<thead>
												<tr>
													<th></th>
													<th>No</th>
													<th style="width:25%">Material No</th>
													<th style="width:35%">Material Desc</th>
													<th style="width:10%">Quantity</th>
													<th>UOM</th>
                                                    <!-- <th>On Hand</th> -->
                                                    <!-- <th>Min Stock</th> -->
													<!-- <th>Outstanding Total</th> -->
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
		var table ='';
		$(document).ready(function(){
			let id_stdstock_header = $('#id_stdstock_header').val();
			let stts = $('#status').val();

			table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				"ajax": {
                        "url":"<?php echo site_url('transaksi2/sr/showStdstockDetail');?>",
						"data":{ id: id_stdstock_header, status: stts },
                        "type":"POST"
                    },
				"columns": [
					{"data":"id_stdstock_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" >`;
                            return rr;
                    }},
					{"data":"no", "className":"dt-center"},
					{"data":"material_no", "className":"dt-center"},
					{"data":"material_desc"},
					{"data":"requirement_qty", "className":"dt-center",render:function(data, type, row, meta){
						//rr=  `<input type="text" class="form-control" id="gr_qty_${data}" value="${data}"
						//${row['status']==1 ?'':'readonly'}>`;
						rr=  `<input type="text" class="form-control" id="gr_qty_${data}" value="${data}">`;
						return rr;
					}},
					{"data":"uom", "className":"dt-center"},
					// {"data":"OnHand", "className":"dt-center"},
					
					// {"data":"MinStock", "className":"dt-center"},
					// {"data":"OpenQty", "className":"dt-center"}
				],
				drawCallback: function() {
					$('.form-control-select2').select2();
				}
			});

			$("#deleteRecord").click(function(){
				let deleteidArr=[];
				$("input:checkbox[class=check_delete]:checked").each(function(){
					deleteidArr.push($(this).val());
				})

				// mengecek ckeckbox tercheck atau tidak
				if(deleteidArr.length > 0){
					var confirmDelete = confirm("Do you really want to Delete records?");
					if(confirmDelete == true){
						// console.log(table);
						$("input:checked").each(function(){
							table.row($(this).closest("tr")).remove().draw();;
						});
					}
				}
				
			});

			checkcheckbox = () => {
				let totalChecked = 0;
				$(".check_delete").each(function(){
					if($(this).is(":checked")){
						totalChecked += 1;

						console.log(totalChecked);
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

			$('#deliveDate').datepicker(optSimple);

			
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
				"no":count,
				"material_no":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
								<option value="">Select Item</option>
								${showMatrialDetailData(requestReason, matrialGroup, requestToOutlet, elementSelect)}
							</select>`,
				"material_desc":"",
				"requirement_qty": "",
				"uom":"",
				// "OnHand":"",
				// "MinStock":"",
				// "OpenQty":""
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

		// function setValueTable(id,no){
		// 	const table = document.getElementById("tblWhole").rows[no].cells;
		// 	// console.log(id);
		// 	$.post(
		// 		"<?php echo site_url('transaksi2/sr/getdataDetailMaterialSelect')?>",{ MATNR:id },(res)=>{
		// 			matSelect = JSON.parse(res);
		// 			matSelect.map((val)=>{
		// 				table[2].innerHTML = `<td>${val.MATNR}</td>`;
		// 				table[3].innerHTML = val.MAKTX;
		// 				table[5].innerHTML = val.UNIT
		// 			})
		// 		}
		// 	)
		// }

		function setValueTable(id,no){
			const requestToOutlet = $('#rto').val();
			table = document.getElementById("tblWhole").rows[no].cells;
			$.post(
				"<?php echo site_url('transaksi2/sr/getdataDetailMaterialSelect')?>",{ MATNR:id, RTO:requestToOutlet },(res)=>{
					matSelect = JSON.parse(res);
					// console.log(matSelect['dataOnHand']);
					let onHand = matSelect['dataOnHand'] ? matSelect['dataOnHand'][0].OnHand : 0;
					matSelect['data'].map((val)=>{
						table[2].innerHTML = `<td>${val.MATNR}</td>`;
						table[3].innerHTML = val.MAKTX;
						table[5].innerHTML = val.UNIT;
						//table[6].innerHTML = onHand == '.000000' ? 0 : onHand;
					})
				}
			)
		}

		function updateDataDB(){
			const id_stdstock_header = $('#id_stdstock_header').val();
			const tbodyTable = $("#tblWhole > tbody");
			const id_stdstock_detail=[];
			const detail_qty=[];
			tbodyTable.find('tr').each(function(i,el){
				let td = $(this).find('td');
				id_stdstock_detail.push(td.eq(0).find('input').val());
				detail_qty.push(td.eq(4).find('input').val());
			})

			$.post("<?php echo site_url('transaksi2/sr/chageDataDB')?>", {
				idStdStock_header: id_stdstock_header, idStdStock_detail: id_stdstock_detail, qty: detail_qty
			}, function(res){location.reload(true);});
		}

		function addDatadb(id_approve=''){
			const id_stdstock_header = $('#id_stdstock_header').val();
			const delivDate= $('#deliveDate').val();
			const createDate= $('#createdDate').val();
			const approve = id_approve;
			const tbodyTable = $("#tblWhole > tbody");
			let matrial_no=[];
			let detail_qty=[];
			let matrialDesc =[];
			let qty =[];
			let uom =[];
			tbodyTable.find('tr').each(function(i,el){
				let td = $(this).find('td');
				matrial_no.push(td.eq(2).text().trim());
				matrialDesc.push(td.eq(3).text());
				qty.push(td.eq(4).find('input').val());
				uom.push(td.eq(5).text());
			})

			// let matrial_no = matrial_no_text.concat(matrial_no_select);
			console.log(matrial_no);
			$.post("<?php echo site_url('transaksi2/sr/addDataUpdate')?>", {
				idStdStock_header: id_stdstock_header, appr: approve, dateDeliv: delivDate, dateCreate: createDate, detMatrialNo: matrial_no, detMatrialDesc: matrialDesc, detQty: qty, detUom: uom,
			}, function(res){
				location.reload(true);
				}
			);
		}
		</script>
	</body>
</html>