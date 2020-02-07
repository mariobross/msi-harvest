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
					<input type="hidden" name="status" id="status" value="<?=$grpo_header['status']?>">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>PO from Vendor</legend>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label"><b>Data SAP per Tanggal/Jam</b></label>
												<div class="col-lg-9"><b></b>
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['id_grpo_header']?>" id="id_grpo_header" nama="id_grpo_header">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Order Entry</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['po_no']?>" id="po_no" nama="po_no">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Order Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['docnum']?>" id="docnum" nama="docnum">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Code</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['kd_vendor']?>" id="kd_vendor" nama="kd_vendor">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Vendor Name</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['nm_vendor']?>" id="nm_vendor" nama="nm_vendor">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Delivery Date</label>
												<div class="col-lg-9 input-group date">
													<input type="text" class="form-control" id="delivDate" value="<?= date("d-m-Y", strtotime($grpo_header['delivery_date']))?>" readonly="" id="delivery_date" nama="delivery_date">
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
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['status'] == 2 ? $grpo_header['grpo_no'] :'(Auto Number after Posting to SAP)'?>" id="grpo_no" nama="grpo_no">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $plant ?>" id="grpo_no" nama="grpo_no">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $storage_location ?>">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="<?= $grpo_header['status_string']?>">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" readonly="" value="All" class="form-control">
												</div>
											</div>

											<div class="form-group row" >
											<label class="col-lg-3 col-form-label">Posting Date</label>
												<div class="col-lg-9 input-group date">
													<input type="text" class="form-control" id="postingDate" value="<?= date("d-m-Y", strtotime($grpo_header['posting_date']))?>" <?php if($grpo_header['status']=='2'):?>readonly=""<?php endif; ?>>
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">
															<i class="icon-calendar"></i>
														</span>
													</div>
												</div>
											</div>

											<?php if($grpo_header['status']=='2'): ?>

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
														<button type="button" class="btn btn-primary" id="btn-update">Save <i class="icon-pencil5 ml-2"></i></button>
														<button type="button" class="btn btn-success" id="btn-approve">Approve <i class="icon-paperplane ml-2"></i></button>
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
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List PO from Vendor</legend>
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
											<th>QC</th>
											<th>Cancel</th>
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
				let id_grpo_header = $('#id_grpo_header').val();
				let stts = $('#status').val();

                $('#table-manajemen').DataTable({
                    "ordering":false, "paging":false,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/pofromvendor/showDeatailEdit');?>",
						"data":{ id: id_grpo_header, status: stts },
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
						{"data":"qc", "className":"dt-center", render:function(data, type, row, meta){
							// console.log(row);
                            rr=`<input type="text" class="form-control" value="${data}" id="${row['id_grpo_detail']}">`;
                            return rr;
                        }},

						{"data":"id_grpo_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" onclick="checkcheckbox();">`;
                            return rr;
                        }},
                    ]
                });

				$("#btn-update").click(function(){
					const postingDate = $('#postingDate').val();
					const idGrpoHeader = $('#id_grpo_header').val();
					table = $('#table-manajemen > tbody');

					let grQty=[];
					let remark=[];
					let id_grpo_detail=[];
					let emptygrpo = true;
					table.find('tr').each(function(i, el){
						let td = $(this).find('td');
						if(td.eq(4).find('input').val()==''){
							alert('Gr Quatity harus di isi');
							emptygrpo = false;
							return emptygrpo;
						}
						grQty.push(td.eq(4).find('input').val());
						remark.push(td.eq(6).find('input').val());
						id_grpo_detail.push(td.eq(6).find('input').attr('id'));	
					})
					if(emptygrpo){
						$.ajax({
							url:"<?php echo site_url('transaksi1/pofromvendor/editTable');?>",
							type:"POST",
							data:{id_grpo_header:idGrpoHeader, pstDate:postingDate, detail_grQty:grQty, remark:remark, idGrpoDetails:id_grpo_detail },
							success:function(res){
								location.reload(true);
							}
						});
					}
					
				});

				$("#btn-approve").click(function(){
					const postingDate = $('#postingDate').val();
					const idGrpoHeader = $('#id_grpo_header').val();
					const approve = '2'
					table = $('#table-manajemen > tbody');

					let grQty=[];
					let remark=[];
					let id_grpo_detail=[];
					let emptygrpo = true;
					table.find('tr').each(function(i, el){
						let td = $(this).find('td');
						if(td.eq(4).find('input').val()==''){
							alert('Gr Quatity harus di isi');
							emptygrpo = false;
							return emptygrpo;
						}
						grQty.push(td.eq(4).find('input').val());
						remark.push(td.eq(6).find('input').val());
						id_grpo_detail.push(td.eq(6).find('input').attr('id'));	
					})
					if(emptygrpo){
						$.ajax({
							url:"<?php echo site_url('transaksi1/pofromvendor/editTable');?>",
							type:"POST",
							data:{id_grpo_header:idGrpoHeader, appr:approve, pstDate:postingDate, detail_grQty:grQty, remark:remark, idGrpoDetails:id_grpo_detail },
							success:function(res){
								location.reload(true);
							}
						});
					}
					
				});

				$("#cancelRecord").click(function(){
					const idGrpoHeader = $('#id_grpo_header').val();
                    let deleteidArr=[];
                    $("input:checkbox[class=check_delete]:checked").each(function(){
                        deleteidArr.push($(this).val());
						console.log(deleteidArr);
                    })


                    // mengecek ckeckbox tercheck atau tidak
                    if(deleteidArr.length > 0){
                        var confirmDelete = confirm("Apa Kamu Yakin Akan Mengbatalkan PO ini?");
                        if(confirmDelete == true){
                            $.ajax({
                                url:"<?php echo site_url('transaksi1/pofromvendor/cancelPoFromVendor');?>", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr, id_grpo_header:idGrpoHeader},
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
					format: 'dd-mm-yyyy',
					todayHighlight: true,
					orientation: 'bottom right',
					autoclose: true
				};
				$('#postingDate').datepicker(optSimple);

				$('#delivDate').datepicker(optSimple);
            });
        
        </script>
	</body>
</html>