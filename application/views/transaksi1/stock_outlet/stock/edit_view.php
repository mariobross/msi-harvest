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
				   <input type="hidden" name="status" id="status" value="<?=$opname_header['status']?>">
				   		<div class="card">
                        	<div class="card-body">
                            	<div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Stock Opname</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?=$opname_header['id_opname_header']?>" id="id_opname_header" nama="id_opname_header" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Stock Opname Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" value="<?= $opname_header['status'] == 2 ? $opname_header['opname_no'] :'(Auto Number after Posting to SAP)'?>" id="opname_no" nama="opname_no" readOnly>
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
													<input type="text" class="form-control" value="<?= $opname_header['status_string']?>" readOnly>
												</div>
											</div>

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
												<input type="text" class="form-control" value="<?= $opname_header['item_group_code']?>" id="materialGroup" name="materialGroup" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="postDate" value="<?= date("d-m-Y", strtotime($opname_header['posting_date']))?>" <?php if($opname_header['status']=='2'):?>readonly=""<?php endif; ?>>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
											</div>

                                            <div class="text-right">
												<button type="button" class="btn btn-primary" name="save" id="save" onclick="<?= ($opname_header['status']=='1') ? 'addDatadb()' : 'updateDataDB()'?>"><?= ($opname_header['status']=='1') ? 'Save' : 'Change'?> <i class="icon-pencil5 ml-2"></i></button>
											   <?php if($opname_header['status']=='2'):?>
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
											<?php if($opname_header['status']=='1'):?>
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
			let id_opname_header = $('#id_opname_header').val();
			let stts = $('#status').val();

			table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				"ajax": {
                        "url":"<?php echo site_url('transaksi1/stock/showStockDetail');?>",
						"data":{ id: id_opname_header, status: stts },
                        "type":"POST"
                    },
				"columns": [
					{"data":"id_opname_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox" class="check_delete" id="chk_${data}" value="${data}" >`;
                            return rr;
                    }},
					{"data":"no", "className":"dt-center"},
					{"data":"material_no", "className":"dt-center"},
					{"data":"material_desc"},
					{"data":"requirement_qty", "className":"dt-center",render:function(data, type, row, meta){
						rr=  `<input type="text" class="form-control" id="gr_qty_${row['no']}" value="${data}" ${row['status']==1 ?'':'readonly'}>`;
						return rr;
					}}
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
			$('#postDate').datepicker(optSimple);
		});

		function onAddrow(){
			let getTable = $("#tblWhole").DataTable();
			count = getTable.rows().count() + 1;
			let elementSelect = document.getElementsByClassName(`dt_${count}`);
			
			const matrialGroup = $('#materialGroup').val();

			
			getTable.row.add({
				"no":count,
				"material_no":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
								<option value="">Select Item</option>
								${showMatrialDetailData( matrialGroup, elementSelect)}
							</select>`,
				"material_desc":"",
				"requirement_qty":"",
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
				url: "<?php echo site_url('transaksi1/stock/getdataDetailMaterial');?>",
				type: "POST",
				data: {
					
					matGroup: matrialGroup
				},
				success:function(res) {
					optData = JSON.parse(res);
					// localStorage.setItem('tmpDataMaterial', JSON.stringify(optData));
					
					optData.forEach((val)=>{						
						$("<option />", {value:val.MATNR, text:val.MAKTX +' - '+ val.MATNR+' - '+val.UNIT	}).appendTo(select);
					})
				}
			});			
		}

		function setValueTable(id,no){
			table = document.getElementById("tblWhole").rows[no].cells;
			$.post(
				"<?php echo site_url('transaksi1/stock/getdataDetailMaterialSelect')?>",{ MATNR:id },(res)=>{
					matSelect = JSON.parse(res);
					matSelect.map((val)=>{
						table[2].innerHTML = `<td>${val.MATNR}</td>`;
						table[3].innerHTML = val.MAKTX;
					})
				}
			)
		}

		function updateDataDB(){
			const id_opname_header = $('#id_opname_header').val();
			const tbodyTable = $("#tblWhole > tbody");
			const id_opname_detail=[];
			const detail_qty=[];
			tbodyTable.find('tr').each(function(i,el){
				let td = $(this).find('td');
				id_opname_detail.push(td.eq(0).find('input').val());
				detail_qty.push(td.eq(4).find('input').val());
			})

			$.post("<?php echo site_url('transaksi1/stock/chageDataDB')?>", {
				idopname_header: id_opname_header, idopname_detail: id_opname_detail, qty: detail_qty
			}, function(res){location.reload(true);});
		}

		function addDatadb(id_approve=''){
			const status= document.getElementById('status').value;
			const idopname_header= document.getElementById('id_opname_header').value;
			const postDate= document.getElementById('postDate').value;
			const approve = id_approve;
			const tbodyTable = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let validasi = true;
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					if(td.eq(4).find('input').val() == ''){
						validasi = false;
					}	
					matrialNo.push(td.eq(2).text()); 
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
				})
			if(!validasi){
				alert('Quatity Tidak boleh Kosong, Harap isi Quantity');
				return false;
			}

			// console.log(requestRespon,'-',matrialGroup,'-',requestToOutlet,'-',delivDate,'-',createDate, matrialNo.join('/'), matrialDesc.join('^'), qty.join('%'), uom.join('*'));
			$.post("<?php echo site_url('transaksi1/stock/addDataUpdate')?>", {
				idopname_header:idopname_header, appr: approve, stts: status, stts: status, postDate: postDate, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, detQty: qty
			}, function(res){
				location.reload(true);
			}
			);
		}
		</script>
	</body>
</html>