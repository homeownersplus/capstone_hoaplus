<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

require_once "../helpers/auth.php";

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

$email = $_GET['email'];
$type = "";
$id = "";

// Check if admin
$sql = "SELECT * FROM admins WHERE email =:email";
$userrow = $dbh->prepare($sql);
$userrow->execute(
    [
        'email' => $email
    ]
);

$count = $userrow->rowCount();
$result = $userrow->fetch(PDO::FETCH_ASSOC);
if ($count > 0) {
    $type = "admin";
    $id = $result['id'];
}
else{

    // check if user
    $sql = "SELECT * FROM user WHERE email =:email";
    $userrow = $dbh->prepare($sql);
    $userrow->execute(
        [
            'email' => $email
        ]
    );

    $count = $userrow->rowCount();
    $result = $userrow->fetch(PDO::FETCH_ASSOC);
    if ($count > 0) {
        $type = "user";
        $id = $result['id'];
    }
}

if(!$type) die(json_encode(array("message" => "email not found.")));

try {
    $mail = new PHPMailer(true);

    //Server settings
    $mail->IsSMTP();
    $mail->CharSet = "UTF-8";                                           //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'casseybertman@gmail.com';                      //SMTP username
    $mail->Password   = 'vfvotethahfzkwfd';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    $mail->setFrom('casseybertman@gmail.com');
    $mail->addAddress($email);     //Add a recipient             //Name is optional
    $mail->addReplyTo('casseybertman@gmail.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Forgot Password';
    $mail->Body    =  ' 
        <html> 
        <head> 
    
        </head> 
        <body> 
            <h2>Home Owners Association</h2> 
            <h4>Heres your forgot password link. dont share it to anyone.</h4>
            <br>
            <a href="http://localhost/capstone_hoaplus/resetpass.php?type='.$type.'&id='.$id.'">Click here.</a>
            <br>
            <h4>Thankyou</h4>
        </body> 
        </html>';

    $mail->send();

    die(json_encode(array("message" => "Please check your email.")));
} catch (Exception $e) {
    die(json_encode(array("message" => "ERROR OCCURED WHILE SENDING AN EMAIL.")));
}