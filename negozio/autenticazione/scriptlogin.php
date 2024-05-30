<?php
include("../connessione.php");
session_start();
$_SESSION["errato"] = false;

$email = $_POST["email"];
$password = $_POST["password"];
$anony = hash ("sha256", $password);

$_SESSION["email"] = $email;
$_SESSION["password"] = $password;

$sql = "SELECT Email, Password FROM utente WHERE Email= '$email'";

$result = $connessione->query($sql);


if ($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $pass= $row["Password"];
    $user = $row["Email"];


    if(!$pass==$anony || !$user==$email){
        $_SESSION["errato"] = true;
        header("Location: ../index.php");
        exit;
    }
    else{
        header("Location: ../home.html");
        exit;
    }
}
else{
    $_SESSION["errato"] = true;
    header("Location: ../index.php");
    exit;
}       
?>
