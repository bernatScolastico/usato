<?php

mysqli_report(MYSQLI_REPORT_OFF);

$servernameDB = "localhost";
$usernameDB = "root";
$passwordDB = "";
$databaseDB = "bunda";

// Create connection
try {
  $conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $databaseDB);

  // Check connection
  if ($conn->connect_error) {
    header("Location: errore.html");
  }
} catch (Exception $e) {
  echo $e->getMessage();
}
