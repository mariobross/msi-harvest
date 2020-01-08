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
							<?php 
								if(!empty($this->session->flashdata('forgotpassword'))){
									if($this->session->flashdata('forgotpassword')=='correct'){ ?>
									<div class="alert alert-success" style="width:550px;">
										<strong>Success!</strong> Password telah dikirim email Anda!
									</div>
							<?php }else{ ?>
								<div class="alert alert-danger" style="width:550px;">
									<strong>Error!</strong> Rubah Password gagal!
								</div>
							<?php }
								}
							?>
							<!-- Basic layout-->
							<div class="card" style="width:550px;">

								<div class="card-body" id="signinPage">
									<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Sign in ke YBC SAP Portal</legend>
									<form action="<?php echo base_url('/msi/dashboard');?>" method="POST">
										<div class="form-group">
											<label>Name:</label>
											<input type="text" class="form-control" name="name" id="name">
										</div>

										<div class="form-group">
											<label>Password:</label>
											<input type="password" class="form-control" name="password" id="password">
										</div>

										<div class="text-right">
											<button type="submit" class="btn btn-primary" id="login">Submit form <i class="icon-user ml-2"></i></button>
										</div>
										<br>
										<div class="text-right">
											<a href="#" id="forgotPassword">Lupa Password</a>
										</div>
									</form>
								</div>
								
								<div class="card-body" id="forgotPassPage" style="display:none;">
									<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Forgot Password</legend>
									<form action="<?php echo base_url('/login/forgotpassword');?>" method="POST">
										<div class="form-group">
											<label>Username:</label>
											<input type="text" class="form-control" id="name" name="name">
										</div>
										<div class="text-right">
											<button type="submit" class="btn btn-primary" id="login">Submit<i class="icon-user ml-2"></i></button> 
										</div>
										<br>
									</form>
								</div>
							</div>
							<!-- /basic layout -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
            $(document).ready(function(){
                $("#forgotPassword").click(function(){
				  $("#signinPage").hide();
				  $("#forgotPassPage").show();
				});
            });
        
        </script>
	</body>
</html>
