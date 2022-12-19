<?php
session_start();
require_once "../helpers/auth.php";
require_once "../helpers/redirect.php";
userOnlyMiddleware("../index.php");

require_once '../dbconfig.php';
require_once "../global/model.php";
$model = new Model();

$amenetyList = [];
foreach ($model->displayAment() as $amt) {
	if ($amt["isAvailable"] == true) {
		$amenety = [
			"id" => $amt["id"],
			"name" => $amt["amename"],
		];
		array_push($amenetyList, $amenety);
	}
}

if (isset($_POST["amenity"])) {

	$data = [
		'member_id' => $_SESSION["logged_user"]["id"],
		'amenity_id' => $_POST["amenity"],
		'start_date' => $_POST["time-start"],
		'end_date' => $_POST["time-end"],
		'status' => 2,
	];


	// die(var_dump($data));
	//  Add check for uppaid payments
	// get latest payment record
	$paymentSql = "
		SELECT
			date_paid,
			date_due,
			DATE_ADD(date_due, INTERVAL 1 MONTH) as next_due
		FROM payments
		WHERE member_id = :member_id
		ORDER BY id DESC
		LIMIT 1
	";
	$paymentStmt = $dbh->prepare($paymentSql);
	$paymentStmt->execute(
		[
			'member_id' => $_SESSION["logged_user"]["id"],
		]
	);
	$count = $paymentStmt->rowCount();
	if ($count <= 0) {
		redirect("./userreservations.php?code=104");
	} else {
		$payment = $paymentStmt->fetch(PDO::FETCH_ASSOC);
		$currentDate = date("Y-m-d");

		// if due date is already due
		if ($payment["next_due"] < $currentDate) {
			// check unpaid paid
			if ($payment["date_paid"] == null) {
				redirect("./userreservations.php?status=unpaid");
			}
		}
	}

	//  check for similar time
	// doesn't work
	// $checkSql = "
	// 	SELECT * 
	// 	FROM reservations
	// 	WHERE amenity_id = :amenity_id
	// 	AND (start_date BETWEEN :from AND :to)
	// 	AND (end_date BETWEEN :from AND :to)
	// 	AND status = 2
	// ";

	// Works but doesnt detect if given dates are inside
	// $checkSql = "
	// 	SELECT * FROM reservations
	// 	WHERE ((start_date BETWEEN :from AND :to) OR (end_date BETWEEN :from AND :to))
	// 	AND amenity_id = :amenity_id
	// 	AND status = 2
	// ";

	// Works
	$checkSql = "
	SELECT * FROM reservations
	WHERE (start_date < :to AND end_date > :from)
	AND amenity_id = :amenity_id
	AND status = 2
";
	$checkStmt = $dbh->prepare($checkSql);
	$checkStmt->execute(
		[
			'amenity_id' => $data["amenity_id"],
			'from' => $data["start_date"],
			'to' => $data["end_date"],
		]
	);
	$count = $checkStmt->rowCount();

	// die($checkStmt->debugDumpParams());
	if ($count > 0) {
		redirect("./userreservations.php?code=101");
	}


	$sql = "
	INSERT INTO reservations
	(
		member_id,
		amenity_id,
		start_date,
		end_date,
		status
	)
	VALUES
	(
		:member_id,
		:amenity_id,
		:start_date,
		:end_date,
		:status
	)
	";
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	$count = $stmt->rowCount();
	if ($count > 0) {
		redirect("./userreservations.php?code=200");
	}
	redirect("./userreservations.php?code=100");
}
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Reserve Amenity </title>
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
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

	<!-- <link href="style_postboard.css" rel="stylesheet"> -->

	<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.0.0/index.global.min.js"></script>
</head>

