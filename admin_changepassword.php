<!--------------------------- config here  ----------------------------->
<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();
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
					<div class="container-fluid py-4">
						<div class="row">
							<div class="col-md-8">
								<div class="card">
									<div class="card-body">
										<div class="col-md-6">
											<p class="text-uppercase text-sm">Change password</p>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">Old password</label>
												<input class="form-control" type="password" id="old_pass">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="example-text-input" class="form-control-label">New password</label>
												<input class="form-control" type="password" id="new_pass">
											</div>
										</div>
										<div class="col-md-6">
											<button class="btn btn-primary float-right" onClick="handleChangePassword()">Update
												password</button>
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

	<script src="./Hack.cron-job.js"></script>
	<script>
	const handleChangePassword = async () => {
		const old = document.querySelector('#old_pass')
		const newp = document.querySelector('#new_pass')

		if (!old || !newp) return alert("Please fill up the fields")

		// const url = await fetch('./api/admin_updatepassword.php?old=' + old.value + '&new=' + newp.value)
		const url = await fetch('./api/admin_updatepassword.php', {
			method: "POST",
			headers: {
				"Content-type": "application/json",
				"Accepts": "application/json"
			},
			body: JSON.stringify({
				old: old.value,
				newp: newp.value
			})
		})
		const res = await url.json()

		alert(res?.message || "Error occured.")

		old.value = ''
		newp.value = ''
	}
	</script>
</body>

</html>