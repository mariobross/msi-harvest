<!DOCTYPE html>
<html lang="en">
	<head>
		<?php  $this->load->view("_template/head.php")?>
	</head>
	<body>

		<!-- /php  $this->load->view("_template/nav.php")?> -->
		<div class="page-content">
			<div class="content-wrapper">
				<div class="content">
					
					<!-- Vertical form options -->
					<div class="row">

						<div class="col-md-6 offset-md-4" style="margin-top:100px;">

							<div class="alert alert-danger errMsg" style="width:550px; display:none"></div>

							<div class="alert alert-success errMsgSuccess" style="width:550px; display:none"></div>
							<!-- Basic layout-->
							<div class="card" style="width:550px;">

								<div class="card-body" id="signinPage">
									<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Sign in ke YBC SAP Portal</legend>
									<!-- <form action="<?php echo base_url('/msi/dashboard');?>" method="POST"> -->
										<div class="form-group">
											<label>Name:</label>
											<input type="text" class="form-control" name="f_name" id="f_name">
										</div>

										<div class="form-group">
											<label>Password:</label>
											<input type="password" class="form-control" name="f_password" id="f_password">
										</div>

										<div class="text-right">
											<button type="button" class="btn btn-primary" id="BtnLogin">Masuk <i class="icon-user ml-2"></i></button>

										</div>
										<br>
										<div class="text-right">
											<a href="#" id="forgotPassword">Lupa Password</a>
										</div>

									<!-- </form> -->
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

				$(".errMsg").hide();

				$("#BtnLogin").click(function(){ 
					
					
					$(".errMsg").hide();
					$('#BtnLogin').prop('disabled',true);
					$("#BtnLogin").html("loading ..");

					if($("#f_name").val() == "" || $("#f_password").val() == ""){
						
						alert("Username atau Password tidak boleh kosong");
						$('#BtnLogin').prop('disabled',false);
						$('#BtnLogin').html('Masuk');
						
						return;
					}
					let data = {
						username : $("#f_name").val(),
						password: $("#f_password").val()
					}	

					$.post("<?php echo site_url('login/userLogin'); ?>",{
							data: data
						},
						(res)=>{
							
							if(res){
								
								let r = JSON.parse(res);
								
								if(r.success){
									
									$(".errMsgSuccess").html(r.message);
									$(".errMsgSuccess").show();
									$('#BtnLogin').prop('disabled',false);
									$('#BtnLogin').html('Masuk');

									setTimeout(function(){ 
										window.location.href = '<?php echo site_url('msi/dashboard'); ?>'; 
									}, 750);

								} else {
									$(".errMsg").html(r.message);
									$(".errMsg").show();
									$('#BtnLogin').prop('disabled',false);
									$('#BtnLogin').html('Masuk');
								}

								
							}
							

						}
					)
					
					
				});
                $("#forgotPassword").click(function(){
				  $("#signinPage").hide();
				  $("#forgotPassPage").show();
				});
            });
        
        </script>
	</body>
</html>