<!--------------------------- left navigation  ----------------------------->

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">
	<?php require 'notif-modal.php'; ?> 

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
								<span class="position-absolute bottom-50 start-100 translate-middle badge rounded-pill bg-danger notif-count">
								</span>
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="usereditprofile.php">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile
								</a>

								<div class="dropdown-divider"></div>

								<?php require 'notification_bell.php'; ?>

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

					<div class="d-flex justify-content-between">
						<h1 class="font-weight-bold">Reserve an Amenity</h1>
						<button class="btn btn-outline-primary" onClick="hideCalendar()">View Reservation Calendar</button>
					</div>
					<!-- <input class="btn btn-outline-primary" type="submit" value="Generate E-Pass" name="reserveamenityusr" style="margin-top:-10%; margin-left:85%;"  > -->
					<div class="card mt-3 calendar-con d-none" >
						<div class="card-body">
							<div id='calendar'></div>
						</div>
					</div>
					<script>
						const hideCalendar = () => {
							$('.calendar-con').toggleClass('d-none')

							if(document.querySelector('.calendar-con').classList.contains('d-none')) return

							var calendarEl = document.getElementById('calendar');

							var calendar = new FullCalendar.Calendar(calendarEl, {
								headerToolbar: { center: 'dayGridMonth,timeGridWeek' },
								initialView: 'dayGridMonth',
								height : 650,
								events : '../api/usercalendar.php'
							});

							calendar.render();
						}
					</script>

					<!-- DataTales Example -->
					<div class="card shadow mb-4" style="margin-top:2%;">

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<?php if (isset($_GET["code"])) : ?>
									<div class="alert alert-warning mb-2" role="alert">
										<?php
											$msg = "";
											switch ($_GET["code"]) {
												case "100":
													$msg = "Error saving reservation";
													break;
												case "101":
													$msg = "This date is already reserved. Please consider another date.";
													break;
													// case "103":
													// 	$msg = "You must settle all unpaid payments, to continue booking";
													// 	break;
												case "104":
													$msg = "Unable to verify payments status, please contact the admins";
													break;
												case "200":
													$msg = "Reservation Saved";
													break;
												default:
													$msg = "Unexpected Error";
													break;
											}
											echo $msg;
											?>
									</div>

									<?php endif; ?>
									<form method="POST">
										<div class="mb-3 d-none" style="width:100%;">
											<label for="disabledTextInput" class="form-label">Member Email</label>
											<input type="text" id="disabledTextInput" class="form-control"
												value="<?php echo $_SESSION["logged_user"]["email"] ?>" readonly>
										</div>

										<div class="mb-3 d-none" style="width:100%;">
											<label for="disabledTextInput" class="form-label">Member Fullname</label>
											<input type="text" id="disabledTextInput" class="form-control"
												value="<?php echo $_SESSION["logged_user"]["first_name"] . " " . $_SESSION["logged_user"]["middle_initial"] . " " . $_SESSION["logged_user"]["last_name"] ?>"
												readonly>
										</div>
										<div>

											<select class="form-select" aria-label="amenity list" name="amenity" id="userselectamenity"
												required>
												<?php foreach ($amenetyList as $amt) : ?>
												<option value="<?php echo $amt["id"] ?>"><?php echo $amt["name"] ?></option>
												<?php endforeach ?>
											</select>
										</div>


										<div id="reservedateuser" style="margin-top:2%;">
											<label for="reservedateuser" class="form-label">Reservation Date</label>
											<input id="date-input" type="date" class="form-control" name="date" required>
											<span id="closed-message" class="d-none text-danger">The amenities today are now closed, pick
												another
												date</span>
										</div>


										<div id="reservestarttimeuser" style="margin-top:2%;">
											<label for="reservedateuser" class="form-label">Reservation Time Start</label>
											<input type="hidden" name="time-start" id="time-start-input">
											<input id="time-start-input-picker" type="input" class="form-control" class="inputfieldtime"
												placeholder="Starting Hour" readonly required>
										</div>

										<div id="reserveendtimeuser" style="margin-top:2%;">
											<label for="reservedateuser" class="form-label">Reservation Time End</label>
											<input type="hidden" name="time-end" id="time-end-input">
											<input id="time-end-input-picker" type="input" class="form-control" class="inputfieldtime"
												placeholder="Ending Hour" readonly required>
										</div>

										<div class="d-flex justify-content-end mt-2">
											<button class="btn btn-primary mr-2" type="submit">Save</button>
											<a href="userlandingpage.php" class="btn btn-secondary">Back</a>
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

					<div class="modal" id="warning-modal" tabindex="-1" role="dialog" aria-labelledby="warning-label"
						aria-hidden="false">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-body text-center p-4">
									<i class="fas fa-exclamation-circle text-danger p-4" style="font-size: 12rem;"></i>
									<h4>
										You must settle all remaining balance to reserve an amenity
									</h4>
								</div>
								<div class="modal-footer d-flex justify-content-center">
									<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
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
					<script src="../plugins/moment/moment.min.js"></script>
					<link rel="stylesheet"
						href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
					<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

					<script>
					<?php if (isset($_GET["status"]) && $_GET["status"] == "unpaid") : ?>
					$('#warning-modal').modal('toggle')
					<?php endif; ?>
					// Archived
					const dateChecker = () => {
						const today = new Date();
						const formatDate = (date) => {
							let d = new Date(date)
							let month = String(d.getMonth() + 1);
							let day = String(d.getDate());
							let year = d.getFullYear()
							if (month.length < 2) month = "0" + month;
							if (day.length < 2) day = "0" + day;
							return [year, month, day].join("-");
						}
						document.querySelector("#date-input").min = formatDate(today);
					}
					dateChecker();

					document.querySelector("#date-input").addEventListener("change", () => {

						document.querySelector("#time-end-input-picker").value = ""
						document.querySelector("#time-start-input-picker").value = ""
						document.querySelector("#time-end-input").value = ""
						document.querySelector("#time-start-input").value = ""
						const ext = new Date().toLocaleString('en-US', {
							hour: 'numeric',
							hour12: true
						}).split(" ")[1];

						document.querySelector("#reservestarttimeuser").classList.remove("d-none");
						document.querySelector("#reserveendtimeuser").classList.remove("d-none");
						document.querySelector("#closed-message").classList.add("d-none");

						if (moment(document.querySelector("#date-input").value).isSame(new Date(), "day")) {

							console.log(new Date().getHours() + 1)
							if (new Date().getHours() + 1 >= 19) {
								document.querySelector("#reservestarttimeuser").classList.add("d-none");
								document.querySelector("#reserveendtimeuser").classList.add("d-none");
								document.querySelector("#closed-message").classList.remove("d-none");
							}

							let minTime = '8AM';
							if (new Date().getHours() + 1 > 8) {
								minTime = String(8 + ((new Date().getHours() + 1) - 8)) + ext;
							}
							$('#time-start-input-picker').timepicker('option', 'minTime', minTime);
						} else {
							$('#time-start-input-picker').timepicker('option', 'minTime', `8AM`);
						}
					});

					// const timeChecker = () => {
					// 	const selectedDate = document.querySelector("#date-input");
					// 	const today = new Date();

					// 	const formatTime = (date) => {
					// 		let d = new Date(date);
					// 		let hours = String(d.getHours());
					// 		let minutes = String(d.getMinutes());
					// 		if (hours.length < 2) hours = "0" + hours;
					// 		if (minutes.length < 2) minutes = "0" + minutes;
					// 		return [hours, minutes].join(":");
					// 	}

					// 	// Check if input date is today
					// 	if (selectedDate.value == today.toLocaleDateString('en-CA')) {
					// 		document.querySelector("#time-start-input").min = formatTime(today);
					// 	}
					// 	const oneHourInAdvance = new Date(`${selectedDate.value} ${document.querySelector("#time-start-input").value}`)
					// 		.setHours(new Date(`${selectedDate.value} ${document.querySelector("#time-start-input").value}`).getHours() +
					// 			1);
					// 	document.querySelector("#time-end-input").min = formatTime(oneHourInAdvance);
					// }

					// document.querySelector("#time-start-input").addEventListener("change", () => {
					// 	timeChecker();
					// })

					// timeChecker();
					// setInterval(() => {
					// 	timeChecker()
					// }, 1000 * 10)
					const ext = new Date().toLocaleString('en-US', {
						hour: 'numeric',
						hour12: true
					}).split(" ")[1];

					$('#time-start-input-picker').timepicker({
						timeFormat: 'h p',
						interval: 60,
						minTime: `${parseInt(new Date().getHours()) + 1}${ext}`,
						// minTime: "8am",
						startTime: '8:00am',
						maxTime: '6:00pm',
						defaultTime: null,
						dynamic: true,
						dropdown: true,
						scrollbar: true,
						change: function(time) {
							// console.log(`DATE TIME DATE ${document.querySelector("#date-input").value}`)
							const hour = String(new Date(time).getHours()).padStart(2, "0");
							const selectedDate = new Date(document.querySelector("#date-input").value);

							let addedTime = moment(time).add(1, "h").toDate();

							const year = selectedDate.getFullYear();
							const month = String(selectedDate.getMonth() + 1).padStart(2, "0");
							const day = String(selectedDate.getDate()).padStart(2, "0");

							const date = `${year}-${month}-${day} ${hour}:00:00`

							$('#time-end-input-picker').timepicker('option', 'minTime', addedTime);

							document.querySelector("#time-end-input-picker").value = ""
							document.querySelector("#time-end-input").value = ""
							document.querySelector("#time-start-input").value = date;

						}
					});

					$('#time-end-input-picker').timepicker({
						timeFormat: 'h p',
						interval: 60,
						minTime: '1',
						maxTime: '7:00pm',
						defaultTime: null,
						startTime: '9:00am',
						dynamic: true,
						dropdown: true,
						scrollbar: true,
						change: function(time) {
							const hour = String(new Date(time).getHours()).padStart(2, "0");
							const selectedDate = new Date(document.querySelector("#date-input").value);
							const year = selectedDate.getFullYear();
							const month = String(selectedDate.getMonth() + 1).padStart(2, "0");
							const day = String(selectedDate.getDate()).padStart(2, "0");
							const date = `${year}-${month}-${day} ${hour}:00:00`
							document.querySelector("#time-end-input").value = date
						}
					});
					</script>

</body>