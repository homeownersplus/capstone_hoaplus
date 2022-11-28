<?php

session_start();
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

$con = new mysqli("localhost", "root", "", "pdocrud");

$sql = "SELECT count(id) FROM `user`";
$result = $con->query($sql);
$rows = mysqli_fetch_array($result);

$PAGE = !isset($_GET['page']) ? 1 : $_GET['page'];
$LIMIT = 5;
$OFFSET = ($PAGE - 1) * $LIMIT;
$TOTAL = $rows[0];
$TOTALPAGES = ceil($TOTAL / $LIMIT);
$SEARCH = !isset($_GET['search']) ? "" : $_GET['search'];

if(isset($_GET['search'])){
    $sql1 = "SELECT * FROM `user` WHERE `email` LIKE '%$SEARCH%' OR `first_name` LIKE '%$SEARCH%' OR `last_name` LIKE '%$SEARCH%' ORDER BY id LIMIT $OFFSET, $LIMIT";
}
else{
    $sql1 = "SELECT * FROM `user` ORDER BY id LIMIT $OFFSET, $LIMIT";
}
$result1 = $con->query($sql1);
$rows1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

$final = array(
    "page" => $PAGE,
    "limit" => $LIMIT,
    "offset" => $OFFSET,
    "total" => $TOTAL,
    "total_pages" => $TOTALPAGES,
    "data" => $rows1,
    "SQL" => $sql1
);

die(json_encode($final));
// die("page : $PAGE, limit : $LIMIT, offset : $OFFSET, total : $TOTAL, totalpages : $TOTALPAGES");
