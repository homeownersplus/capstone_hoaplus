<?php
    session_start();
    include_once('dbconfig.php');
 
    if(isset($_GET['id'])){
        $database = new Connection();
        $db = $database->open();
        try{
            $sql = "UPDATE `admins` SET `isArchive`=0 WHERE id = '".$_GET['id']."'";
            //if-else statement in executing our query
            $_SESSION['message'] = ( $db->exec($sql) ) ? 'Admin Reverted successfully' : 'Something went wrong. Cannot Revert member';
        }
        catch(PDOException $e){
            $_SESSION['message'] = $e->getMessage();
        }
 
        //close connection
        $database->close();
 
    }
    else{
        $_SESSION['message'] = 'Select admin to Revert first';
    }
 
    header('location: admin_manageaccounts.php?archive=1');