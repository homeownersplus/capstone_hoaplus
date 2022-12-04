<?php
session_start();
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
adminOnlyMiddleware();

require_once("dbconfig.php");
include('./global/model.php');
$model = new Model();

// Load Amenity

// Payment History
$amenitySql = "
SELECT * 
FROM tblamenities
WHERE id = :id
";
$fetchStmt = $dbh->prepare($amenitySql);
$fetchStmt->execute(
	[
		'id' => $_GET["q"],
	]
);
$amenity = $fetchStmt->fetch(PDO::FETCH_ASSOC);
if ($amenity == null) {
	die("404 Not Found");
}


if (isset($_POST['insert'])) {

	if (isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "") {

		$filename = $_FILES['image']['name'];
		$file = basename($filename);
		$path = './assets/images/';
		$unique = time() . uniqid(rand());
		$destination = $path . $unique . '.jpg';
		$base = basename($_FILES["image"]["name"]);
		$image = $_FILES["image"]["tmp_name"];
		move_uploaded_file($image, $destination);

		$photo = $unique;
	} else {
		$photo = $amenity["Photo"];
	}


	$sql = "
	UPDATE tblamenities
	SET amename=:name, amendesc=:desc, Photo=:photo
	WHERE id=:id
	";
	$stmt = $dbh->prepare($sql);
	$stmt->execute([
		"name" => $_POST["amename"],
		"desc" => $_POST["amendesc"],
		"photo" => $photo,
		"id" => $_GET["q"],
	]);

	$count = $stmt->rowCount();
	if ($count > 0) {
		redirect("./admin_addamenities.php?amenityupdated");
	}
	redirect("./admineditamenity_form.php?errCode=105");
}
?>


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
	<!--------------------- left navigation  ----------------------------->
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


					<h1 class="h3 mb-4 text-gray-800">Update Amenity</h1>
					<?php if (isset($_GET["errCode"])) : ?>
					<div class="alert alert-warning m-2" role="alert">
						<?php
							$errMsg = "";
							switch ($_GET["errCode"]) {
								case "100":
									$errMsg = "File is not an image";
									break;
								case "101":
									$errMsg = "File name already exists";
									break;
								case "102":
									$errMsg = "File is too large, over 5MB";
									break;
								case "103":
									$errMsg = "Sorry, only JPG, JPEG, and PNG files are allowed.";
									break;
								case "104":
									$errMsg = "Error Saving File";
									break;
								case "105":
									$errMsg = "Error Updating Database File";
									break;
								case "106":
									$errMsg = "Success, you must relogin for the changes to take effect";
									break;
								default:
									$errMsg = "Unexpected Error";
									break;
							}
							echo $errMsg;
							?>
					</div>
					<?php endif; ?>
					<div class="card">
						<div class="card-body">
							<div class="card-tools">
								<form name="insertrecord" method="POST" enctype="multipart/form-data">
									<input type="hidden" class="form-control" name="ame_id" value="<?php echo $_GET["q"]; ?>" required>
									<div style="margin-top:2%; margin-left:10%;">
										<img id="img-preview" src="./assets/images/<?php echo $amenity['Photo']; ?>.jpg" class="img"
											style="max-width: 250px; max-height:250px;;">
										<br>
										<label class="col-form-label"><b>Amenity Image</b></label>
										<input id="img-input" class="form-control" type="file" name="image" accept="image/*"
											onchange="previewFile()" style="margin-left: -0.2%; width:50%;">
									</div>
									<!----------for post title---------->
									<div class="mb-3" style="margin-top:2%; margin-left:10%; ">
										<label for="amename" class="form-label">Amenity Name</label>
										<input type="text" class="form-control" name="amename" value="<?php echo $amenity["amename"]; ?>"
											style="width:50%;" required>
										<div id="emailHelp" class="form-text">Enter exact amenity name.</div>
									</div>


									<!----------for post content---------->
									<div class="form-floating" style="margin-top:2%; margin-left:10%; width:45%;">
										<textarea class="form-control" placeholder="amendesc" name="amendesc" style="height: 100px"
											required><?php echo $amenity["amendesc"]; ?></textarea>
										<label for="amendesc">Write your description here...</label>
										<div id="emailHelp" class="form-text">Provide a short description.</div>
									</div>




									<!----------for post buttons---------->
									<div class="row" style="margin-top:1%">
										<div class="mb-3">
											<input class="btn btn-primary" type="submit" value="Update" name="insert"
												style="margin-left:10%; ">
											<a href="admin_addamenities.php" class="btn btn-secondary">Back</a>
										</div>
									</div>
								</form>
							</div>
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
			<script>
			function previewFile() {
				const preview = document.querySelector('#img-preview');
				const btn = document.querySelector('#img-button');
				const file = document.querySelector('#img-input').files[0];
				const reader = new FileReader();

				reader.addEventListener("load", () => {
					preview.src = reader.result;
				}, false);

				if (file) {
					reader.readAsDataURL(file);
					btn.classList.remove("invisible");
				}
			}
			</script>
			</script>
</body>

</html>