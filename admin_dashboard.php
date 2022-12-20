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

$totalPaidMembersRes = $con->query("SELECT COUNT(date_paid) FROM payments WHERE date_paid IS NOT NULL;");
$totalAssetRes = $con->query("SELECT SUM(amount) as asset FROM payments WHERE date_paid IS NOT NULL;");
$totalUnPaidMembersRes = $con->query("SELECT COUNT(date_paid) FROM (SELECT COALESCE(date_paid, 'empty') as date_paid FROM payments) as tbl WHERE date_paid='empty'");
$totalMembersRes = $con->query("SELECT COUNT(id) as count FROM user");

$totalAsset = $totalAssetRes->fetch_assoc();
$totalMembers = $totalMembersRes->fetch_assoc();
$totalPaidMembers = $totalPaidMembersRes->fetch_assoc();
$totalUnPaidMembers = $totalUnPaidMembersRes->fetch_assoc();


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
	<title> Announcements </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <h1 class="font-weight-bold">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Registered Members</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalMembers["count"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Paid Members</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPaidMembers["COUNT(date_paid)"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Unpaid Members</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalUnPaidMembers["COUNT(date_paid)"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa fa-exclamation fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--Total assets Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Assets</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalAsset["asset"];?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300 "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Approved Reservations</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="approved-reservation-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Amenity Reservation</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <canvas id="cancelled-reservation-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                    <script>
                            const approvedChart = document.getElementById('approved-reservation-chart');
                            const cancelledChart = document.getElementById('cancelled-reservation-chart');

                            const FetchGraph = async() => {
                                const url = await fetch('./api/dashboard_chart.php')
                                const res = await url.json()

                                console.log(res)
                                new Chart(approvedChart, {
                                    type: 'line',
                                    data: {
                                        labels: res?.approved_reservation?.months || [],
                                        datasets: [{
                                            label: 'Approved Reservations',
                                            data: res?.approved_reservation?.total || [],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                            beginAtZero: true
                                            }
                                        }
                                    }
                                });
                                new Chart(cancelledChart, {
                                    type: 'line',
                                    data: {
                                        labels: res?.cancelled_reservation?.months || [],
                                        datasets: [{
                                            label: 'Cancelled Reservations',
                                            data: res?.cancelled_reservation?.total || [],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                            beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            }

                            FetchGraph()
                        </script>
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
<script src="./Hack.cron-job.js"></script>

</body>


</html>