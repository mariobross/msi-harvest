<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

	<!-- Sidebar mobile toggler -->
	<div class="sidebar-mobile-toggler text-center">
		<a href="#" class="sidebar-mobile-main-toggle">
			<i class="icon-arrow-left8"></i>
		</a>
		Navigation
		<a href="#" class="sidebar-mobile-expand">
			<i class="icon-screen-full"></i>
			<i class="icon-screen-normal"></i>
		</a>
	</div>
	<!-- /sidebar mobile toggler -->


	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- Main navigation -->
		<div class="card card-sidebar-mobile">
			<ul class="nav nav-sidebar" data-nav-type="accordion">

				<!-- Main -->
				<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
				<li class="nav-item">
					<a href="index.html" class="nav-link active">
						<i class="icon-home4"></i>
						<span>
							Home
						</span>
					</a>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Transaksi 1</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="Layouts">
						<li class="nav-item nav-item-submenu"><a href="#" class="nav-link active">EKSTERNAL</a>
							<ul class="nav nav-group-sub">
								<li class="nav-item"><a href="<?php echo base_url('/msi/inpofromvendor');?>" class="nav-link">In PO from Vendor</a></li>
								<li class="nav-item"><a href="#" class="nav-link">Good Receipt from Central Kitchen Sentul</a></li>
								<li class="nav-item"><a href="#" class="nav-link">Transfer Out Inter Outlet</a></li>
								<li class="nav-item"><a href="#" class="nav-link">Transfer In Inter Outlet</a></li>
								<li class="nav-item"><a href="<?php echo base_url('/msi/purchaserequest');?>" class="nav-link">Purchase Request (PR)</a></li>
								<li class="nav-item"><a href="../seed/sidebar_right.html" class="nav-link">Retur Out</a></li>
								<li class="nav-item"><a href="../seed/sidebar_right.html" class="nav-link">Retur In</a></li>
								<li class="nav-item"><a href="../seed/sidebar_right.html" class="nav-link">Good Issue</a></li>
								<li class="nav-item"><a href="../seed/sidebar_right.html" class="nav-link">Good Receipt Non PO</a></li>
							</ul>
						</li>
						<li class="nav-item nav-item-submenu"><a href="#" class="nav-link active">PRODUKSI</a>
							<ul class="nav nav-group-sub">
								<li class="nav-item"><a href="#" class="nav-link">Work Order</a></li>	
							</ul>
						</li>
						<li class="nav-item nav-item-submenu"><a href="#" class="nav-link active">STOCK OUTLET</a>
							<ul class="nav nav-group-sub">
								<li class="nav-item"><a href="#" class="nav-link">Stock Opname</a></li>
								<li class="nav-item"><a href="#" class="nav-link">Spoiled/Breakage/lost</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-color-sampler"></i> <span>Transaksi 2</span></a>
					<ul class="nav nav-group-sub">
						<li class="nav-item"><a href="../seed/sidebar_secondary.html" class="nav-link">Secondary sidebar</a></li>
						<li class="nav-item"><a href="../seed/sidebar_right.html" class="nav-link">Right sidebar</a></li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-stack"></i> <span>Master Data</span></a>

					<ul class="nav nav-group-sub" data-submenu-title="Starter kit">
						<li class="nav-item"><a href="<?php echo base_url('/master/manajemen');?>" class="nav-link">Manajeman Pengguna</a></li>
						<li class="nav-item"><a href="<?php echo base_url('/master/akses');?>" class="nav-link">Hak Akses</a></li>
						<li class="nav-item"><a href="../seed/sidebar_main.html" class="nav-link">Integration Log</a></li>
						<li class="nav-item"><a href="../seed/layout_boxed.html" class="nav-link">Master Konversi Item Whole ke Slice</a></li>
						<li class="nav-item"><a href="../seed/navbar_fixed_main.html" class="nav-link">Master Bill Of Materials</a></li>
					</ul>
				</li>
				<li class="nav-item nav-item-submenu">
					<a href="#" class="nav-link"><i class="icon-width"></i> <span>Report Summary</span></a>
					<ul class="nav nav-group-sub" data-submenu-title="Starter kit">
						<li class="nav-item"><a href="<?php echo site_url('/report/inventory');?>" class="nav-link">Inventory Audit</a></li>
						<li class="nav-item"><a href="<?php echo site_url('/report/bincard');?>" class="nav-link">Bincard Report</a></li>
						<li class="nav-item"><a href="<?php echo site_url('/report/onhand');?>" class="nav-link">Onhand Report</a></li>
					</ul>
				</li>
				<!-- /main -->
				
			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->
	
</div>