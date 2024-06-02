<?php
session_start();
include ("../connessione.php");
if (!isset($_SESSION["utente"])){
    header("Location: ../index.php");
}
    
if (isset($_GET['AnnuncioID'])) {
      $_SESSION['AnnuncioID'] = $_GET['AnnuncioID'];
}
if (isset($_GET['ut'])) {
    $_SESSION['ut'] = $_GET['ut'];
}
$ut = $_SESSION['ut'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreaOfferta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <style>
    .centered-content {
            width: 100%;
            max-width: 800px;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 20px;
        }

        .foto_profilo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
            min-width: 450px;
        }

        .card img {
            width: 100%;
            height: auto;
            max-width: 200px;
            max-height: 200px;
        }

        a {
            color: white;
            text-decoration: none;
        }

        a:hover {
            color: white;
            text-decoration: none;
        }

        .buttons-container {
            display: none;
            margin: auto;
        }

        .buttons-container.show-buttons {
            display: block;
        }

        .buttons-container a {
            color: white;
            text-decoration: none;
        }

        .buttons-container a:hover {
            color: white;
            text-decoration: none;
        }

        .overlay {
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        img {
            display: block;
            margin: 20px auto;
            max-width: 200px;
            max-height: 200px;
        }

        h1,
        h3,
        p {
            text-align: center;
        }
    </style>
    
</head>

<body>

<section class="py-5">
    <nav class="navbar navbar-expand-lg nav">
      <div class="container">
        <a class="navbar-brand" href="../pages/home.php">
        <img class="img-fluid text-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center ms-2" height="100" src="../img/icona.jpeg" width="100"></a> 
        <h2 style="font-family: 'Dancing Script', cursive;">MEUCCI BOUTIQUE</h2>
        <button style="background-color: aliceblue !important;" aria-controls="navbarSupportedContent6" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarSupportedContent6" data-bs-toggle="collapse" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent6">
          <ul class="navbar-nav ms-auto my-2 my-lg-0">
            <li class="nav-item me-4">
              <a class="nav-link text-light" href="../pages/about.html">About</a>
            </li>
            <li class="nav-item me-4">
              <a class="nav-link text-light" href="../pages/shop.php">Shop</a>
            </li>
            <li class="nav-item me-4">
              <a class="nav-link text-light" href="creaAnnuncio.php">Aggiungi</a>
            </li>
            <li class="nav-item me-4">
              <a class="nav-link text-light" href="../pages/contact.html">Contact</a>
            </li>
          </ul>

          <div class="d-flex">
            <a class="text-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center ms-2"style="height:32px;width:32px;" href="../pages/profilo.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg></a>

            <a class="text-light border border-2 border-light rounded-circle d-flex align-items-center justify-content-center ms-2" href="https://www.instagram.com/meucci_boutique/" style="height:32px;width:32px;" target="_blank"><svg class="bi bi-instagram" fill="currentColor" height="16" viewbox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
          </svg></a>
          </div>
        </div>
      </div>
    </nav>
  </section>
<div class="profilo">
    <div class="about">
        <?php 
            echo "<h1>Annunci Venduti</h1>";
            echo "<br>"; 
        ?>

<div class="container">
            <!-- dashboard articoli -->
            <?php
        //fai una query per prendere tutti gli annunci venduti
        $ID_utente = $_SESSION["id"];
        $sql = "SELECT annuncio.nome, annuncio.foto, annuncio.ID, tipologia.nome as tip, proposta.prezzo as stat FROM annuncio
                JOIN tipologia ON annuncio.ID_tipologia = tipologia.ID
                JOIN proposta ON proposta.ID_annuncio = annuncio.ID
                WHERE annuncio.stato = 'venduto' AND annuncio.ID_utente= $ID_utente AND proposta.stato = 'accettato'";
        $result = $connessione->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                echo "<div class='row'>";
                while ($row = $result->fetch_assoc()) {
                    $nome = $row['nome'];
                    $foto = $row['foto'];
                    $tipologia = $row['tip'];
                    $ID = $row['ID'];
                    $prezzo = $row['stat'];

                    echo "<div class='col-md-6 mb-4'>
                            <div class='card'>
                                <a href='./articolo.php?idArt=$ID&ut=$ut'>
                                    <img src='$foto' class='card-img-top' alt='$nome'>
                                </a>
                                <div class='card-body'>
                                    <h5 class='card-title'>$nome</h5>
                                    <p class='card-text'>$tipologia</p>
                                    <p class='card-text'>Venduto a $prezzo €</p>
                                </div>
                            </div>
                          </div>";
                }
                echo "</div>";
            } else {
                echo "<p style='color:red'>NESSUN ANNUNCIO PRESENTE</p>";
            }
        } else {
            echo "<h1>Errore nella query</h1> . $connessione->error;";
            echo "<p>$sql</p>";
        }

        ?>
    </div>
</div>
</body>
</html>