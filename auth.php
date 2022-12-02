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
		$_SESSION['logged_position'] = $result['position'];
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
</head>



<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="#" class="h1">Login</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to start your session</p>

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
					<div class="row">
						<div class="col-8">

						</div>
					</div>
					<!-- /.col -->
					<div class="col-4">
						<button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
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