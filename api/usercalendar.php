<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");

require '../vendor/autoload.php';

$con = new mysqli("localhost", "root", "", "pdocrud");

// $id = $_GET['id'];

$sql = $con->query("SELECT tbl1.id, tbl1.start_date, tbl1.end_date, tbl2.amename FROM `reservations` as tbl1, tblamenities as tbl2 WHERE tbl1.status = 3 AND tbl1.amenity_id = tbl2.id");

$calendar_data = array();

while($row = $sql->fetch_assoc()){
    $chunk = array(
        "title" => $row["amename"],
        "start" => $row["start_date"],
        "end" => $row["end_date"],
        "description" => "Reserved"
    );

    array_push($calendar_data, $chunk);
}


die(json_encode($calendar_data));
?>