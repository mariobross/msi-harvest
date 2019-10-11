<!DOCTYPE html>
<html lang="en">
	<head>
		<?php  $this->load->view("_template/head.php")?>
	</head>
	<body>
		<?php  $this->load->view("_template/nav.php")?>
		<div class="page-content">
			<div class="content-wrapper">
				<div class="content">
					<!-- Vertical form options -->
					<div class="row">
						<div class="col-md-6 offset-md-4" style="margin-top:100px;">

							<!-- Basic layout-->
							<div class="card" style="width:550px;">

								<div class="card-body">
									<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Sign in ke YBC SAP Portal</legend>
									<form action="<?php echo base_url('/msi/dashboard');?>" method="POST">
										<div class="form-group">
											<label>Name:</label>
											<input type="text" class="form-control" id="name">
										</div>

										<div class="form-group">
											<label>Password:</label>
											<input type="password" class="form-control" id="password">
										</div>

										<div class="text-right">
											<button type="submit" class="btn btn-primary" id="login">Submit form <i class="icon-user ml-2"></i></button>
										</div>
										<br>
										<div class="text-right">
											<a href="#">Lupa Password</a>
										</div>
									</form>
								</div>
							</div>
							<!-- /basic layout -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
