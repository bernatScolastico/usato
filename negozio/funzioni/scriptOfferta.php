<?php
session_start();
include ("../connessione.php");
// Controlla se l'utente è autenticato
if (!isset($_SESSION["utente"])) {
    // Imposta un messaggio di errore nella sessione
    $_SESSION["errato"] = "No no devi fare il login furbacchione";
  
    // Reindirizza l'utente alla pagina di login
    header("Location: ../index.php");
    
    // Assicurati che lo script si fermi dopo il reindirizzamento
    exit();
}
if (!isset($_SESSION["id"]) || !isset($_SESSION["AnnuncioID"])) {
    echo "Errore: utente o annuncio non specificato.";
    exit;
}

$prezzo = $_POST["prezzo"];
$codice = $_SESSION["id"];
$stato = "disponibile";
$ID_annuncio = $_SESSION["AnnuncioID"];

// Check if the user has already made a proposal for this item
$checkQuery = $connessione->prepare("SELECT * FROM proposta WHERE ID_utente = ? AND ID_annuncio = ?");
$checkQuery->bind_param("ii", $codice, $ID_annuncio);
$checkQuery->execute();
$checkResult = $checkQuery->get_result();

if ($checkResult->num_rows > 0) {
    echo "Hai già fatto una proposta per questo articolo";
    $checkQuery->close();
    exit; // Exit the script to prevent further execution
}
$checkQuery->close();

// Inserisci la nuova proposta
$insertQuery = $connessione->prepare("INSERT INTO proposta (prezzo, ID_utente, ID_annuncio, stato) VALUES (?, ?, ?, ?)");
$insertQuery->bind_param("diis", $prezzo, $codice, $ID_annuncio, $stato);

if ($insertQuery->execute()) {
    echo "Offerta inserita con successo";
} else {
    echo "Errore durante l'inserimento dell'offerta: " . $insertQuery->error;
}

$insertQuery->close();
$connessione->close();
?>