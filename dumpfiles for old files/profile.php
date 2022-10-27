<?php
    require_once("session.php");
    require_once 'dbconfig.php';
    if(isset($_POST['upload'])){
       $userid=intval($_GET['id']);

       $file_name=$_FILES['file']['name'];
       $file_temp=$_FILES['file']['tmp_name'];
       $file_size=$_FILES['file']['size'];
       $file_type=$_FILES['file']['type'];

       $location="upload/".$file_name;

       if($file_size < 524880 ){
           if(move_uploaded_file($file_temp,$location)){
               try{
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql ="UPDATE tblusers SET Photo='$location' WHERE id='$userid'";
                   
                    $dbh->exec($sql);
               }catch(PDOEexception $e){
                   echo $e->getMessage();
               }
               $dbh = null;
             
               header('location:dashboard.php');
              
           }
       }else{
           echo "<script>alert('File size is to large to upload');</script>";
       }
    }

?>


<!doctype html>
<html lang="en">
        <title>HOA+ Upload Post Photo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   

         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="style.css" rel="stylesheet">
        <link href="css/fileupload.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="js/fileupload.js"></script>
      
</head>
<body> 

   <!--------------------------- left navigation  ----------------------------->
   <div class="left">
        <div class="left-panel">
          <div class="left-panel-content">
          <img class="admin-profile" src="photos/user.png"></img>
          <a href="#" class="nav-profile"> Hi Admin! </a>
        
            <div class="nav-panel">

              <a href="dashboard.php">  Dashboard </a>
              <a href="manageposts.php"> Manage Posts </a>
              <a class= href="#"> Members </a>
              <a class= href="#"> Payment </a>
              <a href="payments.php"> Inbox </a>
                          
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
                <img src="photos/member.png"><h2 class="card-title"> Upload Post Photo</h2>
              </div>
        </div>




 <!--------------------------- right box white start ----------------------------->
        <div class="container">
          <div class="jumbotron">
            <div class="card">
                <div class="card-body">
                    <div class="card-tools">
                <form method="POST" enctype="multipart/form-data">
                    <!--<div class="form-group">
                        <label>Upload Here</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn btn-danger">Upload</button>
                    -->
                    <div class="file-upload">  <h3>Profile Upload</h3>
                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"style="background:#A52A2A; border:none;"><span class="glyphicon glyphicon-picture" ></span> Browse Photo</button>

                        <div class="image-upload-wrap">
                            <input class="file-upload-input" type='file' name="file" onchange="readURL(this);" accept="image/*" require/>
                            <div class="drag-text">
                            <h3>Drag and drop a file or Browse Image</h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        <br>
                        <button type="submit" name="upload" class="btn btn-primary"> <span class="glyphicon glyphicon-upload"></span> Upload</button>
                        <a href="manageposts.php" class="btn btn-secondary"> <span class="glyphicon glyphicon-back"></span> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>