<?php

function redirect($url, $statusCode = 302)
{
	header("Location: " . $url, true, $statusCode);
	exit();
}