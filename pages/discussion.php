<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sujet</title>
    <!-- Feuilles de style -->
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">

    <?php
    include_once('../connexion/connexion.php');
    session_start();
    $_SESSION['provenance'] = 'discussion.php';
    if (array_key_exists('idSujet', $_GET)) {
        $_SESSION['provenance'] = $_SESSION['provenance'] . '?idSujet=' . $_GET['idSujet'];
    }
    $connecte = false;
    $sujet = null;
    $pseudo = "";



    if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) {
        $connecte = true;
        $pseudo = $_SESSION['pseudo'];
    }

    // Dans le cas ou l'on recharge la page et que l'on vient de publier un commentaire
    if ($connecte && array_key_exists('idSujet', $_GET) && array_key_exists('reponse', $_POST) && $_POST['reponse'] != "") {
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
    <div class="sect_inc">
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
                    $dateSujet = date('d/m/Y à H:i:s', strtotime($sujet['dateSujet']));

                    echo ('<div class="title">' . $sujet['titreSujet'].'</div>');
                    echo ('<div class="info_sujet">');
                        echo ('<div class="subTitle"> Par le rédacteur : '.$sujet['pseudo'].'</div>');
                        echo ('<div>Le '.$dateSujet.'</div>');
                    echo ('</div>');
                    echo ('<div class="subject">' . $sujet['texteSujet'].'</div>');
                    echo ('<hr>');

                    //Inclure toute les reponses avec un select et un foreach
                    $select_stmt = $objPdo->prepare('SELECT texteReponse, dateRep, pseudo 
                                                    FROM reponse rep, redacteur redac
                                                    WHERE idSujet = ?
                                                    AND rep.idRedacteur = redac.idRedacteur
                                                    ORDER BY dateRep ASC');

                    $select_stmt->bindValue(1, trim($sujet['idSujet']), PDO::PARAM_INT);

                    $select_stmt->execute();

                    $result = $select_stmt->fetchAll();

                    echo ('<div id="title_commentaire" class="title">Commentaires : </div><hr>');
                    if ($result != null) 
                    {
                        foreach ($result as $reponse) 
                        {
                            $dateSujet = date('d/m/Y à H:i:s', strtotime($reponse['dateRep']));

                            echo('<div class="reponse');
                            if ($reponse['pseudo'] == $sujet['pseudo']) 
                            {
                                echo (' writer');
                            }
                            echo ('">');
                                echo ('<div class="commentaire_pseudo">'.$reponse["pseudo"].'</div>');
                                echo ($reponse["texteReponse"]);
                                echo ('<div class="commentaire_date"> le '.$dateSujet.'</div>');
                            echo ('</div>');
                            echo ('<hr>');
                        }
                    }

                    echo ('<table>');


                    // Afficher la saisie de commentaire uniquement si l'on est connecté
                    echo ('<div class ="section_commentaire">');
                    if ($connecte) 
                    {
                        // Section reponse
                        echo ('<div class="title">Ajouter un commentaire</div>');

                        echo ('<form method="POST">');

                            //Affichage du pseudo, et d'un formulaire de commentaire
                            echo ('<div class="subTitle"> Votre pseudo : '.$pseudo.'</div>');

                            echo ('<textarea class="input area" name="reponse" value="reponse" placeholder="Votre réponse..." rows="5" cols="400"></textarea>');
                            echo ('<input class="button" type="submit" value="Poster ma réponse" name="submit_reponse"/>');

                        echo ('</form>');
                    } 
                    else 
                    {
                        echo ('Veuillez vous connecter pour pouvoir ajouter un commentaire');

                        echo ('<div>');
                            // Proposition de connexion
                            echo ('<a href="login.php"><input type="button" class="button" value="Se connecter"></a>');
                            // Ou d'inscription !
                            echo (' ou ');
                            echo ('<a href="creerCompte.php"><input class="button" type="button" value="Créer un compte"></a>');
                        echo ('</div>');
                    }
                    echo ('</div>');
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
        <a href="accueil.php">Retour a l'accueil</a>
    </div>
</body>

</html>