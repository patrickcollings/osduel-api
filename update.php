<?php
	
	require('connection.php');
	header("Access-Control-Allow-Origin: *");
	// UPDATES USERS CURRENT AND GAINEDXP




	// GET NEW XP FROM SERVER
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

	$newxp = explode("\n", $data[2]);


	// GET CURRENT XP TO CALCULATE GAINEDXP
	$stmt = $conn->prepare("SELECT initialxp FROM users WHERE user
	= ?") ;
	$stmt->bind_param("s", $name);
	$stmt->bind_result($dbInitialXp);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0)
	{
		while($stmt->fetch())
		{
		  	$gainedxp = $newxp[0] - $dbInitialXp;
		  	// UPDATE USERS WITH NEW CURRENT XP AND NEW GAINED XP
			$stmt = $conn->prepare("UPDATE users SET currentxp = ?, gainedxp = ? WHERE user = ?");
			$stmt->bind_param("iis", $newxp[0], $gainedxp, $name);
			$stmt->execute();
		}
	}

	

?>