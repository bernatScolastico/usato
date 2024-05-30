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
    <div class="centered-content">
        <?php
        $ut = $_GET["id"];
        if ($ut != $_SESSION["utente"]) {
            $sql = "SELECT foto FROM utente WHERE utente.ID = $ut";
            $result = $conn->query($sql);
            $f = $result->fetch_assoc()["foto"];
            echo "<img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\">";
            $sql = "SELECT * FROM utente WHERE ID = $ut";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $e = $row["email"];
            echo "<h1>$e</h1>";
            echo "<div class=\"text-center\">
                <a href=\"index.php\" class=\"btn btn-primary mt-3\">Torna alla Home</a>
            </div>";
        } else {
            $sql = "SELECT nome, cognome FROM utente WHERE id = " . $_SESSION["utente"] . "";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo "<h1>Benvenuto/a " . $row["nome"] . " " . $row["cognome"] . "</h1>";
            echo "<a href=\"index.php\" class=\"btn btn-primary mt-3\">Torna alla Home</a>";
            echo "<br>";
        }
        ?>
        <?php
        if ($ut == $_SESSION["utente"]) {
            echo "<a href=\"./creaAnnuncio.php\" class=\"btn btn-secondary mt-2\">Crea un nuovo Annuncio</a>
            <br>
            <a href=\"./proposteRicevute.php\" class=\"btn btn-secondary mt-2\">Controlla Proposte Ricevute</a>
            <br>
            <a href=\"./proposteFatte.php\" class=\"btn btn-secondary mt-2\">Controlla Proposte Fatte</a>
            <br>
            <button id=\"CambiaFoto\" class=\"btn btn-warning mt-2\">Cambia Foto Profilo</button>
            <br>
            <a class=\"btn btn-danger mt-2\" href=\"logout.php\">Log Out</a>
            <br>
            <button id=\"toggleButton\" class=\"btn btn-danger mt-2\">Elimina Annuncio</button>
            <br>";
        }
        if (isset($_SESSION["mess"])) {
            echo "<p class=\"mt-3 alert alert-info\">" . $_SESSION["mess"] . "</p>";
            unset($_SESSION["mess"]);
        }
        ?>
        <br>
        <div>
            <!-- menu a tendina categorie -->
            <form action="utente.php" method="GET" class="form-inline">
                <label for="filtro" class="mr-2">Filtro</label>
                <select name="filtro" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="0" hidden></option>
                    <option value="0">Nessun Filtro</option>
                    <?php
                    $sql = "SELECT nome, ID FROM tipologia";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $nome = $row['nome'];
                            $ID = $row['ID'];
                            echo "<option value=\"$ID\">$nome</option>";
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="id" value="<?php echo $ut; ?>">
            </form>
        </div>
        <div class="card-body">
            <!-- dashboard articoli -->
            <?php
            $sql = "SELECT annuncio.ID, annuncio.nome, annuncio.foto, tipologia.nome AS tip FROM annuncio
                        JOIN tipologia ON tipologia.ID = annuncio.ID_tipologia
                        JOIN utente ON utente.ID = annuncio.ID_utente";
            if ($ut != $_SESSION["utente"]) {
                $sql .= " WHERE annuncio.ID NOT IN (SELECT annuncio.ID FROM annuncio 
                                                    JOIN proposta ON annuncio.ID = proposta.ID_annuncio
                                                    WHERE stato LIKE \"b-accettata\")";
                if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                    $filtro = $_GET["filtro"];
                    $sql .= " AND tipologia.ID = $filtro AND utente.ID = $ut";
                } else {
                    $sql .= " AND utente.ID = $ut";
                }
            } else {
                if (isset($_GET["filtro"]) and $_GET["filtro"] != 0) {
                    $filtro = $_GET["filtro"];
                    $sql .= " WHERE tipologia.ID = $filtro AND utente.ID = $ut";
                } else {
                    $sql .= " WHERE utente.ID = $ut";
                }
            }

            $result = $conn->query($sql);
            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nome = $row['nome'];
                        $foto = $row['foto'];
                        $tipologia = $row['tip'];
                        $ID = $row['ID'];
                        echo "<div class=\"card centered-content\">
                                <a href=\"./articolo.php?idArt=$ID&ut=$ut\"><img class=\"\" src=\"$foto\" onerror=\"this.src='../images/default.png'\"></a>
                                <h3>$nome</h3>
                                <p>$tipologia</p>
                                <button class=\"btn btn-danger buttons-container\"><a href=\"./eliminaAnnuncio.php?idArt=$ID&ut=$ut\">Elimina</a></button>
                            </div>";
                    }
                } else {
                    echo "<p style=\"color:red\">NESSUN ANNUNCIO PRESENTE</p>";
                }
            } else {
                echo "<h1>Errore nella query</h1>";
                echo "<p>$sql</p>";
            }
            ?>
        </div>
    </div>
</body>
<script>
    function showProposalForm() {
        // Create the overlay div
        const overlay = document.createElement("div");
        overlay.classList.add("overlay", "d-flex", "justify-content-center", "align-items-center");
        document.body.appendChild(overlay);

        // Create the form div
        const formDiv = document.createElement("div");
        formDiv.classList.add("form-div", "p-4", "bg-white", "border", "rounded", "shadow");
        overlay.appendChild(formDiv);

        // Create the form elements
        const form = document.createElement("form");
        form.action = "./CambiaFotoProfilo.php";
        form.method = "post";
        form.enctype = "multipart/form-data";
        formDiv.appendChild(form);

        const input = document.createElement("input");
        input.type = "file";
        input.name = "foto";
        input.required = true;
        input.classList.add("form-control", "mb-3");
        form.appendChild(input);

        const buttons = document.createElement("div");
        buttons.classList.add("d-flex", "justify-content-between");
        form.appendChild(buttons);

        const submitButton = document.createElement("button");
        submitButton.type = "submit";
        submitButton.textContent = "Invia";
        submitButton.classList.add("btn", "btn-primary");
        buttons.appendChild(submitButton);

        const cancelButton = document.createElement("button");
        cancelButton.type = "button";
        cancelButton.textContent = "Annulla";
        cancelButton.classList.add("btn", "btn-secondary");
        cancelButton.onclick = () => {
            overlay.remove();
        };
        buttons.appendChild(cancelButton);
    }

    function toggleButtons() {
        const buttonsContainers = document.querySelectorAll('.buttons-container');
        const b = document.getElementById('toggleButton');
        buttonsContainers.forEach((container) => {
            container.classList.toggle('show-buttons');
        });
        if (b.innerHTML == "Elimina Annuncio")
            b.innerHTML = "Annulla";
        else
            b.innerHTML = "Elimina Annuncio";
    }

    document.getElementById('toggleButton').addEventListener('click', toggleButtons);

    // Add event listener to the "CambiaFoto" button
    document.getElementById("CambiaFoto").addEventListener("click", showProposalForm);
</script>


</html>