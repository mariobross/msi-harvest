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
					<input type="hidden" name="status" id="status" value="<?=$grsto_header['status']?>">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Transfer Out Inter Outlet</legend>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$grsto_header['id_grsto_header']?>" id="id_grsto_header" nama="id_grsto_header" readOnly>
												</div>
                                            </div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Store Room Reques(SR) Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$grsto_header['po_no']?>" name="srEntry" id="srEntry" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer Out Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?=$grsto_header['transfer_out_number']?>" name="toNumb" id="toNumb">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer In Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $grsto_header['status'] == 2 ? $grsto_header['transfer_in_number'] :'(Auto Number after Posting to SAP)'?>" id="transfer_slip_number" nama="transfer_slip_number" readOnly>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?=$grsto_header['plant']?>" name="outlet" id="outlet">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?=$grsto_header['storage_location']?>" name="storageLocation" id="storageLocation">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Transfer To Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?=$grsto_header['to_plant']?>" name="rto" id="rto">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Delivery Date</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?=date("d-m-Y", strtotime($grsto_header['delivery_date']))?>" id="deliveryDate"> 
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?=$grsto_header['status_string']?>">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$grsto_header['item_group_code']?>" name="MatrialGroup" id="MatrialGroup" readonly>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9 input-group date">
													<input type="text" class="form-control"  value="<?=date("d-m-Y", strtotime($grsto_header['posting_date']))?>" id="postingDate" <?= $grsto_header['status'] == 2 ? "readonly" :''?>>
													<?php if($grsto_header['status'] !='2'): ?>
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">
																<i class="icon-calendar"></i>
															</span>
														</div> 
													<?php endif;?>
												</div>
											</div>
											
											<!-- <div class="form-group row">
												<div class="col-lg-12 text-right">
													<div class="text-right">
														<button type="submit" class="btn btn-success">Cancel <i class="icon-paperplane ml-2"></i></button>
													</div>
												</div>
											</div> -->

											<?php if($grsto_header['status']=='2'): ?>

												<div class="form-group row">
													<div class="col-lg-12 text-right">
														<div class="text-right">
															<button type="button" class="btn btn-success" id="cancelRecord">Cancel <i class="icon-paperplane ml-2"></i></button>
														</div>
													</div>
												</div>
												<?php else :?>
												<div class="form-group row">
													<div class="col-lg-12 text-right">
														<div class="text-right">
															<button type="button" class="btn btn-primary" id="btn-update" onclick="addDatadb()">Save <i class="icon-pencil5 ml-2"></i></button>
															<button type="button" class="btn btn-success" id="btn-update" onclick="addDatadb(2)">Approve <i class="icon-paperplane ml-2"></i></button>
														</div>
													</div>
												</div>
											<?php endif;?>
											
										</fieldset>
									</div>
								</div>	
							</div>
						</div>                    
						
						<div class="card">
							<div class="card-header">
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Transfer Out Inter Outlet</legend>
							</div>
							<div class="card-body">
								<table id="table-manajemen" class="table table-striped " style="width:100%">
								<!-- <!?php if($grsto_header['status']!='2'):?>
									<div class="col-md-12 mb-2">
										<div class="text-left">
											<input type="button" class="btn btn-primary" value="Add" id="addTable" onclick="onAddrow()"> 
											<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
										</div>
									</div>
								<!?php endif; ?> -->
									<thead>
										<tr>
											<th>*</th>
											<th>No</th>
											<th>Material No</th>
											<th>Material Desc</th>
											<th>SR Quantity</th>
											<th>TF Qty</th>
											<th>GR Quantity</th>
											<th>Uom</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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
                let id_grsto_header = $('#id_grsto_header').val();
				let stts = $('#status').val();

				const date = new Date();
				const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
				var optSimple = {
					format: 'yyyy-mm-dd',
					todayHighlight: true,
					orientation: 'bottom right',
					autoclose: true
				};
				$('#postingDate').datepicker(optSimple);

				table = $("#table-manajemen").DataTable({
					"ordering":false,
					"paging":false,
					"ajax": {
							"url":"<?php echo site_url('transaksi1/transferininteroutlet/showGistonewOutDetail');?>",
							"data":{ id: id_grsto_header, status: stts },
							"type":"POST"
						},
					"columns": [
						
						{"data":"id_gistonew_out_detail", "className":"dt-center", render:function(data, type, row, meta){
								rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" >`;
								return rr;
						}},
						{"data":"no", "className":"dt-center"},
						{"data":"material_no", "className":"dt-center"},
						{"data":"material_desc"},
						{"data":"in_whs_qty", "className":"dt-center"},
						{"data":"outstanding_qty", "className":"dt-center"},
						{"data":"gr_quantity", "className":"dt-center",render:function(data, type, row, meta){
							// console.log(row);
							rr=  `<input type="text" class="form-control gr_qty" id="gr_qty_${data}" value="${data}" ${row['status']==1 ?'':'readonly'}>`;
							return rr;
						}},
						{"data":"uom"}
					],
					drawCallback: function() {
						$('.form-control-select2').select2();
					}
				});


				$("#cancelRecord").click(function(){
					const id_grsto_header = $('#id_grsto_header').val();
                    let deleteidArr=[];
                    $("input:checkbox[class=check_delete]:checked").each(function(){
                        deleteidArr.push($(this).val());
						console.log(deleteidArr);
                    })


                    // mengecek ckeckbox tercheck atau tidak
                    if(deleteidArr.length > 0){
                        var confirmDelete = confirm("Apa Kamu Yakin Akan Membatalkan Transfer In Inter Outlet ini?");
                        if(confirmDelete == true){
                            $.ajax({
                                url:"<?php echo site_url('transaksi1/transferininteroutlet/cancelGistonewOut');?>", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr, id_grsto_header:id_grsto_header},
                                success:function(res) {
                                    // dataTable.ajax.reload();
									location.reload(true);
                                }
                            });
                        }
                    }
				});
				
				$("#deleteRecord").click(function(){
					let deleteidArr=[];
					let getTable = $("#table-manajemen").DataTable();
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

			});
			
			function onAddrow(){
				let getTable = $("#table-manajemen").DataTable();
				count = getTable.rows().count() + 1;
				let elementSelect = document.getElementsByClassName(`dt_${count}`);
				var doNo = $('#srEntry').val();
				const matrialGroup = $('#MatrialGroup').val() ? $('#MatrialGroup').val() : 'all';
				// console.log(matrialGroup,'-----',doNo);
				
				getTable.row.add({
					"no":count,
					"material_no":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
									<option value="">Select Item</option>
									${showMatrialDetailData(matrialGroup, doNo, elementSelect)}
								</select>`,
					"material_desc":"",
					"in_whs_qty":"",
					"outstanding_qty":"",
					"gr_quantity":"",
					"uom_req":"",
					"uom":""
					}).draw();
					count++;

				tbody = $("#table-manajemen tbody");
				tbody.on('change','.testSelect', function(){
					tr = $(this).closest('tr');
					no = tr[0].rowIndex;
					id = $('.dt_'+no).val();
					setValueTable(doNo,id,no);
				});
			}

			function showMatrialDetailData(cboMatrialGroup='',do_no='', selectTable){
				
				const select = selectTable ? selectTable : $('#matrialGroupDetail');

				// var countCombo = $('#matrialGroupDetail option').length;
				// // console.log($('#matrialGroupDetail > option').remove());
				// if(countCombo > 0){
				// 	$('#matrialGroupDetail > option').remove();
				// }

				// select.html('<option value="">Select Item</option>');


				$.post("<?php echo site_url('transaksi1/transferininteroutlet/getDetailsTransferOut');?>",{ cboMatrialGroup: cboMatrialGroup,doNo: do_no},(data)=>{
					obj = JSON.parse(data);
					console.log(obj);
					for(let key in obj){
						if(obj.hasOwnProperty(key)){
							$("<option />",{value:obj[key].MATNR, text:obj[key].MATNR +' - '+ obj[key].MAKTX}).appendTo(select);
						}
					}
				})		
			}

			function setValueTable(doNo='',id,no){
				doNo = doNo ? doNo : $('#srEntry').val();
				// console.log(doNo);
				table = document.getElementById("table-manajemen").rows[no].cells;
				$.post(
					"<?php echo site_url('transaksi1/transferininteroutlet/getdataDetailMaterialSelect')?>",{ MATNR:id, do_no:doNo },(res)=>{
						matSelect = JSON.parse(res);

						for(let i in matSelect){
							if(matSelect.hasOwnProperty(i)){
								table[2].innerHTML = `<td>${matSelect[i].MATNR}</td>`;
								table[3].innerHTML = matSelect[i].MAKTX;
								table[4].innerHTML = matSelect[i].In_Whs_Qty;
								table[5].innerHTML = matSelect[i].LFIMG;
								table[7].innerHTML = matSelect[i].VRKME
								table[8].innerHTML = matSelect[i].VRKME
							}
						}
					}
				)
			}

			function addDatadb(id_approve=''){
				if($('.gr_qty').val() ==''){
					alert('Gr Quatity harus di isi');
					return false;
				}
				const id_grsto_header = $('#id_grsto_header').val();
				const srEntry = $('#srEntry').val();
				const approve = id_approve;
				// const delivDate= $('#deliveDate').val();
				// const createDate= $('#createdDate').val();
				const postingDate= document.getElementById('postingDate').value;
				const tbodyTable = $("#table-manajemen > tbody");
				let matrial_no=[];
				let matrialDesc =[];
				let srQty=[];
				let tfQty =[];
				let grQty =[];
				let uom =[];
				let validasi = true;
				tbodyTable.find('tr').each(function(i,el){
					let td = $(this).find('td');
					if(parseInt(td.eq(6).find('input').val(),10) > parseInt(td.eq(5).text(),10)){
							validasi = false;
					}
					matrial_no.push(td.eq(2).text().trim());
					matrialDesc.push(td.eq(3).text());
					srQty.push(td.eq(4).text());
					tfQty.push(td.eq(5).text());
					grQty.push(td.eq(6).find('input').val());
					uom.push(td.eq(7).text());
				})
				if(!validasi){
					alert('Quatity Tidak boleh lebih besar dari Quantity Gudang');
					return false;
				}
				
				$.post("<?php echo site_url('transaksi1/transferininteroutlet/addDataUpdate')?>", {
					idgrsto_header: id_grsto_header, poNo: srEntry, appr:approve, pstDate: postingDate, detMatrialNo: matrial_no, detMatrialDesc: matrialDesc, detSrQty:srQty, detTftQty:tfQty, detGrQty: grQty, detUom: uom
				}, function(res){
					location.reload(true);
					}
				);
			}
        
        </script>
	</body>
</html>