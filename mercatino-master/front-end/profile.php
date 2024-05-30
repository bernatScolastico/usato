<?php
session_start();
if ($_SESSION['log'] == false) {
    $_SESSION['status'] = "Devi effettuare l'accesso prima di poter accedere a questa pagina";
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
    <link href="../css/profile.css" rel="stylesheet">
    <link href="../css/insert.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/modal.css">
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-2 px-lg-5">
            <img src="../img/logo.png" class="me-4 logo" height="7%" width="7%">
            <a class="navbar-brand" href="home.php">Mercatino Meucci</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li>
                        <a href="./sendeed.php">
                            <button class="btn btn-outline-dark me-4 my-1">
                                <i class="bi bi-box-arrow-in-up"></i>
                                Proposte inviate
                                <span class="badge bg-dark text-white ms-1 rounded-pill">
                                    <?php
                                    include ('../connessione.php');
                                    $id = $_SESSION['id'];
                                    $query="SELECT COUNT(*) as num FROM Proposta WHERE Proposta.idUtente='$id'";
                                    $result = $conn->query($query);
                                    $row = $result->fetch_assoc();
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
                                        include ('../connessione.php');
                                        $id = $_SESSION['id'];
                                        $query="SELECT COUNT(*) as num FROM Proposta JOIN Annuncio ON Annuncio.id=Proposta.idAnnuncio WHERE Annuncio.idUtente='$id' ";
                                        $result = $conn->query($query);
                                        $row = $result->fetch_assoc();
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
    <br>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="card col-12 ">
            <div class="text-center profile">
                <?php
                    $sql = "SELECT foto_profilo FROM Utente WHERE id = '$id'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $url = $row["foto_profilo"];
                    echo "<img src='$url' class=' rounded-circle imgg'   id='openModal'>";
                ?>
            </div>
            <div class="modal" id="modal">
                <div class="modal-inner">
                    <form method="POST" action="../back-end/img_profilo.php" enctype="multipart/form-data">
                        <div class="mt-3">
                            <?php
                                $sql = "SELECT foto_profilo FROM Utente WHERE id = '$id'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $url = $row["foto_profilo"];
                                echo "<img src='$url' class='rounded-circle imgl'>";
                            ?>
                        </div>
                        <label for="file">Seleziona un'immagine da caricare</label>
                        <br><br>
                        <div class="containera">
                            <input type="file" name="imgprofilo" id="file-input" accept="image/*" onchange="preview()">
                            <label for="file-input" class="labela">
                                <i class="fas fa-upload"></i> &nbsp; Choose A Photo
                            </label>
                            <p id="num-of-files">No Files Chosen</p>
                            <div id="images"></div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="button mx-3 my-3 col-xxl-xl--lg-md-6 col-sm-12" id="closeModal">CHIUDI</button>
                            <input type="submit" class="button  mx-3 my-3 col-xxl-xl--lg-md-6 col-sm-12" value="INVIA" name="submit" id="closeModal">
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-2 text-center">
                <h4 class="mb-0">
                    <?php
                
                        $id = $_SESSION['id'];
                        $query = "SELECT nome,cognome FROM Utente WHERE id='$id'";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        echo $row['nome'];
                        echo " ";
                        echo $row['cognome'];
                    ?>
                </h4>
                <span class="text-muted d-block mb-2">
                    <?php
                        $id = $_SESSION['id'];
                        $query = "SELECT classe FROM Utente WHERE id='$id'";
                        $result = $conn->query($query);
                        $row = $result->fetch_assoc();
                        echo "Classe: ".$row['classe']."  ";
                        function calcolaEta($dataNascita) 
                        {
                            $dataNascita = new DateTime($dataNascita);
                            $dataCorrente = new DateTime();
                            $differenza = $dataNascita->diff($dataCorrente);
                            $eta = $differenza->y;
                            return $eta;
                        }
                        $sql = "SELECT eta FROM Utente WHERE id = $id";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $dataNascita = $row["eta"];
                        $eta = calcolaEta($dataNascita);
                        echo "Eta: $eta";
                    ?>
                </span>
                <hr>
                <div class="justify-content-between align-items-center text-center mt-4 px-4">
                    <div class="stats text-center">
                        <h6 class="mb-0">Annunci attivi</h6>
                        <span>
                            <?php
                                $id = $_SESSION['id'];
                                $query = "SELECT COUNT(*) as num FROM Annuncio WHERE idUtente='$id'";
                                $result = $conn->query($query);
                                $row = $result->fetch_assoc();
                                echo $row['num'];
                            ?>
                        </span><br>
                        <span>
                        <?php
                            if(isset($_SESSION['status'])){
                                echo $_SESSION['status'];
                            }
                            unset($_SESSION['status']);
                        ?>    
                    </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <a href="../login/logout.php"><button class="col-6 my-2 mx-2 btn btn-outline-dark mt-auto" >logout</button></a>
                    <a href="../front-end/insert_item.php"><button class="col-6 my-2 mx-2 btn btn-outline-dark mt-auto" id='openModalarticolo' >carica articolo</button></a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-center articoli poetsen-one-regular"><h1 >I tuoi articoli</h1></div>
    <section>
        <div class="px-4 px-lg-5 mt-2 ">
            <div class=" row justify-content-center">
                <?php
                    $id = $_SESSION['id'];
                    $query = "SELECT Annuncio.id,Annuncio.nome as nome ,Categoria.nome as categoria,Annuncio.descrizione FROM Annuncio JOIN Categoria ON Annuncio.idCategoria=Categoria.id WHERE Annuncio.idUtente='$id'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) 
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo "<div class='card col-xxl-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mx-3 my-3' style='width: 18rem;'>";
                                echo "<div class='card-img-top'>";
                                    $foto="SELECT url_foto FROM Foto WHERE idAnnuncio=" . $row['id'];
                                    $_SESSION['idAnnuncio']= $row['id'];
                                    $resultfoto = $conn->query($foto);
                                    if ($resultfoto->num_rows > 0) 
                                    {
                                        $carouselId = 'carouselExampleControls' . $row['id'];
                                        echo "<div id='$carouselId' class='carousel carousel-dark slide' data-bs-ride='carousel'>";
                                        echo "<div class='carousel-inner'>";
                                        $first = true;
                                        while ($rowfoto = $resultfoto->fetch_assoc()) 
                                        {
                                            if ($first) {
                                                echo "<div class='carousel-item active'>";
                                                $first = false;
                                            } else {
                                                echo "<div class='carousel-item'>";
                                            }
                                            echo "<img class='d-block w-100' src='" . $rowfoto['url_foto'] . "' height='30%' width='30%'>'";
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                        echo "<button class='carousel-control-prev' type='button' data-bs-target='#$carouselId' data-bs-slide='prev'>";
                                        echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                                        echo "<span class='visually-hidden'>Previous</span>";
                                        echo "</button>";
                                        echo "<button class='carousel-control-next' type='button' data-bs-target='#$carouselId' data-bs-slide='next'>";
                                        echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                                        echo "<span class='visually-hidden'>Next</span>";
                                        echo "</button>";
                                        echo "</div>";
                                    }
                                echo "</div>";
                                echo "<div class='card-body p-4'>";
                                    echo "<div class='text-center'>";
                                        echo "<h2 class='card-title '>" . $row['nome'] . "</h5>";
                                        echo "<p class='card-text'>" . $row['categoria'] . "</p>";
                                        echo "<p class='card-text'>" . $row['descrizione'] . "</p>";
                                    echo "</div>";
                                echo "</div>";
                                echo '<div class="card-footer text-center p-4 pt-0 border-top-0 bg-transparent">';
                                    echo "<form method='POST'  action='../back-end/elimina_annuncio.php'>";
                                        echo "<input type='submit' class='btn btn-outline-dark mt-auto' value='Elimina' >";
                                        echo "<input type='hidden' name='idAnnuncio' value='" . $row['id'] . "'>";
                                    echo "</form>";
                                echo '</div>';
                            echo "</div>";
                        }
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/script.js"></script>
</body>
</html>