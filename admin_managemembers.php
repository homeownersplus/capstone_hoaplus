<!--------------------------- config here  ----------------------------->
<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

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
	<!-- Custom styles for this template-->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
	integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />
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
						<h1 class="h3 mb-0 text-gray-800">HOA User Accounts</h1>
						<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onClick="generatePDF()"><i
								class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>
					</div>

					<!--------------------------------------- Add Modal ------------------------------------->
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registermember"
						onclick="increase();">
						Register
					</button>

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
														<label>First Name: </label>
														<input type="text" name="fname" class="form-control" onInput="onlyLetters(this)">
													</div>
													<div class="col">
														<label>Last Name: </label>
														<input type="text" name="lname" class="form-control" onInput="onlyLetters(this)">
													</div>
													<div class="form-group col-md-2">
														<label>M.I: </label>
														<input type="text" name="mi" class="form-control" placeholder="M.I" onInput="onlyLetters(this)">
													</div>
												</div>

												<div class="mb-3">
													<label>Contact Number: </label>
													<input type="text" class="form-control" name="number" onInput="onlyNumber(this)">
												</div>

												<div class="mb-3">
													<label>Email Address:</label>
													<input type="email" class="form-control" name="email">
												</div>


												<div class="row">
													<div class="form-group col-md-2">
														<label class="col-sm-2 col-form-label">Phase: </label>
														<input type="text" name="phase" class="form-control" >
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
														<input type="text" name="brgy" class="form-control" onInput="onlyLetters(this)">
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
										<th scope="col">MemberID</th>
										<th scope="col">Lastname</th>
										<th scope="col">Firstname</th>
										<th scope="col">M.I</th>
										<th scope="col">Date created</th>
									</thead>
									<tbody>
										<?php 
										while($row = $user_results->fetch_assoc()){
											?>
											<tr>
												<td><?php echo str_pad($row['id'], 5,"0", STR_PAD_LEFT); ?></td>
												<td><?php echo $row['last_name']; ?></td>
												<td><?php echo $row['first_name']; ?></td>
												<td><?php echo $row['middle_initial']; ?></td>
												<td><?php echo $row['created_at']; ?></td>
											</tr>
										<?php }
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		
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

		$('.input-daterange input').each(function() {
			$(this).datepicker('clearDates');
		});

		var table = $('#table-data').DataTable({
			// lengthChange: true,
			dom: 'lBfrtip',
			// responsive: true,
			buttons: [
				{
					extend: 'pdf',
					text: 'Generate Report',
					className: "btn btn-primary",
					exportOptions: {
						columns: 'th:not(:last-child)',
						columnGap: 1
					}
				}
			],
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
				var createdAt = data[3] || 0; // due date column in the table

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
		const generatePDF = () => {
			html2pdf()
			.set({
				margin:       1,
				filename:     'hoa-members.pdf'
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
				if(DQ('[name=number').value.length !== 11) throw "Invalid phone format"
				if(!DQ('[name=email').value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) throw "Invalid email format"

				const form = new FormData()

				form.append('fname', DQ('[name=fname').value)
				form.append('lname', DQ('[name=lname').value)
				form.append('mi', DQ('[name=mi').value)
				form.append('number', DQ('[name=number').value)
				form.append('email', DQ('[name=email').value)
				form.append('phase', DQ('[name=phase').value)
				form.append('block', DQ('[name=block').value)
				form.append('lot', DQ('[name=lot').value)
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

		// let table_data = null
		// const fetchData = async (search, page) => {
		// 	try {
		// 		const url = await fetch(`api/fetch_member.php?page=${page ? page : '1'}&${search ? `search=${search}` : ''}`)
		// 		const toJson = await url.json()

		// 		console.log(toJson)
		// 		let temp = ''

		// 		table_data = toJson
		// 		for (const i of toJson?.data) {
		// 			temp += `
		// 				<tr>
		// 					<td>HOAM${(i.id).padStart(5, '0')}</td>
		// 					<td>${i.last_name}</td>
		// 					<td>${i.first_name}</td>
		// 					<td>${i.middle_initial}</td>
		// 					<td></td>
		// 				</tr>
		// 			`
		// 		}

		// 		DQ('tbody').innerHTML = temp
		// 		DQ('#current-page').innerHTML = page || 1
		// 	} catch (error) {
		// 		console.log(error)
		// 	}
		// }

		// DQ('#search-btn').addEventListener('click', () => {
		// 	if (DQ('#search-field').value.length == 0) return fetchData()
		// 	fetchData(DQ('#search-field').value, 1)
		// })

		// DQ('#next-btn').addEventListener('click', async () => {
		// 	if (!table_data) return

		// 	if (Number(table_data.page) === Number(table_data.total_pages)) return
		// 	DQ('#next-btn').disabled = true

		// 	await fetchData(
		// 		(
		// 			(DQ('#search-field').value.length == 0) ? null : DQ('#search-field').value
		// 		), Number(table_data.page) + 1)

		// 	DQ('#next-btn').disabled = false
		// })

		// DQ('#prev-btn').addEventListener('click', async () => {
		// 	if (!table_data) return

		// 	if (Number(table_data.page) === 0) return
		// 	DQ('#prev-btn').disabled = true

		// 	await fetchData(
		// 		(
		// 			(DQ('#search-field').value.length == 0) ? null : DQ('#search-field').value
		// 		), Number(table_data.page) - 1)

		// 	DQ('#prev-btn').disabled = false
		// })

		// fetchData()

		const repeatFetchNextId = async () => {
			try {
				const url = await fetch(`api/fetch_member.php?page=1`)
				const toJson = await url.json()
				DQ('[name=memberid]').value = "HOAM"+(Number(toJson?.data[0].id) + 1).toString().padStart(5, '0')
			} catch (error) {
				console.log(error)
			}
			finally{
				setTimeout(() => {
					repeatFetchNextId()
				}, 5000);
			}
		}

		repeatFetchNextId()

		const onlyLetters = (evt) => evt.value = evt.value.replace(/[^A-Za-z]/ig, '')
		const onlyNumber = (evt) => evt.value = evt.value.replace(/[^0-9]/ig, '')

		</script>
	</div>
</body>

</html>