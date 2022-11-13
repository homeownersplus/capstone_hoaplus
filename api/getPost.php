<?php
session_start();
require_once "../global/model.php";
require_once "../helpers/auth.php";

if (!isLogged()) {
	die(json_encode(["code" => "401", "message" => "Unauthenticated"]));
}

$postId = $_GET["post_id"] ?? null;


if ($postId != null) {
	$model = new Model();
	$user = $model->displaySingleUser($postId);

	$data = [
		"data" => $user[0] ?? null
	];

	die(json_encode($data));
}