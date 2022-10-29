<?php
    require_once("session.php");
    require_once("dbconfig.php");
    include('./global/model.php');
    $model = new Model();

    if(isset($_POST['insert'])){
        $filename=$_FILES['image']['name'];
        $file = basename($filename);


      
          $ptitle=$_POST['ptitle'];
          $pcontent=$_POST['pcontent'];

          $path = './assets/images/';
          $unique = time().uniqid(rand());
					$destination = $path . $unique . '.jpg';
          $base = basename($_FILES["image"]["name"]);
					$image = $_FILES["image"]["tmp_name"];
					move_uploaded_file($image, $destination);

          $model->addEquipment($unique, $ptitle, $pcontent);
          $_SESSION['message'] = 'Cheers! Post added successfully';   
					echo "<script>window.location.href='adminlandingpage.php?postadded'</script>";
          
        

    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> HOA+ Edit Post </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
        <i class="fa fa-home" aria-hidden="true"></i>
        </div>
        <div class="sidebar-brand-text mx-3">HOA+ Admin <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

   <!-- Nav Item - Dashboard -->
   <li class="nav-item">
                <a class="nav-link" href="adminlandingpage.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Manage Posts</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Members</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Manage Admins</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Payments</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminreservationstable.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Reservations</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_addamenities.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Add an Amenity </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admininboxforconcerns.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inbox </span></a>
            </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                      <!-- Topbar Navbar -->
                      <ul class="navbar-nav ml-auto">

<!-- Nav Item - Search Dropdown (Visible Only XS) -->
<li class="nav-item dropdown no-arrow d-sm-none">
    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
    </a>
    <!-- Dropdown - Messages -->
    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
        aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small"
                    placeholder="Search for..." aria-label="Search"
                    aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</li>



<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">President Aikka</span>
        <img class="img-profile rounded-circle"
            src="photos/profile.png">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <a class="dropdown-item" href="admineditprofile.php">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>

        <a class="dropdown-item" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
</li>

</ul>

</nav>
<!-- End of Topbar -->

    <!--------------------------- Right Panel Contents ----------------------------->
    <!-- Begin Page Content -->
    <div class="container-fluid">
                <!-- <div class="jumbotron">
             -->
            <!-- <div class="card">
                <div class="card-body">
          <div class="card-tools"> -->
                    <!-- Page Heading -->

                    <h1 class="h3 mb-4 text-gray-800">Add Posts</h1>

          <!-- <div class="jumbotron"> -->
            
            <div class="card">
                <div class="card-body">
          <div class="card-tools">
            <form name="insertrecord" method="POST" enctype="multipart/form-data">

                <div style="margin-top:2%; margin-left:10%;">
                <label class="col-form-label"><b>Image</b></label>
										<input class="form-control" type="file" name="image" accept="image/*" onchange="readURL(this, '')" style="margin-left: -0.2%; width:50%;" required>
                </div>
                  <!----------for post title---------->
                   <div class="mb-3" style="margin-top:2%; margin-left:10%; " >
                    <label for="ptitle" class="form-label">Announcement Title</label>
                    <input type="text" class="form-control" name="ptitle" aria-describedby="emailHelp" style="width:50%;" required>
                    <div id="emailHelp" class="form-text">Enter the title that says it all.</div>
                </div>


                      <!----------for post content---------->
                <div class="form-floating" style="margin-top:2%; margin-left:10%; width:45%;" >
                <textarea class="form-control" placeholder="pcontent" name="pcontent" style="height: 100px" required></textarea>
                <label for="pcontent">Write your content here...</label>
                <div id="emailHelp" class="form-text">Compose your announcement clear and exact.</div>
                </div>
                   
                

            
<!----------for post buttons---------->
                <div class="row" style="margin-top:1%">
                    <div class="mb-3">
                       <input class="btn btn-primary" type="submit" value="Post Announcement" name="insert" style="margin-left:10%; ">
                       <a href="adminlandingpage.php" class="btn btn-secondary">Back</a>
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    </body>
</html>