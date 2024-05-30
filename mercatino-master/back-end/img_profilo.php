<?php

    session_start();
    include("../connessione.php");
    $id=$_SESSION['id'];

    $target_dir = "../upload/";
    $target_file = $target_dir . $_FILES["imgprofilo"]["name"];
    $target_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if($target_type != "jpg" && $target_type != "jpeg" && $target_type != "png")
    {
        $_SESSION["foto"] = "Errore: sono ammessi solo i formati JPG, JPEG e PNG";
        header("Location: ../front-end/profile.php");
        exit;
    }

    // Check if the file name already exists in the database
    $existingFileName = $target_dir.$_FILES['imgprofilo']['name'];
    $sql = "SELECT * FROM Utente WHERE foto_profilo = '$existingFileName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a random string of 5 alphanumeric characters
        $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
        
        // Append the random string to the file name before the extension
        $newFileName = pathinfo($existingFileName, PATHINFO_FILENAME) . $randomString . '.' . pathinfo($existingFileName, PATHINFO_EXTENSION);
        
        // Move the uploaded file with the new file name
        $target_file =$target_dir. $newFileName;
    }

    if(move_uploaded_file($_FILES["imgprofilo"]["tmp_name"], $target_file))
    {
        $sql = "UPDATE Utente SET foto_profilo = '$target_file' WHERE id = '$id'";
        $result = $conn->query($sql);
        header("Location: ../front-end/profile.php");
    }
    else
    {
        $_SESSION["foto"] = "Errore durante il caricamento";
        header("Location: ../front-end/profile.php");
    }
?>