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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Tambah Data Pengguna</legend>
                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">NIK:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" >
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Username:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" >
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Nama Lengkap:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" >
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Email:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" >
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">PLant Terdaftar:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="readonly" value="0 plants">
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Password:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" >
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Konfirmasi Password:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" >
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Pilihan Plant:</label>
												<div class="col-lg-9">
                                                    <select class="form-control">
                                                        <option value="1">- Ampera - Block Stock (WDFGAMBS)</option>
                                                        <option value="1">- Ampera - PM (WDFGAMPM)</option>
                                                        <option value="1">- Bekasi - (WDFGBKS)</option>
                                                    </select>
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Group Hak Akses:</label>
												<div class="col-lg-9">
                                                    <select class="form-control multiselect-select-all-filtering" multiple="multiple" data-fouc>
                                                        <option value="cheese">Outlet Staff</option>
                                                        <option value="tomatoes">HQ Inventory</option>
                                                        <option value="mozarella">HQ Controlling</option>
                                                        <option value="mushrooms">HQ - Manager</option>
                                                    </select>
												</div>
											</div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
                                            </div>
                                        </fieldset>
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
	</body>
</html>