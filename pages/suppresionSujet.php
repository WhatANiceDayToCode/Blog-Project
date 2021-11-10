<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sup^pression d'un sujet</title>

        <?php
            include_once("../connexion/connexion.php");
            session_start();

            $idSujet = null;

            if ($connecte && array_key_exists('idSujet', $_GET)) 
            {
                $idSujet = $_GET['idSujet'];
            }
        ?>
    </head>
    <body>
        
    </body>
</html>