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
    $pseudo = "";
    ?>
</head>

<body>
    <?php
    if (array_key_exists('idSujet', $_GET)) {
        // On recupere uniquement les attributs necessaires ainsi que le pseudo du redacteur
        $select_stmt = $objPdo->prepare('SELECT idSujet, titreSujet, texteSujet, pseudo, dateSujet 
                                         FROM sujet s, redacteur r
                                         WHERE idSujet = ? 
                                         AND s.idRedacteur = r.idRedacteur');
        $select_stmt->bindValue(1, trim($_GET['idSujet']), PDO::PARAM_INT);

        $select_stmt->execute();

        $sujet = $select_stmt->fetch();
        if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) {
            $connecte = true;
            $pseudo = $_SESSION['pseudo'];

            // Préparation insertion
            /* Pour insérer il nous faut :
                * Récupérer : 
                * l'id du sujet
                * l'id du rédacteur
                * la date de réponse : SELECT DATE(NOW());
                --> déjà existants
                * le texteReponse
                --> dans le textArea
                */
            $insert_stmt = $objPdo->prepare("INSERT INTO reponse (idSujet,idRedacteur,dateRep,texteReponse) 
                                        VALUES( ? , ? , ? , ? )");

            // Paramètres utilisés
            $idRedacteur = "";
            $dateRep = "SELECT DATE(NOW());";
            $texteRep = $_POST['reponse'];

            // Insertion
            $insert_stmt->bindValue(1, trim($_GET['idSujet']), PDO::PARAM_INT);
            $insert_stmt->bindValue(2, $idRedacteur, PDO::PARAM_INT);
            $insert_stmt->bindValue(3, $dateRep, PDO::PARAM_STR);
            $insert_stmt->bindValue(4, $texteRep, PDO::PARAM_STR);
            $insert_stmt->execute();
        }

        if ($sujet != null) {
            $dateSujet = date('d/m/Y', strtotime($sujet['dateSujet']));

            echo ('Titre : ' . $sujet['titreSujet'] . '<br>Par le rédacteur : ' . $sujet['pseudo'] . ' le ' . $dateSujet . '<br><br><br>');
            //Ouverture de la table avec le texte du sujet et les reponses correspondantes
            echo ('<table>');

            echo ('<tr><td>' . $sujet['texteSujet'] . '</td></tr>');

            //Inclure toute les reponses avec un select et un foreach
            $result = $objPdo->query('SELECT texteReponse, pseudo 
                                              FROM reponse rep, redacteur redac
                                              WHERE idSujet = ' . $sujet['idSujet'] . '
                                              AND rep.idRedacteur = redac.idRedacteur');

            if ($result != null) {
                foreach ($result as $row) {
                    echo ('<tr>');
                    if ($row['pseudo'] != $sujet['pseudo']) {
                        echo ('<td></td>');
                    }
                    echo ('<td>' . $row["texteReponse"] . '<br> Par ' . $row["pseudo"] . '<br><br></td>');
                    echo ('</tr>');
                }
            }

            echo ('<table>');


            // Afficher la saisie de commentaire uniquement si l'on est connecté
            if ($connecte) {
                // Section reponse
                echo ('<br>');
                echo ('<h3>Ajouter un commentaire</h3>');

                echo ('<form method="POST">');

                //Affichage du pseudo, et d'un formulaire de commentaire
                echo ('Votre pseudo : ' . $pseudo . '<br><br>');

                echo ('<textarea name="reponse" value="reponse" placeholder="Votre réponse..." rows="5" cols="45"></textarea><br><br>');
                echo ('<input type="submit" value="Poster ma réponse" name="submit_reponse"/>');

                echo ('</form>');

            } else {

                echo ('<br><br>');
                echo ('Veuillez vous connecter pour pouvoir ajouter un commentaire');

                // Proposition de connexion
                echo ('<br>');
                echo ('<p><a href="login.php">Connexion</a>');

                // Ou d'inscription !
                //echo('<br>');
                echo ('  Pas de compte ? : ');
                echo ('<a href="creerCompte.php"> Inscription </a></p>');
            }

            echo ('<br /><br />');
        } else {
            echo ("Il y a une erreur dans le chargement de la page, merci de revenir à l'accueil<br><br>");
            echo ('<a href="accueil.php"><input type="button" value="Retour a l\'accueil"></a>');
        }
    }
    ?>
    <a href="accueil.php">Retour à l'accueil</a>
</body>

</html>