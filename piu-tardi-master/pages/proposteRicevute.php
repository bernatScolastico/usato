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
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .foto_profilo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 20px auto;
            display: block;
        }

        body {
            padding-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
            min-width: 450px;
        }

        .card-header {
            background-color: purple;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .card .card {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid black;
            max-width: 400px;
            min-width: 300px;
        }

        h1,
        h3,
        p {
            text-align: center;
        }

        img {
            display: block;
            margin: 20px auto;
            max-width: 200px;
            max-height: 200px;
        }

        button {
            width: 30%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin: 3px;
        }

        button:hover {
            background-color: #0069d9;
        }

        .div-link {
            text-align: center;
        }

        .in-attesa {
            background-color: rgba(255, 255, 0, 0.6);
        }

        .rifiutata {
            background-color: rgba(255, 0, 0, 0.6);
        }

        .accettata {
            background-color: rgba(0, 255, 0, 0.6);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1>Proposte Ricevute</h1>
                    </div>
                    <div class="card-body">
                        <?php
                        $sql = "SELECT foto FROM utente WHERE utente.ID = {$_SESSION["utente"]}";
                        $result = $conn->query($sql);
                        $f = $result->fetch_assoc()["foto"];
                        echo "<a href=\"./utente.php?id=" . $_SESSION["utente"] . "\"><img class=\"foto_profilo img-thumbnail mx-auto d-block\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";
                        ?>
                        <a href="./index.php" class="d-block mt-3 text-center">Torna alla Home</a>

                        <?php
                        //dati relativi alla proposta
                        $sql = "SELECT proposta.ID AS prodID, proposta.prezzo AS prezzo, proposta.ID_utente AS utID, dataproposta, stato, annuncio.ID AS annID FROM proposta
                                JOIN annuncio ON annuncio.ID = proposta.ID_annuncio
                                JOIN utente ON annuncio.ID_utente = utente.ID
                                WHERE utente.ID = {$_SESSION["utente"]}
                                ORDER BY stato";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $prodID = $row['prodID'];
                                $prezzo = $row['prezzo'];
                                $utID = $row['utID']; //id utente della proposta
                                $s = $row["stato"];
                                $annID = $row["annID"];

                                //ottengo dati annuncio
                                $sql = "SELECT annuncio.*, tipologia.nome AS tipologia FROM annuncio
                                        JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                                        WHERE annuncio.ID = $annID";
                                $result2 = $conn->query($sql);
                                $ann = $result2->fetch_assoc();
                                $foto = $ann['foto'];
                                $nome = $ann["nome"];
                                $ID = $ann["ID"]; // id dell'annuncio
                                $tipologia = $ann["tipologia"];

                                //ottengo dati utente della proposta
                                $sql = "SELECT * FROM utente
                                        WHERE utente.ID = $utID";
                                $result3 = $conn->query($sql);
                                $ut = $result3->fetch_assoc();
                                $e = $ut["email"];

                                if ($s == "a-in attesa")
                                    echo "<div class=\"card in-attesa\">";
                                else if ($s == "b-accettata")
                                    echo "<div class=\"card accettata\">";
                                else if ($s == "c-rifiutata")
                                    echo "<div class=\"card rifiutata\">";
                                //ricostruisco la data
                                $data = explode("-", $row["dataproposta"]);
                                $newData = $data[2] . "/" . $data[1] . "/" . $data[0];

                                echo "<a href=\"./articolo.php?idArt=$ID&ut=$utID\"><img src=\"$foto\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\" \"></a>
                                        <h3>$nome</h3>
                                        <p>$tipologia</p>
                                        <p>Proposta da:<br><a href=\"./utente.php?id=$utID\">$e<a></p>
                                        <p>Prezzo Proposto: <b>$prezzo €</b></p>";
                                if ($s == 'a-in attesa') {
                                    echo "<p style=\"margin-bottom: 0px;\">$newData</p>";
                                    echo "<div class=\"p-3 div-link\">
                                            <a href=\"./proposteRicevuteScript.php?ID=$prodID&stato=b-accettata&IDann=$ID\"><button>Accetta</button></a>
                                            <a href=\"./proposteRicevuteScript.php?ID=$prodID&stato=c-rifiutata\"><button>Rifiuta</button></a>
                                        </div>";
                                } else
                                    echo "<p>$newData</p>";

                                echo "</div>";
                            }
                        } else
                            echo "<div class='col card bg-light d-flex justify-content-center align-items-center' style='height: 150px'>
                                    <h1>NON SONO PRESENTI ARTICOLI</h1>
                                </div>";
                        ?>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>