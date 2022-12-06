<?php
Class Connection{
    private $server = "mysql:host=localhost;dbname=pdocrud";
     private $username = "root";
     private $password = "";
     private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
     protected $conn;
     public function open(){
        try {
            $dbh = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME,DB_USER,DB_PASS);
        }catch(PDOException $e){
            exit ("Error". $e->getMessage());
        }
        catch (PDOException $e){
            echo "There is some problem in connection: " . $e->getMessage();
        }
    
    }
}
?>

