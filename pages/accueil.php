<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil</title>

        <?php
            session_start();
            include_once("../connexion/connexion.php");
        ?>
    </head>
    <body>
        <a href="login.php">Se connecter</a><br>
        <a href="creerCompte.php">Creer un compte</a><br>
    </body>
</html>