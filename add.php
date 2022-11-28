<?php

session_start();
include_once('dbconfig.php');
include_once('./helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing true enables exceptions
$mail = new PHPMailer(true);

$data = json_decode(file_get_contents("php://input"), true);
//Declared variables for patient


if (isset($_POST['add'])) {


	$con = new mysqli("localhost", "root", "", "pdocrud");

	$id = $_POST['id'];
	$username = $_POST['username'];
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$position = $_POST['position'];
	$password = $_POST['password'];

	$stmt = $con->prepare("SELECT 1 FROM admins where username=?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_row();

	$stmtfullname = $con->prepare("SELECT 1 FROM admins where fullname=?");
	$stmtfullname->bind_param("s", $fullname);
	$stmtfullname->execute();
	$result = $stmtfullname->get_result();
	$full = $result->fetch_row();

	$stmtemail = $con->prepare("SELECT 1 FROM admins where email=?");
	$stmtemail->bind_param("s", $email);
	$stmtemail->execute();
	$result = $stmtemail->get_result();
	$mail = $result->fetch_row();

	$stmtposition = $con->prepare("SELECT 1 FROM admins where position=?");
	$stmtposition->bind_param("s", $position);
	$stmtposition->execute();
	$result = $stmtposition->get_result();
	$posi = $result->fetch_row();







	$stmtpassword = $con->prepare("SELECT 1 FROM admins where password=?");
	$stmtpassword->bind_param("s", $password);
	$stmtpassword->execute();
	$result = $stmtpassword->get_result();
	$pass = $result->fetch_row();

	$number = preg_match('@[0-9]@', $password);
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);



	if ($user) {
		$_SESSION['message'] = "This username is already taken!";
	} else if ($full) {
		$_SESSION['message'] = "This fullname is already taken!";
	} else if ($mail) {
		$_SESSION['message'] = "This email is already taken!";
	} else if ($pass) {
		$_SESSION['message'] = "This password is already taken!";
	} else if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
		$_SESSION['message'] = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
	} else {
		try {
			$mail = new PHPMailer(true);
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
			echo 'Message has been sent';


			//use prepared statement to prevent sql injection
			$query = ("INSERT INTO `admins` (`id`,`username`, `fullname`, `email`, `position`, `password`) VALUES ('" . $id . "','" . $username . "', '" . $fullname . "', '" . $email . "','" . $position . "', '" . $password . "')");
			//if-else statement in executing our prepared statement
			$_SESSION['message'] = 'Admin record added successfully';

			// Log event

			if (mysqli_query($con, $query) or die("Insert Query Failed")) {
				echo "1";
			} else {
				echo "0";
			}
		} catch (PDOException $e) {
			$_SESSION['message'] = $e->getMessage();
		}
	}
} else {
	$_SESSION['message'] = 'Fill up add form first';
}

header('location: manageadminss.php');