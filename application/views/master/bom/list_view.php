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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>BOM List</legend>
                                            <div class="form-group row">
												<label class="col-lg-1 col-form-label">Search By</label>
												<div class="col-lg-3 input-group">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">Kode BOM Item</option>
														<option value="">Nama BOM Item</option>
													</select>
												</div>
												<div class="col-lg-3 input-group ">
													<select class="form-control form-control-select2" data-live-search="true">
														<option value="">Any Part of Field</option>
														<option value="">All Part of Field</option>
													</select>
												</div>
												<div class="col-lg-3 input-group ">
													<input type="text" class="form-control">
												</div>
												<div class="col-lg-2 input-group ">
													<button type="button" id="btnSearch" class="btn btn-primary">Search<i class="icon-search4 ml-2"></i></button>
												</div>
												<div class="col-lg-2 input-group ">
													<div id="totalData"></div>
												</div>
											</div>
											
                                        </fieldset>
                                    </div>
								</div>	
								<br>
                            </form>
                        </div>
                    </div>   
					<div class="card">
						<div class="card-header">
                            <a href="<?php echo site_url('master/bom/add') ?>" class="btn btn-primary"> Add New</a> 
                        </div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12" style="overflow: auto">
								<fieldset>
									<table class="table table-bordered table-striped" id="table-bom">
										<thead>
											<tr>
												<th style="text-align: left">*</th>
												<th>Action</th>
												<th>BOM Item No</th>
												<th>BOM Item Description</th>
												<th>BOM Quantity</th>
											</tr>
										</thead>
									</table>
								<fieldset>	
								</div>
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
                        "url":"<?php echo site_url('master/bom/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
						{"data":"no","className":"dt-center", render:function(data, type, row, meta){
                                rr = `<a href='<?php echo site_url('master/bom/edit')?>' ><i class='icon-file-check2' title="Edit"></i></a>&nbsp;`;
                                return rr;
                            }
                        },
                        {"data":"bom_no"},
                        {"data":"bom_description"},
                        {"data":"quantity"}
                        
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