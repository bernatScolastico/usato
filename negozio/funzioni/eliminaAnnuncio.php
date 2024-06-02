<?php
session_start();
include ("../connessione.php");

// Controlla se l'utente è autenticato
if (!isset($_SESSION["utente"])) {
    // Imposta un messaggio di errore nella sessione
    $_SESSION["errato"] = "devi fare il login prima di accedere al negozio";
    // Reindirizza l'utente alla pagina di login
    header("Location: ../index.php");
    // Assicurati che lo script si fermi dopo il reindirizzamento
    exit();
}

if (isset($_GET['AnnuncioID'])) {
    $_SESSION['AnnuncioID'] = $_GET['AnnuncioID'];
}

$AnnuncioID = $_SESSION['AnnuncioID'];

$sql = "DELETE FROM annuncio WHERE annuncio.ID = $AnnuncioID";
$sql_proposte = "DELETE FROM proposta WHERE proposta.ID_annuncio = $AnnuncioID";

if ($connessione->query($sql) === TRUE && $connessione->query($sql_proposte) === TRUE) {
    $_SESSION["alert"] = ["type" => "success", "message" => "Annuncio eliminato con successo"];
} else {
    $_SESSION["alert"] = ["type" => "error", "message" => "Errore durante l'eliminazione dell'annuncio: " . addslashes($connessione->error)];
}

$connessione->close();

header("Location: ../pages/profilo.php");
exit();
?>
