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
                            <legend class="font-weight-semibold"><i class="icon-list mr-2"></i>List Integration Log</legend>
                        </div>
                        <div class="card-body">
                            <table id="table-manajemen" class="table table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Modul</th>
                                        <th>Message</th>
                                        <th>Error Time</th>
                                        <th>Trans ID</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php 
									$i = 1;
									if(isset($data)){
										foreach($data as $_data){ 
											$mod =$_data->modul;
											if ($mod=='Good Issue from Production' || $mod=='Good Receipt Produksi'){
												$modul='produksi';
											}else if ($mod=='Purchase Request'){
												$modul='pr';
											}else if ($mod=='Store Room Request'){
												$modul='stdstock';
											}else if ($mod=='GR PO From Vendor'){
												$modul='grpo';
											}else if ($mod=='Good Issue'){
												$modul='issue';
											}else if ($mod=='Good Receipt Whole to Slice'||$mod=='Good Issue from Whole Outlet'){
												$modul='twtsnew';
											}else if ($mod=='Transfer Out Inter Outlet'){
												$modul='gistonew_out';
											}else if ($mod=='Retur'){
												$modul='gisto_dept';
											}else if ($mod=='Purchase Request'){
												$modul='pr';
											}else if ($mod=='Store Room Request'){
												$modul='stdstock';
											}else if ($mod=='GR From Sentul'){
												$modul='grpodlv';
											}else if ($mod=='Stock Counting Opname'){
												$modul='opname';
											}else if ($mod=='Transfer In Inter Outlet'){
												$modul='grsto';
											}
								?> 
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $_data->modul; ?></td>
										<td><?php echo $_data->message; ?></td>
										<td><?php echo $_data->time_error; ?></td>
										<td><?php echo $_data->id_trans; ?></td>
										<td><a href='<?php echo site_url('master/'.$modul.'/edit/'.$_data->id_trans)?>' ><i class='icon-file-plus2' title="Edit"></i></a></td>
									</tr>
								<?php
										}
									}
								?>
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
                    "ordering":false,  "paging": true, "searching":true
                });
            });
        </script>
	</body>
</html>