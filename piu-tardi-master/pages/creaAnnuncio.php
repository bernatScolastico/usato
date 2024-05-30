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
        }

        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: purple;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .btn-primary {
            background-color: purple;
            border: none;
        }

        .btn-primary:hover {
            background-color: darkmagenta;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="mb-0">Crea un nuovo Annuncio</h5>
                    </div>
                    <div class="card-body">
                        <a href="./index.php" class="d-block mt-3 text-center">Torna alla Home</a>
                        <form action="./creaAnnuncioScript.php" method="post" enctype="multipart/form-data"
                            class="mt-4">
                            <div class="form-group">
                                <label for="nome">Nome Articolo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descrizione">Descrizione Oggetto</label>
                                <textarea name="descrizione" class="form-control" cols="50" rows="5" maxlength="250"
                                    placeholder="Max. 250 Caratteri"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="file">Foto dell'Articolo</label>
                                <input type="file" name="file" class="form-control-file" required>
                            </div>
                            <div class="form-group">
                                <label for="tipologia">Tipologia dell'Articolo</label>
                                <select name="tipologia" class="form-control" required>
                                    <option value="0" hidden></option>
                                    <?php
                                    $sql = "SELECT * FROM tipologia";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc())
                                        echo "<option value='" . $row["ID"] . "'>" . $row["nome"] . "</option>";
                                    ?>
                                </select>
                                <br>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">INVIA</button>
                        </form>
                        <?php
                        if (isset($_SESSION["mess"])) {
                            echo "<div class='mt-3 alert alert-info text-center'>" . $_SESSION["mess"] . "</div>";
                            unset($_SESSION["mess"]);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>