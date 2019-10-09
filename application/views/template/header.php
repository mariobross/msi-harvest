<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Harvest MSI </title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('/files/');?>global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('/files/');?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('/files/');?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('/files/');?>assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('/files/');?>assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('/files/');?>assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<script src="<?php echo base_url()?>files/global_assets/js/main/jquery.min.js"></script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<!-- Core JS files -->
	<script src="<?php echo base_url('/files/');?>global_assets/js/main/jquery.min.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/plugins/pickers/daterangepicker.js"></script>

	<script src="<?php echo base_url('/files/');?>assets/js/app.js"></script>
	<script src="<?php echo base_url('/files/');?>global_assets/js/demo_pages/dashboard.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a href="index.html" class="d-inline-block">
				<h2>YBC SAP Portal</h2>
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<span class="navbar-text ml-md-3 mr-md-auto">	
			</span>
			<?php if(isset($this->session->userdata['user'])){ ?>
				<ul class="navbar-nav">
					<li class="nav-item dropdown dropdown-user">
						<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
							<img src="../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="">
							<span>Alam Sutra Manager (SX Alam)</span>
						</a>

						<div class="dropdown-menu dropdown-menu-right">
							<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
							<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
							<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
							<a href="#" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
						</div>
					</li>
				</ul>
			<?php }else{}?>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		
		<!-- /main sidebar -->

	