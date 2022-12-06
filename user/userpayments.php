<?php
session_start();
require_once "../helpers/auth.php";
require_once "../helpers/redirect.php";
userOnlyMiddleware("../index.php");


date_default_timezone_set('Asia/Manila');
require_once '../dbconfig.php';


$rows = [];

$sql = "
	SELECT
		payments.id as p_id,
		payments.date_paid,
		payments.date_due,
		payments.amount,
		DATE_ADD(date_due, INTERVAL 1 MONTH) as next_due
	FROM payments
	WHERE member_id = :user_id
	ORDER BY date_due DESC;
";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION["logged_user"]["id"], PDO::PARAM_STR);

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
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
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

						<!-- Nav Item - Search Dropdown (Visible Only XS)
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a> -->
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
					<!-- <div class="jumbotron">
             -->
					<!-- <div class="card">
                <div class="card-body"> -->
					<!-- <div class="card-tools">  -->
					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-800">Payment History</h1>
					<!-- DataTales Example -->
					<div class="card shadow mb-4" style="margin-top:2%;">

						<div class="card-body">
							<div class="form-group d-flex justify-content-end align-items-center">

								<button class="btn btn-primary" onclick="generatePdf()">Generate
									Report</button>

							</div>
							<div class="table-responsive">

								<table class="table" id="table-data" style="margin-top:2%;">
									<thead>
										<th>Payment ID</th>
										<th>Amount Due</th>
										<th>Date Due</th>
										<th>Date Paid</th>
										<th>Next Payment Date</th>
										<th>Status</th>
									</thead>
									<tbody>
										<?php foreach ($rows as $row) : ?>
										<tr>
											<th>PAY<?php echo str_pad($row["p_id"], 4, "0", STR_PAD_LEFT); ?></th>
											<th><?php
														// Check if paid
														// multiply amount for every 30 days overdue
														$initial = $row["amount"];
														$multiplier = 1;

														if ($row["date_paid"] == null) {
															if ($row["date_due"] < date("Y-m-d")) {
																$dueDate = new DateTime($row["date_due"]);
																$currentDate = new DateTime();

																$dateDiff = $dueDate->diff($currentDate)->format("%a");

																if ($dateDiff > 30) {
																	// echo ("($dateDiff)");
																	$multiplier = ceil($dateDiff / 30);
																}
															}
														}
														echo "&#8369; " . $initial * $multiplier;
														?></th>
											<th><?php echo date("M d, Y", strtotime($row["date_due"])); ?></th>
											<th><?php echo $row["date_paid"] != null ? date("M d, Y", strtotime($row["date_paid"])) : ""  ?>
											</th>
											<th><?php echo date("M d, Y", strtotime($row["next_due"])); ?></th>
											<th><?php echo $row["date_paid"] != null ? "Paid" : "Unpaid" ?></th>
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
										<span> Capstone 2022</span>
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

					<!-- Bootstrap core JavaScript-->
					<script src="../vendor/jquery/jquery.min.js"></script>
					<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

					<!-- Core plugin JavaScript-->
					<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

					<!-- Custom scripts for all pages-->
					<script src="../js/sb-admin-2.min.js"></script>
					<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
					<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
					<!-- Page level plugins -->
					<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
					<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>

					<!-- <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script> -->



					<script>
					const loggedUser = '<?php echo $_SESSION["logged_user"]["username"] ?>';

					var table = $('#table-data').DataTable({
						// lengthChange: true,
						// dom: 'lBfrtip',
						"dom": '<"top"<"left-col"l><"center-col"B><"right-col">>frt<"bottom"<"left-col"i><p>>',

						// responsive: true,
						buttons: [
							// {
							// 	extend: 'excel',
							// 	text: 'Excel Report',
							// 	className: "btn btn-primary",
							// 	exportOptions: {
							// 		columns: 'th:not(:last-child)'
							// 	}
							// },
							{
								extend: 'pdf',
								text: 'Generate Report',
								className: "btn btn-primary invisible pdf-generate-btn",
								customize: function(doc) {
									const date = moment().format("MMMM Do YYYY, h:mm:ss a");
									doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
									doc.styles.tableBodyEven.alignment = 'center';
									doc.styles.tableBodyOdd.alignment = 'center';
									doc.content.splice(0, 1, {
										text: [{
											text: 'HOA+ USER PAYMENTS REPORT \n',
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
							}
						],
						'lengthMenu': [
							[10, 25, 50, -1],
							[10, 25, 50, "All"]
						]
					});

					const generatePdf = () => {
						document.querySelector('.pdf-generate-btn').click()
					}
					</script>

</body>