<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Sujet</title>
    <!-- Feuilles de style -->
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">

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

                header('Location:' . $_SESSION['provenance']);
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
        
    ?>
    <div class="sect_inc">
        <form action="" method="post">
            <?php
                echo ('<div class="title">Création d\'un sujet</div> ');
                echo ('<div class="subTitle"> Si possible veuillez vérifier que le sujet n\'a pas déjà été abordé avant de créer le sujet</div><hr>');

                echo ('<div class="all_input">');
                echo ('<input class="input" type="text" placeholder="Titre" name="titre"');
                if (!$valide) 
                {
                    echo (' value = "' . $_POST['titre'] . '"');
                }
                echo ('>');

                echo ('<textarea class="area input" type="text" placeholder="Texte du Sujet" name="texteSujet" minlength="5" maxlength="200" rows="10" cols="100">');
                if (!$valide) 
                {
                    echo ($_POST['texteSujet']);
                }
                echo ('</textarea>');

                if ($message != "") 
                {
                    echo ("<div class='message'>" . $message . "</div>");
                }
            ?>
            <input class="button" type="submit" value="Valider">
        </form>
        <a href="accueil.php">Retour à l'accueil</a>
    </div>
</body>

</html>