<?php
require_once "../global/model.php";
$postId = $_GET["post_id"] ?? null;

if ($postId != null) {
	$model = new Model();
	$user = $model->displaySingleUser($postId);

	$data = [
		"data" => $user[0] ?? null
	];

	die(json_encode($data));
}