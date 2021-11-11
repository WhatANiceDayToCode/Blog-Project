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
            include_once("supprimerSujetTraitement.php");
        ?>
    </head>
    <body>
        <div class="sect_inc">
            <div class="title">
                Suppression du sujet
            </div>
            <div class="info_suppr_sujet">
                Attention, Si vous venez à supprimer ce sujet, vous supprimerez également toutes les réponses liées à ce sujet. La suppresion seras irréversible
            </div>
            <form id="form_suppr_sujet" action="" method="post">
                <button id="bouton_supprimer_sujet" type="submit" name="supprimer" value="supprimer">Suppression du menu</button>  
                <a href="<?php echo $_SESSION['provenance']?>">
                    <button type="button" class="button">Retourner au sujet</button>
                </a>
            </form>
            <a href="accueil.php">Retourner à l'accueil</a>
        </div>
    </body>
</html>