<?php

session_start();
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

try{
    //Create an instance; passing true enables exceptions
    $mail = new PHPMailer(true);

    $con = new mysqli("localhost", "root", "", "pdocrud");

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mi = $_POST['mi'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $phase = $_POST['phase'];
    $block = $_POST['block'];
    $lot = $_POST['lot'];
    $brgy = $_POST['brgy'];
    $password = $_POST['password'];
    $validid = $_FILES['validid'];
    $htitle = $_FILES['htitle'];
    $isShared = 0;

    if(isset($_POST['shared_accounts'])){
        $shared_accounts = json_decode($_POST['shared_accounts'], true);
        $isShared = 1;
    }

    $temp_valid_id = explode(".", $validid["name"]);
    $newfilename_valid_id = round(microtime(true)) . '.' . end($temp_valid_id);
    move_uploaded_file($validid["tmp_name"], "./" . $newfilename_valid_id);


    $temp_htitle = explode(".", $htitle["name"]);
    $newfilename_htitle = round(microtime(true) * 3) . '.' . end($temp_htitle);
    move_uploaded_file($htitle["tmp_name"], "./" . $newfilename_htitle);

    $stmt = $con->prepare("INSERT INTO `user`(`username`, `password`, `email`, `first_name`, `last_name`, `middle_initial`, `contact_number`, `phase`, `block`, `lot`, `barangay`, `isSharedAccount`, `id_img`, `land_reg_img`) VALUES (? , ? ,? ,? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $email, $password, $email, $fname, $lname, $mi, $number, $phase, $block, $lot, $brgy, $isShared, $newfilename_valid_id, $newfilename_htitle);
    $stmt->execute();

    $user_id = $stmt->insert_id;

    if(isset($_POST['shared_accounts'])){
        foreach ($shared_accounts as $key => $value) {
            $stmt1 = $con->prepare("INSERT INTO `user_family`(`user_id`, `full_name`, `relationship`) VALUES (?, ? , ?)");
            $stmt1->bind_param("sss", $user_id, $value["name"], $value["relation"]);
            $stmt1->execute();
        }
    }

    //Server settings
    $mail->IsSMTP();
    $mail->CharSet = "UTF-8";                                           //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'everlastingpearl2@gmail.com';                      //SMTP username
    $mail->Password   = 'vpszuqjxinmvskql';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    $mail->setFrom('everlastingpearl2@gmail.com');
    $mail->addAddress($email);     //Add a recipient             //Name is optional
    $mail->addReplyTo('everlastingpearl2@gmail.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email and Password';
    $mail->Body    =  ' 
        <html> 
        <head> 
    
        </head> 
        <body> 
            <h2>Home Owners Association</h2> 
            <h4>To login in your account here is your email and password</h4>
            <br>
            <h4>Email: <b>' . $email . '</b></h4>
            <h4>Password: <b>' . $password . '</b></h4>
            <br>
            <h4>Thankyou</h4>
        </body> 
        </html>';


    $mail->send();

	$adminId = "Admin_" . $_SESSION["logged_user"]["username"];
    $event = "$adminId created new Member [$email]";

	$logstmt = $con->prepare("INSERT INTO `logs` (`message`) VALUES ( ? )");
	$logstmt->bind_param("s",$event );
	$logstmt->execute();

    die("success");
}
catch(Exception $e) {
    die('Message: ' .$e->getMessage());
}