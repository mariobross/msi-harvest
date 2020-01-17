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
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="POST">
							<input type="hidden" name="status" id="status" value="<?=$retin_header['status']?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Retur In</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$retin_header['id_retin_header']?>" id="idreturn" name="idreturn" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Return Out Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" id="roNumber"  name="roNumber" value="<?=$retin_header['do_no']?>" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Return In Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" id="riNumber"  name="riNumber" value="<?=$retin_header['transfer_in_number']?>" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Return From</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" id="rf"  name="rf" value="<?=$retin_header['return_from']?>" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet To</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$retin_header['plant']?>" id="plant" name="plant" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control"  value="<?=$retin_header['storage_location']?>" id="storageLocation" name="storageLocation" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retin_header['status_string']?>" id="status_string" name="status_string" readOnly>
												</div>
											</div>

											<!-- <div class="form-group row">
												<label class="col-lg-3 col-form-label">Retur Out to Outlet</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">Select Item</option>
														<option value="1">Pilih 1</option>
														<option value="2">Pilih 2</option>
													</select>
												</div>
											</div> -->

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$retin_header['item_group_code']?>" name="MatrialGroup" id="MatrialGroup" readonly>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
													<input type="text" class="form-control"  value="<?=date("d-m-Y", strtotime($retin_header['posting_date']))?>" id="postingDate" <?= $retin_header['status'] == 2 ? "readonly" :''?>>
													<?php if($retin_header['status'] !='2'): ?>
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">
																<i class="icon-calendar"></i>
															</span>
														</div> 
													<?php endif;?>
												</div>
											</div>

                                            <div class="text-right">
												<button type="button" class="btn btn-success" id="cancelRecord">Cancel <i class="icon-paperplane ml-2"></i></button>
													
												<!-- <button type="submit" class="btn btn-success">Approve SAP<i class="icon-paperplane ml-2"></i></button> -->
                                            </div>

											
                                        </fieldset>
                                    </div>
                                </div>
								<br>
								<div class="row">
									<div class="col-md-12" style="overflow: auto">
										<table class="table table-striped " id="tblWhole" style="width:100%">
											<thead>
												<tr>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Outstanding Qty</th>
													<th>GR Qty</th>
													<th>UOM</th>
													<th>Cancel</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
                            </form>
                        </div>
                    </div>                    
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
        <?php  $this->load->view("_template/js.php")?>
		<script>
		$(document).ready(function(){
                let id_retin_header = $('#idreturn').val();
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

				table = $("#tblWhole").DataTable({
					"ordering":false,
					"ajax": {
							"url":"<?php echo site_url('transaksi1/returnin/showReturnInDetail');?>",
							"data":{ id: id_retin_header, status: stts },
							"type":"POST"
						},
						"columns": [
                        {"data":"no", "className":"dt-center"},
                        {"data":"material_no", "className":"dt-center"},
                        {"data":"material_desc"},
                        {"data":"outstanding_qty", "className":"dt-center"},
                        {"data":"gr_quantity", "className":"dt-center", render:function(data, type, row, meta){
							rr= row['status'] == 1 ? `<input type="text" class="form-control" id="gr_qty_${data}" value="${data}">`: `${row['gr_quantity']}`;
                            return rr;
						}},
                        {"data":"uom", "className":"dt-center"},
						{"data":"id_retin_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" onclick="checkcheckbox();">`;
                            return rr;
                        }},
                    ],
					drawCallback: function() {
						$('.form-control-select2').select2();
					}
				});


				$("#cancelRecord").click(function(){
					const id_retin_header = $('#idreturn').val();
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
                                url:"<?php echo site_url('transaksi1/returnin/cancelReturnIn');?>", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr, id_retin_header:id_retin_header},
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

			checkcheckbox = () => {
                    
				const lengthcheck = $(".check_delete").length;
				
				let totalChecked = 0;
				$(".check_delete").each(function(){
					if($(this).is(":checked")){
						totalChecked += 1;
					}
				});
			}

		</script>
	</body>
</html>