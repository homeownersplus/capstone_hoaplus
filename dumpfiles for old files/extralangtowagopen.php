<!--------------------------- white box sa right for main contents ----------------------------->
    <?php 
   require_once('session.php');
  //require_once('search.php');
  
  ?>


    <div class="container">
      <div class="jumbotron">
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
                  <a <?php echo $row['Photo'];?>.jpg  target="_blank"><img src="assets/images/<?php echo $row['Photo']; ?>.jpg" style="width: 240px;height: 200px;"></a>
                  </div>

                  <p><h6 class = "card-title"><i class="fa-regular fa-calendar" style="padding:1%;"></i>Date Posted: <?php echo $row[ 'PostingDate'];?></h6></p>
                  <p class = "card-text"><?php echo $row['pcontent'];?></p>
                  <a href="manageposts.php" class="btn btn-primary"  style="margin-top:3%;" >Manage Post</a>
              </div>
          </div>
          </div>               
          <?php 
				$cnt++;
			   }}
			?>
          </div>    


          </div>
        </div>
    </div>
</div>
     
       