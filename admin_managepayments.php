<!--------------------------- config here  ----------------------------->
<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
require_once "./helpers/logger.php";
adminOnlyMiddleware();


date_default_timezone_set('Asia/Manila');
require_once './dbconfig.php';


$rows = [];

$sql = "
	SELECT
		payments.id as p_id,
		payments.member_id as m_id,
		user.first_name as fname,
		user.middle_initial as mi,
		user.last_name as lname,
		payments.date_paid,
		payments.date_due,
		DATE_ADD(date_due, INTERVAL 1 MONTH) as next_due
	FROM payments
	INNER JOIN user
	ON payments.member_id = user.id
	ORDER BY date_due DESC;
";
$stmt = $dbh->query($sql);
$stmt->execute();
if ($stmt->rowCount() > 0) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// paypost

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
			redirect("./admin_managepayments.php?err=invalidCredentials");
		}
	}
	// prepare data
	$currentDate = date("Y-m-d");
	$id = intval($_POST['payment_id']);

	// get payment record
	$payment = null;
	foreach ($rows as $row) {
		if ($row["p_id"] == $id) {
			$payment = $row;
			break;
		}
	}

	if ($payment == null) {
		redirect("./admin_managepayments.php?code=404");
	}

	// update payment
	$sql = "UPDATE payments SET date_paid = :date_paid WHERE id=:id";
	$query = $dbh->prepare($sql);

	$query->bindParam(':date_paid', $currentDate, PDO::PARAM_STR);
	$query->bindParam(':id', $id, PDO::PARAM_STR);

	$adminId = "Admin_" . $_SESSION["logged_user"]["username"];
	$memberId = "HOAM" . str_pad($payment["m_id"], 4, "0", STR_PAD_LEFT);

	if ($query->execute()) {
		// log as paid
		logAction($dbh, "$adminId marked Member $memberId as paid.");

		// calculate next payment due
		$newPaymentSql = "
		INSERT INTO payments
		(
			member_id,
			amount,
			date_due
		)
		VALUES
		(
			:member_id,
			:amount,
			:due_date
		)
		";

		$membershipCost = 300;
		$newPaymentStmt = $dbh->prepare($newPaymentSql);
		$newPaymentStmt->execute([
			':member_id' => $payment["m_id"],
			':amount' => $membershipCost,
			':due_date' => $payment["next_due"],
		]);

		if ($newPaymentStmt->rowCount() == 0) {
			redirect("./admin_managepayments.php?code=422");
		}

		// redirect
		redirect("admin_managepayments.php?code=200");
	} else {
		redirect("./admin_managepayments.php?code=400");
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
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
		integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />


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
						<h1 class="h3 mb-0 text-gray-800">Manage Payments</h1>

						<!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->


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

					<?php if (isset($_GET['code'])) : ?>
					<div class="alert alert-warning alert-dismissible fade show" role="alert">
						<strong>
							<i class="fas fa-exclamation-circle"></i>
						</strong>
						<?php
							$errMsg = "";
							switch ($_GET["code"]) {
								case "200":
									$errMsg = "Marked as Paid!";
									break;
								case "404":
									$errMsg = "Error finding payment record.";
									break;
								case "422":
									$errMsg = "Error Calculating Next Due, Please contact the admins.";
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
							<div class="form-group input-daterange d-flex justify-content-between align-items-center">

								<input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd"
									placeholder="From:">

								<div class="form-group-addon mx-4">To</div>

								<input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd"
									placeholder="To:">

							</div>
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">

									<table class="table" id="table-data" style="margin-top:2%;">
										<thead>
											<th scope="col">Payment ID</th>
											<th scope="col">Member Full Name</th>
											<th scope="col">Payment Due</th>
											<th scope="col">Date Paid</th>
											<th scope="col">Next Due</th>
											<th scope="col">Status</th>
											<th scope="col">Action</th>
										</thead>
										<tbody>
											<?php foreach ($rows as $row) : ?>
											<tr>
												<th><?php echo $row["p_id"] ?></th>
												<th><?php echo $row["fname"] . " " . $row["mi"] . " " . $row["lname"] ?></th>
												<th><?php echo date("M d, Y", strtotime($row["date_due"])); ?></th>
												<th><?php echo $row["date_paid"] != null ? date("M d, Y", strtotime($row["date_paid"])) : ""  ?>
												</th>
												<th><?php echo date("M d, Y", strtotime($row["next_due"])); ?></th>
												<th><?php echo $row["date_paid"] != null ? "Paid" : "Not Paid" ?></th>
												<th>
													<?php echo $row["date_paid"] != null ? "" : '<button onclick="loadId(' . $row["p_id"] . ')" data-toggle="modal" data-target="#confirm-modal" class="btn btn-primary">Mark as Paid</button>' ?>
												</th>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</div>
				<!-- End of Main Content -->

				<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal"
					aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form method="POST">

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
									<input id="payment-id" type="hidden" name="payment_id">
									Please type your password to continue.
									<input class="form-control mt-2" type="password" name="confirmPwd" placeholder="Your password">
								</div>
								<div class="modal-footer">
									<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary">Confirm</button>
								</div>
							</div>
						</form>

					</div>
				</div>

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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
		</script>

		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
			integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
		</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
			integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
		</script>

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
		$('.input-daterange input').each(function() {
			$(this).datepicker('clearDates');
		});
		var table = $('#table-data').DataTable({
			// lengthChange: true,
			dom: 'lBfrtip',
			// responsive: true,
			buttons: [{
				extend: 'excel',
				text: 'Generate Report',
				className: "btn btn-primary",
				exportOptions: {
					columns: 'th:not(:last-child)'
				}
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
				var createdAt = data[2] || 0; // due date column in the table

				if (
					(min == "" || max == "") ||
					(moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
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
		</script>

		<script>
		const loadId = (id) => {
			document.querySelector("#payment-id").value = id;
		}
		</script>
	</div>
</body>

</html>