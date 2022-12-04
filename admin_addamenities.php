<!--------------------------- config here  ----------------------------->
<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();

// if (isset($_REQUEST['del'])){
//     $uid =intval($_GET['del']);
//     $sql = "DELETE FROM tbldump WHERE id=:id";
//     $query=$dbh->prepare($sql);

//     $query->bindParam(':id', $uid, PDO::PARAM_STR);
//     $query->execute();

//     echo "<script>alert ('Post Successfully Deleted!');</script>";
//     echo "<script>window.location.href='adminposts.php'</script>";

//secondchange
// }

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
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="font-weight-bold">Manage Amenities</h1>
						<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
					</div>
					<a class="btn btn-primary" href="adminaddamenity_form.php">Add Amenity
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
											<th>Amenity Photo</th>
											<th>Amenity Name</th>
											<th>Adding Date</th>
											<!-- <th><center>Perform Actions</center></th> -->
										</thead>
										<tbody>
											<?php




											$rows = $model->displayAment();

											$cnt = 1;
											if (!empty($rows)) {
												foreach ($rows as $row) {
											?>
											<tr>
												<td><?php echo htmlentities($cnt); ?></td>
												<td><img src="./assets/images/<?php echo $row['Photo']; ?>.jpg"
														style="width: 150px;height: 100px; object-fit: cover;"></td>
												<td><?php echo $row['amename']; ?></td>
												<td><?php echo $row['PostingDate']; ?></td>




												<td>
													<center>

														<!-- <a href="adminupdateposts.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><span class="fas fa-edit"></span></a>
						<a href="adminposts.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Do you really want to delete?')"><span class="fas fa-trash"></span></a> -->

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


</html>