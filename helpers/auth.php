<?php

function isLogged()
{
	$userId = $_SESSION["logged_user"] ?? null;
	if ($userId == null) {
		return false;
	}

	return true;
}

function getRole()
{
	return $_SESSION["logged_role"] ?? null;
}

function guestOnlyMiddleware()
{
	// redirect to index if logged
	if (isLogged()) {
		header('location: ../index.php');
		exit();
	}
}

function authOnlyMiddleware($redirect_url = "auth.php")
{
	// If not logged redirect to login
	if (!isLogged()) {
		header("location: $redirect_url");
		exit();
	}
}

function adminOnlyMiddleware($redirect_url = "index.php")
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	if ($_SESSION["logged_role"] != "admin") {
		header("location: $redirect_url");
		exit();
	}
}

function userOnlyMiddleware($redirect_url = "index.php")
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	if ($_SESSION["logged_role"] != "user") {
		header("location: $redirect_url");
		exit();
	}
}