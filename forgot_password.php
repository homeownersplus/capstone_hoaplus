<?php
session_start();
require_once 'dbconfig.php';
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
guestOnlyMiddleware();
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
			<div class="card-body">
				<p class="login-box-msg">Forgot Password</p>

				<div>
					<input type="hidden" name="auth_action" value="login">
					<div class="input-group mb-3">
						<input type="email" class="form-control" name="email" id="email" placeholder="email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<a href="auth.php">Go back to login ?</a>
					<!-- /.col -->
					<div class="d-flex justify-content-end">
						<button  name="login" class="btn btn-primary" onClick="handleSendEmail()">Send an Email</button>
					</div>
					<!-- /.col -->
			</div>
</div>


		</div>
		<!-- /.login-box -->

		<!-- jQuery -->
		<script src="plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>

        <script>
            const handleSendEmail = async () => {
                const email = document.querySelector("#email")

                if(!email.value) return alert("Email field is required")

                const url = await fetch('./api/send_forgatpass_email.php?email='+email.value)

                const res = await url.json()

                alert(res.message)
            }
        </script>
</body>

</html>