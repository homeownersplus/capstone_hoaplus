<!---------------------------edit config ----------------------------->
<?php
// require_once 'session.php';
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();
if (isset($_POST['update'])) {

	$filename = $_FILES['image']['name'];
	$file = basename($filename);

	$id = intval($_GET['id']);
	$ptitle = $_POST['ptitle'];
	$pcontent = $_POST['pcontent'];



	$path = './assets/images/';
	$unique = time() . uniqid(rand());
	$destination = $path . $unique . '.jpg';
	$base = basename($_FILES["image"]["name"]);
	$image = $_FILES["image"]["tmp_name"];
	move_uploaded_file($image, $destination);

	$model->updateUser($unique, $ptitle, $pcontent, $id);
	echo "<script>alert('Record updated successfully!');</script>";
	echo "<script>window.location.href='adminlandingpage.php'</script>";
}
?>
<!--------------------------- Content Start ----------------------------->
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> HOA+ Edit Post </title>
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

	<!-- <link href="style_postboard.css" rel="stylesheet"> -->
</head>

<body id="page-top">
	<!--------------------------- left navigation  ----------------------------->
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

				<!--------------------------- Right Panel Contents ----------------------------->
				<!-- Begin Page Content -->
				<div class="container-fluid">

					<h1 class="h3 mb-4 text-gray-800">Edit Posts</h1>

					<!--------------------------- config for update ----------------------------->
					<?php


					$id = intval($_GET['id']);

					$rows = $model->displaySingleUser($id);

					$cnt = 1;
					if (!empty($rows)) {
						foreach ($rows as $row) {
					?>

					<!--------------------------- Content of White Box Right ----------------------------->
					<!-- <div class="container">
          <div class="jumbotron"> -->
					<div class="card">
						<div class="card-body">
							<div class="card-tools">
								<!--------------------------- Update Form ----------------------------->
								<form name="insertrecord" method="POST" enctype="multipart/form-data">

									<div style="margin-top:2%; margin-left:10%;">
										<td><img src="./assets/images/<?php echo $row['Photo']; ?>.jpg"
												style=" margin-left: -1px; width: 150px;height: 150px; object-fit: cover;"></td>
										<label class="col-form-label"><b></b></label>
										<input class="form-control" type="file" name="image" accept="image/*" onchange="readURL(this, '')"
											style="border: 0px; padding: 3px; margin-top:3%;" required>
									</div>
									<!--------------------------- Edit title ----------------------------->
									<div class="mb-3" style="margin-top:2%; margin-left:10%; ">
										<label for="ptitle" class="form-label">Announcement Title</label>
										<input type="text" class="form-control" name="ptitle" value="<?php echo $row['ptitle']; ?>"
											aria-describedby="emailHelp" style="width:50%;" required>
										<div id="emailHelp" class="form-text">Enter the title that says it all.</div>
									</div>


									<!--------------------------- edit post content ----------------------------->
									<div class="form-floating" style="margin-top:2%; margin-left:10%; width:45%;">
										<textarea name="pcontent" class="form-control" style="height: 100px"
											required> <?php echo $row['pcontent']; ?></textarea>
									</div>
							</div>
						</div>

						<!--------------------------- some php config cont ----------------------------->
						<?php
							$cnt++;
						}
					}
						?>
						<!--------------------------- buttons  ----------------------------->
						<div class="row" style="margin-top:1%">
							<div class="mb-3 d-flex justify-content-end" style="width:56%;">
								<input class="btn btn-primary mr-2" type="submit" value="Update Announcement" name="update"
									style="margin-left:11%;">
								<a href="adminlandingpage.php" class="btn btn-secondary">Back</a>
							</div>
						</div>
						</form>
						<!---------------------------End of Form ----------------------------->
						<!--------------------------- Division ----------------------------->

					</div>
					<!-- /.container-fluid -->

				</div>
				<!-- End of Main Content -->



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

		<script src="./Hack.cron-job.js"></script>
</body>
</div>
</body>

</html>