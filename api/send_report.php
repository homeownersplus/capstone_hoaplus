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

$report = $_GET['report'];

$sql = "SELECT * FROM user WHERE id =:id";
$userrow = $dbh->prepare($sql);
$userrow->execute(
    [
        'id' => $_SESSION['userid']
    ]
);

$result = $userrow->fetch(PDO::FETCH_ASSOC);

$sender = $result['email'];
$to = "homeownersassociationplus@gmail.com";
try {
    $mail = new PHPMailer(true);

    //Server settings
    $mail->IsSMTP();
    $mail->CharSet = "UTF-8";                                           //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'casseybertman@gmail.com';                      //SMTP username
    $mail->Password   = 'fvlybuxxfwogogkx';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    $mail->setFrom('casseybertman@gmail.com');
    $mail->addAddress($to);     //Add a recipient             //Name is optional
    $mail->addReplyTo('casseybertman@gmail.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Report';
    $mail->Body    =  ' 
    <html> 
    <head> 

    </head> 
    <body> 
        <h3>Sender : '.$sender.'</h3> <br/><br/>
        <p>'.$report.'</p>
    </body> 
    </html>';

    $mail->send();

    die(json_encode(array("message" => "Please check your email.")));
} catch (Exception $e) {
    die(json_encode(array("message" => $e->getMessage())));
}