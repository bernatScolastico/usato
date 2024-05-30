<?php
session_start();
include ("../connessione.php");

$nome= $_POST["nome"];
$descrizione = $_POST["descrizione"];
$tipologia = intval($_POST["tipologia"]);
$img = "../img/".$_FILES["file"]["name"];
$codice = $_SESSION["id"];


$sql= ("INSERT INTO annuncio (nome, descrizione, foto, ID_utente, ID_tipologia)  VALUES ('$nome','$descrizione','$img','$codice','$tipologia')");

var_dump($sql);
$result = $connessione->query($sql);
?>