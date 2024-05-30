<?php
session_start();
include ("./connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>negozio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

        button#proposta {
            display: block;
            margin: 0 auto;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-div {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .form-div form {
            text-align: center;
        }

        .form-div input[type="number"] {
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .form-div input[type="submit"],
        .form-div button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin: 3px;
        }

        .form-div input[type="submit"]:hover,
        .form-div button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header text-center">
            <h5 class="mb-0">Annuncio Dettaglio</h5>
        </div>
        <div class="card-body">
            <a href="index.php" class="d-block text-center mb-4">Torna alla Home</a>
            <?php
            $ut = $_GET["ut"];
            $sql = "SELECT foto FROM utente WHERE utente.ID = $ut";
            $result = $conn->query($sql);
            $f = $result->fetch_assoc()["foto"];
            echo "<a href=\"./utente.php?id=" . $ut . "\"><img class=\"foto_profilo\" src=\"$f\" onerror=\"this.src='../images/default.png'\"></a>";
            $art = $_GET["idArt"];
            $sql = "SELECT a.id, a.nome AS nome, a.descrizione AS descr, a.foto AS foto, a.datacaricamento AS data, t.nome AS tipo, u.email AS email, u.ID as utID FROM annuncio AS a
                JOIN tipologia AS t ON t.ID = a.ID_tipologia
                JOIN utente AS u ON u.ID = a.ID_utente
                WHERE a.ID = $art";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $n = $row["nome"];
                $d = $row["descr"];
                $f = $row["foto"];
                $data = explode("-", $row["data"]);
                $newData = $data[2] . "/" . $data[1] . "/" . $data[0];
                $e = $row["email"];
                $t = $row["tipo"];
                $utID = $row["utID"];

                echo "<h1>$n</h1>";
                echo "<img src=\"$f\" onerror=\"this.src='../images/default.png'\" width=\"200px\" height=\"200px\"><br>";
                echo "<h3>$d</h3>";
                echo "<p>Caricata da:<br><a href=\"./utente.php?id=$utID\">$e<a></p>"; //LINK DIRETTO ALL'UTENTE
                echo "<p>$t - $newData</p>";
                if ($utID != $_SESSION["utente"]) {
                    $sql = "SELECT * FROM proposta WHERE ID_annuncio = $id AND stato = 'b-accettata'";
                    $result2 = $conn->query($sql);
                    if ($result2->num_rows > 0)
                        echo "<h3 class='text-center'>Articolo già venduto, <a href=\"./index.php\">Cerca qualcos'altro</a></h3>";
                    else {
                        echo "<button id=\"proposta\" class='btn btn-primary'>Fai una Proposta</button>";
                    }
                }
            }
            if (isset($_SESSION["messaggio"]) or !empty($_SESSION["messaggio"])) {
                echo "<br><p class='text-center'>{$_SESSION["messaggio"]}</p>";
                unset($_SESSION["messaggio"]);
            }
            ?>
        </div>
    </div>
</body>

<script>
    function showProposalForm() {
        // Create the overlay div
        const overlay = document.createElement("div");
        overlay.classList.add("overlay");
        document.body.appendChild(overlay);

        // Create the form div
        const formDiv = document.createElement("div");
        formDiv.classList.add("form-div");
        overlay.appendChild(formDiv); // Append the formDiv to the overlay

        // Get the ID from the PHP variable
        const id = '<?php echo $id; ?>';
        const ut = '<?php echo $utID;?>';

        // Create the form elements
        const form = document.createElement("form");
        form.action = "creaProposta.php";
        form.method = "post";
        formDiv.appendChild(form);

        const input = document.createElement("input");
        input.type = "number";
        input.name = "proposta";
        input.placeholder = "Inserisci la tua proposta";
        input.min = 0;
        input.required = true;
        form.appendChild(input);

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "id";
        hiddenInput.value = id;
        form.appendChild(hiddenInput);

        const hiddenInput2 = document.createElement("input");
        hiddenInput2.type = "hidden";
        hiddenInput2.name = "ut";
        hiddenInput2.value = ut;
        form.appendChild(hiddenInput2);

        const buttons = document.createElement("div");
        form.appendChild(buttons);

        const submitButton = document.createElement("button");
        submitButton.type = "submit";
        submitButton.textContent = "Invia";
        buttons.appendChild(submitButton);

        const cancelButton = document.createElement("button");
        cancelButton.type = "button";
        cancelButton.textContent = "Annulla";
        cancelButton.onclick = () => {
            overlay.remove();
        };
        buttons.appendChild(cancelButton);
    }

    // Add event listener to the "proposta" button
    document.getElementById("proposta").addEventListener("click", showProposalForm);
</script>

</html>