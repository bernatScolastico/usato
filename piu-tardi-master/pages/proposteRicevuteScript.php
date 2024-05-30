<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");

$newStato = $_GET["stato"];
var_dump($newStato);echo "<br>";
$prodID = $_GET["ID"];
var_dump($prodID);echo "<br>";
$ID = $_GET["IDann"];
var_dump($ID);echo "<br>";
$sql = "UPDATE proposta SET stato = '$newStato'
        WHERE ID = $prodID";    
$conn->query($sql);
if($newStato == "b-accettata"){
    $sql = "UPDATE proposta SET stato = 'c-rifiutata' WHERE ID_annuncio = $ID AND stato = 'a-in attesa'";
    $conn->query($sql);
}
header("Location: ./proposteRicevute.php");
