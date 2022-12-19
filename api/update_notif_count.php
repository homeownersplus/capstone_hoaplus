<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");

require '../vendor/autoload.php';

$con = new mysqli("localhost", "root", "", "pdocrud");
$id = $_SESSION['userid'];

$sql = $con->query("UPDATE `notif` SET `isread`='1' WHERE `receiver`=$id");
$row = $sql->fetch_assoc();

die(json_encode(
    array(
        "status" => true
    )
));
?>