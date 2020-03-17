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
					<input type="hidden" name="status" id="status" value="<?=$retOut_header['status']?>">
						<div class="card">
                        	<div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Retur Out</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retOut_header['id_gisto_dept_header']?>" id="idreturnOut" name="idreturnOut" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Return No</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $retOut_header['status'] == 2 ? $retOut_header['gisto_dept_no'] :'(Auto Number after Posting to SAP)'?>" id="transfer_slip_number" id="retOutNo" name="retOutNo" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retOut_header['plant']?>" id="plant" name="plant" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retOut_header['storage_location']?>" id="storageLocation" name="storageLocation" readOnly>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Retur Out to Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retOut_header['receiving_plant']?>" id="receiving_plant" name="receiving_plant" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retOut_header['status_string']?>" id="status_string" name="status_string" readOnly>
												</div>
											</div>

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retOut_header['item_group_code']?>" name="MatrialGroup" id="MatrialGroup" readonly>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
													<input type="text" class="form-control"  value="<?=date("d-m-Y", strtotime($retOut_header['posting_date']))?>" id="postingDate" <?= $retOut_header['status'] == 2 ? "readonly" :''?>>
													<?php if($retOut_header['status'] !='2'): ?>
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">
																<i class="icon-calendar"></i>
															</span>
														</div> 
													<?php endif;?>
                                                </div>
											</div>

                                            <div class="text-right">
											<?php if($retOut_header['status'] =='2'): ?>
												<button type="button" class="btn btn-success" id="cancelRecord">Cancel <i class="icon-paperplane ml-2"></i></button>
												<?php endif;?>
												<?php if($retOut_header['status'] !='2'): ?>
												<!-- <button type="button" class="btn btn-primary" name="save" id="save" onclick="addDatadb()">Save<i class="icon-paperplane ml-2"></i></button> --> 
												<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)">Approve SAP<i class="icon-paperplane ml-2"></i></button>
												<?php endif;?>
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
											<thead>
												<tr>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>In Whs Quantity</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Remark</th>
													<th>Cancel</th>
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
			const id_gisto_dept_header = $('#idreturnOut').val();
			const stts = $('#status').val();

			table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				"ajax": {
						"url":"<?php echo site_url('transaksi1/returnout/showReturnInDetail');?>",
						"data":{ id: id_gisto_dept_header, status: stts },
						"type":"POST"
					},
					"columns": [
					{"data":"no", "className":"dt-center"},
					{"data":"material_no", "className":"dt-center"},
					{"data":"material_desc"},
					{"data":"stock", "className":"dt-center"},
					{"data":"gr_quantity", "className":"dt-center", render:function(data, type, row, meta){
						rr= row['status'] == 1 ? `<input type="text" class="form-control" id="gr_qty_${data}" value="${data}">`: `${row['gr_quantity']}`;
						return rr;
					}},
					{"data":"uom", "className":"dt-center"},
					{"data":"reason", "className":"dt-center"},
					{"data":"id_gisto_dept_detail", "className":"dt-center", render:function(data, type, row, meta){
						rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" onclick="checkcheckbox();">`;
						return rr;
					}},
				],
				drawCallback: function() {
					$('.form-control-select2').select2();
				}
			});				

			$("#cancelRecord").click(function(){
				const id_gisto_dept_header = $('#idreturnOut').val();
				let deleteidArr=[];
				$("input:checkbox[class=check_delete]:checked").each(function(){
					deleteidArr.push($(this).val());
					console.log(deleteidArr);
				})


				// mengecek ckeckbox tercheck atau tidak
				if(deleteidArr.length > 0){
					var confirmDelete = confirm("Apa Kamu Yakin Akan Membatalkan Return Out ini?");
					if(confirmDelete == true){
						$.ajax({
							url:"<?php echo site_url('transaksi1/returnout/cancelReturnOut');?>", //masukan url untuk delete
							type: "post",
							data:{deleteArr: deleteidArr, id_gisto_dept_header:id_gisto_dept_header},
							success:function(res) {
								// dataTable.ajax.reload();
								location.reload(true);
							}
						});
					}
				}
			});

			checkcheckbox = () => {
                    
				const lengthcheck = $(".check_delete").length;
				
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
				format: 'yyyy-mm-dd',
				todayHighlight: true,
				orientation: 'bottom right',
				autoclose: true
			};
			$('#postingDate').datepicker(optSimple);
		});

		function addDatadb(id_approve=''){
			const approve = id_approve;
			const postDate= document.getElementById('postingDate').value;
			const idreto  = document.getElementById('idreturnOut').value;

			// const status= document.getElementById('status').value;
			// const reqtOutlet = document.getElementById('receiving_plant').value;
			// const arrOutletVal = reqtOutlet.split(' - ');
			// const requestOutlet = arrOutletVal[0];
			// const requestOutletName= arrOutletVal[1];
			// const MatrialGroup= document.getElementById('MatrialGroup').value;
			// const postDate= document.getElementById('postingDate').value;
			// const approve = id_approve;
			// const tbodyTable = $('#tblWhole > tbody');
			// let matrialNo =[];
			// let matrialDesc =[];
			// let whsQty =[];
			// let qty =[];
			// let uom =[]; 
			// let remark =[];
			// tbodyTable.find('tr').each(function(i, el){
			// 	let td = $(this).find('td');
			// 	matrialNo.push(td.eq(1).text()); 
			// 	matrialDesc.push(td.eq(2).text());
			// 	whsQty.push(td.eq(3).text());
			// 	qty.push(td.eq(4).text());
			// 	uom.push(td.eq(5).text());
			// 	remark.push(td.eq(6).text());
			// })

			$.post("<?php echo site_url('transaksi1/returnout/addDataUpdate')?>", {
				//appr: approve, stts: status, reqOutlet:requestOutlet, reqOutletName:requestOutletName,matGroup: MatrialGroup, stts: status, posting_date: postDate, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, inWhsQty:whsQty, detQty: qty, detUom: uom, detRemark:remark
				idRetOut: idreto, appr: approve, posting_date: postDate
			}, function(res){
				location.reload(true);
			}
			);
		}
		</script>
	</body>
</html>