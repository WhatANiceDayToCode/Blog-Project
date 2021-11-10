<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="./style.css">
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">
        <title>Suppression d'un sujet</title>

        <?php
            include_once("../connexion/connexion.php");
            session_start();

            $idSujet = null;
            $connecte = false;

            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection'])
            {
                $connecte = true;
            }

            if ($connecte && array_key_exists('idSujet', $_GET)) 
            {
                $idSujet = $_GET['idSujet'];
            }


        ?>
    </head>
    <body>
        <div class="sect_inc">
            <div class="title">Suppression du sujet</div>
            <div>

            </div>
                <form action="" method="post">
                    <button type="button" value="supprimer">Suppression du menu</button>
                    <?php
                        echo ('<a href="'.$_SESSION['provenance'].'"><button type="button" class="button">Retourner au sujet</button></a>');
                    ?>
                </form>
                <a href="accueil.php">Retourner à l'accueil</a>
        </div>
        <input type="button" value="Suppression du menu">
    </body>
</html>