<?php
session_start();
require_once 'dbconfig.php';
require_once "./helpers/auth.php";
require_once "./helpers/redirect.php";
guestOnlyMiddleware();

if(!isset($_GET['type']) || !isset($_GET['id'])) header("Location: auth.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reset Password</title>

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
				<div>
					<p>New Password </p>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" id="password" placeholder="New Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<!-- /.col -->
					<div class="d-flex justify-content-end">
						<button  name="login" class="btn btn-primary" onClick="handleChangePass()">Save</button>
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
            const handleChangePass = async () => {
				var parts = window.location.search.substr(1).split("&");
				var $_GET = {};
				for (var i = 0; i < parts.length; i++) {
					var temp = parts[i].split("=");
					$_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
				}

                const password = document.querySelector("#password")
				const type = $_GET['type']
				const id = $_GET['id']

                if(!password.value) return alert("Password field is required")

                const url = await fetch('./api/reset_pass.php?password='+password.value+'&id='+id+'&type='+type)

                const res = await url.json()
                alert(res.message)
            }
        </script>
</body>

</html>