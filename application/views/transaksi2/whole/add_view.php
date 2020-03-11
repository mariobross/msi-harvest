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
					<div class="card">
                        <div class="card-body">
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Tambah Whole to Slice</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" id="idWhole" name="idWhole" readOnly>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Code</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true" id="itemCode" name="itemCode" onchange="setDetail(this)">
														<option value="">Pilih item...</option>
														<?php foreach($items as $key=>$val):?>
															<option value="<?= $val['MATNR']?>"><?= $val['MATNR'].' - '.$val['MAKTX']?></option>
														<?php endforeach?>
													</select>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Description</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Description Item" id="itemDesc" name="itemDesc" readOnly>
													
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Quatity</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="0.00" id="qty" name="qty">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">On Hand</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="0.00" id="onHand" name="onHand" readonly>
												</div>
											</div>

                                            <div class="text-right">
                                                <button type="button" class="btn btn-primary" name="save" id="save" onclick="addDatadb()">Save <i class="icon-pencil5 ml-2"></i></button>
												<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)">Approve SAP<i class="icon-paperplane ml-2"></i></button>
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
											<tbody>
												<tr>
													<td><input type="checkbox" id="record"/></td>
													<td>1</td>
													<td width="35%">
														<select class="form-control form-control-select2" data-live-search="true" id="matrialGroup" onchange="setValueTable(this.value,2)">
															<option value="">Select Item</option>
														</select>
													</td>
													<td width="35%"></td>
													<td><input type="text" class="form-control  qty" name="gr_qty_2" id="gr_qty_2" style="width:100%" autocomplete="off"></td>
													<td></td>
													<td></td>
												</tr>
											</tbody>
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
			var table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				drawCallback: function() {
					$('.form-control-select2').select2();
				}
			});
			count = 1;

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
		});

		function setDetail(item){
			const text = item.options[item.selectedIndex].text
			const textArr = text.split(' - ');
			const itemCode = textArr[0];
			$('#itemDesc').val(textArr[1]);
			const select = $('#matrialGroup');
			showMatrialDetailData(itemCode, select);
			$.post("<?php echo site_url('transaksi2/whole/getOnHand')?>",{
				item_code:itemCode},
				function(res){
					const value = JSON.parse(res);
					$('#onHand').val(value);
			});
			
		}

		function showMatrialDetailData(itemCode='', select){
			// console.log(select);
			$.ajax({
				url: "<?php echo site_url('transaksi2/whole/getdataDetailMaterial');?>",
				type: "POST",
				data: {
					item_code: itemCode
				},
				success:function(res) {
					optData = JSON.parse(res);
					// localStorage.setItem('tmpDataMaterial', JSON.stringify(optData));
					console.log(optData);
					optData.forEach((val)=>{						
						$("<option />", {value:val.MATNR1, text:val.MATNR1 +' - '+ val.MAKTX1+' - '+val.UOM}).appendTo(select);
					})
				}
			});			
		}

		function onAddrow(){
			let getTable = $("#tblWhole").DataTable();
			count = getTable.rows().count() + 2;
			let elementSelect = document.getElementsByClassName(`dt_${count}`);
			const itemCode = $('#itemCode').val();

			
			// console.log(optSelect);
			
			getTable.row.add({
				"0":`<input type="checkbox" class="check_delete" id="chk_${count}" value="${count}">`,
				"1":count -1,
				"2":`<select class="form-control form-control-select2 dt_${count} testSelect" data-live-search="true" id="selectDetailMatrial" data-count="${count}">
								<option value="">Select Item</option>
								${showMatrialDetailData(itemCode, elementSelect)}
							</select>`,
				"3":"",
				"4":`<input type="text" class="form-control qty" id="gr_qty_${count}" value="" style="width:100%" autocomplete="off">`,
				"5":"",
				"6":""
				}).draw();
				count++;

			tbody = $("#tblWhole tbody");
			tbody.on('change','.testSelect', function(){
				tr = $(this).closest('tr');
				no = tr[0].rowIndex;
				console.log(tr[0].rowIndex );
				id = $('.dt_'+no).val();
				setValueTable(id,no);
			});
		}

		function setValueTable(id,no){
			table = document.getElementById("tblWhole").rows[no].cells;
			const itemCode = $('#itemCode').val();
			$.post(
				"<?php echo site_url('transaksi2/whole/getdataDetailMaterial')?>",{ item_code: itemCode, MATNR:id },(res)=>{
					matSelect = JSON.parse(res);
					matSelect.map((val)=>{
						table[3].innerHTML = val.MAKTX1;
						table[4].innerHTML = `<input type="text" class="form-control qty" id="gr_qty_${val.qty}" value="${val.qty}" style="width:100%" autocomplete="off">`;
						table[5].innerHTML = val.UOM
					})
				}
			)
		}

		function addDatadb(id_approve=''){
			if($('.qty').val() ==''){
					alert('Quatity harus di isi');
					return false;
				}
			if($('#qty').val() ==''){
				alert('Quatity Paket harus di isi');
				return false;
			}
			const itemCode= document.getElementById('itemCode').value;
			const itemDesc= document.getElementById('itemDesc').value;
			const qtyPaket= document.getElementById('qty').value;
			const approve = id_approve;
			const tbodyTable = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let uom =[];
			tbodyTable.find('tr').each(function(i, el){
					let td = $(this).find('td');
					matrialNo.push(td.eq(2).find('select').val()); 
					matrialDesc.push(td.eq(3).text());
					qty.push(td.eq(4).find('input').val());
					uom.push(td.eq(5).text());
				})


			$.post("<?php echo site_url('transaksi2/whole/addData')?>", {
				item_code: itemCode, item_desc: itemDesc, qty_paket: qtyPaket, appr: approve, detMatrialNo: matrialNo, detMatrialDesc: matrialDesc, detQty: qty, detUom: uom,
			}, function(res){
				location.reload(true);
			});
		}


		</script>
	</body>
</html>