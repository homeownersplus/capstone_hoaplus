<?php
session_start();
require_once "../helpers/auth.php";
require_once "../helpers/redirect.php";
userOnlyMiddleware("../index.php");
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> HOA+ Member </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
		integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Custom fonts for this template-->
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="../css/sb-admin-2.min.css" rel="stylesheet">

	<!-- Custom styles for this page -->
	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


	<!-- <link href="style_postboard.css" rel="stylesheet"> -->


</head>

<!--------------------------- left navigation  ----------------------------->

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fa fa-home" aria-hidden="true"></i>
				</div>
				<div class="sidebar-brand-text mx-3">HOA+Member <sup></sup></div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<li class="nav-item">
				<a class="nav-link" href="userlandingpage.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Announcements</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="userpayments.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Payments</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userreservations.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Reserve Amenity</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userreservationtable.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Reservation History</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userconcernform.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Send a Message </span></a>
			</li>


			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

			<?php
			// require_once('session.php');
			//require_once('search.php');

			?>
		</ul>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>


					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<!-- Dropdown - Messages -->
						<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
							aria-labelledby="searchDropdown">
							<form class="form-inline mr-auto w-100 navbar-search">
								<div class="input-group">
									<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
										aria-label="Search" aria-describedby="basic-addon2">
									<div class="input-group-append">
										<button class="btn btn-primary" type="button">
											<i class="fas fa-search fa-sm"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
						</li>



						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<span
									class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["logged_user"]["username"] ?></span>
								<img class="img-profile rounded-circle"
									src="<?php echo $_SESSION["logged_user"]["avatar"] ? "../photos/" . $_SESSION["logged_user"]["avatar"] : '../photos/profile.png' ?>">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="usereditprofile.php">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile
								</a>


								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Logout
								</a>
							</div>
						</li>

					</ul>

				</nav>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-- <div class="jumbotron">
             -->
					<!-- <div class="card">
                <div class="card-body">
          <div class="card-tools"> -->
					<!-- Page Heading -->


					<h1 class="h3 mb-4 text-gray-800">Send a message</h1>
					<!-- <input class="btn btn-outline-primary" type="submit" value="Generate E-Pass" name="reserveamenityusr" style="margin-top:-10%; margin-left:85%;"  > -->

					<div class="card shadow mb-4" style="margin-top:2%;">

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

									<form name="reserveamenityusr" method="POST" enctype="multipart/form-data">
										<!-- <fieldset disabled> -->

										<div class="mb-3" style="width:100%;">
											<label for="disabledTextInput" class="form-label">Member Email</label>
											<input type="text" id="disabledTextInput" class="form-control"
												placeholder="fetch logged in user email here" disabled>
										</div>

										<div class="mb-3" style="width:100%;">
											<label for="disabledTextInput" class="form-label">Member Fullname</label>
											<input type="text" id="disabledTextInput" class="form-control"
												placeholder="fetch logged in full name here" disabled>
										</div>


										<!-- <div >
                <label class="col-form-label"><b>Attach Report Image</b></label>
										<input class="form-control" type="file" name="image" accept="image/*" onchange="readURL(this, '')" >
                </div> -->


										<div class="form-floating" style="margin-top:3%;">
											<textarea class="form-control" name="pconcern" required></textarea>
											<label for="pconcern">Write your concern here...</label>
											<div id="emailHelp" class="form-text">Compose your concern short but precise.</div>
										</div>

										<div>


											<div style="margin-top:3%">
												<input class="btn btn-primary" type="submit" value="Send message" name="userreportconcern">
												<a href="userlandingpage.php" class="btn btn-secondary">Back</a>

											</div>
											<!-- /.container-fluid -->

										</div>
										<!-- End of Main Content -->

										<!-- Footer -->
										<footer class="sticky-footer bg-white">
											<div class="container my-auto">
												<div class="copyright text-center my-auto">
													<span>Copyright &copy; Capstone 2022</span>
												</div>
											</div>
										</footer>
										<!-- End of Footer -->

							</div>
							<!-- End of Content Wrapper -->

						</div>
						<!-- End of Page Wrapper -->

						<!-- Scroll to Top Button-->
						<a class="scroll-to-top rounded" href="#page-top">
							<i class="fas fa-angle-up"></i>
						</a>

						<!-- Logout Modal-->
						<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
							aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
										<button class="close" type="button" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
									<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
										<a class="btn btn-primary" href="../logout.php">Logout</a>
									</div>
								</div>
							</div>
						</div>

						<!-- Bootstrap core JavaScript-->
						<script src="../vendor/jquery/jquery.min.js"></script>
						<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

						<!-- Core plugin JavaScript-->
						<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

						<!-- Custom scripts for all pages-->
						<script src="../js/sb-admin-2.min.js"></script>

						<!-- Page level plugins -->
						<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
						<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

						<!-- Page level custom scripts -->
						<script src="../js/demo/datatables-demo.js"></script>
						<link rel="stylesheet"
							href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

</body>