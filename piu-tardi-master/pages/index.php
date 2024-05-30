<?php
session_start();
include("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>negozio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background: rgb(61, 82, 160);
            background: linear-gradient(150deg, rgba(61, 82, 160, 0.9559164733178654) 13%, rgba(112, 145, 230, 0.9118329466357309) 37%, rgba(134, 151, 196, 0.8561484918793504) 54%, rgba(173, 187, 218, 1) 68%, rgba(237, 232, 245, 1) 100%);
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
        }

        .foto_profilo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .bordo {
            border: 1px solid black;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            height: 400px;
            /* Adjust the height as needed */
            overflow: hidden;
        }

        .bordo h3,
        .bordo p {
            margin: 10px;
            /* Add some margin to the text inside the card */
            word-wrap: break-word;
            /* Wrap long words */
        }

        .card-image img {
            height: 200px;
            max-width: 200px;
            object-fit: cover;
            /* Adjust this value as needed */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Più-tardi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorie
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            $sql = "SELECT nome, ID FROM tipologia";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $nome = $row['nome'];
                                    $ID = $row['ID'];
                                    echo "<li><a class='dropdown-item' href='index.php?filtro=$ID'>$nome</a></li>";
                                }
                            }
                            echo "<li><a class='dropdown-item' href='index.php?filtro=0'>Nessun Filtro</a></li>";
                            ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <?php
                        $sql = "SELECT foto FROM utente WHERE utente.ID = {$_SESSION["utente"]}";
                        $result = $conn->query($sql);
                        $f = $result->fetch_assoc()["foto"];
                        echo "<a href=\"./utente.php?id=" . $_SESSION["utente"] . "\"><img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Central Div with Responsive Columns -->
    <div class="container mt-5">
        <div class="row">
            <?php
            $sql = "SELECT annuncio.ID, annuncio.nome, annuncio.foto, tipologia.nome AS tip, utente.ID AS utID, utente.email AS email FROM annuncio
                JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                JOIN utente ON utente.ID = annuncio.ID_utente
                WHERE utente.ID != " . $_SESSION["utente"] . "
                AND annuncio.ID NOT IN (SELECT annuncio.ID FROM annuncio 
                                        JOIN proposta ON annuncio.ID = proposta.ID_annuncio
                                        WHERE stato LIKE \"b-accettata\")";

            $filtro;
            if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                $filtro = $_GET["filtro"];
                $sql .= " AND tipologia.ID = $filtro";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nome = $row['nome'];
                    $foto = $row['foto'];
                    $tipologia = $row['tip'];
                    $ID = $row['ID'];
                    $utID = $row['utID'];
                    $e = $row['email'];
            ?>
                    <div class="col-md-3" style="text-align:center;">
                        <div class="bordo bg-light">
                            <div class="card-image">
                                <a href="./articolo.php?idArt=<?php echo $ID; ?>&ut=<?php echo $utID; ?>"><img src="<?php echo $foto; ?>" onerror="this.src='../images/default.png'" class="img-fluid"></a>
                            </div>
                            <h3><?php echo $nome; ?></h3>
                            <p><?php echo $tipologia; ?></p>
                            <p>Caricata da:<br><a href="./utente.php?id=<?php echo $utID; ?>"><?php echo $e; ?></a></p>
                        </div>
                    </div>
            <?php
                }
            } else
                echo "<div class='col bordo bg-light d-flex justify-content-center align-items-center' style='height: 150px'>
                        <h1>NON SONO PRESENTI ARTICOLI</h1>
                      </div>";
            ?>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../js/script.js"></script>

</html>