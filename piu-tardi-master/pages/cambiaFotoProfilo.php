<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");


$sql = "SELECT nome, cognome, foto FROM utente WHERE id = {$_SESSION["utente"]}";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$n = $row["nome"];
$c = $row["cognome"];
$f = $row["foto"];

var_dump($n);
var_dump($c);
var_dump($f);

if (file_exists($f))
    unlink($f);

$target_dir = "../images/" . $_SESSION["utente"] . "/";
$target_type = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
$target_name = $n . $c . "." . $target_type;
$target_file = $target_dir . $target_name;

var_dump($target_dir);echo "<br>";
var_dump($target_type);echo "<br>";
var_dump($target_name);echo "<br>";
var_dump($target_file);echo "<br>";

if ($target_type != "jpg" && $target_type != "jpeg" && $target_type != "png") {
    echo "Dentro l'if dell'estensione<br>";
    $_SESSION["mess"] = "Errore: sono ammessi solo i formati JPG, JPEG e PNG";
    header("Location: ./utente.php?id={$_SESSION["utente"]}");
    exit;
}

if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
    $sql = "UPDATE utente SET foto = '$target_file'
            WHERE id = {$_SESSION["utente"]}";
    var_dump($sql);echo "<br>";
    $result = $conn->query($sql);
    var_dump($result);echo "<br>";
    $_SESSION["mess"] = "Il file è stato caricato correttamente";
    header("Location: ./utente.php?id={$_SESSION["utente"]}");
} else {
    $_SESSION["mess"] = "Errore durante il caricamento";
    header("Location: ./utente.php?id={$_SESSION["utente"]}");
}
