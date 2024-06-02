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

$ID_utente = $_SESSION["id"];
$ID_proposta = $_GET["ID"];

$sql = "SELECT * FROM proposta WHERE ID = $ID_proposta";
$result = $connessione->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ID_annuncio = $row["ID_annuncio"];
    $prezzo = $row["prezzo"];
    $ID_venditore = $row["ID_utente"];
    
    $sql_accetta = "UPDATE proposta SET stato = 'accettato' WHERE ID = $ID_proposta";
    $sql_rifiuta = "UPDATE proposta SET stato = 'rifiutato' WHERE ID_annuncio = $ID_annuncio AND ID != $ID_proposta";
    $sql_annuncio = "UPDATE annuncio SET stato = 'venduto' WHERE ID = $ID_annuncio";

    if ($connessione->query($sql_accetta) === TRUE and $connessione->query($sql_rifiuta) === TRUE and $connessione->query($sql_annuncio) === TRUE){
        $_SESSION["alertOfferta"] = "Offerta accettata";
        header("Location: ../pages/profilo.php");
        exit();
    } else {
        $_SESSION["alertOfferta"] = "Errore durante l'accettazione dell'offerta: " . $connessione->error;
        header("Location: ../pages/profilo.php");
        exit();
    }
} else {
    $_SESSION["alertOfferta"] = "Nessuna offerta trovata";
    header("Location: ../pages/profilo.php");
    exit();
}
?>











