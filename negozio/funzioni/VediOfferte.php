<?php
session_start();
include ("../connessione.php");

if (isset($_GET['AnnuncioID'])) {
    $_SESSION['AnnuncioID'] = $_GET['AnnuncioID'];
}

$AnnuncioID = $_SESSION['AnnuncioID'];

$stmt = $connessione->prepare("SELECT utente.nome, proposta.ID, proposta.prezzo 
                               FROM proposta 
                               JOIN annuncio ON annuncio.ID = proposta.ID_annuncio
                               JOIN utente ON utente.ID = proposta.ID_utente
                               WHERE annuncio.ID = ?");
$stmt->bind_param("i", $AnnuncioID);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Annuncio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .annuncio {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .annuncio h2 {
            margin-top: 0;
        }
        .annuncio p {
            line-height: 1.6;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Offerte disponibili</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $utenteNome = $row['nome'];
            $Id = $row['ID'];
            $prezzo = $row['prezzo'];
            ?>
            <div class="annuncio">
                <h2><?php echo "Nome: $utenteNome"; ?></h2>
                <p><?php echo "ID: $Id"; ?></p>
                <p><?php echo "Prezzo: $prezzo". "€"; ?></p>
                <a href="../funzioni/accettaOfferta.php?ID=<?php echo $Id; ?>">Accetta</a>
            </div>
            <?php
        }
    } else {
        echo "<p>Nessuna offerta disponibile per questo annuncio</p>";
    }
    $stmt->close();
    $connessione->close();
    ?>
</div>
</body>
</html>