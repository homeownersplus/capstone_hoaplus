<!--------------------------- config here  ----------------------------->
<?php
session_start();
require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();


//inactiveposts
if (isset($_REQUEST['del'])) {
    $uid = intval($_GET['del']);
    $sql = "UPDATE tblusers SET status = 1 WHERE id=:id";
    $query = $dbh->prepare($sql);

    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert ('Post Successfully InActive!');</script>";
    echo "<script>window.location.href='adminlandingpage.php'</script>";
}

if (isset($_REQUEST['active'])) {
    $uid = intval($_GET['active']);
    $sql = "UPDATE tblusers SET status = 0 WHERE id=:id";
    $query = $dbh->prepare($sql);

    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert ('Post Successfully Active!');</script>";
    echo "<script>window.location.href='adminlandingpage.php'</script>";
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> HOA+ Admin </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
		integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<!-- Custom styles for this page -->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


	<!-- <link href="style_postboard.css" rel="stylesheet"> -->
</head>

<!--------------------------- left navigation  ----------------------------->

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
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

			<li class="nav-item">
				<a class="nav-link" href="manageadminss.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Manage Admins</span></a>
			</li>
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
					<span>Add an Amenity </span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="admininboxforconcerns.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Inbox </span></a>
			</li>
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

			<?php
            //    require_once('session.php');
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

					<!-- Topbar Search
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<!-- Nav Item - Search Dropdown (Visible Only XS) -->
						<li class="nav-item dropdown no-arrow d-sm-none">
							<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-search fa-fw"></i>
							</a>
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


						<!---adminlogin fetch--->

						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<span
									class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["logged_user"]["username"] ?></span>
								<img class="img-profile rounded-circle" src="photos/profile.png">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="admineditprofile.php">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile
								</a>

								<a class="dropdown-item" href="adminactivitylogs.php">
									<i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
									Activity Log
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

					<h1 class="h3 mb-4 text-gray-800">Manage Posts</h1>
					<a class="btn btn-primary" href="adminaddpost.php">Add Post
						<i class="fas fa-plus"></i></a>

					<!---alert messages--->
					<?php

                    if (isset($_SESSION['message'])) {
                    ?>
					<div class="alert alert-warning alert-dismissible fade show text-center" role="alert"
						style="margin-top:20px;">
						<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>


						<?php echo $_SESSION['message']; ?>
					</div>
					<?php

                        unset($_SESSION['message']);
                    }
                    ?>




					<!-- DataTales Example -->
					<div class="card shadow mb-4" style="margin-top:2%;">

						<div class="card-body">

							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

									<table class="table" id="example1" style="margin-top:2%;">
										<thead>
											<th>#</th>
											<th>Image</th>
											<th>Post Title</th>
											<th>Post Date</th>
											<th>
												<center>Perform Actions</center>
											</th>
										</thead>
										<tbody>
											<?php




                                            $rows = $model->displayUsers();

                                            $cnt = 1;
                                            if (!empty($rows)) {
                                                foreach ($rows as $row) {
                                            ?>
											<tr>
												<td><?php echo htmlentities($cnt); ?></td>
												<td><img src="./assets/images/<?php echo $row['Photo']; ?>.jpg"
														style="width: 150px;height: 100px; object-fit: cover;"></td>
												<td><?php echo $row['ptitle']; ?></td>

												<td><?php echo $row['PostingDate']; ?></td>

												<td>
													<center>

														<a href="adminupdateposts.php?id=<?php echo $row['id']; ?>"
															class="btn btn-primary btn-sm"><span class="fas fa-edit"></span></a>



														<?php

                                                                if ($row['status'] == 0) {
                                                                ?>
														<a href="adminlandingpage.php?del=<?php echo $row['id']; ?>" class="btn btn-success btn-sm"
															onClick="return confirm('Do you really want to make this post Inactive?')"><span
																class="fas fa-pause"></span></a>
														<?php

                                                                } else {
                                                                ?>
														<a href="adminlandingpage.php?active=<?php echo $row['id']; ?>"
															class="btn btn-danger btn-sm"
															onClick="return confirm('Do you really want to make this post Active?')"><span
																class="fas fa-play"></span></a>
														<?php

                                                                }

                                                                ?>








													</center>
												</td>
											</tr>

											<?php
                                                    $cnt++;
                                                }
                                            }
                                            ?>

										</tbody>
									</table>



							</div>
						</div>






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
						<a class="btn btn-primary" href="logout.php">Logout</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap core JavaScript-->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Core plugin JavaScript-->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

		<!-- Custom scripts for all pages-->
		<script src="js/sb-admin-2.min.js"></script>

		<!-- Page level plugins -->
		<script src="vendor/datatables/jquery.dataTables.min.js"></script>
		<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

		<!-- Page level custom scripts -->
		<script src="js/demo/datatables-demo.js"></script>

</body>


</html>