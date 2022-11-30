<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fa fa-home" aria-hidden="true"></i>
		</div>
		<div class="sidebar-brand-text mx-3">HOA+ Admin <sup></sup></div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="adminlandingpage.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Manage Posts</span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="admin_managemembers.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Members</span></a>
	</li>
	<?php if (in_array($_SESSION["logged_user"]["position"] ?? "admin", ["admin", "president"])) : ?>
	<li class="nav-item">
		<a class="nav-link" href="manageadminss.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Manage Admins</span></a>
	</li>
	<?php endif; ?>
	<li class="nav-item">
		<a class="nav-link" href="admin_managepayments.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Payments</span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="adminreservationstable.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Reservations</span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="admin_addamenities.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Add Amenity </span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="admininboxforconcerns.php">
			<i class="fas fa-fw fa-tachometer-alt"></i>
			<span>Inbox </span></a>
	</li>
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>