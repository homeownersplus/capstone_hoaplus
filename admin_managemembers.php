<!--------------------------- config here  ----------------------------->
<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();


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
						<h1 class="h3 mb-0 text-gray-800">Manage Members</h1>
						<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
					</div>

					<!--------------------------------------- Add Modal ------------------------------------->
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registermember"
						onclick="increase();">
						Register New Member
					</button>

					<!-- Modal -->
					<div class="modal fade" id="registermember" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
						aria-labelledby="registermemberLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="eregistermemberLabel">Register New Member</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<form method="POST" action="">
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
														<label>First Name: </label>
														<input type="text" name="fname" class="form-control">
													</div>
													<div class="col">
														<label>Last Name: </label>
														<input type="text" name="lname" class="form-control">
													</div>
													<div class="form-group col-md-2">
														<label>M.I: </label>
														<input type="text" name="mi" class="form-control" placeholder="M.I">
													</div>
												</div>




												<div class="mb-3">
													<label>Contact Number: </label>
													<input type="ctnumber" class="form-control" name="number">
												</div>

												<div class="mb-3">
													<label>Email Address:</label>
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
													<div class="col">
														<label class="col-sm-2 col-form-label"> Barangay: </label>
														<input type="text" name="brgy" class="form-control">
													</div>
												</div>

												<br>
												<div class="input-group mb-3">
													<input type="text" name="password" class="form-control" aria-label="Recipient's username"
														id="pass" aria-describedby="basic-addon2" placeholder="Generate Password">

													<div class="input-group-append">
														<button class="btn btn-outline-secondary" type="button"
															onclick="genPass();">Generate</button>
													</div>
												</div>
											</div>


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

														<label class="form-label"> Full Name: </label>
														<input type="text" class="form-control" name="fullname" aria-label="Sizing example input"
															aria-describedby="inputGroup-sizing-default" id="txtinput" disabled="disabled" />
														<br>
														<button type="button" onclick="remove()" class="btn btn-outline-secondary">Remove</button>
														<button type="button" onclick="add() " class="btn btn-outline-primary">Add</button>
														<div id="new_chq"></div>
														<input type="hidden" value="1" id="total_chq">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary">Register Member</button>
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

					<!-- DataTales Example -->
					<div class="card shadow mb-4" style="margin-top:2%;">

						<div class="card-body">

							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

									<table class="table" id="example1" style="margin-top:2%;">
										<thead>
											<th scope="col">MemberID</th>
											<th scope="col">Lastname</th>
											<th scope="col">Firstname</th>
											<th scope="col">M.I</th>
											<th scope="col">Action</th>
										</thead>
										<tbody>
											</td>
											</tr>
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

		<script>
		var a = 1;

		function increase() {

			var textBox = document.getElementById("memid");
			textBox.value = "HOAM000" + a;
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
			if (!txtPassportNumber.disabled) {
				txtPassportNumber.focus();
			}
		}

		function add() {
			var new_chq_no = parseInt($('#total_chq').val()) + 1;
			var new_input = "  <div class='input-group mb-3'> <input type='text' id='new_" + new_chq_no +
				"' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default' placeholder='Full Name'' </div>";

			$('#new_chq').append(new_input);
			$('#total_chq').val(new_chq_no)
		}

		function remove() {
			var last_chq_no = $('#total_chq').val();
			if (last_chq_no > 1) {
				$('#new_' + last_chq_no).remove();
				$('#total_chq').val(last_chq_no - 1);
			}
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

		<script>
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
		</script>
		<script>
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
		</script>
	</div>
</body>

</html>