
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
if (isset($_GET['AnnuncioID'])) {
    $_SESSION['AnnuncioID'] = $_GET['AnnuncioID'];
}

$AnnuncioID = $_SESSION['AnnuncioID'];


$sql = "DELETE FROM annuncio WHERE annuncio.ID = $AnnuncioID";
$sql_proposte = "DELETE FROM proposta WHERE proposta.ID_annuncio = $AnnuncioID";
$result = $connessione->query($sql);
$result_proposte = $connessione->query($sql_proposte);

if ($connessione->query($sql) === TRUE and $connessione->query($sql_proposte) === TRUE){
        header("Location: ../pages/profilo.php");
    exit;
} else {
    echo "Errore durante l'eliminazione dell'annuncio: " . $connessione->error;
}

?>


