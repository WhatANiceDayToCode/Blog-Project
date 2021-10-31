<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- php ici pour modifier le titre de la page  -->
    <title>Sujet</title>
    <?php
    include_once('../connexion/connexion.php');
    session_start();
    $_SESSION['provenance'] = 'discussion.php';
    $connecte = false;
    $sujet = null;

    if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) {
        $connecte = true;
    }

    ?>
</head>

<body>
    <?php
    if (array_key_exists('idSujet', $_GET)) {
        if ($connecte == true) {
            $pseudo = $_SESSION['pseudo'];
        }

        //On recupere uniquement les attributs necessaires ainsi que le pseudo du redacteur
        $select_stmt = $objPdo->prepare('SELECT titreSujet, texteSujet, pseudo, dateSujet 
                                                 FROM sujet s, redacteur r
                                                 WHERE idSujet = ? 
                                                 AND s.idRedacteur = r.idRedacteur');
        $select_stmt->bindValue(1, trim($_GET['idSujet']), PDO::PARAM_INT);

        $select_stmt->execute();


        $sujet = $select_stmt->fetch();

        if ($sujet != null) {
            $dateSujet = date('d/m/Y', strtotime($sujet['dateSujet']));

            echo ('Titre : ' . $sujet['titreSujet'] . '<br>Par le rédacteur : ' . $sujet['pseudo'] . ' le ' . $dateSujet . '<br><br><br>');

            //Ouverture de la table avec le texte du sujet et les reponses correspondantes
            echo ('<table>');

            echo ('<tr><td>' . $sujet['texteSujet'] . '</td><td></td></tr>');
            //Inclure toute les reponses avec un select et un foreach

            echo ('<table>');


            // Section commentaires
            echo ('<br>');
            echo ('<h1>Commentaires</h1>');

            echo ('<form method="POST">');
            //Affichage du pseudo, et d'un formulaire de commentaire
            echo ('<h2>Votre pseudo : ' . $pseudo . '</h2>
                    <textarea name="commentaire" placeholder="Votre commentaire..."></textarea>
                    
                    <br />

                    <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
                    <a href="accueil.php">
                        <input type="button" value="Retour" name="Retour">
                    </a>');

            echo ('</form>');

            if (isset($c_msg)) {
                echo $c_msg;
            }
            echo ('<br /><br />');

            // while($c = $commentaires->fetch()) { $c['pseudo']:</b> <?= $c['commentaire']
            // else
            // {
            //     echo("Aucun sujet n'existe avec ce code, merci de retourner à l'accueil <br><br>");
            //     echo('<a href="accueil.php"><input type="button" value="Retour a l\'accueil"></a>');
            // }

            // Fin section commentaires
        } else {
            echo ("Il y a une erreur dans le chargement de la page, merci de revenir à l'accueil<br><br>");
            echo ('<a href="accueil.php"><input type="button" value="Retour a l\'accueil"></a>');
        }
    }
    ?>

</body>

</html>