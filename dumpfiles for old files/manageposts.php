<?php
require_once 'dbconfig.php';
include('./global/model.php');
$model = new Model();

if (isset($_REQUEST['del'])){
    $uid =intval($_GET['del']);
    $sql = "DELETE FROM tblusers WHERE id=:id";
    $query=$dbh->prepare($sql);

    $query->bindParam(':id', $uid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert ('Post Successfully Deleted!');</script>";
    echo "<script>window.location.href='manageposts.php'</script>";


}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> HOA+ Admin </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="style.css" rel="stylesheet">
  </head>
  <body>
    <!--------------------------- left navigation  ----------------------------->
      <div class="left">
        <div class="left-panel">
          <div class="left-panel-content">
          <img class="admin-profile" src="photos/user.png"></img>
          <a href="#" class="nav-profile"> Hi Admin! </a>
        
            <div class="nav-panel">

            <a href="admin_postboard.php">  Post Board </a>
              <a href="manageposts.php"> Manage Posts </a>
              <a href="#"> Members </a>
              <a href="#"> Payment </a>
              <a href="inbox.php"> Inbox </a>
                          
            </div>
          </div>
          <a class="logout" href="start.php" > Logout</a>
        </div>
      </div>

    <!--------------------------- Right Panel Contents ----------------------------->
    <div class="right"> 
      <div class="right-content">
          <div class="title">
            <a href="index.php"><img src="photos/Logo 2.png" class="logo"> </a>
            <h2> Homeowners Association </h2>
          </div>


        <div class="heading">
              <div class="heading-content">
                <img src="photos/member.png"><h2 class="card-title"> Manage Posts</h2>
              </div>
        </div>

     
  <?php 
   require_once('session.php');
  //require_once('search.php');
  
  ?>
  

   
  <div class="container">
          <div class="jumbotron">
            
            <div class="card">
                <div class="card-body">
          <div class="card-tools">
          <a class="btn btn-primary" href="insert.php">Add Post
              <i class="fas fa-plus"></i></a>

 <!---alert messages--->
 <?php 
                
                if(isset($_SESSION['message'])){
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert" style="margin-top:20px;">
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                 
                    
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php
 
                    unset($_SESSION['message']);
                }
            ?>
         
        


          </div>
        </div>
             
        <div class="card-body">
	<table class="table" id="example1">
		<thead>
			<th>#</th>
			<th>Image</th>
			<th>Post Title</th>
      <th>Post Date</th>
			<th><center>Perform Actions</center></th>
		</thead>
		<tbody>
         
			<?php
      
      
    

      $rows = $model->displayUsers();

				$cnt=1;
				if (!empty($rows)) {
          foreach ($rows as $row) {
			?>
				<tr>
					<td><?php echo htmlentities($cnt);?></td>
					<td><img src="./assets/images/<?php echo $row['Photo']; ?>.jpg" style="width: 150px;height: 100px; object-fit: cover;"></td>
					<td><?php echo $row['ptitle']; ?></td>
          <td><?php echo $row['PostingDate']; ?></td>
         
					
         
					
					<td>
            <center>
						
						<a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><span class="fas fa-edit"></span></a>
						<a href="manageposts.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Do you really want to delete?')"><span class="fas fa-trash"></span></a>
					
          </center>
          </td>
				</tr>

			<?php 
				$cnt++;
			   }}
			?>

		</tbody>
	</table>
        </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>






</script>
</script>
</body>
</html>