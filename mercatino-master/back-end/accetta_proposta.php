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
        $id_ann=$_POST['idAnnuncio'];
        $sql="UPDATE Annuncio SET proposta_accettata='$id_prp' WHERE id='$id_ann'";
        $conn->query($sql);
        $sql="UPDATE Proposta SET stato='a' WHERE id='$id_prp'";
        $conn->query($sql);
        $sql= "DELETE FROM Annuncio WHERE id='$id_ann'";
        $conn->query($sql);
        
        header("Location: ../front-end/recived.php");
    }
?>