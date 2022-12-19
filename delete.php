<?php
    session_start();
    include_once('dbconfig.php');
 
    if(isset($_GET['id'])){
        $database = new Connection();
        $db = $database->open();
        try{
            $sql = "UPDATE `admins` SET `isArchive`=1 WHERE id = '".$_GET['id']."'";
            //if-else statement in executing our query
            $_SESSION['message'] = ( $db->exec($sql) ) ? 'Admin Archived successfully' : 'Something went wrong. Cannot Archive member';
        }
        catch(PDOException $e){
            $_SESSION['message'] = $e->getMessage();
        }
 
        //close connection
        $database->close();
 
    }
    else{
        $_SESSION['message'] = 'Select admin to Archive first';
    }
 
    header('location: admin_manageaccounts.php');