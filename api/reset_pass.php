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
$con = new mysqli("localhost", "root", "", "pdocrud");

$password = $_GET['password'];
$type = $_GET['type'];
$id = $_GET['id'];

if($type == "admin"){
    $sql1 = "UPDATE `admins` SET `password`= ? WHERE id = ?";
    $stmt1 = $con->prepare($sql1);
    $stmt1->bind_param("ss", $password,$id);
    $stmt1->execute();

    die(
        json_encode(
            array(
                "message" => "Password changed!"
            )
        )
    );
}
else if($type == "user"){
    $sql1 = "UPDATE `user` SET `password`= ? WHERE id = ?";
    $stmt1 = $con->prepare($sql1);
    $stmt1->bind_param("ss", $password,$id);
    $stmt1->execute();

    die(
        json_encode(
            array(
                "message" => "Password changed!"
            )
        )
    );
}