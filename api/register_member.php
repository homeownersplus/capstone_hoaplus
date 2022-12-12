<?php

session_start();
date_default_timezone_set('Asia/Manila');
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

try {
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

    if (isset($_POST['shared_accounts'])) {
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

    if (isset($_POST['shared_accounts'])) {
        foreach ($shared_accounts as $key => $value) {
            $stmt1 = $con->prepare("INSERT INTO `user_family`(`user_id`, `full_name`, `relationship`) VALUES (?, ? , ?)");
            $stmt1->bind_param("sss", $user_id, $value["name"], $value["relation"]);
            $stmt1->execute();
        }
    }

    // Add Member Initial Payment
    $membershipCost = 300;
    $currentDate = date("Y-m-d");
    $nextMonth = date("Y-m-d", strtotime('+1 month'));
    $adminId = "Admin_" . $_SESSION["logged_user"]["username"];
    $memberId = "HOAM" . str_pad($user_id, 4, "0", STR_PAD_LEFT);

    logAction($dbh, "$adminId marked Member $memberId as paid.");

    $firstPaymentSql = "
    INSERT INTO payments
    (
        member_id,
        amount,
        date_due,
        date_paid
    )
    VALUES
    (
        :member_id,
        :amount,
        :due_date,
        :date_paid
    )
    ";

    $firstPaymentStmt = $dbh->prepare($firstPaymentSql);
    $firstPaymentStmt->execute([
        ':member_id' => $user_id,
        ':amount' => $membershipCost,
        ':due_date' =>  $currentDate,
        ':date_paid' => $currentDate,
    ]);
    // Add Next Due
    $newPaymentSql = "
		INSERT INTO payments
		(
			member_id,
			amount,
			date_due
		)
		VALUES
		(
			:member_id,
			:amount,
			:due_date
		)
		";

    $newPaymentStmt = $dbh->prepare($newPaymentSql);
    $newPaymentStmt->execute([
        ':member_id' => $user_id,
        ':amount' => $membershipCost,
        ':due_date' => $nextMonth,
    ]);

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
    $mail->addAddress($email);     //Add a recipient             //Name is optional
    $mail->addReplyTo('casseybertman@gmail.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Homeowners Association Plus Account Details';
    $mail->Body    =  ' 
        <html> 
        <head> 
    
        </head> 
        <body> 
            <h2>Home Owners Association</h2> 
            <h4>Hi! You have successfully registered to Homeowners Association Plus! To login to your account and navigate the features that awaits, here is your account email and password.</h4>
            <br>
            <h4>Email: <b>' . $email . '</b></h4>
            <h4>Password: <b>' . $password . '</b></h4>
            <br>
            <h4>You can now login by using this link: https://homeownersplus.000webhostapp.com</h4>
            <br>
            <h4>Note: For security purposes, it is advised to keep your credentials only to yourself. </h4>
            <br>
            <h4>Regards, </h4>
            <h4>HOA+ Team</h4>
        </body> 
        </html>';


    $mail->send();

    $adminId = "Admin_" . $_SESSION["logged_user"]["username"];
    $event = "$adminId created new Member [$email]";

    $logstmt = $con->prepare("INSERT INTO `logs` (`message`) VALUES ( ? )");
    $logstmt->bind_param("s", $event);
    $logstmt->execute();

    die("success");
} catch (Exception $e) {
    die('Message: ' . $e->getMessage());
}