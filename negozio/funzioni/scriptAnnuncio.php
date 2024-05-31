<?php
session_start();
include ("../connessione.php");

$nome= $_POST["nome"];
$descrizione = $_POST["descrizione"];
$tipologia = intval($_POST["tipologia"]);
$target_dir = "../img/";
$img = $target_dir . $_FILES["file"]["name"];
$codice = $_SESSION["id"];

$imageFileType = strtolower(pathinfo($img,PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png"  && $imageFileType != "jpeg"){
    echo "Errore: sono ammessi solo JPG,JPEG, PNG";
    $uploadOk = false;
} else{
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $img)){
    echo "Il file è caricato correttamente";
    }
    else{
        echo "errore";
    }
}

$sql= ("INSERT INTO annuncio (nome, descrizione, foto, ID_utente, ID_tipologia)  VALUES ('$nome','$descrizione','$img','$codice','$tipologia')");


var_dump($sql);
$result = $connessione->query($sql);
?>