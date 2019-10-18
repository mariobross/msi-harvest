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
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Tambah Goods Receipt Non PO</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">ID Transaksi</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="ID Transaksi" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Goods Receipt No.</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="(Auto Number after Posting to SAP)" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Plant</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readOnly>
												</div>
                                            </div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Storage Location</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Outlet" readOnly>
												</div>
                                            </div>

											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Cost Center</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="" readOnly>
												</div>
											</div>
                                            
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Status</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" placeholder="Not Approved" readOnly>
												</div>
											</div>

                                           	<div class="form-group row">
												<label class="col-lg-3 col-form-label">Material Group</label>
												<div class="col-lg-9">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">Select Item</option>
														<option value="1">Pilih 1</option>
														<option value="2">Pilih 2</option>
													</select>
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

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
												<button type="submit" class="btn btn-success">Approve SAP<i class="icon-paperplane ml-2"></i></button>
                                            </div>

											
                                        </fieldset>
                                    </div>
                                </div>
								<br>
								<div class="row">
									<div class="col-md-12" style="overflow: auto">
										<table class="table table-bordered table-striped" id="tblWhole">
											<thead>
												<tr>
													<th></th>
													<th>No</th>
													<th>Material No</th>
													<th>Material Desc</th>
													<th>Quantity</th>
													<th>UOM</th>
													<th>Text</th>
												</tr>
											</thead>
										</table>
									</div>
									<div class="col-md-12">
										<div class="text-left">
											<input type="button" class="btn btn-primary" value="Add" id="addTable"> 
											<input type="button" value="Delete" class="btn btn-danger" id="deleteRecord"> 
										</div>
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
			var table = $("#tblWhole").DataTable({
				"ordering":false
			});
			count = 1;

			$("#addTable").on('click', function() {
				table.row.add([
					`<input type="checkbox"  value="dt_${count}" class="check_delete" id="dt_${count}" onclick="checkcheckbox();">`,
					count,
					`<select class="form-control form-control-select2" data-live-search="true">
						<option value="">Select Item</option>
						<option value="1">Pilih 1</option>
						<option value="2">Pilih 2</option>
					</select>`,
					``,
					'<input type="text" name="qty[]" id="qty[]">',
					'',
					'<input type="text" name="qty[]" id="qty[]">'
				]).draw(false);
				count++;
			});

			$("#addTable").click();

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
		</script>
	</body>
</html>