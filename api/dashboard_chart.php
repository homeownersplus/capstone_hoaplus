<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");

require '../vendor/autoload.php';

$con = new mysqli("localhost", "root", "", "pdocrud");
$months = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "June", 7 => "July", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");

$approvedReservationRes = $con->query("SELECT YEAR(start_date) AS year, MONTH(start_date) AS month, COUNT(*) as total FROM reservations WHERE status=3 GROUP BY year, month");
$cancelledReservationRes = $con->query("SELECT YEAR(start_date) AS year, MONTH(start_date) AS month, COUNT(*) as total FROM reservations WHERE status=1 GROUP BY year, month");

$chart_data = array(
    "approved_reservation" => array(
        "months" => array(),
        "total" => array()
    ),
    "cancelled_reservation" => array(
        "months" => array(),
        "total" => array()
    )
);

while($approvedReservation = $approvedReservationRes->fetch_assoc()){
    array_push($chart_data["approved_reservation"]["months"],$months[$approvedReservation['month']]. " ".$approvedReservation['year']);
    array_push($chart_data["approved_reservation"]["total"],intval($approvedReservation['total']));
}

while($cancelledReservation = $cancelledReservationRes->fetch_assoc()){
    array_push($chart_data["cancelled_reservation"]["months"],$months[$cancelledReservation['month']]. " ".$cancelledReservation['year']);
    array_push($chart_data["cancelled_reservation"]["total"],intval($cancelledReservation['total']));
}



die(json_encode($chart_data));
?>