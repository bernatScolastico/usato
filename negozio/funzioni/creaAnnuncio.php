<?php
session_start();
include ("../connessione.php");
if (!isset($_SESSION["utente"]))
    header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreaAnnuncio</title>
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
                        <form action="scriptAnnuncio.php" method="post" enctype="multipart/form-data"
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
                                    $result = $connessione->query($sql);
                                    while ($row = $result->fetch_assoc())
                                        echo "<option value='" . $row["ID"] . "'>" . $row["nome"] . "</option>";
                                    ?>
                                </select>
                                <br>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">INVIA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>