
<?php
session_start();
include ("../connessione.php");

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


