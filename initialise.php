<?php
	require('connection.php');
	header("Access-Control-Allow-Origin: *");

	$name = $_GET["name"];

	$url = 'http://services.runescape.com/m=hiscore_oldschool/index_lite.ws?player=' . $name;
	// Initialise cURL resource
	$curl = curl_init();
	// Setup options for cURL request
	curl_setopt_array($curl, array(
	  CURLOPT_RETURNTRANSFER => 1,
	  CURLOPT_URL => $url
	));
	// Get result from request
	$result = curl_exec($curl);
	// Close cURL resource
	curl_close($curl);
	// Print result
	$data = explode(",", $result);

	$xp = explode("\n", $data[2]);

	addUser($name, $xp[0], $conn);

	// Add data to database
	function addUser($user, $initialxp, $conn)
	{
		$xpgained = 0;
		$stmt = $conn->prepare("INSERT INTO users (user, initialxp, currentxp, gainedxp) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("siii", $user, $initialxp, $initialxp, $xpgained);
		$stmt->execute();
  	}	

?>