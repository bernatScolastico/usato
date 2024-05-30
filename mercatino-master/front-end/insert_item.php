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

    <link href="../css/insert.css" rel="stylesheet" />

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-2 px-lg-5">
            <img src="../img/logo.png" class="me-4 logo" >
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
                                    $query = "SELECT COUNT(*) as num FROM Proposta WHERE Proposta.idUtente='$id'";
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
                                        $query="SELECT COUNT(*) as num FROM Proposta JOIN Annuncio ON Annuncio.id=Proposta.idAnnuncio WHERE Annuncio.idUtente='$id'";
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
    <div class="row">
        <div class="card mx-auto my-5" style="width: 18rem;">
        <div class="card-body text-center">
            <h5 class="card-title display-5 poetsen-one-regular">Inserisci articolo</h5>
            <hr>
            <form method="POST" action="../back-end/upload.php" enctype="multipart/form-data">
                <label class="form-label poetsen-one-regular" style="font-family: 48px">Seleziona una o piu immagini per il tuo annuncio (max 10)</label>
                <div class="containera">
                    <input type="file" name="img_articolo[]" id="file-input" accept="image/*" onchange="preview()" multiple required>
                    <label for="file-input" class="labela">
                        <i class="fas fa-upload"></i> &nbsp; Choose A Photo
                    </label>
                    <p id="num-of-files">Nessuna foto scelta</p>
                    <div id="images"></div>
                    
                </div>
                <br>
                <label class="form-label poetsen-one-regular" style="font-family: 48px">Nome articolo</label>
                <input type="text" name="nome" aria-label="Large" class="form-control text-center">
                <br>
                <label class="form-label poetsen-one-regular" style="font-family: 48px">Descrizione (max 150 caratteri)</label>
                <input type="text" name="descrizione" aria-label="Large" class="form-control text-center">
                <br>
                <?php
                    $query = "SELECT * FROM Categoria";
                    $result = $conn->query($query);
                    echo "<label class='form-label poetsen-one-regular' style='font-family: 48px'>Categoria</label>";
                    echo "<br>";
                    echo "<select name='categoria' class='text-center '>";
                    while ($row = $result->fetch_assoc()) 
                    {
                        echo "<option  value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                    echo "</select>";
                ?>
                <br><br>
                <input type="submit" class="btn btn-primary" value="CARICA" name="submit">
            </form>
        </div>
                
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/script.js"></script>
</body>
</html>