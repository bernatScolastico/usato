<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");

$ID = $_GET["idArt"];
$sql = "DELETE FROM annuncio WHERE ID = $ID";
$result = $conn->query($sql);
header("Location: ./utente.php?id=".$_SESSION["utente"]);