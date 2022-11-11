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

function authOnlyMiddleware()
{
	// If not logged redirect to login
	if (!isLogged()) {
		header('location: ../auth.php');
		exit();
	}
}

function adminOnlyMiddleware()
{
	// redirect to index not admin
	if ($_SESSION["logged_role"] != "admin") {
		header('location: ../index.php');
		exit();
	}
}

function userOnlyMiddleware()
{
	// redirect to index not user
	if ($_SESSION["logged_role"] != "user") {
		header('location: ../index.php');
		exit();
	}
}