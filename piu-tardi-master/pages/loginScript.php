<?php
session_start();
include("./connessione.php");

$e = $_POST["email"];
$pass = hash("sha256", $_POST["password"]);
$sql = "SELECT * FROM utente WHERE email = '$e'";

$result = $conn->query($sql);
if (is_bool($result)) {
  $_SESSION["errore"] = "ERRORE - RISULTATO BOOLEANO";
  header("Location: ../index.php");
} else {
  if ($result->num_rows > 0) {
    $sql = "SELECT * FROM utente WHERE email = '$e' AND password = '$pass'";
    var_dump($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION["utente"] = $row["ID"];
      header("Location: ./index.php");
    } else {
      $_SESSION["errore"] = "PASSWORD ERRATA";
      header("Location: ../index.php");
    }
  } else {
    $_SESSION["errore"] = "UTENTE NON ESISTENTE";
    header("Location: ../index.php");
  }
}