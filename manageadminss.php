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
				<!--------------------------- Right Panel Contents ----------------------------->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 text-gray-800">Manage Admin</h1>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnew">
							Add New Admin
						</button>
					</div>

					<div class="card">
						<div class="card-body">
							<!---alert messages--->
							<?php

							if (isset($_SESSION['message'])) {
							?>
							<div class="alert alert-warning alert-dismissible fade show text-center" role="alert"
								style="margin-top:20px;">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>


								<?php echo $_SESSION['message']; ?>
							</div>
							<?php

								unset($_SESSION['message']);
							}
							?>



							<!----------table here---------->

							<div class="table-responsive">
								<table class="table text-nowrap" style="margin-top: 3%;">
									<thead>
										<th>ID</th>
										<th>Username</th>
										<th>Fullname</th>
										<th>Email</th>
										<th>Position</th>
										<!-- <th>Password</th> -->
										<th>Action</th>
									</thead>
									<tbody>

										<!----------config---------->
										<?php
										include_once('dbconfig.php');

										$database = new Connection();
										$db = $database->open();
										try {
											$sql = 'SELECT * FROM admins';
											foreach ($db->query($sql) as $row) {
										?>
										<tr>
											<td>HOAADMIN <?php echo $row['id']; ?></td>
											<td><?php echo $row['username']; ?></td>
											<td><?php echo $row['fullname']; ?></td>
											<td><?php echo $row['email']; ?></td>
											<td><?php echo $row['position']; ?></td>
											<td>
												<a href="#edit_<?php echo $row['id']; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal">
													Edit</a>
												<a href="#delete_<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm"
													data-bs-toggle="modal"> Delete</a>
											</td>
											<?php include('edit_delete_modal.php'); ?>
										</tr>
										<?php
											}
										} catch (PDOException $e) {
											echo "There is some problem in connection: " . $e->getMessage();
										}

										//close connection
										$database->close();

										?>










									</tbody>
								</table>
							</div>
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

</body>


<?php include('add_modal.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
	integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="jquery.min.js"></script>

</body>

</html>