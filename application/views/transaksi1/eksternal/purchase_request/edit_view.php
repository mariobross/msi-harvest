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
					<input type="hidden" name="status" id="status" value="<?=$pr_header['status']?>">
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Purchase Request (PR)</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$pr_header['id_pr_header']?>" id="id_pr_header" nama="id_pr_header" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Purchase Request (PR) Number	</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $pr_header['status'] == 2 ? $pr_header['pr_no'] :'(Auto Number after Posting to SAP)'?>" id="pr_no" nama="pr_no" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $plant_name?>" readOnly>
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
													<input type="text" class="form-control" value="<?= $pr_header['status_string']?>" readOnly>
												</div>
											</div>

											<!-- <div class="form-group row">
												<label class="col-lg-3 col-form-label">Request Reason</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $pr_header['request_reason']?>" id="rr" readOnly>
												</div>
											</div> -->

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $pr_header['item_group_code']?>" id="materialGroup" name="materialGroup" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Delivery Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="deliveDate" value="<?= date("d-m-Y", strtotime($pr_header['delivery_date']))?>" <?php if($pr_header['status']=='2'):?>readonly=""<?php endif; ?>>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
                                               <button type="button" class="btn btn-primary" name="save" id="save" onclick="<?= ($pr_header['status']=='1') ? 'addDatadb()' : 'updateDataDB()'?>"><?= ($pr_header['status']=='1') ? 'Save' : 'Change'?> <i class="icon-pencil5 ml-2"></i></button>
											   <?php if($pr_header['status']=='2'):?>
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
										<?php if($pr_header['status']=='1'):?>
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
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Quantity</th>
													<th>Price / Item</th>
													<th>Last Vendor</th>
													<th>UOM</th>
													<th>On Hand</th>
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
			let id_pr_header = $('#id_pr_header').val();
			let stts = $('#status').val();

			table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				"ajax": {
                        "url":"<?php echo site_url('transaksi1/purchase_request/showPurchaseDetail');?>",
						"data":{ id: id_pr_header, status: stts },
                        "type":"POST"
                    },
				"columns": [
					{"data":"id_pr_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" >`;
                            return rr;
                    }},
					{"data":"no", "className":"dt-center"},
					{"data":"material_no", "className":"dt-center"},
					{"data":"material_desc"},
					{"data":"requirement_qty", "className":"dt-center",render:function(data, type, row, meta){
						// console.log(row);
						rr=  `<input type="text" class="form-control" id="gr_qty_${row['no']}" value="${data ? data : 0}"
						${row['status']!=1 ?'':'readonly'}>`;
						return rr;
					}},
					{"data":"price", "className":"dt-center"},
					{"data":"vendor", "className":"dt-center"},
					{"data":"uom", "className":"dt-center"},
					{"data":"onHand", "className":"dt-center"}
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
			$('#deliveDate').datepicker(optSimple);
		});

		function onAddrow(){
			let getTable = $("#tblWhole").DataTable();
			count = getTable.rows().count() + 1;
			let elementSelect = document.getElementsByClassName(`dt_${count}`);
			// const requestReason = $('#rr').val();
			const matrialGroup = $('#materialGroup').val();

			
			getTable.row.add({
				"no":count,
				"material_no":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
								<option value="">Select Item</option>
								${showMatrialDetailData( matrialGroup, elementSelect)}
							</select>`,
				"material_desc":"",
				"price":"",
				"vendor":"",
				"uom":"",
				"onHand":""
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

		function showMatrialDetailData( matrialGroup='',  select){
			$.ajax({
				url: "<?php echo site_url('transaksi1/purchase_request/getdataDetailMaterial');?>",
				type: "POST",
				data: {
					matGroup: matrialGroup
				},
				success:function(res) {
					optData = JSON.parse(res);
					// localStorage.setItem('tmpDataMaterial', JSON.stringify(optData));
					// console.log(optData);
					
					optData.forEach((val)=>{						
						$("<option />", {value:val.MATNR, text:val.MAKTX +' - '+ val.MATNR+' - '+val.UNIT	}).appendTo(select);
					})
				}
			});			
		}

		function setValueTable(id,no){
			table = document.getElementById("tblWhole").rows[no].cells;
			$.post(
				"<?php echo site_url('transaksi1/purchase_request/getdataDetailMaterialSelect')?>",{ MATNR:id },(res)=>{
					matSelect = JSON.parse(res);
					// console.log(matSelect);
					matSelect.map((val)=>{
						// console.log(val);
						table[2].innerHTML = `<td>${val.MATNR}</td>`;
						table[3].innerHTML = val.MAKTX;
						table[7].innerHTML = val.UNIT
					})
				}
			)
		}

		function updateDataDB(){
			const id_pr_header = $('#id_pr_header').val();
			const tbodyTable = $("#tblWhole > tbody");
			const id_pr_detail=[];
			const detail_qty=[];
			tbodyTable.find('tr').each(function(i,el){
				let td = $(this).find('td');
				id_pr_detail.push(td.eq(0).find('input').val());
				detail_qty.push(td.eq(4).find('input').val());
			})

			$.post("<?php echo site_url('transaksi1/purchase_request/chageDataDB')?>", {
				idpr_header: id_pr_header, idpr_detail: id_pr_detail, qty: detail_qty
			}, function(res){location.reload(true);});
		}

		function addDatadb(id_approve=''){
			const status= document.getElementById('status').value;
			const idpr_header= document.getElementById('id_pr_header').value;
			const deliveDate= document.getElementById('deliveDate').value;
			const approve = id_approve;
			const tbodyTable = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let price = [];
			let vendor = [];
			let uom =[]; 
			let onHand = [];
			let validasi = true;
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					if(td.eq(4).find('input').val() == ''){
						validasi = false;
					}	
					matrialNo.push(td.eq(2).text()); 
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
					price.push(td.eq(5).text());
					vendor.push(td.eq(6).text());
					uom.push(td.eq(7).text());
					onHand.push(td.eq(8).text());
				})
			if(!validasi){
				alert('Quatity Tidak boleh Kosong, Harap isi Quantity');
				return false;
			}

			// console.log(requestRespon,'-',matrialGroup,'-',requestToOutlet,'-',delivDate,'-',createDate, matrialNo.join('/'), matrialDesc.join('^'), qty.join('%'), uom.join('*'));
			$.post("<?php echo site_url('transaksi1/purchase_request/addDataUpdate')?>", {
				idpr_header:idpr_header, appr: approve, stts: status, stts: status, deliveDate: deliveDate, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, detQty: qty, detPrice:price, detVendor:vendor, detUom: uom, detOnHand:onHand
			}, function(res){
				location.reload(true);
			}
			);
		}
		</script>
	</body>
</html>