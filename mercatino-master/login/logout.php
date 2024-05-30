
<?php
    session_start();
    $_SESSION['status']="Logout effettuato con successo";
    $_SESSION['log'] = false;
    session_unset();
    header("Location: ..\index.php")
?>

