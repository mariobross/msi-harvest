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
			.hide{
				display: none;
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
											<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Produksi</legend>
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Outlet</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readOnly>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Item Produksi</label>
												<div class="col-lg-9">
													<div id="item1">
														<select class="form-control form-control-select2" data-live-search="true" id="selectItem" onchange="getDataHeader(this.value)">
															<option value="">None Selected</option>
															<?php foreach($wo_code as $key=>$value):?>
																<option value="<?=$key?>" desc="<?=$value?>"><?=$value?></option>
															<?php endforeach;?>
														</select>
													</div>
													<div id="item2" class="hide">
														<input type="text" id="itemSelected" class="form-control" placeholder="" readOnly>
														<input type="hidden" id="wonumber">
														<input type="hidden" id="wodesc">
														<input type="hidden" id="wolocked">
													</div>
												</div>
											</div>

											<div id='form1' class="hide">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Qty Produksi</label>
													<div class="col-lg-9">
														<input type="text" id="qtyProduksi" class="form-control" placeholder="(Suggest Qty : 1.0000)" >
													</div>
												</div>
											</div>
											
											<div id='form2' class="hide">
												<div class="form-group row">
													<label class="col-lg-3 col-form-label">UOM</label>
													<div class="col-lg-9">
														<input type="text" id="uomProduksi" class="form-control" readOnly>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 col-form-label">Posting Date</label>
													<div class="col-lg-9 input-group date">
														<input type="text" class="form-control" id="postDate" readonly autocomplate="off">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">
																<i class="icon-calendar"></i>
															</span>
														</div>
													</div>
												</div>

												<div class="text-right" id="btnAction">
													<button type="button" class="btn btn-primary" name="save" id="save" onclick="addDatadb()">Save <i class="icon-pencil5 ml-2"></i></button>
													<button type="button" class="btn btn-success" name="approve" id="approve" onclick="addDatadb(2)" >Approve <i class="icon-paperplane ml-2" ></input></i>
												</div>
											</div>
											
										</fieldset>
									</div>
								</div>
							</div>
						</div> 
						<div class='hide' id="form3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Item</legend>
										<div class="col-md-12 mb-2" id="btnAddListItem">
											<div class="text-left">
												<input type="button" class="btn btn-primary" value="Add" id="addTable"> 
												<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
											</div>
										</div>
										<div class="col-md-12" style="overflow: auto" >
											<table class="table table-striped" id="tblWhole">
												<thead>
													<tr>
														<th><input type="checkbox" name="checkall" id="checkall"></th>
														<th>Material No</th>
														<th>Material Desc</th>
														<th>Quantity</th>
														<th>UOM</th>
														<th>On Hand</th>
														<th>Min Stock</th>
														<th>Oustanding Total</th>
													</tr>
												</thead>
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
			table = $("#tblWhole").DataTable({
				"ordering":false,
				"paging":false,
				drawCallback: function() {
					$('.form-control-select2').select2();
				}
			});

			/*$("#addTable").on('click', function() {
				table.row.add([
					`<input type="checkbox"  value="dt_${count}" class="check_delete" id="dt_${count}" onclick="checkcheckbox();">`,
					count,
					`<select class="form-control form-control-select2" data-live-search="true">
						<option value="">Select Item</option>
						<option value="1">Pilih 1</option>
						<option value="2">Pilih 2</option>
					</select>`,
					``,
					'',
					'<input type="text" name="qty[]" id="qty[]">',
					'',
					`<select class="form-control form-control-select2" data-live-search="true">
						<option value="">Select Item</option>
						<option value="1">Pilih 1</option>
						<option value="2">Pilih 2</option>
					</select>`,
					'<input type="text" name="qty[]" id="qty[]">'
				]).draw(false);
				count++;
			});*/

			//$("#addTable").click();
			
			// untuk check all
			$("#checkall").click(function(){
				if($(this).is(':checked')){
					$(".check_delete").prop('checked', true);
				}else{
					$(".check_delete").prop('checked', false);
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

			tbody = $("#tblWhole tbody");
			tbody.on('change','#descmat', function(){
				tr = $(this).closest('tr');
				no = tr[0].rowIndex;
				const qty = $("option:selected", this).attr("matqty");
				const matrial_no = $("option:selected", this).val();
				const rel = $("option:selected", this).attr("rel");
				table = document.getElementById("tblWhole").rows[no].cells;
				table[1].innerHTML = matrial_no;
				table[3].innerHTML = `<input type="text" id="editqty" class="form-control" value="${qty}" ${rel == "N" ? "readonly": ""}>`
			});
			
		});
		
		function getDataHeader(woNumber){
			var selectedText = $("#selectItem option:selected").val();
			var desc = $('#selectItem option:selected').attr('desc');
			$("#form1").removeClass('hide');
			$("#item1").addClass('hide');
			$("#item2").removeClass('hide');
			$("#itemSelected").attr('placeholder',desc);
			$("#wonumber").val(woNumber);
			$("#wodesc").val(desc);
			
			$.post("<?php echo site_url('transaksi1/wo/wo_header_uom');?>",{material_no: woNumber},(data)=>{
				const value = JSON.parse(data);
				// console.log(value.data[0]['BuyUnitMsr']);
				if(value.data[0]['U_Locked'] == 'N'){
					$("#btnAddListItem").addClass('hide');
				}
				$("#uomProduksi").val(value.data[0]['BuyUnitMsr']);
			});
		}
		
		$('#qtyProduksi').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				event.preventDefault();
				$("#form2").removeClass('hide');
				$("#form3").removeClass('hide');
				const qty = $("#qtyProduksi").val();
				$(this).attr('readonly', true);
				
				let kode_paket = $("#wonumber").val();

				var obj = $('#tblWhole tbody tr').length;

				if(obj>0){
					const tables = $('#tblWhole').DataTable();

					tables.destroy();
					$("#tblWhole > tbody > tr").remove();
				}
				
                dataTable = $("#tblWhole").DataTable({
                    "ordering":false,  "paging": false, "searching":true,
					drawCallback: function() {
					$('.form-control-select2').select2();
					},
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/wo/showDetailInput');?>",
						"data":{  
							kode_paket:kode_paket,
							Qty:qty

						},
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"id_mpaket_h_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox"  value="dt_${row['no']}" class="check_delete" id="dt_${row['no']}" onclick="checkcheckbox();">`;
                            return rr;
                        }},
                        {"data":"material_no", "className":"dt-center"},
                        {"data":"descolumn"},
                        {"data":"qty", "className":"dt-center"},
                        {"data":"uom", "className":"dt-center"},
                        {"data":"OnHand", "className":"dt-center"},
                        {"data":"MinStock", "className":"dt-center"},
                        {"data":"OpenQty", "className":"dt-center"}
                    ]
                });
			}
		});

		function addDatadb(id_approve = ''){
			if($('#postDate').val() ==''){
				alert('Posting date harus di isi');
				return false;
			}
			
			woNumber 	= $('#wonumber').val();
			woDesc 		= $('#wodesc').val();
			qtyProd 	= $('#qtyProduksi').val();
			uomProd 	= $('#uomProduksi').val();
			postDate 	= $('#postDate').val();
			approve		= id_approve;

			arr = woDesc.split(' - ');

			table = $('#tblWhole > tbody');
			let matrialNo =[];
			let matrialDesc =[];
			let qty =[];
			let uom =[];
			let onHand =[];
			let minStock =[];
			let outStandTot =[];
			let validasi = true;
			table.find('tr').each(function(i, el){
				let td = $(this).find('td');
				if(td.eq(3).find('input').val() == ''){
						validasi = false;
					}
				matrialNo.push(td.eq(1).text()); 
				matrialDesc.push(td.eq(2).find('select').text());
				qty.push(td.eq(3).find('input').val());
				uom.push(td.eq(4).text());	
				onHand.push(td.eq(5).text());	
				minStock.push(td.eq(6).text());	
				outStandTot.push(td.eq(7).text());
			});
			if(!validasi){
				alert('Quatity Tidak boleh Kosong, Harap isi Quantity');
				return false;
			}
			// console.log(matrialDesc);
			$.post("<?php echo site_url('transaksi1/wo/addData')?>",{
				woDesc:arr[1], woNumber:woNumber, qtyProd:qtyProd, uomProd:uomProd, postDate:postDate, approve:approve, matrialNo:matrialNo, matrialDesc:matrialDesc, qty:qty, uom:uom, onHand:onHand, minStock:minStock, outStandTot:outStandTot},
				function(res){
					location.reload(true);
				}
			);
			
		}
		</script>
	</body>
</html>