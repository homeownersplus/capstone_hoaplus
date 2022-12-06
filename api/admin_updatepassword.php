<?php

session_start();
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: GET");
header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

$con = new mysqli("localhost", "root", "", "pdocrud");

$old = $_GET['old'];
$newp = $_GET['new'];

$sql = "SELECT `password` FROM `admins` WHERE `password` = ? AND `id` = ". $_SESSION['userid'];
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $old);
$stmt->execute();
$result = $stmt->get_result(); 
$row = $result->fetch_assoc();

if($row){

    $sql1 = "UPDATE `admins` SET `password`= ? WHERE id = ". $_SESSION['userid'];
    $stmt1 = $con->prepare($sql1);
    $stmt1->bind_param("s", $newp);
    $stmt1->execute();

    die(
        json_encode(
            array(
                "message" => "Password changed!"
            )
        )
    );
}
else{
    die(
        json_encode(
            array(
                "message" => "invalid password"
            )
        )
    );
}

?>