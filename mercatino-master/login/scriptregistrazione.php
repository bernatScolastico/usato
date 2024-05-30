<?php
    session_start();
    include('../connessione.php');

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $classe=$_POST['classe'];
    $data_nascita = $_POST['data_nascita'];
    $password = $_POST['pw'];

    // Controllo se la password soddisfa i requisiti
    if (!preg_match("/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/", $password)) {
        $_SESSION['status'] = "La password deve essere di almeno 8 caratteri, contenere una lettera maiuscola, una cifra e un carattere speciale.";
        header("Location: registrazione.php");
        exit();
    }

    $password = hash("sha256", $password);

    // Controllo se l'Utente è già registrato
    $checkQuery = "SELECT * FROM Utente WHERE email = '$email'";
    $result = $conn->query($checkQuery);

    // Se non è registrato lo inserisco nel database, altrimenti mostro un errore
    if($result->num_rows == 0)
    {
        $query = "INSERT INTO Utente (username,password,nome,cognome,email,eta,classe) VALUES ('$username','$password','$nome', '$cognome', '$email','$data_nascita','$classe')";
        if ($conn->query($query)) 
        {
            $_SESSION['status'] = "Registrazione effettuata";
            header("Location: ..\index.php");
        } 
        else 
        {
            $_SESSION['status'] = "Email gia esistente";
            header("Location: registrazione.php");
        }
    }
    else 
    {
        $_SESSION['status'] = "Utente gia esistente";
        header("Location: registrazione.php");
    }
?>