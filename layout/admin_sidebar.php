<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="./index.php">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fa fa-home" aria-hidden="true"></i>
		</div>
		<div class="sidebar-brand-text mx-3">HOA+ Admin <sup></sup></div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item">
		<a class="nav-link" href="admin_dashboard.php">
			<i class="fa fa-bullhorn" aria-hidden="true"></i>
			<span>Dashboard</span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="adminlandingpage.php">
			<i class="fa fa-bullhorn" aria-hidden="true"></i>
			<span>Announcements</span></a>
	</li>
	<?php if (!in_array(strtolower($_SESSION["logged_position"]), ["admin", "president"])) : ?>
	<li class="nav-item">
		<a class="nav-link" href="admin_managemembers.php">
			<i class="fa fa-users" aria-hidden="true"></i>
			<span>User Accounts</span></a>
	</li>
	<?php endif; ?>

	<?php if (in_array(strtolower($_SESSION["logged_position"]), ["admin", "president"])) : ?>
	<li class="nav-item">
		<a class="nav-link" href="admin_manageaccounts.php">
			<i class="fa fa-user" aria-hidden="true"></i>
			<span>User Accounts</span></a>
	</li>
	<?php endif; ?>
	<li class="nav-item">
		<a class="nav-link" href="admin_managepayments.php">
			<i class="fa fa-heart" aria-hidden="true"></i>
			<span>Payments</span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="adminreservationstable.php">
			<i class="fa fa-ticket" aria-hidden="true"></i>
			<span>Reservations</span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="admin_addamenities.php">
			<i class="fa fa-building" aria-hidden="true"></i>
			<span>Manage Amenity </span></a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="admininboxforconcerns.php">
			<i class="fa fa-comments" aria-hidden="true"></i>
			<span>Inbox </span></a>
	</li>
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>