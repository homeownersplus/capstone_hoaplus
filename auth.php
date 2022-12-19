<?php
session_start();
require_once 'dbconfig.php';
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
guestOnlyMiddleware();

if (isset($_POST["login"])) {
	if (empty($_POST['email']) || empty($_POST['password'])) {
		redirect("auth.php?err=missing");
	}

	// Check if default admin
	$sql = "SELECT * FROM tbladmin WHERE username =:email AND password=:password";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		[
			'email' => $_POST['email'],
			'password' => $_POST['password']
		]
	);

	$count = $userrow->rowCount();
	$result = $userrow->fetch(PDO::FETCH_ASSOC);
	if ($count > 0) {
		$result["password"] = null;
		$_SESSION['userid'] = $result['id'];
		$_SESSION['logged_user'] = $result;
		$_SESSION['logged_role'] = "admin";
		$_SESSION['logged_position'] = "admin";
		redirect("./admin_dashboard.php?msg=logged");
	}

	// Check if admin
	$sql = "SELECT * FROM admins WHERE email =:email AND password=:password AND isArchive=0";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		[
			'email' => $_POST['email'],
			'password' => $_POST['password']
		]
	);

	$count = $userrow->rowCount();
	$result = $userrow->fetch(PDO::FETCH_ASSOC);
	if ($count > 0) {
		$result["password"] = null;
		$_SESSION['userid'] = $result['id'];
		$_SESSION['logged_user'] = $result;
		$_SESSION['logged_role'] = "admin";
		$_SESSION['logged_position'] = $result['position'];
		redirect("./admin_dashboard.php?msg=logged");
	}

	// check if user
	$sql = "SELECT * FROM user WHERE email =:email AND password=:password";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		[
			'email' => $_POST['email'],
			'password' => $_POST['password']
		]
	);

	$count = $userrow->rowCount();
	$result = $userrow->fetch(PDO::FETCH_ASSOC);
	if ($count > 0) {
		$result["password"] = null;
		$_SESSION['userid'] = $result['id'];
		$_SESSION['logged_user'] = $result;
		$_SESSION['logged_role'] = "user";
		$_SESSION['logged_position'] = "user";
		redirect("./user/userlandingpage.php?msg=logged");
	}

	redirect("auth.php?err=invalid");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">

	<style>
	.main-custom-bg {
		background-image: url("./img/login-bg.png");
		background-size: cover;
		position: relative;
		isolation: isolate;
	}

	.main-custom-bg::after {
		content: "";
		z-index: -1;
		inset: 0;
		position: absolute;
		background: black;
		opacity: 0.6;
	}
	</style>
</head>



<body class="hold-transition login-page main-custom-bg">
	<div class="login-box">
		<!-- /.login-logo -->
		<img class="img-fluid" src="./img/roofline.png" style="scale: 1.26; margin-bottom: 0.6rem;">
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="#" class="h1">Login</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form method="POST">
					<input type="hidden" name="auth_action" value="login">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="email" placeholder="Email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<a href="forgot_password.php">Forgot password ?</a>
					<!-- /.col -->
					<div class="d-flex justify-content-end">
						<button type="submit" name="login" class="btn btn-primary">Sign In</button>
					</div>
					<!-- /.col -->
			</div>
			</form>


			<?php
			if (isset($_GET["err"])) {
				$errMsg = "Unexpected Error";
				switch ($_GET["err"]) {
					case "missing":
						$errMsg = "All fields are required";
						break;
					case "invalid":
						$errMsg = "Invalid Credentials";
						break;
				}
				echo '<div class="alert alert-danger social-auth-links text-center mt-2 mb-3">' . $errMsg . '</div>';
			}
			?>
		</div>
		<!-- /.login-box -->

		<!-- jQuery -->
		<script src="plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
</body>

</html>