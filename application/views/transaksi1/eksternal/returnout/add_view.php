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

			.hidden{
				display: 'hidden';
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
						<div class="card">
                        	<div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Tambah Retur Out</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Return Number</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
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
													<input type="hidden" value="1" id="status" name="status"/>
													<input type="text" class="form-control" value="Not Approved" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Retur Out to Outlet</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="rto" name="rto" onchange="showMaterial()">
													<option value="">Select Item</option>
														<?php foreach($plants as $key=>$val):?>
															<option value="<?=$val['OUTLET'].'|'.$val['OUTLET_NAME1']?>"><?=$val['OUTLET_NAME1'].'('.$val['OUTLET'].')'?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>
											
											<div id="form1" style="display:none">
                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="materialGroup" name="materialGroup" onchange="showMatrialDetail(this.value)">
													<option value="">Select Item</option>
														<option value="all">All</option>
														<?php foreach($matrialGroup as $key=>$val):?>
															<option value="<?=$val['ItmsGrpNam']?>"><?=$val['ItmsGrpNam']?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>
											</div>
											
											<div id="form2" style="display:none">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Posting Date</label>
                                                <div class="col-lg-9 input-group date">
                                                    <input type="text" class="form-control" id="postDate" autocomplete="off" readonly>
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
											</div>
											
                                        </fieldset>
                                    </div>
                                </div>
								</div>
                    	</div>   
						<div id="form3" style="display:none">	
						<div class="card">
							<div class="card-body">
								<div class="row">
								<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
								<div class="col-md-12 mb-2">
									<div class="text-left">
										<input type="button" class="btn btn-primary" value="Add" id="addTable" onclick="onAddrow()"> 
										<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord">
									</div>
								</div>
                                            
									<div class="col-md-12" style="overflow: auto">
										<table class="table table-striped" id="tblWhole">
											<thead>
												<tr>
													<th></th>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>In Whs Quantity</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Remarks</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><input type="checkbox" id="record"/></td>
													<td>1</td>
													<td width="25%">
														<select class="form-control form-control-select2" data-live-search="true" id="matrialGroup" onchange="setValueTable(this.value,1)" >
															<option value="">Select Item</option>
														</select>
													</td>
													<td width="30%"></td>
													<td></td>
													<td><input type="text" class="form-control  qty" name="qty[]" id="qty" style="width:100%" autocomplete="off"></td>
													<td></td>
													<td><input type="text" class="form-control remark" name="remark[]" id="remark" style="width:100%" autocomplete="off"></td>
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
		$(document).ready(function(){
			
			var table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
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
			$('#postDate').datepicker();
		});

		function showMaterial(){
			const requsetOutlet = $('#rto').val();
			const arrOutletVal = requsetOutlet.split('|');
			console.log(arrOutletVal);
			$("#form1").css('display', '');
		}

		function onAddrow(){
			let getTable = $("#tblWhole").DataTable();
			count = getTable.rows().count() + 1;
			let elementSelect = document.getElementsByClassName(`dt_${count}`);
			const reqtOutlet = $('#rto').val();
			const arrOutletVal = reqtOutlet.split('|');
			const requestOutlet = arrOutletVal[0];
			const matrialGroup = $('#materialGroup').val();

			
			getTable.row.add({
				"0":`<input type="checkbox" class="check_delete" id="chk_${count}" value="${count}">`,
				"1":count,
				"2":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
						<option value="">Select Item</option>
						${showMatrialDetailData(requestOutlet, matrialGroup, elementSelect)}
					</select>`,
				"3":"",
				"4":"",
				"5":`<input type="text" class="form-control qty" id="gr_qty_${count}" value="" style="width:100%" autocomplete="off">`,
				
				"6":"",
				"7":`<input type="text" class="form-control remark" id="remark_${count}" value="" style="width:100%" autocomplete="off">`,
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
			const reqtOutlet = $('#rto').val();
			const arrOutletVal = reqtOutlet.split('|');
			const requestToOutlet = arrOutletVal[0];
			const materialGroup = $('#materialGroup').val();
			table = document.getElementById("tblWhole").rows[no].cells;
			$.post(
				"<?php echo site_url('transaksi1/returnout/getdataDetailMaterialSelect')?>",{ MATNR:id, RTO:requestToOutlet, DSNAM:materialGroup },(res)=>{
					matSelect = JSON.parse(res);
					// console.log(matSelect['dataInWhsQty'][0]);
					let inWhsQty = matSelect['dataInWhsQty'] ? matSelect['dataInWhsQty'][0].OnHand : 0;
					
					matSelect['data'].map((val)=>{
						table[3].innerHTML = val.MAKTX;
						table[6].innerHTML = val.UNIT;
						table[4].innerHTML = inWhsQty == '.000000' ? 0 : onHand;
					})
				}
			)
		}

		function showMatrialDetail(selectMaterial){
			const reqtOutlet = $('#rto').val();
			const arrOutletVal = reqtOutlet.split('|');
			const requestOutlet = arrOutletVal[0];
			const select = $('#matrialGroup');
			$("#form2").css('display', '');
			$("#form3").css('display', '');
			showMatrialDetailData(requestOutlet, selectMaterial, select);
		}

		function showMatrialDetailData(requestOutlet='', selectMaterial='',  select){
			$.ajax({
				url: "<?php echo site_url('transaksi1/returnout/getdataDetailMaterial');?>",
				type: "POST",
				data: {
					reqOutlet: requestOutlet, 
					matGroup: selectMaterial
				},
				success:function(res) {
					optData = JSON.parse(res);
					// localStorage.setItem('tmpDataMaterial', JSON.stringify(optData));
					
					optData.forEach((val)=>{						
						$("<option />", {value:val.MATNR1, text:val.MATNR1 +' - '+ val.MAKTX+' - '+val.UNIT	}).appendTo(select);
					})
				}
			});			
		}

		function addDatadb(id_approve=''){
			const status= document.getElementById('status').value;
			const reqtOutlet = document.getElementById('rto').value;
			const arrOutletVal = reqtOutlet.split('|');
			const requestOutlet = arrOutletVal[0];
			const requestOutletName= arrOutletVal[1];
			const MatrialGroup= document.getElementById('materialGroup').value;
			const postDate= document.getElementById('postDate').value;
			const approve = id_approve;
			const tbodyTable = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let whsQty =[];
			let qty =[];
			let uom =[]; 
			let remark =[];
			let validasi = true;
			let validasiQty = true;
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					if(td.eq(4).find('input').val() == ''){
						validasi = false;
					}	
					matrialNo.push(td.eq(2).find('select').val()); 
					matrialDesc.push(td.eq(3).text());
					whsQty.push(td.eq(4).text());
					qty.push(td.eq(5).find('input').val());
					uom.push(td.eq(6).text());
					remark.push(td.eq(7).find('input').val());
				})
			if(!validasi){
				alert('Quatity Tidak boleh Kosong, Harap isi Quantity');
				return false;
			}

			$.post("<?php echo site_url('transaksi1/returnout/addData')?>", {
				appr: approve, stts: status, reqOutlet:requestOutlet, reqOutletName:requestOutletName,matGroup: MatrialGroup, stts: status, posting_date: postDate, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, inWhsQty:whsQty, detQty: qty, detUom: uom, detRemark:remark
			}, function(res){
				location.reload(true);
			}
			);
		}
		</script>
	</body>
</html>