<?php

	require 'connection.php';
	header("Access-Control-Allow-Origin: *");
	//$newDate = $_GET["date"];
	$newDate = date("jS F H:i");
	echo $newDate;

	$stmt = $conn->prepare("UPDATE lastupdate SET lastdate = ?");
	$stmt->bind_param("s", $newDate);
	$stmt->execute();

?>			