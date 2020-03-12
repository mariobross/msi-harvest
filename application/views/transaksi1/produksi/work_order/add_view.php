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
																<option value="<?=$key?>"><?=$value?></option>
															<?php endforeach;?>
														</select>
													</div>
													<div id="item2" class="hide">
														<input type="text" id="itemSelected" class="form-control" placeholder="" readOnly>
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
														<input type="text" class="form-control" id="postDate">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">
																<i class="icon-calendar"></i>
															</span>
														</div>
													</div>
												</div>

												<div class="text-right" style="display:none" id="btnAction">
													<button type="submit" class="btn btn-primary">Save<i class="icon-safe ml-2"></i></button>
													<button type="submit" class="btn btn-success">Approve SAP<i class="icon-paperplane ml-2"></i></button>
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
										<div class="col-md-12 mb-2">
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
			/*var table = $("#tblWhole").DataTable({
				"ordering":false
			});*/
			count = 1;

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


			$('#postDate').datepicker();
			
		});
		
		function getDataHeader(woNumber){
			$("#form1").removeClass('hide');
			$("#item1").addClass('hide');
			$("#item2").removeClass('hide');
			$("#itemSelected").attr("placeholder",woNumber);
			
			$.post("<?php echo site_url('transaksi1/wo/wo_header_uom');?>",{material_no: woNumber},(data)=>{
				$("#uomProduksi").val(data);
			});
		}
		
		$('#qtyProduksi').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				event.preventDefault();
				$("#form2").removeClass('hide');
				$("#form3").removeClass('hide');
				$(this).attr('readonly', true);
				
				let kode_paket = $("#itemSelected").attr("placeholder");
				
                $("#tblWhole").DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('transaksi1/wo/showDetailInput');?>",
						"data":{  
							kode_paket:kode_paket
						},
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"id_mpaket_h_detail", "className":"dt-center", render:function(data, type, row, meta){
                            rr=`<input type="checkbox"  value="dt_${count}" class="check_delete" id="dt_${count}" onclick="checkcheckbox();">`;
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
		</script>
	</body>
</html>