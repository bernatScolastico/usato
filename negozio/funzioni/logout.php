<?php 
session_start();
include("../connessione.php");

// Check if session exists before destroying it
if (session_id()) {
    session_destroy();
}

// Redirect to the homepage
header("Location: ../index.php");
exit();
?>
