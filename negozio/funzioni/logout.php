<?php 
session_start();
include("../connessione.php");
session_destroy();
header("Location: ../index.php");

?>
