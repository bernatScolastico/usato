<?php
include("../connessione.php");
session_start();

$email = $_POST["email"];
$password = $_POST["password"];
$nome = $_POST["nome"];
$cognome = $_POST["Cognome"];
$classe = $_POST["classe"];
$eta = $_POST["eta"];

$anony = hash("sha256", $password);

// Verifica se l'email è già presente nel database
$sql = "SELECT email FROM utente WHERE email = ?";
$stmt = $connessione->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "ERRORE";
    $stmt->close();
    exit;
} else {
    $stmt->close(); // Chiudi la dichiarazione precedente

    // Inserisci il nuovo utente nel database
    $sql = "INSERT INTO utente (password, nome, cognome, eta, classe, email) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("ssssss", $anony, $nome, $cognome, $eta, $classe, $email);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit;
    } else {
        echo "Errore durante l'inserimento: " . $stmt->error;
    }

    $stmt->close();
}

$connessione->close();
?>