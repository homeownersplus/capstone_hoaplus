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
$message = "";
$result = $con->query("SELECT reservations.start_date as start_date, reservations.end_date as end_date, tblamenities.amename as amenity_name, tblamenities.PostingDate as amenity_posted_date, reservations.status as reservation_status, user.first_name, user.middle_initial, user.last_name, user.id as user_id FROM `tbl_epass` , reservations, user, tblamenities WHERE tbl_epass.id = $epass_id AND reservations.id = tbl_epass.reservation_id AND tblamenities.id = reservations.amenity_id AND user.id = reservations.member_id;");
$row = $result->fetch_assoc();
$today = date("Y-m-d H:i:s");

if($row){
    if($row["end_date"] <= $today){
        $message = "Your reservation has expired.";
    }
    else{
        $message = "Your reservation is on going.";
    }
}
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
    <?php
    if($row){
    ?>
    <div class="movie-card">
		<div class="movie-content">
			<center>

			<img src="../assets/hoa_logo.png" style="display:width;width:150px;margin:auto;"/>
            <h3 class="text-center" style="margin-top : -20px;">RESERVATION TICKET</h3>
			</center>
        </div>

        <div id="qr-con" class="justify-content-center d-flex">
        </div>

		<div class="movie-content">
			<div class="movie-content-header">
                <h3 class="movie-title"><?php echo $row["amenity_name"]; ?></h3>
			</div>
			<div class="movie-info">
				<div class="info-section">
					<label>Posted Date</label>
					<span><?php echo date('M d,Y, h:i A',strtotime($row["amenity_posted_date"])); ?></span>
				</div><!--date,time-->
				<div class="info-section">
					<label>Status</label>
					<span>Confirmed</span>
				</div><!--screen-->
				<div class="info-section">
					<label>Fullname</label>
					<span><?php echo $row["first_name"]. " ". $row["middle_initial"]. " ". $row["last_name"]; ?></span>
				</div><!--row-->
			</div>
			<div class="movie-info">
				<div class="info-section">
					<label>Start </label>
					<span><?php echo date('M d,Y, h:i A',strtotime($row["start_date"])); ?></span>
				</div>
				<div class="info-section">
					<label>End </label>
					<span><?php echo date('M d,Y, h:i A',strtotime($row["end_date"])); ?></span>
				</div>
			</div>
		</div><!--movie-content-->
	</div><!--movie-card-->
    <?php }
    ?>

    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <?php
                    if($message != "Your reservation is on going."){
                        echo '<div class="modal-dialog alert alert-danger" ><div class="modal-body fw-bolder text-align-center  alert alert-danger">';
                    }
                    else{
                        echo '<div class="modal-dialog alert alert-primary" ><div class="modal-body fw-bolder text-align-center  alert alert-primary">';
                    }
                ?>
                <center>
                    <?php  echo $message;?>
                </center>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#modal').modal("show")
    </script>
    <script>

        var parts = window.location.search.substr(1).split("&");
        var $_GET = {};
        for (var i = 0; i < parts.length; i++) {
            var temp = parts[i].split("=");
            $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
        }

        const QR = new QRCode(document.querySelector('#qr-con'), `http://localhost/capstone_hoaplus/api/e_pass.php?id=${$_GET['id']}`)
    </script>
<style>
* {
	transition: 300ms;
}

.intro {
	text-align:center;
}

ul {
	list-style-type:none;
}

h1,h2,h3,h4,h5,p {
	font-weight: 400;
}

a {
	text-decoration:none;
	color:inherit;
}

a:hover {
	color:#6ABCEA;
}

.container {
	display: flex;
	flex-wrap: wrap;
	max-width: 100%;
	margin-top: 10vh;
	margin-left: auto;
	margin-right: auto;
	justify-content: center;
}

.movie-card {
	background: #ffffff;
	box-shadow: 0px 6px 18px rgba(0,0,0,.1);
	width: 100%;
	max-width: 350px;
	margin: 2em;
	border-radius: 10px;
	display:inline-block;
}

.movie-header {
	padding:0;
	margin: 0;
	height: 367px;
	width: 100%;
	display: block;
	border-top-left-radius: 10px;
	border-top-right-radius:10px;
}

.manOfSteel {
	background: $manOfSteel;
	background-size: cover;
}

.babyDriver {
	background: $babyDriver;
	background-size: cover;
}

.theDarkTower {
	background: $theDarkTower;
	background-size: cover;
	background-position: 100% 100%;
}

.bladeRunner2049 {
	background: $bladeRunner2049;
	background-size: cover;
	background-position: 100% 80%;
}

.header-icon-container {
	position: relative;
}

.header-icon {
	width: 100%;
	height: 367px;
	line-height: 367px;
	text-align:center;
	vertical-align:middle;
	margin: 0 auto;
	color: #ffffff;
	font-size: 54px;
	text-shadow:0px 0px 20px #6abcea, 0px 5px 20px #6ABCEA;
	opacity: .85;
}

.header-icon:hover {
	background:rgba(0,0,0,.15);
	font-size: 74px;
	text-shadow:0px 0px 20px #6abcea, 0px 5px 30px #6ABCEA;
	border-top-left-radius: 10px;
	border-top-right-radius:10px;
	opacity: 1;
}

.movie-card:hover {
	transform:scale(1.03);
	box-shadow: 0px 10px 25px rgba(0,0,0,.08);
}

.movie-content {
	padding: 18px 18px 24px 18px;
	margin: 0;
}

.movie-content-header, .movie-info {
	display: table;
	width: 100%;
}

.movie-title {
	font-size: 24px;
	margin: 0;
	display: table-cell;
}

.imax-logo {
	width: 50px;
	height: 15px;
	background: url("https://6a25bbd04bd33b8a843e-9626a8b6c7858057941524bfdad5f5b0.ssl.cf5.rackcdn.com/media_kit/3e27ede823afbf139c57f1c78a03c870.jpg") no-repeat;
	background-size: contain;
	display:table-cell;
	float: right;
	position:relative;
	margin-top: 5px;
}

.movie-info {
	margin-top: 1em;
}

.info-section {
	display: table-cell;
	text-transform: uppercase;
	text-align:center;
}

.info-section:first-of-type {
	text-align:left;
}

.info-section:last-of-type {
	text-align:right;
}

.info-section label {
	display: block;
	color: rgba(0,0,0,.5);
	margin-bottom: .5em;
	font-size: 9px;
}

.info-section span {
	font-weight: 700;
	font-size: 11px;
}

@media screen and (max-width: 500px) {
	.movie-card {
		width: 95%;
		max-width: 95%;
		margin: 1em;
		display: block;
	}
	
	.container {
		padding: 0;
		margin: 0;
	}
}
        </style>

</body>
</html>