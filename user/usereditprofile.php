<?php
session_start();
require_once '../dbconfig.php';
require_once "../helpers/auth.php";
require_once "../helpers/redirect.php";
userOnlyMiddleware("../index.php");

// Payment History
$paymentSql = "
SELECT
	date_paid,
	date_due,
	DATE_ADD(date_due, INTERVAL 1 MONTH) as next_due
FROM payments
WHERE member_id = :member_id
AND date_paid IS NOT NULL
ORDER BY id DESC
LIMIT 1
";
$paymentStmt = $dbh->prepare($paymentSql);
$paymentStmt->execute(
	[
		'member_id' => $_SESSION["logged_user"]["id"],
	]
);
$payment = $paymentStmt->fetch(PDO::FETCH_ASSOC);



$action = $_POST["action"] ?? null;
if ($action == "update_photo") {
	$target_file = "../photos/" . basename($_FILES["image"]["name"]);
	$newFileName = uniqid(uniqid(rand()));
	$file_path = "../photos/" . $newFileName;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	$fileName = $newFileName . "." . $imageFileType;

	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if ($check == false) {
		redirect("./usereditprofile.php?errCode=100");
	}

	if (file_exists($target_file)) {
		redirect("./usereditprofile.php?errCode=101");
	}

	if ($_FILES["image"]["size"] > 5000000) {
		redirect("./usereditprofile.php?errCode=102");
	}

	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		redirect("./usereditprofile.php?errCode=103");
	}


	if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file_path . "." . $imageFileType)) {
		redirect("./usereditprofile.php?errCode=104");
	} else {
		$sql = "
		UPDATE user
		SET avatar=?
		WHERE id=?
		";
		$stmt = $dbh->prepare($sql);
		$stmt->execute([
			$fileName,
			$_SESSION["logged_user"]["id"],
		]);

		$count = $stmt->rowCount();
		if ($count > 0) {
			redirect("./usereditprofile.php?errCode=106");
		}
		redirect("./usereditprofile.php?errCode=105");
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
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
				<div class="sidebar-brand-icon rotate-n-15"> <i class="fa fa-home" aria-hidden="true"></i> </div>
				<div class="sidebar-brand-text mx-3">HOA+Member <sup></sup></div>
			</a>
			<!-- Divider -->
			<hr class="sidebar-divider my-0">
			<!-- Nav Item - Dashboard -->
			<li class="nav-item">
				<a class="nav-link" href="userlandingpage.php">
					<i class="fa fa-bullhorn" aria-hidden="true"></i>
					<span>Announcements</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="userpayments.php">
					<i class="fa fa-heart" aria-hidden="true"></i>
					<span>Payments</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userreservations.php">
					<i class="fa fa-ticket" aria-hidden="true"></i>
					<span>Reserve Amenity</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userreservationtable.php">
					<i class="fa fa-history" aria-hidden="true"></i>
					<span>Reservation History</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userconcernform.php">
					<i class="fa fa-comments" aria-hidden="true"></i>
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
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"> <i class="fa fa-bars"></i>
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
										<button class="btn btn-primary" type="button"> <i class="fas fa-search fa-sm"></i> </button>
									</div>
								</div>
							</form>
						</div>
						</li>
						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false"> <span
									class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["logged_user"]["username"] ?></span>
								<img class="img-profile rounded-circle"
									src="<?php echo $_SESSION["logged_user"]["avatar"] ? "../photos/" . $_SESSION["logged_user"]["avatar"] : '../photos/profile.png' ?>">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="usereditprofile.php"> <i
										class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile </a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"> <i
										class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </a>
							</div>
						</li>
					</ul>
				</nav>
				<!-- End of Topbar -->
				<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-- Page Heading -->
					<div class="container-fluid py-4">
						<div class="row">
							<div class="col-md-8">
								<div class="card">
									<div class="card-header pb-0">
										<div class="d-flex align-items-center">
											<!-- <p class="mb-0">Edit Profile</p>
								<button class="btn btn-primary btn-sm ms-auto">Settings</button> -->
										</div>
									</div>

									<div class="card-body">
										<p class="text-uppercase text-sm">HOA Member Information</p>
										<div class="row justify-content-center">
											<!-- <div class="col-4 col-lg-4 order-lg-2"> -->
											<div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
												<form method="POST" enctype="multipart/form-data">
													<?php if (isset($_GET["errCode"])) : ?>
													<div class="alert alert-warning m-2" role="alert">
														<?php
															$errMsg = "";
															switch ($_GET["errCode"]) {
																case "100":
																	$errMsg = "File is not an image";
																	break;
																case "101":
																	$errMsg = "File name already exists";
																	break;
																case "102":
																	$errMsg = "File is too large, over 5MB";
																	break;
																case "103":
																	$errMsg = "Sorry, only JPG, JPEG, and PNG files are allowed.";
																	break;
																case "104":
																	$errMsg = "Error Saving File";
																	break;
																case "105":
																	$errMsg = "Error Updating Database File";
																	break;
																case "106":
																	$errMsg = "Success, you must relogin for the changes to take effect";
																	break;
																default:
																	$errMsg = "Unexpected Error";
																	break;
															}
															echo $errMsg;
															?>
													</div>
													<?php endif; ?>
													<input type="hidden" name="action" value="update_photo">
													<img id="img-preview"
														src="<?php echo $_SESSION["logged_user"]["avatar"] ? "../photos/" . $_SESSION["logged_user"]["avatar"] : '../photos/profile.png' ?>"
														class="img-fluid rounded-circle"
														style="width: 150px;height: 150px; margin-left: 25%; margin-top:10%;">
													<input id="img-input" class="form-control" type="file" name="image" accept=".png, .jpg, .jpeg"
														onchange="previewFile()"
														style="border: 0px; padding: 3px; margin-top:3%; margin-top:10%; margin-left:5%; width:90%;"
														required>
													<div class="mb-3" style="margin-top:10%;">
														<button id="img-button" class="btn btn-outline-primary invisible" type="submit"
															style="margin-left:23%;">
															Update Photo
														</button>
													</div>
												</form>

												<hr class=" horizontal dark mt-0">
											</div>
										</div>
									</div>

									<div class="row">

										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Username</label>
												<input class="form-control" type="text"
													value="<?php echo $_SESSION["logged_user"]["username"] ?>" disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Email address</label>
												<input class="form-control" type="email"
													value=" <?php echo $_SESSION["logged_user"]["email"] ?>" disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Full Name</label>
												<input class="form-control" type="text"
													value="<?php echo $_SESSION["logged_user"]["first_name"] . " " . $_SESSION["logged_user"]["middle_initial"] . " " . $_SESSION["logged_user"]["last_name"] ?>"
													disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Member ID</label>
												<input class="form-control" type="text"
													value="HOAM<?php echo str_pad($_SESSION["logged_user"]["id"], 4, "0", STR_PAD_LEFT) ?>"
													disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Last Payment Date</label>
												<input class="form-control" type="text" value="<?php echo $payment["date_due"]; ?>" disabled>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Next Payment Date</label>
												<input class="form-control" type="text" value="<?php echo $payment["next_due"]; ?>" disabled>
											</div>
										</div>
									</div>

									<hr class="horizontal dark">
									<p class="text-uppercase text-sm">Member Information</p>
									<div class="row">

										<div class="col-md-12">
											<div class="form-group"> </div>
											<label for="example-text-input" class="form-control-label">Email Address</label>
											<input class="form-control" type="email" value="<?php echo $_SESSION["logged_user"]["email"] ?>"
												disabled>
										</div>
										<div class="col-md-4">
											<div class="form-group"> </div>
											<label for="example-text-input" class="form-control-label">Contact Number</label>
											<input class="form-control" type="text"
												value="<?php echo $_SESSION["logged_user"]["contact_number"] ?>" disabled>
										</div>

										<div class="col-md-4">
											<div class="form-group"> </div>
											<label for="example-text-input" class="form-control-label">Phase Lot Block</label>
											<input class="form-control" type="text"
												value="<?php echo $_SESSION["logged_user"]["phase"] . ", " . $_SESSION["logged_user"]["block"] . ", " . $_SESSION["logged_user"]["lot"] ?>"
												disabled>
										</div>

										<div class="col-md-4">
											<div class="form-group"> </div>
											<label for="example-text-input" class="form-control-label">Barangay</label>
											<input class="form-control" type="text" value="<?php echo $_SESSION["logged_user"]["barangay"] ?>"
												disabled>
										</div>

									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<!-- /.container-fluid -->
	</div>
	</div>
	</div>
	<!-- End of Main Content -->
	<!-- Footer -->
	<footer class="sticky-footer bg-white">
		<div class="container my-auto">
			<div class="copyright text-center my-auto"> <span> Capstone 2022</span> </div>
		</div>
	</footer>
	<!-- End of Footer -->
	</div>
	</div>
	<!-- End of Content Wrapper -->
	</div>
	</div>
	<!-- End of Page Wrapper -->
	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i> </a>
	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button> <a
						class="btn btn-primary" href="../logout.php">Logout</a>
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

	<script>
	function previewFile() {
		const preview = document.querySelector('#img-preview');
		const btn = document.querySelector('#img-button');
		const file = document.querySelector('#img-input').files[0];
		const reader = new FileReader();

		reader.addEventListener("load", () => {
			preview.src = reader.result;
		}, false);

		if (file) {
			reader.readAsDataURL(file);
			btn.classList.remove("invisible");
		}
	}
	</script>
</body>