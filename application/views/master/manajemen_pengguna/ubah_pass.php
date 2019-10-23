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
                                            <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i>Ubah Password</legend>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Username:</label>
												<div class="col-lg-9">
													<input type="text" class="form-control" readonly="readonly" value="SX_Alam">
												</div>
											</div>

                                            <div class="form-group row">
												<label class="col-lg-3 col-form-label">Password Baru:</label>
												<div class="col-lg-9">
													<input type="password" class="form-control" value="">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-lg-3 col-form-label">Konfirmasi Password Baru:</label>
												<div class="col-lg-9">
													<input type="password" class="form-control" value="">
												</div>
											</div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                <button type="submit" class="btn btn-success">Reset</button>
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