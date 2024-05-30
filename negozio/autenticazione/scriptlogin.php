<?php
include("../connessione.php");
session_start();
$_SESSION["errato"] = false;

$email = $_POST["email"];
$password = $_POST["password"];
$anony = hash ("sha256", $password);

$_SESSION["email"] = $email;
$_SESSION["password"] = $password;

$sql = "SELECT ID, email, password FROM utente WHERE email= '$email'";

$result = $connessione->query($sql);

if ($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $pass= $row["password"];
    $user = $row["email"];
    $_SESSION["id"] = intval($row["ID"]);

    if(!$pass==$anony || !$user==$email){
        $_SESSION["errato"] = "Username o password errati";
        header("Location: ../index.php");
        exit;
    }
    else{
        $_SESSION["utente"] = $email;
        header("Location: ../pages/home.php");
        exit;
    }
}
else{
    $_SESSION["errato"] = "Username o password errati";
    header("Location: ../index.php");
    exit;
}       
?>
