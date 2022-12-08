<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

$con = new mysqli("localhost", "root", "", "pdocrud");

$result = $con->query("SELECT * FROM `admins` WHERE id = " . $_SESSION['userid']);
$row = $result->fetch_assoc();

if (empty($row)) {
	$result = $con->query("SELECT * FROM `tbladmin` WHERE id = " . $_SESSION['userid']);
	$row = $result->fetch_assoc();
}

require_once './dbconfig.php';


$action = $_POST["action"] ?? null;
if ($action == "update_photo") {
	$target_file = "./photos/" . basename($_FILES["image"]["name"]);
	$newFileName = uniqid(uniqid(rand()));
	$file_path = "./photos/" . $newFileName;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	$fileName = $newFileName . "." . $imageFileType;

	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if ($check == false) {
		redirect("./admineditprofile.php?errCode=100");
	}

	if (file_exists($target_file)) {
		redirect("./admineditprofile.php?errCode=101");
	}

	if ($_FILES["image"]["size"] > 5000000) {
		redirect("./admineditprofile.php?errCode=102");
	}

	if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		redirect("./admineditprofile.php?errCode=103");
	}


	if (!move_uploaded_file($_FILES["image"]["tmp_name"], $file_path . "." . $imageFileType)) {
		redirect("./admineditprofile.php?errCode=104");
	} else {
		$sql = "
		UPDATE admins
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
			redirect("./admineditprofile.php?errCode=106");
		}
		redirect("./admineditprofile.php?errCode=105");
	}
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
		<?php require_once("./layout/admin_sidebar.php") ?>

		<!-- End of Sidebar -->
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<!-- Main Content -->
			<div id="content">
				<!-- Topbar -->
				<?php require_once("./layout/admin_topbar.php") ?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-800">Admin Profile</h1>
					<div class="container-fluid py-4">
						<div class="row">
							<div class="col-md-8">
								<div class="card">
									<div class="card-header pb-0">
										<div class="d-flex align-items-center">
										</div>
									</div>
									<div class="card-body">
										<p class="text-uppercase text-sm">Admin Information</p>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="example-text-input" class="form-control-label">Username</label>
													<input class="form-control" type="text" value="<?php echo $row['username'] ?? ''; ?>"
														disabled>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="example-text-input" class="form-control-label">Email address</label>
													<input class="form-control" type="email" value="<?php echo $row['email'] ?? ''; ?>" disabled>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="example-text-input" class="form-control-label">Full Name</label>
													<input class="form-control" type="text" value="<?php echo $row['fullname'] ?? ''; ?>"
														disabled>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="example-text-input" class="form-control-label">Position</label>
													<input class="form-control" type="text" value="<?php echo $row['position'] ?? ''; ?>"
														disabled>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="example-text-input" class="form-control-label">Admin ID</label>
													<input class="form-control" type="text" value="<?php echo $row['id'] ?? ''; ?>" disabled>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group"> </div>
											</div>
											<div class="col-md-4">
												<div class="form-group"> </div>
											</div>
											<div class="col-md-4">
												<div class="form-group"> </div>
											</div>
											<div class="col-md-4">
												<div class="form-group"> </div>
											</div>
										</div>
										<div class="row"> </div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card-profile">
									<!-- <img src="../assets/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top"> -->
									<div class="row justify-content-center">
										<!-- <div class="col-4 col-lg-4 order-lg-2"> -->
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
											<div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
												<?php if ($_SESSION['logged_position'] != "admin") : ?>
												<input type="hidden" name="action" value="update_photo">
												<img id="img-preview"
													src='<?php echo $_SESSION["logged_user"]["avatar"] ? "./photos/" . $_SESSION["logged_user"]["avatar"] : "./photos/profile.png" ?>'
													class="img-fluid rounded-circle"
													style="width: 150px;height: 150px; margin-left: 25%; margin-top:10%;">
												<h5 class="card-title" style="margin-top:7%; margin-left:20%"><?php echo $row['fullname']; ?>
												</h5>
												<input id="img-input" class="form-control" type="file" name="image" accept=".png, .jpg, .jpeg"
													onchange="previewFile()"
													style="border: 0px; padding: 3px; margin-top:3%; margin-top:10%; margin-left:5%; width:90%;"
													required>
												<div class="mb-3" style="margin-top:10%;">
													<button id="img-button" class="btn btn-primary invisible" type="submit"
														style="margin-left:23%;">
														Update Photo
													</button>
												</div>
												<?php endif; ?>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
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
		<!-- End of Content Wrapper -->
	</div>
	<!-- End of Page Wrapper -->
	<!-- Scroll to Top Button-->
	<?php require_once("./layout/admin_logout.php") ?>

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

</html>