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

        <script language="javascript" type="text/javascript">
            function validationSuppr() 
            {
                if (confirm("Êtes vous sur de vouloir supprimer cet élèment ?")) 
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        </script>

        <?php
            //Variable utilisé
            include_once('../connexion/connexion.php');
            session_start();
            $_SESSION['provenance'] = 'discussion.php';
            if (array_key_exists('idSujet', $_GET)) 
            {
                $_SESSION['provenance'] = $_SESSION['provenance'] . '?idSujet=' . $_GET['idSujet'];
            }
            $connecte = false;
            $sujet = null;
            $pseudo = "";
            $message = "";



            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection'])
            {
                $connecte = true;
                $pseudo = $_SESSION['pseudo'];
            }

            // Dans le cas ou l'on recharge la page et que l'on vient de publier un commentaire
            if ($connecte && array_key_exists('idSujet', $_GET) && array_key_exists('reponse', $_POST))
            {
                if ($_POST['reponse'] != "")
                {
                    // Recuperer l'ID du redacteur
                    $select_stmt = $objPdo->prepare('SELECT idRedacteur FROM redacteur WHERE pseudo = ?');
                    $select_stmt->bindValue(1, trim($pseudo), PDO::PARAM_STR);
                    $select_stmt->execute();
                    $idRedacteur = $select_stmt->fetch()['idRedacteur'];

                    // Inserer la reponse dans la BD
                    $insert_stmt = $objPdo->prepare("INSERT INTO reponse (idSujet,idRedacteur,dateRep,texteReponse) VALUES(? ,? ,CURRENT_TIMESTAMP() ,?)");
                    $insert_stmt->bindValue(1, strip_tags(trim($_GET['idSujet'])), PDO::PARAM_INT);
                    $insert_stmt->bindValue(2, $idRedacteur, PDO::PARAM_INT);
                    $insert_stmt->bindValue(3, strip_tags(trim($_POST['reponse']),'<br>'), PDO::PARAM_STR);
                    $insert_stmt->execute();
                } 
                else
                {
                    $message = "Merci de saisir une reponse";
                }
            }
        ?>
    </head>

    <body>
        <!-- Accueil -->
        <div class="logo"> 
            <a href="./accueil.php">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI3LjAyIDI3LjAyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxwYXRoIHN0eWxlPSIiIGQ9Ik0zLjY3NCwyNC44NzZjMCwwLTAuMDI0LDAuNjA0LDAuNTY2LDAuNjA0YzAuNzM0LDAsNi44MTEtMC4wMDgsNi44MTEtMC4wMDhsMC4wMS01LjU4MSAgIGMwLDAtMC4wOTYtMC45MiwwLjc5Ny0wLjkyaDIuODI2YzEuMDU2LDAsMC45OTEsMC45MiwwLjk5MSwwLjkybC0wLjAxMiw1LjU2M2MwLDAsNS43NjIsMCw2LjY2NywwICAgYzAuNzQ5LDAsMC43MTUtMC43NTIsMC43MTUtMC43NTJWMTQuNDEzbC05LjM5Ni04LjM1OGwtOS45NzUsOC4zNThDMy42NzQsMTQuNDEzLDMuNjc0LDI0Ljg3NiwzLjY3NCwyNC44NzZ6IiBmaWxsPSIjZmZmZmZmIiBkYXRhLW9yaWdpbmFsPSIjMDMwMTA0Ij48L3BhdGg+Cgk8cGF0aCBzdHlsZT0iIiBkPSJNMCwxMy42MzVjMCwwLDAuODQ3LDEuNTYxLDIuNjk0LDBsMTEuMDM4LTkuMzM4bDEwLjM0OSw5LjI4YzIuMTM4LDEuNTQyLDIuOTM5LDAsMi45MzksMCAgIEwxMy43MzIsMS41NEwwLDEzLjYzNXoiIGZpbGw9IiNmZmZmZmYiIGRhdGEtb3JpZ2luYWw9IiMwMzAxMDQiPjwvcGF0aD4KCTxwb2x5Z29uIHN0eWxlPSIiIHBvaW50cz0iMjMuODMsNC4yNzUgMjEuMTY4LDQuMjc1IDIxLjE3OSw3LjUwMyAyMy44Myw5Ljc1MiAgIiBmaWxsPSIjZmZmZmZmIiBkYXRhLW9yaWdpbmFsPSIjMDMwMTA0Ij48L3BvbHlnb24+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPC9nPjwvc3ZnPg==" alt="Accueil" />
            </a>
        </div>
        <div class="sect_inc">
            <?php
                if (array_key_exists('idSujet', $_GET)) 
                {
                    // On recupere uniquement les attributs necessaires ainsi que le pseudo du redacteur
                    $select_stmt = $objPdo->prepare('SELECT idSujet, titreSujet, texteSujet, pseudo, dateSujet 
                                                    FROM sujet s, redacteur r
                                                    WHERE idSujet = ? 
                                                    AND s.idRedacteur = r.idRedacteur');
                    $select_stmt->bindValue(1, strip_tags(trim($_GET['idSujet'])), PDO::PARAM_INT);

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
                        //Bouton pour supprimer le sujet uniquement si l'on est connecté
                        if ($connecte && $_SESSION['pseudo'] == $sujet['pseudo']) 
                        {
                            echo ('<div class="lien_suppression_sujet"><a href="supprimerSujet.php?idSujet='.$sujet['idSujet'].'">Supprimer le sujet</a></div>');
                        }
                        echo ('<hr>');

                        //Inclure toute les reponses avec un select et un foreach
                        $select_stmt = $objPdo->prepare('SELECT idReponse, texteReponse, dateRep, pseudo 
                                                        FROM reponse rep, redacteur redac
                                                        WHERE idSujet = ?
                                                        AND rep.idRedacteur = redac.idRedacteur
                                                        ORDER BY dateRep ASC');

                        $select_stmt->bindValue(1, $sujet['idSujet'], PDO::PARAM_INT);

                        $select_stmt->execute();

                        $result = $select_stmt->fetchAll();

                        //Affichage de chaque réponse
                        echo ('<div id="title_reponse" class="title">Réponse : </div><hr>');
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
                                    echo ('<div class="reponse_pseudo">'.$reponse["pseudo"].'</div>');
                                    echo ($reponse["texteReponse"]);
                                    
                                    //Ajout de l'option supprimer si on est connecté
                                    if ($connecte && $_SESSION['pseudo'] == $reponse['pseudo']) 
                                    {
                                        echo ('<div class="bloc_bas_reponse">');
                                            echo ('<a href="supprimerReponse.php?idReponse='.$reponse['idReponse'].'" onclick="return validationSuppr()">Supprimer la réponse</a>');
                                            echo ('<div class="reponse_date"> le '.$dateSujet.'</div>');
                                        echo ('</div>');
                                    }
                                    else
                                    {
                                        echo ('<div class="reponse_date"> le '.$dateSujet.'</div>');
                                    }
                                    
                                echo ('</div>');
                                echo ('<hr>');
                            }
                        }

                        echo ('<table>');


                        // Afficher la saisie de commentaire uniquement si l'on est connecté
                        echo ('<div class ="section_reponse">');
                        if ($connecte) 
                        {
                            // Section reponse
                            echo ('<div class="title">Ajouter une réponse</div>');

                            echo ('<form method="POST">');

                                //Affichage du pseudo, et d'un formulaire de commentaire
                                echo ('<div class="subTitle"> Votre pseudo : '.$pseudo.'</div>');

                                echo ('<textarea class="input area" name="reponse" value="reponse" placeholder="Votre réponse..." minlength="5" maxlength="200" rows="5" cols="400"></textarea>');
                                echo ('<button type="submit">Poster ma réponse</button>');
                                if ($message != "") 
                                {
                                    echo ('<div class="message">'.$message.'</div>');
                                }

                            echo ('</form>');
                        } 
                        else 
                        {
                            echo ('Veuillez vous connecter pour pouvoir ajouter un commentaire');

                            echo ('<div>');
                                // Proposition de connexion
                                echo ('<a href="login.php"><button type="button">Se connecter</button></a>');
                                // Ou d'inscription !
                                echo (' ou ');
                                echo ('<a href="creerCompte.php"><button type="button">Créer un compte</button></a>');
                            echo ('</div>');
                        }
                        echo ('</div>');
                    } 
                    else 
                    {
                        echo ("Aucun sujet n'existe avec ce code, merci de revenir à l'accueil");
                    }
                } 
                else 
                {
                    echo ("Il y a une erreur dans le chargement de la page, merci de revenir à l'accueil");
                }
            ?>
            <a href="accueil.php">Retour a l'accueil</a>
        </div>
    </body>
</html>