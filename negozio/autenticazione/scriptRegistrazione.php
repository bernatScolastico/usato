<?php
session_start();
include("../connessione.php");

// Verifica che tutti i campi del modulo siano stati inviati
if (isset($_POST["email"], $_POST["password"], $_POST["nome"], $_POST["Cognome"], $_POST["classe"], $_POST["eta"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $nome = $_POST["nome"];
    $cognome = $_POST["Cognome"];
    $classe = $_POST["classe"];
    $eta = $_POST["eta"];

    // Hash della password
    $anony = hash("sha256", $password);

    // Verifica se l'email è già presente nel database
    $sql_check_email = "SELECT email FROM utente WHERE email = ?";
    $stmt_check_email = $connessione->prepare($sql_check_email);
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    if ($result_check_email->num_rows > 0) {
        // Crea un messaggio di errore e reindirizza alla pagina index.php
        $_SESSION["errore_registrazione"] = "L'email inserita è già utilizzata.";
        $stmt_check_email->close();
        header("Location: ../index.php");
        exit;
    } else {
        $stmt_check_email->close();

        // Inserisci il nuovo utente nel database
        $sql_insert_user = "INSERT INTO utente (password, nome, cognome, eta, classe, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_user = $connessione->prepare($sql_insert_user);
        $stmt_insert_user->bind_param("ssssss", $anony, $nome, $cognome, $eta, $classe, $email);

        if ($stmt_insert_user->execute()) {
            $_SESSION["successo_registrazione"] = "Registrazione avvenuta con successo! Effettua il login per accedere al negozio.";
            header("Location: ../index.php");
            exit;
        } else {
            // Crea un messaggio di errore e reindirizza alla pagina index.php
            $_SESSION["errore_registrazione"] = "Errore durante l'inserimento nel database: " . $stmt_insert_user->error;
            header("Location: ../index.php");
            exit;
        }

        $stmt_insert_user->close();
    }
} else {
    // Se i campi del modulo non sono stati inviati, crea un messaggio di errore e reindirizza alla pagina index.php
    $_SESSION["errore_registrazione"] = "Tutti i campi del modulo devono essere compilati.";
    header("Location: ../index.php");
    exit;
}
$connessione->close();
?>


