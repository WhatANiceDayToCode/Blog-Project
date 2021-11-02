<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Créer un Sujet</title>

        <?php
            session_start();
            include_once("../connexion/connexion.php");
            $message = "";
            $connecte = $_SESSION['connection'];
            $valide = true;

            if ($connecte && array_key_exists('titre', $_POST) && array_key_exists('texteSujet', $_POST)) 
            {
                if ($_POST['titre'] != "" && $_POST['texteSujet'] != "") 
                {
                    $message = '';

                    // Recuperer l'ID du redacteur
                    $select_stmt = $objPdo->prepare('SELECT idRedacteur FROM redacteur WHERE pseudo = ?');
                    $select_stmt->bindValue(1, trim($_SESSION['pseudo']), PDO::PARAM_STR);
                    $select_stmt->execute();
                    $idRedacteur = $select_stmt->fetch()['idRedacteur'];

                    // Inserer la reponse dans la BD
                    $insert_stmt = $objPdo->prepare("INSERT INTO sujet (idRedacteur,titreSujet,texteSujet,dateSujet) VALUES(? ,? ,? ,CURRENT_TIMESTAMP())");
                    $insert_stmt->bindValue(1, $idRedacteur, PDO::PARAM_INT);
                    $insert_stmt->bindValue(2, trim($_POST['titre']), PDO::PARAM_STR);
                    $insert_stmt->bindValue(3, trim($_POST['texteSujet']), PDO::PARAM_STR);
                    $insert_stmt->execute();

                    header('Location:'.$_SESSION['provenance']);
                }
                else
                {
                    $valide = false;
                    $message = "Merci de bien saisir tout les champs afin de pouvoir créer le sujet";
                }
            }
            
        ?>
    </head>
    <body>
        <?php
            if ($message != "") 
            {
                echo $message;
                echo ("<br><br>");
            }
        ?>
        <form action="" method="post">
            <?php
                echo('Merci de saisir les informations suivantes : <br><br>');
                echo('Titre : ');
                echo('<br><input type="text" name="titre"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['titre'].'"');
                }
                echo('><br>');
                echo('Texte du Sujet :');
                echo('<br><input type="text" name="texteSujet"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['texteSujet'].'"');
                }
                echo('><br><br>');
            ?>
            <input type="submit" value="Créer"><br><br>
        </form>
        <a href="accueil.php">Retour à l'accueil</a>  
    </body>
</html>