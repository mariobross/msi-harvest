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
					<input type="hidden" name="status" id="status" value="<?=$twtsnew_header['status']?>">
					<input type="hidden" name="uom_paket" id="uom_paket" value="<?=$twtsnew_header['uom_paket']?>">
					<input type="hidden" name="plant" id="plant" value="<?=$twtsnew_header['plant']?>">
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Edit Whole to Slice</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$twtsnew_header['id_twtsnew_header']?>" id="idWhole" name="idWhole" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Code</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$twtsnew_header['kode_paket']?>" id="itemCode" name="itemCode" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Nama Lengkap:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$twtsnew_header['nama_paket']?>" id="itemDesc" name="itemDesc" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Quatity</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$twtsnew_header['quantity_paket']?>" id="qty" name="qty">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">On Hand</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$twtsnew_header['onHand']?>" id="onHand" name="onHand" readonly>
												</div>
											</div>

                                            <?php if($twtsnew_header['status']=='2'): ?>

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
															<button type="button" class="btn btn-success" id="btn-approve" onclick="addDatadb(2)">Approve <i class="icon-paperplane ml-2"></i></button>
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
									<?php if($twtsnew_header['status']=='1'):?>
										<div class="col-md-12 mb-2">
											<div class="text-left">
												<input type="button" class="btn btn-primary" value="Add" id="addTable" onclick="onAddrow()"> 
												<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
											</div>
										</div>
									<?php endif; ?>
									<div class="col-md-12" style="overflow: auto">
										<table class="table table-striped" id="tblWhole">
											<thead>
												<tr>
													<th colspan="7" >BOM ITEM</th>
												</tr>
												<tr>
													<th></th>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Var</th>
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
			let id_twtsnew_header = $('#idWhole').val();
			let stts = $('#status').val();

			table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				"ajax": {
                        "url":"<?php echo site_url('transaksi2/whole/showTwtsnewDetail');?>",
						"data":{ id: id_twtsnew_header, status: stts },
                        "type":"POST"
                    },
				"columns": [
					{"data":"id_twtsnew_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" >`;
                            return rr;
                    }},
					{"data":"no", "className":"dt-center"},
					{"data":"material_no", "className":"dt-center"},
					{"data":"material_desc"},
					{"data":"quantity", "className":"dt-center",render:function(data, type, row, meta){
						rr=  `<input type="text" class="form-control" id="gr_qty_${data}" value="${data}"
						${row['status']==1 ?'':'readonly'}>`;
						return rr;
					}},
					{"data":"uom", "className":"dt-center"},
					{"data":"var", "className":"dt-center"},
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
							// console.log(deleteidArr);
							$("input:checked").each(function(){
								table.row($(this).closest("tr")).remove().draw();;
							});
                        }
                    }
					
				});
				
				$("#cancelRecord").click(function(){
					const idWhole = $('#idWhole').val();
                    let deleteidArr=[];
                    $("input:checkbox[class=check_delete]:checked").each(function(){
                        deleteidArr.push($(this).val());
						console.log(deleteidArr);
                    })


                    // mengecek ckeckbox tercheck atau tidak
                    if(deleteidArr.length > 0){
                        var confirmDelete = confirm("Apa Kamu Yakin Akan Mengbatalkan Whole to Slice ini?");
                        if(confirmDelete == true){
                            $.ajax({
                                url:"<?php echo site_url('transaksi2/whole/cancelWholeToSlice');?>", //masukan url untuk delete
                                type: "post",
                                data:{deleteArr: deleteidArr, idWhole:idWhole},
                                success:function(res) {
                                    // dataTable.ajax.reload();
									location.reload(true);
                                }
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
		});

		function addDatadb(id_approve=''){
			if($('.qty').val() ==''){
					alert('Quatity harus di isi');
					return false;
				}
			if($('#qty').val() ==''){
				alert('Quatity Paket harus di isi');
				return false;
			}
			const idWhole= document.getElementById('idWhole').value;
			const itemCode= document.getElementById('itemCode').value;
			const itemDesc= document.getElementById('itemDesc').value;
			const qtyPaket= document.getElementById('qty').value;
			const approve = id_approve;
			const tbodyTable = $('#tblWhole > tbody');
			let id_twtsnew_detail = [];
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let uom =[];
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					id_twtsnew_detail.push(td.eq(0).find('input').val());
					matrialNo.push(td.eq(2).text()); 
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
					uom.push(td.eq(5).text());
				})


			$.post("<?php echo site_url('transaksi2/whole/addDataUpdate')?>", {
				id_whole: idWhole, item_code: itemCode, item_desc: itemDesc, qty_paket: qtyPaket, appr: approve, idTwtsnewDetail:id_twtsnew_detail, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, detQty: qty, detUom: uom,
			}, function(res){
				location.reload(true);
			});
		}
		</script>
	</body>
</html>