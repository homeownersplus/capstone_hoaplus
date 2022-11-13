<!--------------------------- config here  ----------------------------->
<?php

session_start();
require_once '../dbconfig.php';
$start_from = 0;
include('../global/model.php');
$model = new Model();



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
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="../css/sb-admin-2.min.css" rel="stylesheet">

	<!-- Custom styles for this page -->
	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


	<!-- <link href="style_postboard.css" rel="stylesheet"> -->
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
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Announcements</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="userpayments.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Payments</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userreservations.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Reserve Amenity</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userreservationtable.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Reservation History</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="userconcernform.php">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Send a Message </span></a>
			</li>

			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

			<?php
			//    require_once('session.php');
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
								<img class="img-profile rounded-circle" src="../photos/profile.png">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="usereditprofile.php">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Member Profile
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
                <div class="card-body">
          <div class="card-tools"> -->
					<!-- Page Heading -->

					<h1 class="h3 mb-4 text-gray-800">HOA Announcements</h1>

					<div class="container">


						<div class="card">
							<div class="card-body">
								<div class="row">
									<?php
									$rows = $model->displayActiveUsers();
									$cnt = 1;
									if (!empty($rows)) {
										foreach ($rows as $row) {
									?>

									<!-- User Information -->
									<div class="card shadow mb-8" style="width:33%;">
										<div class="card-header py-3">
											<h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">
												<?php echo $row['ptitle']; ?></h6>
										</div>
										<div class="card-body">
											<div class="text-center">
												<a href="../assets/images/<?php echo $row['Photo']; ?>.jpg" target="_blank"><img
														src="../assets/images/<?php echo $row['Photo']; ?>.jpg"
														style="width: 250px;height: 150px; object-fit: cover;"></a>
											</div>
											<p>
											<h6 class="card-title">
												<?php
														echo date('M d, Y', strtotime($row['PostingDate']))
														?>
											</h6>
											</p>
											<h6 class="card-title">
												<?php
														$out = strlen($row['pcontent']) > 30 ? substr($row['pcontent'], 0, 30) . "..." : $row['pcontent'];
														echo $out;
														?>
											</h6>

											<button type="button" onclick="loadPost(<?php echo $row['id'] ?>)" data-toggle="modal"
												data-target="#post-modal" class="btn btn-primary">Read More</button>
										</div>
									</div>

									<?php
											$cnt++;
										}
									}
									?>


									<!---alert messages--->
									<?php

									if (isset($_SESSION['messageusr'])) {
									?>
									<div class="alert alert-warning alert-dismissible fade show text-center" role="alert"
										style="margin-top:20px;">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>


										<?php echo $_SESSION['messageusr']; ?>
									</div>
									<?php

										unset($_SESSION['messageusr']);
									}
									?>

									<!-- Post Modal -->
									<div class="modal fade" id="post-modal" tabindex="-1" aria-hidden="true">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="card">
														<img id="post-modal-img" src="../assets/images/1665062910477404697633ed7fedbb99.jpg"
															class="card-img-top" alt="post image">
														<div class="card-body">
															<h5 id="post-modal-title" class="card-title">Post Title</h5>
															<h6 id="post-modal-date" class="card-subtitle mb-2 text-muted">Jun 6, 2022</h6>
															<p id="post-modal-content" class="card-text">Some quick example text to build on the card
																title and make up the
																bulk of the card's content.
															</p>
														</div>
													</div>
												</div>
											</div>
										</div>


									</div>
								</div>


								<!-- <div class="row-cols-1 row-cols-md-2 g-4"style="text-align: center;"> -->




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

		<!-- Page level plugins -->
		<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
		<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

		<!-- Page level custom scripts -->
		<script src="../js/demo/datatables-demo.js"></script>

		<script>
		const loadPost = async (id) => {
			const postTitle = document.querySelector("#post-modal-title");
			const postDate = document.querySelector("#post-modal-date");
			const postImg = document.querySelector("#post-modal-img");
			const postContent = document.querySelector("#post-modal-content");

			const res = await fetch(`../api/getPost.php?post_id=${id}`);
			const data = await res.json();
			const post = data.data;
			console.log(post)
			postTitle.innerText = post.ptitle;

			const dateFormat = new Date(post.PostingDate).toDateString().split(" ");
			postDate.innerText = `${dateFormat[1]} ${dateFormat[2]}, ${dateFormat[3]}`;

			postImg.src = `../assets/images/${post.Photo}.jpg`;
			postContent.innerText = post.pcontent;
			console.log(data);
		}
		</script>

</body>


</html>