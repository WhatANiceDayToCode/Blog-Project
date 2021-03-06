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

            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection'])
            {
                if (array_key_exists('idSujet', $_GET)) 
                {
                    $idSujet = trim($_GET['idSujet']);


                    //Si l'on est ici c'est que l'on a cliqué sur le bouton
                    if (array_key_exists('supprimer',$_POST) && $_POST['supprimer']="supprimer") 
                    {
                        //On supprime le sujet en question
                        $delete_stmt = $objPdo->prepare('DELETE 
                                                            FROM sujet 
                                                            WHERE idSujet = ?');
                        $delete_stmt->bindValue(1, $idSujet, PDO::PARAM_INT);
                        $delete_stmt->execute();

                        header('Location:accueil.php');
                    }
                }  
            }
            else
            {
                header('Location:'.$_SESSION['provenance']);
            }
        ?>
    </head>
    <body>
        <div class="sect_inc">
            <div class="title">
                <img class="warning" src="../img/warning.png" alt="warning"></img>
                Suppression du sujet
                <img class="warning" src="../img/warning.png" alt="warning"></img>
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