<?php
    include ('../connessione.php');
    session_start();
    if($_SESSION['log'] ==false )
    {
        $_SESSION['status']="Devi effettuare l'accesso prima di poter accedere a questa pagina";
        header("Location: ../index.php");
    }
    $id=$_POST['idAnnuncio'];
    $sql = "DELETE FROM Annuncio WHERE id =$id ";
    $conn->query($sql);
    header("Location: ../front-end/profile.php");
?>
