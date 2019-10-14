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
                        <div class="card-header">
                            <a href="<?php echo site_url('master/akses/add') ?>" class="btn btn-danger"> Add New</a>
                        </div>
                        <div class="card-body">
                            <table id="table-akses" class="table table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">*</th>
                                        <th>Group Hak Akses</th>
                                        <th>Admin Terkait</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
				</div>
				<?php  $this->load->view("_template/footer.php")?>
			</div>
		</div>
        <?php  $this->load->view("_template/js.php")?>
        <script>
            $(document).ready(function(){
                $('#table-akses').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('master/akses/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
                        {"data":"grup_hak_akses"},
						{"data":"admin_terkait","className":"dt-center", render:function(data, type, row, meta){
								rr = (data=="true")?`<a href='<?php echo site_url('master/akses/edit')?>' ><i class='icon-file-check'></i></a>`:``;
								return rr;
                            }
                        },
                        {"data":"no","className":"dt-center", render:function(data, type, row, meta){
                                rr = `<a href='<?php echo site_url('master/akses/edit')?>' ><i class='icon-file-check2'></i></a>&nbsp;<a href='<?php echo site_url('master/akses/edit')?>' ><i class='icon-file-text3'></i></a>&nbsp;<a href='<?php echo site_url('master/akses/delete')?>' ><i class='icon-file-minus2'></i></a>`;
                                return rr;
                            }
                        }
                    ]
                });
            });
        
        </script>
	</body>
</html>