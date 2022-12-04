<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

date_default_timezone_set('Asia/Manila');
require_once './dbconfig.php';

if (isset($_POST["delete_id"])) {
	$id = (int) $_POST["delete_id"];
	$sql = "DELETE FROM reservations WHERE id=?";
	$stmt = $dbh->prepare($sql);
	$stmt->execute([$id]);
}

if (isset($_POST["complete_id"])) {
	$id = (int) $_POST["complete_id"];
	$sql = "UPDATE reservations SET status = 3 WHERE id=:id";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
}

if (isset($_POST["cancel_id"])) {
	$id = (int) $_POST["cancel_id"];
	$sql = "UPDATE reservations SET status = 1 WHERE id=:id";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_STR);
	$stmt->execute();
}

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
	ORDER BY created_at DESC
";
$stmt = $dbh->query($sql);
$stmt->execute();
if ($stmt->rowCount() > 0) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
		integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- <link href="style_postboard.css" rel="stylesheet"> -->
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
						<h1 class="h3 mb-0 text-gray-800">Admin Reservations Table</h1>
						<!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
					</div>

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
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">
									<table class="table" id="table-data" style="margin-top:2%;">
										<thead>
											<th>Member ID</th>
											<th>Reserved Amenity</th>
											<th>Reservation Time Start</th>
											<th>Reservation Time End</th>
											<th>Date Created</th>
											<th>Status</th>
											<th></th>
										</thead>
										<tbody>
											<?php foreach ($rows as $row) : ?>
											<tr>
												<th>HOAM<?php echo str_pad($row["member_id"], 4, "0", STR_PAD_LEFT); ?></th>
												<th><?php echo $row["amenity"] ?></th>
												<th><?php echo date("M d, Y h:i A", strtotime($row["start_date"])); ?></th>
												<th><?php echo date("M d, Y h:i A", strtotime($row["end_date"])); ?></th>
												<th><?php echo date("Y-m-d", strtotime($row["created_at"])); ?></th>
												<th><?php echo $statusList[$row["status"]]; ?></th>
												<th class="d-flex gap-1">
													<?php if ($row["status"] == 1) : ?>
													<form method="POST">
														<input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>">
														<button type="submit" class="btn btn-danger btn-sm">REMOVE</button>
													</form>
													<?php endif; ?>
													<?php if ($row["status"] == 2) : ?>
													<form method="POST">
														<input type="hidden" name="cancel_id" value="<?php echo $row["id"]; ?>">
														<button type="submit" class="btn btn-warning btn-sm">CANCEL</button>
													</form>
													<form method="POST">
														<input type="hidden" name="complete_id" value="<?php echo $row["id"]; ?>">
														<button type="submit" class="btn btn-success btn-sm">COMPLETE</button>
													</form>
													<?php endif; ?>
												</th>
											</tr>
											<?php endforeach; ?>
										</tbody>
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
						// lengthChange: true,
						// dom: 'lBfrtip',
						// responsive: true,
						"dom": '<"top"<"left-col"l><"center-col"B><"right-col">>frtip',
						buttons: [{
							extend: 'pdf',
							text: 'Generate Report',
							className: "btn btn-primary invisible pdf-generate-btn",
							exportOptions: {
								columns: 'th:not(:last-child)',
								columnGap: 1
							},
							customize: function(doc) {
								const date = moment().format("MMMM Do YYYY, h:mm:ss a");
								doc.content.splice(0, 1, {
									text: [{
										text: 'HOA+ RESERVED AMENITIES REPORT \n',
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
							var createdAt = data[2] || 0; // Our date column in the table

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