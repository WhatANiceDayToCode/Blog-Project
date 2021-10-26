<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil</title>

        <?php
            session_start();
            include_once('../connexion/connexion.php');
            $message = "";
            $connecte = false;

            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) 
            {
                $message = "Connecté";
                $connecte = true;
            }
        
            $_SESSION['provenance'] = 'accueil.php';
        ?>
    </head>
    <body>
        <?php
            if (!$connecte) 
            {
                echo('<a href="login.php">Se connecter</a><br>');
                echo('<a href="creerCompte.php">Creer un compte</a><br>');
            }
            else
            {
                echo $message.'<br>';
                echo $_SESSION['pseudo'];
            }
        ?>
        <br><a href="deconnexion.php">deconnecter</a>
    </body>
</html>