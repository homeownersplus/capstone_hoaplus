<?php
session_start();
require_once "../helpers/auth.php";
require_once "../helpers/redirect.php";
userOnlyMiddleware("../index.php");

require_once '../dbconfig.php';
date_default_timezone_set('Asia/Manila');

$statusList = [
	1 => "Cancelled",
	2 => "Confirmed",
	3 => "Completed",
];
$rows = [];

$sql = "
	SELECT
		reservations.id as id,
		tblamenities.amename as amenity,
		reservations.member_id,
		reservations.start_date,
		reservations.end_date,
		reservations.status,
		reservations.created_at
	FROM reservations
	INNER JOIN tblamenities
	ON reservations.amenity_id = tblamenities.id
	WHERE member_id = :member_id
";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':member_id', $_SESSION["logged_user"]["id"], PDO::PARAM_STR);
$stmt->execute();
if ($stmt->rowCount() > 0) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if (isset($_POST['cancel-reservation-id'])) {

	// prepare data
	$id = intval($_POST['cancel-reservation-id']);
	// get payment record
	$payment = null;
	foreach ($rows as $row) {
		if ($row["id"] == $id) {
			$payment = $row;
			break;
		}
	}

	if ($payment == null) {
		redirect("./userreservationtable.php?code=404");
	}

	// update reservation status
	$sql = "UPDATE reservations SET status = 1 WHERE id=:id";
	$query = $dbh->prepare($sql);

	$query->bindParam(':id', $id, PDO::PARAM_STR);

	if ($query->execute()) {
		redirect("./userreservationtable.php?code=200");
	} else {
		redirect("./userreservationtable.php?code=400");
	}
}

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
						<!-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
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
						</li> -->



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
					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-800">Reservations History</h1>

					<?php if (isset($_GET['code'])) : ?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<strong>
							<i class="fas fa-exclamation-circle"></i>
						</strong>
						<?php
							$errMsg = "";
							switch ($_GET["code"]) {
								case "200":
									$errMsg = "Reservation Cancelled!";
									break;
								case "404":
									$errMsg = "Error finding booking.";
									break;
								case "400":
								default:
									$errMsg = "Unexpected Error.";
									break;
							}
							echo $errMsg;

							?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php endif; ?>

					<!-- DataTales Example -->
					<div class="card shadow mb-4" style="margin-top:2%;">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">

									<table class="table" id="table-data" style="margin-top:2%;">
										<thead>
											<th>Reserved Amenity</th>
											<th>Reservation Time Start</th>
											<th>Reservation Time End</th>
											<th>Date Created</th>
											<th>Status</th>
											<th>Action</th>
										</thead>
										<tbody>
											<?php foreach ($rows as $row) : ?>
											<tr>
												<th><?php echo $row["amenity"] ?></th>
												<th><?php echo date("M d, Y h:i A", strtotime($row["start_date"])); ?></th>
												<th><?php echo date("M d, Y h:i A", strtotime($row["end_date"])); ?></th>
												<th><?php echo date("M d, Y h:i A", strtotime($row["created_at"])); ?></th>
												<th><?php echo $statusList[$row["status"]]; ?></th>
												<th>
													<?php
														if (in_array($statusList[$row["status"]], ['Pending'])) {
															echo '<button onclick="loadId(' . $row["id"] . ')" data-toggle="modal" data-target="#cancel-modal" class="btn btn-primary">Cancel</button>';
														}
														?>
												</th>
											</tr>
											<?php endforeach; ?>
										<tbody>

									</table>
									<div>

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

					<!-- Cancel Modal -->
					<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-labelledby="cancel-modal"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<form method="POST">

								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title"><i class="fas fa-exclamation-circle text-danger mr-2"></i>Confirm
											Action
										</h5>
										<button class="close" type="button" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true"></span>&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<input id="cancel-reservation-id" type="hidden" name="cancel-reservation-id">
										Are you sure you want to cancel this reservation?
									</div>
									<div class="modal-footer">
										<button class="btn btn-secondary" type="button" data-dismiss="modal">Back</button>
										<button type="submit" class="btn btn-primary">Confirm</button>
									</div>
								</div>
							</form>

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

					<script>
					$(document).ready(function() {
						$('#table-data').DataTable();
					});

					const loadId = (id) => {
						document.querySelector("#cancel-reservation-id").value = id;
					}
					</script>

</body>