<?php
mysqli_report(MYSQLI_REPORT_OFF);
$connessione = new mysqli("localhost", "root", "", "usato");

if($connessione->connect_error){
    echo "ERRORE";
}
else{
    echo "SUCCESSO";
}

?>



