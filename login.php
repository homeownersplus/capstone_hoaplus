<?php
session_start();
require_once 'dbconfig.php';
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
guestOnlyMiddleware();

if (isset($_POST["login"])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
		redirect("auth.php?err=missing");
	}

	// Check if default admin
	$sql = "SELECT * FROM tbladmin WHERE username =:username AND password=:password";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		[
			'username' => $_POST['username'],
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
		redirect("./adminlandingpage.php?msg=logged");
	}

	// Check if admin
	$sql = "SELECT * FROM admins WHERE username =:username AND password=:password";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		[
			'username' => $_POST['username'],
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
		$_SESSION['logged_position'] = strtolower($result['position']);
		redirect("./adminlandingpage.php?msg=logged");
	}

	// check if user
	$sql = "SELECT * FROM user WHERE username =:username AND password=:password";
	$userrow = $dbh->prepare($sql);
	$userrow->execute(
		[
			'username' => $_POST['username'],
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

	redirect("dang.php?err=invalid");
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>HOA+ Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!----for replacement yung css--->
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="photos/home-button.png" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Welcome back!</h4>

							<form method="POST">
								<input type="hidden" name="auth_action" value="login">
								<div class="input-group mb-3">
									<input type="text" class="form-control" name="username" placeholder="Username">
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

								<div class="form-group m-0">
									<button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
								</div>
								<div class="mt-4 text-center">
									Don't have an account yet? Visit HOA Office</a>
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
					</div>
					<div class="footer">
						2022 &mdash; Capstone
					</div>
				</div>
			</div>
		</div>
	</section>



	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<!-- <script src="dist/js/adminlte.min.js"></script> -->
</body>

</html>