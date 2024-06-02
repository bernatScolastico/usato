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

if (!isset($_SESSION["id"]) || !isset($_SESSION["AnnuncioID"])) {
    $_SESSION["alert"] = ["type" => "error", "message" => "Errore: utente o annuncio non specificato."];
    header("Location: ../pages/shop.php");
    exit();
}

$prezzo = $_POST["prezzo"];
$codice = $_SESSION["id"];
$stato = "disponibile";
$ID_annuncio = $_SESSION["AnnuncioID"];

// Controlla che il prezzo sia un numero
if (!is_numeric($prezzo) || $prezzo <= 0) {
    $_SESSION["alert"] = ["type" => "error", "message" => "Il prezzo deve essere un numero valido."];
    header("Location: ../pages/shop.php");
    exit();
}

// Verifica se l'utente ha già fatto una proposta per questo articolo
$checkQuery = $connessione->prepare("SELECT * FROM proposta WHERE ID_utente = ? AND ID_annuncio = ?");
$checkQuery->bind_param("ii", $codice, $ID_annuncio);
$checkQuery->execute();
$checkResult = $checkQuery->get_result();

if ($checkResult->num_rows > 0) {
    $_SESSION["alert"] = ["type" => "error", "message" => "Hai già fatto una proposta per questo articolo."];
    $checkQuery->close();
    header("Location: ../pages/shop.php");
    exit();
}
$checkQuery->close();

// Inserisci la nuova proposta
$insertQuery = $connessione->prepare("INSERT INTO proposta (prezzo, ID_utente, ID_annuncio, stato) VALUES (?, ?, ?, ?)");
$insertQuery->bind_param("diis", $prezzo, $codice, $ID_annuncio, $stato);

if ($insertQuery->execute()) {
    $_SESSION["alert"] = ["type" => "success", "message" => "Offerta inserita con successo."];
} else {
    $_SESSION["alert"] = ["type" => "error", "message" => "Errore durante l'inserimento dell'offerta: " . addslashes($insertQuery->error)];
}

$insertQuery->close();
$connessione->close();

header("Location: ../pages/shop.php");
exit();
?>
