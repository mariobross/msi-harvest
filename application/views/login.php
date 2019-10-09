
<!-- Main content -->
<div class="content-wrapper">


	<!-- Content area -->
	<div class="content">

		<!-- Vertical form options -->
		<div class="row">
			<div class="col-md-6 offset-md-4" style="margin-top:100px;">

				<!-- Basic layout-->
				<div class="card" style="width:550px;">

					<div class="card-body">
						<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Sign in ke YBC SAP Portal</legend>
						<form action="#" method="POST">
							<div class="form-group">
								<label>Name:</label>
								<input type="text" class="form-control" id="name">
							</div>

							<div class="form-group">
								<label>Password:</label>
								<input type="password" class="form-control" id="password">
							</div>

							<div class="text-right">
								<button type="button" class="btn btn-primary" id="login">Submit form <i class="icon-user ml-2"></i></button>
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
		<!-- /vertical form options -->
		
		<script>
			$(document).ready(function(){
				base_url = 'http://localhost/msi-harvest/';
				$("#login").click(function(){
					name = $('#name').val().trim();
					pass = $('#password').val().trim();

					if(name=='' && pass==''){
						swal("Oops...", "Name and password must not be blank", "error");
					}else{
						$.post(base_url+'login/userLogin',{Name: name, Password: pass},function(data){
							if(data!=0){
								window.location.replace(data);
							}else{
								swal("Oops...", "Something went wrong!", "error");
							}
						});
					}
				});
			})
			
		
		</script>
</body>
</html>
