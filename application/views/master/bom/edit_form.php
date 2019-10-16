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
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Edit BOM Item</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">BOM Item Code:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="1ACO0117">
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">BOM Item Description:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="" value="Latte Cookies">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">BOM Quantity:</label>
												<div class="col-lg-9">
                                                    <input type="text" class="form-control" value="15.00 EA"> 
												</div>
											</div>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 

					<div class="card">
                        <div class="card-header">
                            <legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Manajemen Pengguna</legend>
                        </div>
                        <div class="card-body">
                            <table id="table-bom" class="table table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">*</th>
                                        <th>Material No</th>
                                        <th>Material Desc</th>
                                        <th>Quantity</th>
                                        <th>Uom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
							<div class="text-center">
								<button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
							</div>
                        </div>
                    </div>
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
        <?php  $this->load->view("_template/js.php")?>
		<script>
            $(document).ready(function(){
                $('#table-bom').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('master/bom/bomItemData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
                        {"data":"material_no"},
                        {"data":"material_description"},
						{"data":"quantity", render:function(data, type, row, meta){
                                rr = `<input type='text' class='form-control' value=${data}>`;
                                return rr;
                            }
                        },
                        {"data":"uom"},
                    ]
                });

                deleteConfirm = (url)=>{
                    $('#btn-delete').attr('href', url);
	                $('#deleteModal').modal();
                }
            });
        
        </script>
	</body>
</html>