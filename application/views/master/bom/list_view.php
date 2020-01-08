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
						<form action="#" method="POST">
							<div class="card-header">
								<a href="<?php echo site_url('master/bom/add') ?>" class="btn btn-primary"> Add New</a> 
								<input type="button" value="Export To Excel" class="btn btn-success" id="btnExpExcel">
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12" style="overflow: auto">
									<fieldset>
										<table class="table table-bordered table-striped" id="table-bom">
											<thead>
												<tr>
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
						</form>
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