<?php
session_start();
require("./helpers/auth.php");

$role = getRole();
$loginLink = "";
switch ($role) {
	case 'admin':
		$loginLink = '<a class="nav-link" href="adminlandingpage.php">Admin Dashboard</a>';
		break;
	case 'user':
		$loginLink = '<a class="nav-link" href="./user/userlandingpage.php">User Dashboard</a>';
		break;
	default:
		$loginLink = '<a class="nav-link" href="auth.php">Login</a>';
		break;
}
?>
<!DOCTYPE html>
<html lang="en">
<!--divinectorweb.com-->

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to HOA+</title>

	<!-- All CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
	<link rel="stylesheet" href="css/stylelanding.css">
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
		<div class="container">
			<a class="navbar-brand" href="#"><span class="text-secondary">HOA</span>PLUS</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="#">Home</a>
					</li>
					<li class="nav-item">
						<?php echo $loginLink; ?>
					</li>
				</ul>
			</div>
		</div>
	</nav>



	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
				aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
				aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
				aria-label="Slide 3"></button>
		</div>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="img/home-1.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption">
					<h5>Welcome to your virtual HOA space</h5>
					<p>A digital space to make the best out of your HOA organization. </p>

				</div>
			</div>
			<div class="carousel-item">
				<img src="img/home-2.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption">
					<h5>Create real value</h5>
					<p>Manage your own membership account, get the latest updates upon signing in, reserve your needed amenities and create the real value of your monthly membership. </p>

				</div>
			</div>
			<div class="carousel-item">
				<img src="img/home-3.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption">
					<h5>In property and places</h5>
					<p>Maximize time and efficiency in just a click. Visit your HOA admin to sign up for an account now. </p>

				</div>
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
			data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
			data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>


	<!-- footer starts -->
	<footer class="bg-dark p-2 text-center">
		<div class="container">
			<p class="text-white">All Rights Reserved for Capstone Project</p>
		</div>
	</footer>
	<!-- footer ends -->










	<!-- All Js -->
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>




<!--for getting the form download the code from download button-->