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
					<input type="hidden" name="status" id="status" value="<?=$grnonpo_header['status']?>">
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Goods Receipt Non PO</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$grnonpo_header['id_grnonpo_header']?>" id="idgrnonpo" name="idgrnonpo" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Goods Receipt No.</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $grnonpo_header['status'] == 2 ? $grnonpo_header['grnonpo_no'] :'(Auto Number after Posting to SAP)'?>" id="grNo" nama="grNo" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Plant</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$grnonpo_header['plant']?>" id="plant" name="plant" readOnly>
												
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$grnonpo_header['storage_location']?>" id="storage_location" name="storage_location" readOnly>
												
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Cost Center</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$grnonpo_header['cost_center']?>" id="cost_center" name="cost_center" readOnly>
												</div>
											</div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$grnonpo_header['status_string']?>" id="status_string" name="status_string" readOnly>
												</div>
											</div>

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
												<input type="text" class="form-control" value="<?=$grnonpo_header['item_group_code']?>" name="MatrialGroup" id="MatrialGroup" readonly>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
													<input type="text" class="form-control"  value="<?=date("d-m-Y", strtotime($grnonpo_header['posting_date']))?>" id="postingDate" <?= $grnonpo_header['status'] == 2 ? "readonly" :''?>>
													<?php if($grnonpo_header['status'] !='2'): ?>
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">
																<i class="icon-calendar"></i>
															</span>
														</div> 
													<?php endif;?>
												</div>
											</div>

											<?php if($grnonpo_header['status']=='2'): ?>

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
                        <div class="card-body">
                            
								<div class="row">
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
									<div class="col-md-12" style="overflow: auto">
										<table class="table table-striped" id="tblWhole">
										<?php if($grnonpo_header['status']!='2'):?>
											<div class="col-md-12 mb-2">
												<div class="text-left">
													<input type="button" class="btn btn-primary" value="Add" id="addTable" onclick="onAddrow()"> 
													<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
												</div>
											</div>
										<?php endif; ?>
											<thead>
												<tr>
													<th>*</th>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Text</th>
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
            $(document).ready(function(){
                let id_grnonpo_header = $('#idgrnonpo').val();
				let stts = $('#status').val();

				const date = new Date();
				const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
				var optSimple = {
					format: 'dd-mm-yyyy',
					todayHighlight: true,
					orientation: 'bottom right',
					autoclose: true
				};
				$('#postingDate').datepicker(optSimple);

				table = $("#tblWhole").DataTable({
					"ordering":false,
					"paging":false,
					"ajax": {
							"url":"<?php echo site_url('transaksi1/grnopo/showGistonewOutDetail');?>",
							"data":{ id: id_grnonpo_header, status: stts },
							"type":"POST"
						},
					"columns": [
						
						{"data":"id_grnonpo_detail", "className":"dt-center", render:function(data, type, row, meta){
								rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" >`;
								return rr;
						}},
						{"data":"no", "className":"dt-center"},
						{"data":"material_no", "className":"dt-center"},
						{"data":"material_desc"},
						{"data":"gr_quantity", "className":"dt-center",render:function(data, type, row, meta){
							rr=  (row["status"] == 2) ? data : `<input type="text" class="form-control" id="gr_qty_${row['no']}" value="${data}">`;
							return rr;
						}},
						{"data":"uom"},
						{"data":"text", "className":"dt-center",render:function(data, type, row, meta){
							// console.log(row);
							rr= (row["status"] == 2) ? data : `<input type="text" class="form-control" id="text_${row['no']}" value="">`;
							return rr;
						}}
					],
					drawCallback: function() {
						$('.form-control-select2').select2();
					}
				});


				$("#cancelRecord").click(function(){
					const id_grnonpo_header = $('#idgrnonpo').val();
                    let deleteidArr=[];
                    $("input:checkbox[class=check_delete]:checked").each(function(){
                        deleteidArr.push($(this).val());
						console.log(deleteidArr);
                    })


                    // mengecek ckeckbox tercheck atau tidak
                    if(deleteidArr.length > 0){
                        var confirmDelete = confirm("Apa Kamu Yakin Akan Membatalkan Goods Receipt Non PO ini?");
                        if(confirmDelete == true){
                            $.ajax({
                                url:"<?php echo site_url('transaksi1/grnopo/cancelGrNonPo');?>", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr, id_grnonpo_header:id_grnonpo_header},
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

			});
			
			function onAddrow(){
				let getTable = $("#tblWhole").DataTable();
				count = getTable.rows().count() + 1;
				let elementSelect = document.getElementsByClassName(`dt_${count}`);
				var doNo = $('#idgrnonpo').val();
				const matrialGroup = $('#MatrialGroup').val() ? $('#MatrialGroup').val() : 'all';
				
				getTable.row.add({
					"no":count,
					"material_no":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
									<option value="">Select Item</option>
									${showMatrialDetailData(matrialGroup, doNo, elementSelect)}
								</select>`,
					"material_desc":"",
					"gr_quantity":"",
					"uom":"",
					"text":""
					}).draw();
					count++;

				tbody = $("#tblWhole tbody");
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


				$.post("<?php echo site_url('transaksi1/grnopo/getDetailsTransferOut');?>",{ cboMatrialGroup: cboMatrialGroup},(data)=>{
					obj = JSON.parse(data);
					// console.log(data);
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
				table = document.getElementById("tblWhole").rows[no].cells;
				$.post(
					"<?php echo site_url('transaksi1/grnopo/getdataDetailMaterialSelect')?>",{ MATNR:id, do_no:doNo },(res)=>{
						matSelect = JSON.parse(res);

						for(let i in matSelect){
							if(matSelect.hasOwnProperty(i)){
								table[2].innerHTML = `<td>${matSelect[i].MATNR}</td>`;
								table[3].innerHTML = matSelect[i].MAKTX;
								table[5].innerHTML = matSelect[i].UNIT;
							}
						}
					}
				)
			}

			function addDatadb(id_approve=''){
				const id_grnonpo_header = $('#idgrnonpo').val();
				const approve = id_approve;
				const postingDate= $('#postingDate').val();
				const tbodyTable = $("#tblWhole > tbody");
				let matrial_no=[];
				let matrialDesc =[];
				let qty =[];
				let uom =[];
				let text = [];
				tbodyTable.find('tr').each(function(i,el){
					let td = $(this).find('td');
					matrial_no.push(td.eq(2).text().trim());
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
					uom.push(td.eq(5).text());
					text.push(td.eq(6).find('input').val());
				})
				
				$.post("<?php echo site_url('transaksi1/grnopo/addDataUpdate')?>", {
					idgrnonpo_header: id_grnonpo_header, aapr:approve, pstDate: postingDate, detMatrialNo: matrial_no, detMatrialDesc: matrialDesc, detQty: qty, detUom: uom, detText:text
				}, function(res){
					location.reload(true);
					}
				);
			}
        
        </script>
		</script>
	</body>
</html>