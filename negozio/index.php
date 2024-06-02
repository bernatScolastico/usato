<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticazione</title>
    <link rel="stylesheet" href="s.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<script>
// PHP per verificare se c'è un messaggio di errore nella sessione
<?php
if ($_SESSION["errato"]) {
    $message = $_SESSION["errato"];
    echo "Swal.fire({
        title: 'Errore',
        text: '" . $message . "',
        icon: 'error'
    });";
    unset($_SESSION["errato"]); // Rimuovi il messaggio una volta mostrato
}
?>
</script>
<?php
// Controlla se c'è un messaggio di errore di registrazione nella sessione
if (isset($_SESSION["errore_registrazione"])) {
    echo "<script>alert('" . $_SESSION["errore_registrazione"] . "');</script>";
    // Rimuovi il messaggio di errore dalla sessione dopo averlo visualizzato
    unset($_SESSION["errore_registrazione"]);
}
?>
<script>
<?php
// Verifica se c'è un messaggio di successo nella sessione
if (isset($_SESSION["successo_registrazione"])) {
    $message = $_SESSION["successo_registrazione"];
    echo "Swal.fire({
        title: 'Successo',
        text: '" . $message . "',
        icon: 'success'
    });";
    // Rimuovi il messaggio dalla sessione dopo averlo mostrato
    unset($_SESSION["successo_registrazione"]);
}
?>
</script>
    <div class="wrapper">
        <span class="bg-animate"></span>
        <span class="bg-animate2"></span>

        <div class="form-box login">
            <h2 class="animation" style="--i:0; --j:21;">Login</h2>
            <form action="autenticazione/scriptlogin.php" method="POST">
                <div class="input-box animation" style="--i:1; --j:22;">
                    <input type="text" name="email" required>
                    <label>Username</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:2; --j:23;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn animation" style="--i:3; --j:24;">Login</button>
                <div class="logreg-link animation" style="--i:4; --j:25;">
                    <p>Don't have an account? <a href="#" class="register-link">Sign Up</a></p>
                </div>
            </form>
        </div>
        <div class="info-text login">
            <h2 class="animation" style="--i:0; --j:20;">Welcome Back To Meucci Boutique!</h2>
        </div>
        <div class="form-box register">
            <h2 class="animation" style="--i:17; --j:0;">Sign Up</h2>
            <form action="autenticazione/scriptRegistrazione.php" method="POST">
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" name="email"  required>
                    <label>Email</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" name="nome"  required>
                    <label>Nome</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" name="Cognome"  required>
                    <label>Cognome</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:20; --j:3;">
                    <input type="password" name="password" required>
                    <label>Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" name="classe"  required>
                    <label>Classe</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" name="eta"  required>
                    <label>eta</label>
                    <i class='bx bxs-user'></i>
                </div>
                <button type="submit" class="btn animation" style="--i:21; --j:4;">Sign Up</button>
                <div class="logreg-link animation" style="--i:22; --j:5;">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
        <div class="info-text register">
            <h2 class="animation" style="--i:17; --j:0;">Welcome Back!</h2>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>