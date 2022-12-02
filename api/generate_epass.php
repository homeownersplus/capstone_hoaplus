<?php

session_start();
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: GET");
header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

$con = new mysqli("localhost", "root", "", "pdocrud");

$reservation_id = $_GET['id'];

$sql = "SELECT * FROM `tbl_epass` WHERE `reservation_id` = $reservation_id AND is_used = 0 ORDER BY id LIMIT 1";
$result = $con->query($sql);
$row = $result->fetch_assoc();

if(!$row){
    $create_epass = $con->prepare("INSERT INTO `tbl_epass`(`reservation_id`) VALUES (?)");
    $create_epass->bind_param("s", $reservation_id);
    $create_epass->execute();

    die(
        json_encode(
            array(
                "epass_id" => $create_epass->insert_id
            )
        )
    );
}
else{
    die(
        json_encode(
            array(
                "epass_id" => $row['id']
            )
        )
    );
}