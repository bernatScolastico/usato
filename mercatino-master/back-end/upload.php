<?php
    session_start();
    include("../connessione.php");
    $id=$_SESSION['id'];
    
    if(isset($_POST['submit'])) 
    {
        $target_dir = "../upload/";
        $descrizione=$_POST['descrizione'];
        $categotia=$_POST['categoria'];
        $nome=$_POST['nome'];
        $sql="INSERT INTO Annuncio (idUtente,nome,idCategoria,descrizione) VALUES ('$id','$nome','$categotia','$descrizione')";
        $conn->query($sql);
        $idAnnuncio = $conn->insert_id;

        $countfiles = count($_FILES['img_articolo']['name']);
        if($countfiles>10)
        {
            $_SESSION["quantita"] = "Sono ammesse al massimo 10 immagini, quelle di troppo sono state scartate";
            $countfiles=10;
        }
        else
            unset($_SESSION["quantita"]);
    
        // Looping all files
        for($i=0;$i<$countfiles;$i++)
        {
            $filename = $target_dir. $_FILES['img_articolo']['name'][$i];

            // Check if the file name already exists in the database
            $existingFileName = $target_dir.$_FILES['img_articolo']['name'][$i];
            $sql = "SELECT * FROM Foto WHERE url_foto = '$existingFileName'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Generate a random string of 5 alphanumeric characters
                $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
                
                // Append the random string to the file name before the extension
                $newFileName = pathinfo($existingFileName, PATHINFO_FILENAME) . $randomString . '.' . pathinfo($existingFileName, PATHINFO_EXTENSION);
                
                // Move the uploaded file with the new file name
                $filename =$target_dir. $newFileName;
            }

            $caricamenti_a_buon_fine;
            // Upload file
            if(move_uploaded_file($_FILES['img_articolo']['tmp_name'][$i],$filename))
            {
                $sql="INSERT INTO Foto (url_foto,idAnnuncio) VALUES ('$filename','$idAnnuncio')";
                $res=$conn->query($sql);
                if($res)
                {
                    $caricamenti_a_buon_fine++;
                }
            }
        }
        if($caricamenti_a_buon_fine==$countfiles)
        {
            $_SESSION["caricamento"] = "Caricamento avvenuto con successo";
            header("Location: ../front-end/profile.php");
        }
        else
        {
            $_SESSION["caricamento"] = "Errore nel caricamento";
            $sql="DELETE FROM Foto WHERE idAnnuncio='$idAnnuncio'";
            $conn->query($sql);
            $sql="DELETE FROM Annuncio WHERE idAnnuncio='$idAnnuncio'";
            $conn->query($sql);
            header("Location: ../front-end/profile.php");
        }
        
    }
?>