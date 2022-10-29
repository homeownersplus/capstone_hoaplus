<?php
session_start();

try {
    require_once '../dbconfig.php';
    if(isset($_POST['login'])){
        
        if(empty($_POST['username']) || empty($_POST['password'])){

            $message ="All fields are required";

        }else{
            $sql = "SELECT * FROM user WHERE username =:username AND password=:password";
            $userrow =$dbh->prepare($sql);
            $userrow->execute(
                array(
                    'username' => $_POST['username'],
                    'password' => $_POST['password']
                )
            );
            $count = $userrow->rowCount();
            if($count > 0){
                foreach($userrow as $result);
                $_SESSION['userid'] = $result['id'];
                header('location: userlandingpage.php');
            }else{
                $message ="Wrong username or password";
            }
        }

    }
} catch (\Throwable $error) {
   $message->$error->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>



<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1">User Login</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="POST">
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
    if(isset($message)){
    echo '<div class="alert alert-danger social-auth-links text-center mt-2 mb-3">'.$message.'</div>';
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
