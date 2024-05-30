<?php
    session_start();
    if($_SESSION['log'] ==false )
    {
        $_SESSION['status']="Devi effettuare l'accesso prima di poter accedere a questa pagina";
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">

        <link href="../css/home.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../css/modal.css">
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-2 px-lg-5">
                <img src="../img/logo.png" class="me-4" height="7%" width="7%">
                <a class="navbar-brand" href="home.php">Mercatino Meucci</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li>
                            <a href="./sendeed.php">
                                <button class="btn btn-outline-dark me-4 my-1" >
                                    <i class="bi bi-box-arrow-in-up"></i>
                                        Proposte inviate
                                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                                        <?php
                                            include('../connessione.php');
                                            $id=$_SESSION['id'];
                                            $query="SELECT COUNT(*) as num FROM Proposta WHERE Proposta.idUtente='$id'";
                                            $result=$conn->query($query);
                                            $row=$result->fetch_assoc();
                                            echo $row['num'];
                                        ?>
                                    </span>
                                </button>
                            </a>
                        </li>
                        <li>
                            <a href="./recived.php">
                                <button class="btn btn-outline-dark me-5 my-1">
                                    <i class="bi bi-box-arrow-in-down"></i>
                                        Proposte ricevute
                                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                                        <?php
                                            include('../connessione.php');
                                            $id=$_SESSION['id'];
                                            $query="SELECT COUNT(*) as num FROM Proposta JOIN Annuncio ON Annuncio.id=Proposta.idAnnuncio WHERE Annuncio.idUtente='$id'";
                                            $result=$conn->query($query);
                                            $row=$result->fetch_assoc();
                                            echo $row['num'];
                                        ?>
                                    </span>
                                </button>
                            </a>
                        </li>
                        <li>
                            <a href="./profile.php">
                                <button class="btn btn-outline-dark my-1">
                                    <i class="bi bi-person-circle"></i>
                                </button>
                            </a>
                        </li>                        
                    </ul>
                </div>
            </div>
        </nav>
        <section>
            <div class="px-4 px-lg-5 mt-5 ">
                <div class=" row justify-content-center">
                    <?php
                        

                        $id = $_SESSION['id'];
                        $query = "SELECT Proposta.prezzo as prezzo,Proposta.id as idproposta,Proposta.idUtente as idutente, Proposta.data_pubblicazione as dataP,Annuncio.nome as nome,Proposta.stato as stato,Annuncio.id as idannuncio FROM Proposta JOIN Annuncio ON Proposta.idAnnuncio=Annuncio.id JOIN Utente ON Proposta.idUtente=Utente.id WHERE  Proposta.idUtente='$id'";
                        
                       
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) 
                        {
                            while ($row = $result->fetch_assoc())
                            {
                                $idutente="SELECT Annuncio.idUtente FROM Annuncio JOIN Proposta ON Annuncio.id=Proposta.idAnnuncio WHERE Proposta.idUtente='$id'";
                                $result_idutente=$conn->query($idutente);
                                $row_idutente=$result_idutente->fetch_assoc();

                                $mail="SELECT email FROM Utente WHERE id=".$row_idutente['idUtente']." ";
                                
                                $result_mail=$conn->query($mail);
                                $row_mail=$result_mail->fetch_assoc();
                                echo "<div class='card col-xxl-xl-3 col-lg-4 col-md-6 col-sm-12 mx-3 my-3' style='width: 18rem;'>";
                                    echo "<div class='card-body p-4'>";
                                        echo "<div class='text-center poetsen-one-regular'>";
                                            echo "<h5 class='card-title '>" . $row['nome'] . "</h5>";
                                            echo "<p class='card-text'>" . $row['prezzo'] . "€"."</p>";
                                            echo "<p class='card-text'>" . $row['dataP'] . "</p>";
                                            echo "<form method='POST'  action='mostra_utente.php'>";
                                                echo "<input type='submit' class='card-text' value=". $row_mail['email']." >";
                                                echo "<input type='hidden' name='utente_da_mostrare' value='" . $row_idutente['idUtente']. "'>";
                                            echo "</form>";
                                            if($row['stato']=='r')
                                            {
                                                echo "<p class='card-text'>Proposta rifiutata</p>";
                                                echo "<form method='POST' class='mt-3 text-center'  action='../back-end/elimina_proposta.php'>";
                                                    echo "<input type='submit' class='btn btn-danger mx-2' value='Elimina' >";
                                                    echo "<input type='hidden' name='idproposta' value='" . $row['idproposta'] . "'>";
                                                echo "</form>";
                                            }
                                            else if($row['stato']=='a')
                                            {
                                                echo "<p class='card-text'>Proposta accettata</p>";
                                                echo "<form method='POST' class='mt-3 text-center'  action='../back-end/elimina_proposta_annuncio.php'>";
                                                    echo "<input type='submit' class='btn btn-success mx-2' value='Fine' >";
                                                    echo "<input type='hidden' name='idproposta' value='" . $row['idproposta'] . "'>";
                                                    echo "<input type='hidden' name='idAnnuncio' value='" . $row['idannuncio'] . "'>";
                                                echo "</form>";
                                            }
                                            else
                                            {
                                                echo "<br>";
                                                echo "<p class='card-text'>Proposta non visionata</p>";
                                            }
                                            
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        }
                        else
                        {
                            echo "<h1 class='text-center'>Non hai inviato nessuna proposta</h1>";
                        }
                    ?>
                </div>
            </div>
        </section>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/script_home.js"></script>
    </body>
</html>