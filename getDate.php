<?php
  
  require('connection.php');
  header("Access-Control-Allow-Origin: *");
  
  // RETURNS USERS GAINED XP  
  $stmt = $conn->prepare("SELECT * FROM lastupdate") ;
  $stmt->bind_result($dbDate);
  $stmt->execute() ;
  $stmt->store_result();

  if ($stmt->num_rows > 0)
  {
    while($stmt->fetch())
    {
      echo json_encode(array($dbDate));
    }
  }

  
?>