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
                            <a href="<?php echo site_url('master/manajemen/add') ?>" class="btn btn-danger"> Add New</a>
                        </div>
                        <div class="card-body">
                            <table id="table-manajemen" class="table table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">*</th>
                                        <th>Username</th>
                                        <th>Nama Lengkap</th>
                                        <th>Group Hak Akses</th>
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
                $('#table-manajemen').DataTable({
                    "ordering":false,  "paging": true, "searching":true,
                    "ajax": {
                        "url":"<?php echo site_url('master/manajemen/showAllData');?>",
                        "type":"POST"
                    },
                    "columns": [
                        {"data":"no"},
                        {"data":"username"},
                        {"data":"nama_lengkap"},
                        {"data":"grup_hak_akses"},
                        {"data":"no","className":"dt-center", render:function(data, type, row, meta){
                                console.log(row['no']);
                                rr = `<a href='<?php echo site_url('master/manajemen/edit')?>' ><i class='icon-file-plus2'></i></a>&nbsp;<a href='<?php echo site_url('master/manajemen/delete')?>' ><i class='icon-file-minus2'></i></a>`;
                                return rr;
                            }
                        }
                    ]
                });
            });
        
        </script>
	</body>
</html>