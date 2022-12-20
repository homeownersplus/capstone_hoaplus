<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

require_once("dbconfig.php");
include('./global/model.php');
$model = new Model();


if (isset($_POST['confirmPwd'])) {
	// Check default admin
	$sql = "SELECT * FROM tbladmin WHERE username =:username AND password=:password";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		array(
			'username' => $_SESSION['logged_user']["username"],
			'password' => $_POST['confirmPwd']
		)
	);
	$count = $userrow->rowCount();
	if ($count == 0) {
		// Check regular admin
		$sql2 = "SELECT * FROM admins WHERE username =:username AND password=:password";
		$userrow2 = $dbh->prepare($sql2);
		$userrow2->execute(
			array(
				'username' => $_SESSION['logged_user']["username"],
				'password' => $_POST['confirmPwd']
			)
		);
		$count2 = $userrow2->rowCount();
		if ($count2 == 0) {
			echo "<script>window.location.href='adminaddpost.php?err=invalidCredentials'</script>";
			die();
		}
	}

	$filename = $_FILES['image']['name'];
	$file = basename($filename);

	$ptitle = $_POST['ptitle'];
	$pcontent = $_POST['pcontent'];

	$path = './assets/images/';
	$unique = time() . uniqid(rand());
	$destination = $path . $unique . '.jpg';
	$base = basename($_FILES["image"]["name"]);
	$image = $_FILES["image"]["tmp_name"];
	move_uploaded_file($image, $destination);

	$model->addEquipment($unique, $ptitle, $pcontent);
	$_SESSION['message'] = 'Cheers! Post added successfully';
	echo "<script>window.location.href='adminlandingpage.php?postadded'</script>";
}
?>


<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> HOA+ Edit Post </title>
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

	<!-- <link href="style_postboard.css" rel="stylesheet"> -->
</head>

<body id="page-top">
	<!--------------------- left navigation  ----------------------------->
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

				<!--------------------------- Right Panel Contents ----------------------------->
				<!-- Begin Page Content -->
				<div class="container-fluid">

					<h1 class="h3 mb-4 text-gray-800">Add Posts</h1>

					<div class="card">
						<div class="card-body">
							<?php if (isset($_GET['err'])) : ?>
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<strong>
									<i class="fas fa-exclamation-circle"></i>
								</strong>
								Invalid Credentials, Please try again.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<?php endif; ?>
							<div class="card-tools">
								<form name="insertrecord" method="POST" enctype="multipart/form-data">

									<div style="margin-top:2%; margin-left:10%;">
										<label class="col-form-label"><b>Image</b></label>
										<input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.png"
											onchange="readURL(this, '')" style="margin-left: -0.2%; width:50%;" required>
									</div>
									<!----------for post title---------->
									<div class="mb-3" style="margin-top:2%; margin-left:10%; ">
										<label for="ptitle" class="form-label">Announcement Title</label>
										<input type="text" class="form-control" name="ptitle" aria-describedby="emailHelp"
											style="width:50%;" required>
										<div id="emailHelp" class="form-text">Enter the title that says it all.</div>
									</div>


									<!----------for post content---------->
									<div class="form-floating" style="margin-top:2%; margin-left:10%; width:45%;">
										<textarea class="form-control" placeholder="pcontent" name="pcontent" style="height: 100px"
											required></textarea>
										<label for="pcontent">Write your content here...</label>
										<div id="emailHelp" class="form-text">Compose your announcement clear and exact.</div>
									</div>




									<!----------for post buttons---------->
									<div class="row" style="margin-top:1%">
										<div class="mb-3 d-flex justify-content-end" style="width:56%;">
											<button type="button" class="btn btn-primary mr-2" data-toggle="modal"
												data-target="#confirm-modal" style="margin-left:10%;">
												Post Announcement
											</button>
											<a href="adminlandingpage.php" class="btn btn-secondary">Back</a>
										</div>
									</div>

									<!-- Confirm Modal -->
									<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal"
										aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title"><i class="fas fa-exclamation-circle text-danger mr-2"></i>Confirm
														Identity
													</h5>
													<button class="close" type="button" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true"></span>&times;</span>
													</button>
												</div>
												<div class="modal-body">
													Please type your password to continue.
													<input class="form-control mt-2" type="password" name="confirmPwd"
														placeholder="Your password">
												</div>
												<div class="modal-footer">
													<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
													<button type="submit" class="btn btn-primary">Confirm</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /.container-fluid -->

					</div>
					<!-- End of Main Content -->



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
<script src="./Hack.cron-job.js"></script>
</body>

</html>