<?php
include("../connessione.php");
session_start();

$email = $_POST["email"];
$password = $_POST["password"];
$cf = $_POST["cf"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$classe = $_POST["classe"];
$eta = $_POST["eta"];

$anony = hash ("sha256", $password);

$sql = "SELECT Email FROM utente WHERE Email= '$email'";
$result = $connessione->query($sql);
if($result->num_rows > 0){
    echo "ERRORE";
    exit;
}

else{
    $sql = "INSERT INTO utente (CF, Email, Password, Nome, Cognome, Classe, Età, Immagine) VALUES ('$cf','$email','$anony','$nome','$cognome','$classe','$eta','')";
    $result = $connessione->query($sql);

    header("Location: ../index.html");
    exit;
}
?>