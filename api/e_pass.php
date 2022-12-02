<?php

session_start();
include_once('../dbconfig.php');
include_once('../helpers/logger.php');

// header("Content-Type: application/json");
// header("Acess-Control-Allow-Origin: *");
// header("Acess-Control-Allow-Methods: GET");
// header("Acess-Control-Allow-Headers: Acess-Control-Alllow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

$con = new mysqli("localhost", "root", "", "pdocrud");

$epass_id = $_GET['id'];

$result = $con->query("SELECT reservations.start_date as start_date, reservations.end_date as end_date, tblamenities.amename as amenity_name, tblamenities.PostingDate as amenity_posted_date, reservations.status as reservation_status, user.first_name, user.middle_initial, user.last_name, user.id as user_id FROM `tbl_epass` , reservations, user, tblamenities WHERE tbl_epass.id = $epass_id AND reservations.id = tbl_epass.reservation_id AND tbl_epass.is_used = 0 AND tblamenities.id = reservations.amenity_id AND user.id = reservations.member_id;");
$row = $result->fetch_assoc();
if(!$row) echo "INVALID QRCODE.";

$update_epass = $con->prepare("UPDATE `tbl_epass` SET `is_used`='1' WHERE id = ?");
$update_epass->bind_param("s", $epass_id);
$update_epass->execute();

$result1 = $con->query("SELECT `id`, `user_id`, `full_name`, `relationship` FROM `user_family` WHERE `user_id` = ".$row['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOA - MEMBER INFO</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<body>
    <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <tr>
                <th>Amenity name : </th>
                <td><?php echo $row["amenity_name"]; ?></td>
            <tr>
                <th>Posted Date : </th>
                <td><?php echo $row["amenity_posted_date"]; ?></td>
            </tr>
            <tr>
                <th>Reservation Status : </th>
                <td><?php echo $row["reservation_status"] == "1" ? "Cancelled" : ($row["reservation_status"] == "2" ? "Pending" : "Confirmed");  ?></td>
            </tr>
            <tr>
                <th>Full name : </th>
                <td><?php echo $row["first_name"]. " ". $row["middle_initial"]. " ". $row["last_name"]; ?></td>
            </tr>
            <tr>
                <th>Start : </th>
                <td><?php echo $row["start_date"]; ?></td>
            </tr>
            <tr>
                <th>End : </th>
                <td><?php echo $row["end_date"]; ?></td>
            </tr>
            <tr>
                <th>Shared Accounts</th>
                <td>
                    <?php while ($row1 = $result1->fetch_assoc()) {?>
                        <p><?php echo $row1["full_name"]. " - ".$row1["relationship"];?> </p>
                    <?php } ?>
                </td>
            </tr>
        </table>
    <div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>