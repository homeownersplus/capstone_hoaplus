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


	<style>
	.left-col {
		float: left;
		width: 25%;
	}

	.center-col {
		float: left;
		width: 50%;
	}

	.right-col {
		float: left;
		width: 25%;
	}
	</style>
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
<<<<<<< HEAD
						<h1 class="font-weight-bold">Manage Amenities</h1>
						<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
=======
						<h1 class="h3 mb-0 text-gray-800">Manage Available Amenities</h1>
						<a class="btn btn-primary" href="adminaddamenity_form.php">Add Amenity
							<i class="fas fa-plus"></i></a>
>>>>>>> 272f0464d4a4aba853c1cfb36b26a29d24502bc6
					</div>


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
							<div class="form-group d-flex justify-content-between align-items-center">

								<div class="d-flex input-daterange">
									<input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd"
										placeholder="From:">
									<input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd"
										placeholder="To:">
								</div>
								<button class="btn btn-primary" onclick="generatePdf()">Generate
									Report</button>

							</div>

							<table class="table" id="table-data" style="margin-top:2%;">
								<thead>
									<th>#</th>
									<th>Photo</th>
									<th>Name</th>
									<th>Adding Date</th>
									<th>Perform Actions</th>
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
										<td><?php echo date("Y-m-d", strtotime($row["PostingDate"])); ?></td>
										<td>
											<a href="./admineditamenity_form.php?q=<?php echo $row["id"] ?>"
												class="btn btn-outline-primary btn-sm">Edit</a>
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
	<!-- <script src="js/demo/datatables-demo.js"></script> -->
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
	<!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
	<!-- <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
		integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>
	const loggedUser = '<?php echo $_SESSION["logged_user"]["username"] ?>';

	$('.input-daterange input').each(function() {
		$(this).datepicker('clearDates');
	});

	var table = $('#table-data').DataTable({
		"dom": '<"top"<"left-col"l><"center-col"B><"right-col">>frt<"bottom"<"left-col"i><p>>',
		buttons: [{
			extend: 'pdf',
			text: 'Generate Report',
			className: "btn btn-primary invisible pdf-generate-btn",
			exportOptions: {
				columns: [0, 2, 3],
				columnGap: 1
			},
			customize: function(doc) {
				const date = moment().format("MMMM Do YYYY, h:mm:ss a");
				doc.content.splice(0, 1, {
					text: [{
						text: 'HOA+ AMENITIES REPORT \n',
						bold: true,
						fontSize: 16
					}, {
						text: ` As of ${date} \n`,
						bold: false,
						fontSize: 9
					}, {
						text: `Generated By: ${loggedUser}`,
						bold: false,
						fontSize: 9
					}],
					margin: [0, 0, 0, 12],
					alignment: 'center'
				});
			},
		}],
		'lengthMenu': [
			[10, 25, 50, -1],
			[10, 25, 50, "All"]
		]
	});

	// Extend dataTables search
	$.fn.dataTable.ext.search.push(
		function(settings, data, dataIndex) {
			var min = $('#min-date').val();
			var max = $('#max-date').val();
			var createdAt = data[3] || 0; // Our date column in the table

			// Filter by date range
			if (
				(min == "" || max == "") ||
				(moment(createdAt).isSameOrAfter(min, "day") && moment(createdAt).isSameOrBefore(max, "day"))
			) {
				return true;
			}
			return false;
		}
	);

	// Re-draw the table when the a date range filter changes
	$('.date-range-filter').change(function() {
		table.draw();
	});

	$('#my-table_filter').hide();

	const generatePdf = () => {
		document.querySelector('.pdf-generate-btn').click()
	}
	</script>
</body>


</html>