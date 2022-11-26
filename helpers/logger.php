<?php

function logAction($conn, $event)
{
	$sql = "
	INSERT INTO logs
	(
		message
	)
	VALUES
	(
		:message
	)
	";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':message', $event, PDO::PARAM_STR);

	$stmt->execute();

	$count = $stmt->rowCount();
	if ($count <= 0) {
		die("Error logging event");
	}
}