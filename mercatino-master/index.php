<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <link rel="stylesheet" href="stylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
</head>
<body id="background" >
    <div class="row">
        <div class="card mx-auto my-5" style="width: 18rem;">
            <div class="card-body text-center" >
            
                <h5 class="card-title display-3 poetsen-one-regular">Login</h5>
                <form method="POST" action="./login/login.php">
                <label class="form-label poetsen-one-regular" style="font-family: 48px">Email:</label> <br>
                <input type="email" name="email" required placeholder="cognome.nome@itismeucci.com" class="form-control"><br>

                <label class="form-label poetsen-one-regular" style="font-family: 48px">Password:</label>  <br>
                <div class="input-group">
                    <input type="password" name="pw" id="psw" required placeholder="password" class="form-control">
                    <span class="input-group-text" >
                        <i class="bi bi-eye-slash-fill" id="eye"></i>
                    </span>
                </div>
                <?php
                    session_start();
                    if(isset($_SESSION['status']))
                    {
                        echo "<br>";
                        if($_SESSION['status'] == "Registrazione effettuata"||$_SESSION['status']=="Logout effettuato con successo")
                        {
                            echo "<label class='text-success'>".$_SESSION['status']."</label>";
                            session_unset();
                        }
                        else
                        {
                            echo "<label class='text-danger'>".$_SESSION['status']."</label>";
                            session_unset();
                        }
                    }                 
                ?>
                <br>
                <p>non sei registrato? clicca <a href="./login/registrazione.php">qui</a></p>
                <hr>
                <input type="submit" class="btn btn-primary"  required value="Accedi">
            </form>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    var eye = document.getElementById("eye");
    var pw = document.getElementById("psw");
    eye.addEventListener("click", function(){
        if(pw.type == "password")
        {
            pw.type = "text";
            eye.setAttribute("class", "bi bi-eye-fill");
        }
        else
        {
            pw.type = "password";
            eye.setAttribute("class", "bi bi-eye-slash-fill");
        }
    });
</script>