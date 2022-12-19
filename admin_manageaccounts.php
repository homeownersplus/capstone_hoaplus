<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

if (!in_array(strtolower($_SESSION["logged_position"]), ["admin", "president"])) {
	redirect("./index.php");
}

require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();

$con = new mysqli("localhost", "root", "", "pdocrud");

//inactiveposts
if (isset($_REQUEST['del'])) {
	$uid = intval($_GET['del']);
	$sql = "UPDATE tblusers SET status = 1 WHERE id=:id";
	$query = $dbh->prepare($sql);

	$query->bindParam(':id', $uid, PDO::PARAM_STR);
	$query->execute();

	echo "<script>alert ('Post Successfully InActive!');</script>";
	echo "<script>window.location.href='adminlandingpage.php'</script>";
}

if (isset($_REQUEST['active'])) {
	$uid = intval($_GET['active']);
	$sql = "UPDATE tblusers SET status = 0 WHERE id=:id";
	$query = $dbh->prepare($sql);

	$query->bindParam(':id', $uid, PDO::PARAM_STR);
	$query->execute();

	echo "<script>alert ('Post Successfully Active!');</script>";
	echo "<script>window.location.href='adminlandingpage.php'</script>";
}

$user_sql = "SELECT * FROM `user`";

$user_results = $con->query($user_sql);
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> User Accounts </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
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
	<!-- Custom styles for this template-->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
		integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

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
						<h1 class="font-weight-bold">Manage Accounts</h1>
						<div class="btn-group" role="group" aria-label="Add new accounts">
							<?php 
								if(isset($_GET['archive'])){
									?>
										<a href="admin_manageaccounts.php" class="btn btn-outline-primary mr-2">Unarchived</a>
									<?php
								}
								else{
									?>
										<a href="admin_manageaccounts.php?archive=1" class="btn btn-outline-primary mr-2">Archived</a>
									<?php
								}
							?>
							<button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#registermember"
								onclick="increase();">
								New Member
							</button>
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnew">
								New Admin
							</button>
						</div>
					</div>

					<!--------------------------------------- Add Modal ------------------------------------->
					<!-- Button trigger modal -->


					<!-- Modal -->
					<div class="modal fade" id="registermember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
						aria-labelledby="registermemberLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="eregistermemberLabel">Register</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<div>
									<div class="modal-body">
										<div class="row">
											<div class="col">
												<div class="mb-3">
													<label for="staticEmail" class="col-sm-2 col-form-label">MemberID:</label>
													<div class="col-sm-10">
														<h4><input type="text" readonly class="form-control-plaintext" name="memberid" id="memid">
														</h4>
													</div>
												</div>

												<div class="row">
													<div class="col">
														<label>First Name: <span style="color:red">*</span> </label>
														<input type="text" name="fname" class="form-control" onInput="onlyLetters(this)">
													</div>
													<div class="col">
														<label>Last Name: <span style="color:red">*</span> </label>
														<input type="text" name="lname" class="form-control" onInput="onlyLetters(this)">
													</div>
													<div class="form-group col-md-2">
														<label>M.I: </label>
														<input type="text" name="mi" class="form-control" placeholder="M.I"
															onInput="onlyLetters(this)">
													</div>
												</div>

												<div class="mb-3">
													<label>Contact Number: </label>
													<input type="text" class="form-control" name="number" onInput="onlyNumber(this)">
												</div>

												<div class="mb-3">
													<label>Email Address: <span style="color:red">*</span></label>
													<input type="email" class="form-control" name="email">
												</div>

												<div class="row">
													<div class="form-group col-md-2">
														<label class="col-sm-2 col-form-label">Phase: </label>
														<input type="text" name="phase" class="form-control">
													</div>
													<div class="form-group col-md-2">
														<label class="col-sm-2 col-form-label">Block: </label>
														<input type="text" name="block" class="form-control">
													</div>
													<div class="form-group col-md-2">
														<label class="col-sm-2 col-form-label">Lot: </label>
														<input type="text" name="lot" class="form-control">
													</div>
													<div class="form-group col-md-2">
														<label class="col-sm-2 col-form-label">Street: </label>
														<input type="text" name="street" class="form-control">
													</div>
												</div>

												<div>
													<label class="col-sm-2 col-form-label"> Barangay: </label>
													<input type="text" name="brgy" class="form-control" onInput="onlyLetters(this)">
												</div>
												<br>
												<p>Password
												<small data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Your password must contain 8 characters in total with the combination of 1 Uppercase letter, lowercase letter, symbols, and numbers.">
												<i class="fa-regular fa-circle-question"></i>
												<span style="color:red">*</span>
												</small></p>
												<div class="input-group mb-3">
													<span class="input-group-text" style="cursor:pointer" onClick="showPassUser()"><i class="fa-solid fa-eye"></i></span>
													<input type="password" name="password" class="form-control"
														id="pass" aria-describedby="basic-addon2" placeholder="Generate Password">

													<div class="input-group-append">
														<button class="btn btn-outline-secondary" type="button"
															onclick="genPass();">Generate</button>
													</div>
												</div>
											</div>
											<script>
												function showPassUser() {
													var x = document.getElementById("pass");
													if (x.type === "password") {
														x.type = "text";
													} else {
														x.type = "password";
												}
												}
											</script>


											<div class="col">
												<div class="col">
													<label class="form-label">Copy of Valid ID</label>
													<input class="form-control" name="validid" type="file" id="formFile">
												</div>
												<div class="col">
													<label class="form-label">Copy of Land Registration</label>
													<input class="form-control" name="htitle" type="file" id="formFile">
												</div>


												<br>

												<label for="chk">
													<input type="checkbox" id="chk2" onclick="EnableDisableTextBox(this)" />
													Enable shared account(must be valid hoa voter).
												</label>

												<br>



												<div class="row">
													<div class="col">

														<div class="row">
															<div class="col">
																<label class="form-label"> Full Name: </label>
																<input type="text" class="form-control shared-account" id="txtinput"
																	disabled="disabled" />
															</div>
															<div class="col">
																<label class="form-label"> Relationship: </label>
																<input type="text" class="form-control shared-account-relationship" id="txtinput_rel"
																	disabled="disabled" />
															</div>
														</div>
														<br>
														<div id="new_chq"></div>

														<button type="button" onclick="remove()" class="btn btn-outline-secondary">Remove</button>
														<button type="button" onclick="add() " class="btn btn-outline-primary">Add</button>
														<input type="hidden" value="1" id="total_chq">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" id="register_btn">Register</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!----------------------------------- End Add Modal ------------------------------------->

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
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" data-bs-toggle="tab" href="#admin-table-tab" aria-selected="true"
								role="tab">Admins</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" data-bs-toggle="tab" href="#member-table-tab" aria-selected="false" role="tab"
								tabindex="-1">Members</a>
						</li>
					</ul>
					<div id="accounts-tab" class="tab-content">
						<div class="tab-pane fade active show" id="admin-table-tab" role="tabpanel">
							<!-- Admin Table -->
							<div class="card shadow mb-4">
								<div class="card-body">
									<div class="form-group d-flex justify-content-end align-items-center">
										<button class="btn btn-primary" onclick="generatePdfAdmin()">Generate
											Report</button>
									</div>
									<div class="table-responsive">
										<table id="admin-table" class="table">
											<thead>
												<th>ID</th>
												<th>Username</th>
												<th>Fullname</th>
												<th>Email</th>
												<th>Position</th>
												<th>Status</th>
												<th class="not-this">Action</th>
											</thead>
											<tbody>

												<!----------config---------->
												<?php

												$database = new Connection();
												$db = $database->open();
												try {
													if(isset($_GET['archive'])){
														$sql = 'SELECT * FROM admins WHERE isArchive=1';
													}
													else{
														$sql = 'SELECT * FROM admins WHERE isArchive=0';
													}
													foreach ($db->query($sql) as $row) {
												?>
												<tr>
													<td data-order="<?php echo $row['id']; ?>">HOAADMIN <?php echo $row['id']; ?></td>
													<td><?php echo $row['username']; ?></td>
													<td><?php echo $row['fullname']; ?></td>
													<td><?php echo $row['email']; ?></td>
													<td><?php echo $row['position']; ?></td>
													<td>
														<?php
															if(isset($_GET['archive'])){
																?>
																<span class="badge text-bg-danger">Term ended</span>
																<?php
															}
															else{
																?>
																<span class="badge text-bg-success">Active</span>
																<?php
															}
															?>
													</td>
													<td>
														<?php
														if(isset($_GET['archive'])){
															?>
																<a href="#revert_<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm"
																data-bs-toggle="modal"> Revert</a>
															<?php
														}
														else{
															?>
															<a href="#edit_<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"
																data-bs-toggle="modal">
																Edit</a>
															<a href="#delete_<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm"
																data-bs-toggle="modal"> Archive</a>
															<?php
														}
														?>
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
						<div class="tab-pane fade" id="member-table-tab" role="tabpanel">
							<!-- Members Table -->
							<div class="card shadow mb-4">

								<div class="card-body">
									<div class="form-group d-flex justify-content-end align-items-center">
										<div class="d-flex input-daterange mr-2">
											<input type="text" id="min-date" class="form-control date-range-filter"
												data-date-format="yyyy-mm-dd" placeholder="From:">
											<input type="text" id="max-date" class="form-control date-range-filter"
												data-date-format="yyyy-mm-dd" placeholder="To:">
										</div>
										<button class="btn btn-primary" onclick="generatePdfMember()">Generate
											Report</button>
									</div>
									<div class="table-responsive">
										<table class="table" id="member-table">
											<thead>
												<th>MemberID</th>
												<th>Last Name</th>
												<th>First Name</th>
												<th>M.I</th>
												<th>Date Joined</th>
												<th class="not-this">Attachments</th>
											</thead>
											<tbody>
												<?php
												while ($row = $user_results->fetch_assoc()) {
												?>
												<tr>
													<td><?php echo str_pad($row['id'], 5, "0", STR_PAD_LEFT); ?></td>
													<td><?php echo $row['last_name']; ?></td>
													<td><?php echo $row['first_name']; ?></td>
													<td><?php echo $row['middle_initial']; ?></td>
													<td data-sort="<?php echo strtotime($row["created_at"]);?>"><?php echo date("M d, Y", strtotime($row["created_at"])); ?></td>
													<td>
														<div class="btn-group d-flex">
															<?php if (($row["id_img"] != "")) { ?>
															<a target="_blank" href="./api/<?php echo $row["id_img"]; ?>"
																class="flex-fill btn btn-outline-primary btn-sm mr-1" style="width: 5em;">VIEW ID</a>
															<br />
															<?php } ?>
															<?php if (($row["land_reg_img"] != "")) { ?>
															<a target="_blank" href="./api/<?php echo $row["land_reg_img"]; ?>"
																class="flex-fill btn btn-outline-primary btn-sm" style="width: 5em;">VIEW LAND TITLE</a>
															<?php } ?>
														</div>
													</td>
												</tr>
												<?php }
												?>
											</tbody>
										</table>
									</div>
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
		<?php require_once("./layout/admin_logout.php") ?>

		<?php include('add_modal.php'); ?>


		<script>
		var a = 1;
		let total_shared_accounts = 1

		function increase() {

			var textBox = document.getElementById("memid");
			textBox.value = "-";
			a++;
		}

		function genPass() {
			// define result variable 
			var password = "";
			// define allowed characters
			var characters = "0123456789@#$%!-&*ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

			// define length of password character
			var long = "8";
			for (var i = 0; i < long; i++) {
				// generate password
				gen = characters.charAt(Math.floor(Math.random() * characters.length));
				password += gen;
			}
			// send the output to the input
			document.getElementById('pass').value = password;
		}
		</script>
		<script>
		function EnableDisableTextBox(chk) {
			var txtPassportNumber = document.getElementById("txtinput");
			txtPassportNumber.disabled = chk2.checked ? false : true;
			document.getElementById('txtinput_rel').disabled = chk2.checked ? false : true;

			if (!txtPassportNumber.disabled) {
				txtPassportNumber.focus();
			}

			if (!chk2.checked) {
				document.querySelector('#new_chq').innerHTML = ''
				total_shared_accounts = 1
			}
		}

		function add() {
			if (!DQ('#chk2').checked || (total_shared_accounts === 3)) return

			var new_chq_no = parseInt($('#total_chq').val()) + 1;
			var new_input = `
				<div class='row mb-3'> 
					<div class="col">
						<div class='input-group mb-3'> 
							<input type='text' id='new_${new_chq_no}'
							class='form-control shared-account' placeholder='Full Name'/>
						</div>
					</div>
					<div class="col">
						<div class='input-group mb-3'> 
							<input type='text' id='new_${new_chq_no}_rel'
							class='form-control shared-account-relationship' placeholder='Relationship'/>
						</div>
					</div>
				</div>
			`;

			total_shared_accounts++
			$('#new_chq').append(new_input);
			$('#total_chq').val(new_chq_no)
		}

		function remove() {
			console.log(total_shared_accounts)
			if (total_shared_accounts !== 1) {
				document.querySelector('#new_chq').removeChild(document.querySelector('#new_chq').lastElementChild);
			}
			total_shared_accounts = total_shared_accounts !== 1 ? total_shared_accounts - 1 : total_shared_accounts
		}
		</script>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
			integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script src="vendor/datatables/jquery.dataTables.min.js"></script>
		<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

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

		// admin date filter
		$('.input-daterange input').each(function() {
			$(this).datepicker('clearDates');
		});

		// admin table
		var adminTable = $('#admin-table').DataTable({
			"dom": '<"top"<"left-col"l><"center-col"B><"right-col">>frt<"bottom"<"left-col"i><p>>',
			"columnDefs": [{
				"type": "num",
				"targets": 0
			}],
			buttons: [{
				extend: 'pdf',
				text: 'Generate Report',
				className: "btn btn-primary invisible pdf-generate-btn-admin",
				exportOptions: {
					columns: 'th:not(.not-this)',
					columnGap: 1
				},
				customize: function(doc) {
					const date = moment().format("MMMM Do YYYY, h:mm:ss a");
					// doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.styles.tableBodyEven.alignment = 'center';
					doc.styles.tableBodyOdd.alignment = 'center';
					doc.content.splice(0, 1, {
						text: [{
							text: 'HOA+ USER ACCOUNTS REPORT - HOA ADMINS \n',
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

		// member table
		var memberTable = $('#member-table').DataTable({
			"dom": '<"top"<"left-col"l><"center-col"B><"right-col">>frt<"bottom"<"left-col"i><p>>',
			buttons: [{
				extend: 'pdf',
				text: 'Generate Report',
				className: "btn btn-primary invisible pdf-generate-btn-member",
				exportOptions: {
					columns: 'th:not(.not-this)',
					columnGap: 1
				},
				customize: function(doc) {
					const date = moment().format("MMMM Do YYYY, h:mm:ss a");
					doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					doc.styles.tableBodyEven.alignment = 'center';
					doc.styles.tableBodyOdd.alignment = 'center';
					doc.content.splice(0, 1, {
						text: [{
							text: 'HOA+ USER ACCOUNTS REPORT - HOA MEMBERS \n',
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
				var createdAt = data[4] || 0; // due date column in the table

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
			memberTable.draw();
		});
		</script>
		<script>
		const generatePDF = () => {
			html2pdf()
				.set({
					margin: 1,
					filename: 'hoa-members.pdf'
				})
				.from(document.querySelector('.table-responsive')).save()
		}
		$(document).ready(function() {
			$('.edtbtn').on('click', function() {
				$('#editmodal').modal('show');

				$tr = $(this).closest('tr');

				var data = $tr.children("td").map(function() {
					return $(this).text();
				}).get();

				console.log(data);

				$('#mem_id').val(data[0]);
				$('#edit_lname').val(data[1]);
				$('#edit_fname').val(data[2]);
				$('#edit_mi').val(data[3]);
				$('#edit_number').val(data[4]);
				$('#edit_email').val(data[5]);
				$('#edit_phase').val(data[6]);
				$('#edit_block').val(data[7]);
				$('#edit_lot').val(data[8]);
				$('#edit_brgy').val(data[9]);
				$('#edit_ffname').val(data[10]);

			});
		});
		$(document).ready(function() {
			$('.dltbtn').on('click', function() {
				$('#dltmodal').modal('show');

				$tr = $(this).closest('tr');

				var data = $tr.children("td").map(function() {
					return $(this).text();
				}).get();

				console.log(data);
				$('#del_id').val(data[0]);

			});
		});

		// Add members
		const registerBtn = document.querySelector('#register_btn')
		const DQ = (element) => document.querySelector(element)

		const handleRegisterMember = async (e) => {
			registerBtn.disabled = true
			registerBtn.value = 'Saving...'
			try {
				if (DQ('[name=number').value.length !== 11) throw "Invalid phone format"
				if (!DQ('[name=email').value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/))
					throw "Invalid email format"

				const form = new FormData()

				form.append('fname', DQ('[name=fname').value)
				form.append('lname', DQ('[name=lname').value)
				form.append('mi', DQ('[name=mi').value)
				form.append('number', DQ('[name=number').value)
				form.append('email', DQ('[name=email').value)
				form.append('phase', DQ('[name=phase').value)
				form.append('block', DQ('[name=block').value)
				form.append('lot', DQ('[name=lot').value)
				form.append('street', DQ('[name=street').value)
				form.append('brgy', DQ('[name=brgy').value)
				form.append('password', DQ('[name=password').value)
				form.append('validid', DQ('[name=validid').files[0])
				form.append('htitle', DQ('[name=htitle').files[0])

				let allowedImageTypes = ["image/jpeg", "image/png"]

				if (!DQ('[name=htitle')?.files[0] || !DQ('[name=validid')?.files[0]) return alert(
					"Please complete the files needed.")

				if (!allowedImageTypes.includes(DQ('[name=htitle').files[0].type)) {
					throw "Allowed file type's for the copy of land registrations are: [ .jpg .png .jpeg ]"
				}

				if (!allowedImageTypes.includes(DQ('[name=validid').files[0].type)) {
					throw "Allowed file type's for the copy of valid id are: [ .jpg .png .jpeg ]"
				}
				if(!(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(DQ('[name=password').value))) 
					throw "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character."

				if (DQ('#chk2').checked) {
					const shared = []

					document.querySelectorAll('.shared-account').forEach((e, i) => {
						e?.value && shared.push({
							name: e.value,
							relation: document.querySelectorAll('.shared-account-relationship')[i]?.value || "N/A"
						})
					})

					form.append('shared_accounts', JSON.stringify(shared))
				}

				const url = await fetch('api/register_member.php', {
					method: "POST",
					body: form
				})

				const toJson = await url.text()

				alert("Saved")
				console.log(toJson)
				location.reload()
			} catch (error) {
				alert(error)
			} finally {
				registerBtn.disabled = false
				registerBtn.value = 'Register'
			}
		}

		registerBtn.addEventListener('click', handleRegisterMember)

		const repeatFetchNextId = async () => {
			try {
				const url = await fetch(`api/fetch_member.php?page=1`)
				const toJson = await url.json()
				DQ('[name=memberid]').value = "HOAM" + (Number(toJson?.data[0].id) + 1).toString().padStart(5, '0')
			} catch (error) {
				console.log(error)
			} finally {
				setTimeout(() => {
					repeatFetchNextId()
				}, 5000);
			}
		}

		repeatFetchNextId()

		const onlyLetters = (evt) => evt.value = evt.value.replace(/[^A-Z a-z]/ig, '')
		const onlyNumber = (evt) => evt.value = evt.value.replace(/[^0-9]/ig, '')

		const generatePdfAdmin = () => {
			document.querySelector('.pdf-generate-btn-admin').click()
		}
		const generatePdfMember = () => {
			document.querySelector('.pdf-generate-btn-member').click()
		}
		</script>
	</div>
</body>

</html>