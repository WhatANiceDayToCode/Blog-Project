<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil</title>
        <script language="javascript" type="text/javascript">
            function valideSuppr() 
            {
                if (confirm("Etes vous sur de vouoir vous déconnecter ?")) 
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        </script>
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
                echo ('Bienvenue '.$_SESSION['pseudo'].' / '.$_SESSION['nom'].' '.$_SESSION['prenom']);
                echo ('<br><br>');
                echo ('<a href="deconnexion.php"><input type="button" value="Se deconnecter" onclick="return valideSuppr()"></a>');
            }
        ?>
    </body>
    
</html>