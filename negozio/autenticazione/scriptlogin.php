<?php
include("../connessione.php");
session_start();
$_SESSION["errato"] = false;

$email = $_POST["email"];
$password = $_POST["password"];
$anony = hash("sha256", $password);

$_SESSION["email"] = $email;
$_SESSION["password"] = $password;

// Preparare una dichiarazione SQL per evitare SQL injection
$sql = "SELECT ID, email, password FROM utente WHERE email = ?";
$stmt = $connessione->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pass = $row["password"];
    $user = $row["email"];
    $_SESSION["id"] = intval($row["ID"]);
    
    if ($pass !== $anony || $user !== $email) {
        $_SESSION["errato"] = "Username o password errati";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION["utente"] = $email;
        header("Location: ../pages/shop.php");
        exit;
    }
} else {
    $_SESSION["errato"] = "Username o password errati";
    header("Location: ../index.php");
    exit;
}

$stmt->close();
$connessione->close();
?>
