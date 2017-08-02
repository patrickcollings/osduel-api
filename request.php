<?php
  
  require('connection.php');
  header("Access-Control-Allow-Origin: *");
  
  // RETURNS USERS GAINED XP  
  $stmt = $conn->prepare("SELECT user, gainedxp FROM users") ;
  $stmt->bind_result($dbName, $dbXp);
  $stmt->execute() ;
  $stmt->store_result();

  $arr = array();

  if ($stmt->num_rows > 0)
  {
    while($stmt->fetch())
    {
      $arr[$dbName] = $dbXp;
    }
  }

  echo json_encode($arr);
?>