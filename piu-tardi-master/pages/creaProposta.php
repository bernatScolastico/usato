<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");

$id = $_POST["id"];
$ut = $_POST["ut"];
$p = $_POST["proposta"];
var_dump($id);
var_dump($p);
$sql = "INSERT INTO proposta (prezzo, ID_utente, ID_annuncio, stato)
        VALUES ($p, " . $_SESSION["utente"] . ", $id, 'a-in attesa')";
$result = $conn->query($sql);
if (!$result) {
    $_SESSION["messaggio"] = "ERRORE NELL'INVIO DELLA PROPOSTA";
} else
    $_SESSION["messaggio"] = "PROPOSTA INVIATA CON SUCCESSO";
header("Location: ./articolo.php?idArt=$id&ut=$ut");
// echo "--------------".$ut."--------------".$id."----------------";
