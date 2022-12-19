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

$sql = $con->query("SELECT COUNT(id) as count FROM `notif` WHERE receiver = $id AND isread=0");
$row = $sql->fetch_assoc();

$sql1 = $con->query("SELECT * FROM `notif` WHERE receiver = $id ORDER BY id DESC");

$res = array();

while($row1 = $sql1->fetch_assoc()){
    array_push($res, $row1);
}

die(json_encode(
    array(
        "counts" => intval($row['count']),
        "notif" => $res
    )
));
?>