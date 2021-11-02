<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sujet</title>
    <?php
        include_once('../connexion/connexion.php');
        session_start();
        $_SESSION['provenance'] = 'discussion.php';
        if (array_key_exists('idSujet', $_GET)) 
        {  
            $_SESSION['provenance'] = $_SESSION['provenance'].'?idSujet='.$_GET['idSujet'];
        }
        $connecte = false;
        $sujet = null;
        $pseudo = "";



        if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) 
        {
            $connecte = true;
            $pseudo = $_SESSION['pseudo'];
        }

        // Dans le cas ou l'on recharge la page et que l'on vient de publier un commentaire
        if ($connecte && array_key_exists('idSujet', $_GET) && array_key_exists('reponse', $_POST) && $_POST['reponse'] != "") 
        {
            // Recuperer l'ID du redacteur
            $select_stmt = $objPdo->prepare('SELECT idRedacteur FROM redacteur WHERE pseudo = ?');
            $select_stmt->bindValue(1, trim($pseudo), PDO::PARAM_STR);
            $select_stmt->execute();
            $idRedacteur = $select_stmt->fetch()['idRedacteur'];

            // Inserer la reponse dans la BD
            $insert_stmt = $objPdo->prepare("INSERT INTO reponse (idSujet,idRedacteur,dateRep,texteReponse) VALUES(? ,? ,CURRENT_TIMESTAMP() ,?)");
            $insert_stmt->bindValue(1, trim($_GET['idSujet']), PDO::PARAM_INT);
            $insert_stmt->bindValue(2, $idRedacteur, PDO::PARAM_INT);
            $insert_stmt->bindValue(3, trim($_POST['reponse']), PDO::PARAM_STR);
            $insert_stmt->execute();
        }

    ?>
</head>

<body>
    <?php
        if (array_key_exists('idSujet', $_GET)) 
        {
            // On recupere uniquement les attributs necessaires ainsi que le pseudo du redacteur
            $select_stmt = $objPdo->prepare('SELECT idSujet, titreSujet, texteSujet, pseudo, dateSujet 
                                            FROM sujet s, redacteur r
                                            WHERE idSujet = ? 
                                            AND s.idRedacteur = r.idRedacteur');
            $select_stmt->bindValue(1, trim($_GET['idSujet']), PDO::PARAM_INT);

            $select_stmt->execute();

            $sujet = $select_stmt->fetch();
            
            // Affichage des sujets
            if ($sujet != null) 
            {
                $dateSujet = date('d/m/Y à h:i:s', strtotime($sujet['dateSujet']));

                echo ('Titre : '.$sujet['titreSujet'].'<br>Par le rédacteur : '.$sujet['pseudo'].' le '.$dateSujet.'<br><br><br>');
                //Ouverture de la table avec le texte du sujet et les reponses correspondantes
                echo ('<table>');

                echo ('<tr><td>' . $sujet['texteSujet'] . '</td></tr>');

                //Inclure toute les reponses avec un select et un foreach
                $result = $objPdo->query('SELECT texteReponse, dateRep, pseudo 
                                         FROM reponse rep, redacteur redac
                                         WHERE idSujet = '.$sujet['idSujet'].'
                                         AND rep.idRedacteur = redac.idRedacteur
                                         ORDER BY dateRep ASC');


                    // La passer en prepared


                if ($result != null) 
                {
                    foreach ($result as $reponse) 
                    {
                        $dateSujet = date('d/m/Y à h:i:s', strtotime($reponse['dateRep']));

                        echo ('<tr>');
                        if ($reponse['pseudo'] != $sujet['pseudo']) 
                        {
                            echo ('<td></td>');
                        }
                        echo ('<td>'.$reponse["texteReponse"].'<br> Par '.$reponse["pseudo"].' à '.$dateSujet.'<br><br></td>');
                        echo ('</tr>');
                    }
                }

                echo ('<table>');


                // Afficher la saisie de commentaire uniquement si l'on est connecté
                if ($connecte) 
                {
                    // Section reponse
                    echo ('<br>');
                    echo ('<h3>Ajouter un commentaire</h3>');

                    echo ('<form method="POST">');

                    //Affichage du pseudo, et d'un formulaire de commentaire
                    echo ('Votre pseudo : ' . $pseudo . '<br><br>');

                    echo ('<textarea name="reponse" value="reponse" placeholder="Votre réponse..." rows="5" cols="45"></textarea><br><br>');
                    echo ('<input type="submit" value="Poster ma réponse" name="submit_reponse"/>');

                    echo ('</form>');

                } 
                else 
                {
                    echo ('<br><br>');
                    echo ('Veuillez vous connecter pour pouvoir ajouter un commentaire<br><br>');

                    // Proposition de connexion
                    echo ('<a href="login.php"><input type="button" value="Se connecter"></a><br>');

                    // Ou d'inscription !
                    echo ('<br>Pas de compte ?<br>');
                    echo ('<a href="creerCompte.php"><input type="button" value="Créer un compte"></a>');
                }

                echo ('<br><br>');
            } 
            else 
            {
                echo ("Aucun sujet n'existe avec ce code, merci de revenir à l'accueil<br><br>");
            }
        }
        else 
        {
            echo ("Il y a une erreur dans le chargement de la page, merci de revenir à l'accueil<br><br>");
        }
    ?>
    <a href="accueil.php"><input type="button" value="Retour a l'accueil"></a>
</body>

</html>