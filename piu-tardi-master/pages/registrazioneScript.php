<?php
session_start();
include("./connessione.php");

$et = $_POST["eta"];
$pass = hash("sha256", $_POST["password"]);
$n = $_POST["nome"];
$c = $_POST["cognome"];
$e = $_POST["email"];
$cl = $_POST["classe"];
$sql = "SELECT * FROM utente WHERE email = '$e'";

$result = $conn->query($sql);
if (is_bool($result)) {
  $_SESSION["errore"] = "ERRORE - RISULTATO BOOLEANO";
  header("Location: ./registrazione.php");
} else {
  if ($result->num_rows == 0) {
    $sql = "INSERT INTO utente(email, password, nome, cognome, eta, classe) VALUES ( '$e', '$pass', '$n', '$c', '$et', '$cl')";
    $conn->query($sql);
    if ($conn->affected_rows > 0) {
      $_SESSION["utente"] = $us;
      header("Location: ./index.php");
    } else {
      $_SESSION["errore"] = "ERRORE - QUERY SQL";
      header("Location: ./registrazione.php");
    }
  } else {
    $_SESSION["errore"] = "EMAIL GIÀ ESISTENTE";
    header("Location: ./registrazione.php");
  }
}
