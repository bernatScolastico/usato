<?php
    session_start();
    if($_SESSION['log'] ==false )
    {
        $_SESSION['status']="Devi effettuare l'accesso prima di poter accedere a questa pagina";
        header("Location: ../index.php");
    }
    else
    {
        include('../connessione.php');
        $id = $_SESSION['id'];
        $id_prp=$_POST['idproposta'];
        $sql="UPDATE Proposta SET stato='r' WHERE id='$id_prp'";
        $conn->query($sql);
        
        header("Location: ../front-end/recived.php");
    }
?>