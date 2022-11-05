<?php
    session_start();
    include_once('dbconfig.php');
 
    if(isset($_POST['edit'])){
        $database = new Connection();
        $db = $database->open();
        try{
            $id = $_GET['id'];
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            // $email = $_POST['email'];
            // $password = $_POST['password'];
 
            $sql = "UPDATE admins SET username = '$username', fullname = '$fullname' WHERE id = '$id'";
            //if-else statement in executing our query
            $_SESSION['message'] = ( $db->exec($sql) ) ? 'Admin updated successfully!' : 'Something went wrong. No data were replaced.';
 
        }
        catch(PDOException $e){
            $_SESSION['message'] = $e->getMessage();
        }
 
        //close connection
        $database->close();
    }
    else{
        $_SESSION['message'] = 'Fill up edit form first';
    }
 
    header('location: manageadminss.php');
 
?>