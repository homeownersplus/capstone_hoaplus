<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");

require '../vendor/autoload.php';

$con = new mysqli("localhost", "root", "", "pdocrud");

$id = $_GET['id'];
$reason = "";

$sql = $con->query("SELECT cancel_reason FROM `reservations` WHERE id = $id");

$res = $sql->fetch_assoc();

if($res){
    $reason = $res["cancel_reason"];
}

die(json_encode(array(
    "message" => $reason
)));
?>