<!--------------------------- config here  ----------------------------->
<?php
    require_once '../dbconfig.php';
    $start_from = 0; 
    include('../global/model.php');
    $model = new Model();

  
?>

<!---------------------------start of templates here  ----------------------------->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> HOA+ Member </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

<!--------------------------- font awesome icons  ----------------------------->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="stylers.css" rel="stylesheet">
  </head>
  <body>
    <!--------------------------- left navigation  ----------------------------->
      <div class="left">
        <div class="left-panel">
          <div class="left-panel-content">
          <img class="admin-profile" src="photos/user.png"></img>
          <a href="#" class="nav-profile"> Hi Member! </a>
        
            <div class="nav-panel">

              <a href="#">  Announcements </a>
              <a href="#"> Payments</a>
              <a class= href="#">Reservations</a>
              <a href="#"> Report a Concern</a>
                          
            </div>
          </div>
          <a class="logout" href="logout.php" > Logout</a>
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
            <img src="photos/member.png"><h2 class="card-title"> Announcements</h2>
          </div>
        </div>

    <!--------------------------- white box sa right for main contents ----------------------------->
    <?php 
   require_once('session.php');
  //require_once('search.php');
  
  ?>


    <div class="container">
      <div class="jumbotron">
      
 <!---alert messages--->
 <?php 
                
                if(isset($_SESSION['messageusr'])){
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show text-center" role="alert" style="margin-top:20px;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 
                    
                        <?php echo $_SESSION['messageusr']; ?>
                    </div>
                    <?php
 
                    unset($_SESSION['messageusr']);
                }
            ?>
         
        


        
          </div>
        </div>
             
        <div class="card">
          <div class="card-body">
          <div class="row-cols-1 row-cols-md-2 g-4"style="text-align: center;">
          <?php
      
      
    

      $rows = $model->displayUsers();

				$cnt=1;
				if (!empty($rows)) {
          foreach ($rows as $row) {
			?>

            <!-- User Information -->
            <div class="column">
            <div class="card shadow mb-8">
              
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;"><?php echo $row['ptitle'];?></h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                    <a <?php echo $row['Photo'];  ?>.jpg  target="_blank"><img src="../assets/images/<?php echo $row['Photo']; ?>.jpg" style="width: 240px;height: 200px;"></a>
                    </div>

                    <p><h6 class = "card-title"><i class="fa-regular fa-calendar" style="padding: 1%;"></i>Date Posted: <?php echo $row['PostingDate'];?></h6></p>
                    <p class = "card-text"><?php echo $row['pcontent'];?></p>
                
                </div>
            </div>
            </div>               
          <?php 
				$cnt++;
			   }}
         else{
          {
            echo "<script>alert ('No announcement comback later');</script>";
           
          }
         }
			?>
          </div>    


          </div>
        </div>
    </div>
</div>
     
       

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 
  <script src="jquery.min.js"></script>
 
  </body>
</html>