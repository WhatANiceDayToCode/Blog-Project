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

            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) 
            {
                $connecte = true;
            }
        ?>
    </head>
    <body>
        <?php
            if (array_key_exists('idSujet', $_GET)) 
            {
                $select_stmt = $objPdo->prepare('SELECT * FROM sujet WHERE idSujet = ?');
                $select_stmt->bindValue(1, trim($_GET['idSujet']), PDO::PARAM_INT);

                $select_stmt->execute();

            
                $sujet = $select_stmt->fetch();

                if ($sujet != null)
                {
                    $redacteurSujet = $objPdo->query('SELECT * FROM redacteur WHERE idRedacteur = '.$sujet['idRedacteur']);
                    $redacteurSujet = $redacteurSujet->fetch();

                    echo('Titre : '.$sujet['titreSujet'].' , par le rédacteur : '.$redacteurSujet['pseudo'].'<br><br><br>');
                    echo('<table><tr><td>'.$sujet['texteSujet'].'</td><td></td></tr>');

                    
                }
                else
                {
                    echo("Aucun sujet n'existe avec ce code, merci de retourner à l'accueil <br><br>");
                    echo('<a href="accueil.php"><input type="button" value="Retour a l\'accueil"></a>');
                }
            }
            else 
            {
                echo("Il y a une erreur dans le chargement de la page, merci de revenir à l'accueil<br><br>");
                echo('<a href="accueil.php"><input type="button" value="Retour a l\'accueil"></a>');
            }
        ?>
        
    </body>
</html>