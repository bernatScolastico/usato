<?php
session_start();
include ("../connessione.php");

// Controlla se l'utente è autenticato
if (!isset($_SESSION["utente"])) {
    // Imposta un messaggio di errore nella sessione
    $_SESSION["errato"] = "devi fare il login prima di accedere al negozio";
    // Reindirizza l'utente alla pagina di login
    header("Location: ../index.php");
    // Assicurati che lo script si fermi dopo il reindirizzamento
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $descrizione = $_POST["descrizione"];
    $tipologia = intval($_POST["tipologia"]);
    $target_dir = "../img/";
    $img = $target_dir . basename($_FILES["file"]["name"]);
    $codice = $_SESSION["id"];
    $stato = "disponibile";

    // Verifica l'estensione del file
    $imageFileType = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION["alert"] = ["type" => "error", "message" => "Errore: sono ammessi solo JPG, JPEG, PNG"];
        header("Location: creaAnnuncio.php");
        exit();
    }

    // Carica il file
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $img)) {
        $_SESSION["alert"] = ["type" => "error", "message" => "Errore durante il caricamento del file"];
        header("Location: creaAnnuncio.php");
        exit();
    }

    // Utilizza una transazione per garantire atomicità
    $connessione->begin_transaction();
    try {
        // Controlla se esiste già un annuncio con lo stesso nome
        $stmt = $connessione->prepare("SELECT COUNT(*) FROM annuncio WHERE nome = ? AND ID_utente = ?");
        $stmt->bind_param("si", $nome, $codice);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) {
            // Inserisci il nuovo annuncio
            $stmt = $connessione->prepare("INSERT INTO annuncio (nome, descrizione, foto, ID_utente, ID_tipologia, stato) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $nome, $descrizione, $img, $codice, $tipologia, $stato);
            $stmt->execute();
            $stmt->close();

            $connessione->commit();
            $_SESSION["alert"] = ["type" => "success", "message" => "Annuncio inserito con successo"];
            header("Location: ../pages/profilo.php");
            exit();
        } else {
            $_SESSION["alert"] = ["type" => "error", "message" => "Un annuncio con lo stesso nome esiste già."];
            $connessione->rollback();
            header("Location: creaAnnuncio.php");
            exit();
        }
    } catch (Exception $e) {
        $connessione->rollback();
        $_SESSION["alert"] = ["type" => "error", "message" => "Errore durante l'inserimento dell'annuncio: " . $e->getMessage()];
        header("Location: creaAnnuncio.php");
        exit();
    }
} else {
    $_SESSION["alert"] = ["type" => "error", "message" => "Richiesta non valida."];
    header("Location: creaAnnuncio.php");
    exit();
}
?>