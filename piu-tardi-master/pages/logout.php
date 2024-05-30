<?php
session_start();
include("./connessione.php");
session_unset();
header("Location: ../index.php");
