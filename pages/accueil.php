<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil</title>
        <link rel="stylesheet" href="./style.css">
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">

        <script language="javascript" type="text/javascript">
            function validationDeco() 
            {
                if (confirm("Etes vous sur de vouoir vous déconnecter ?")) 
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
            include_once('../connexion/connexion.php');
            session_start();
            $_SESSION['provenance'] = 'accueil.php';
            $connecte = false;

            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) 
            {
                $connecte = true;
            }
        ?>
    </head>
    <body>
        <?php
            if (!$connecte) 
            {
                echo ('<a href="login.php"><input type="button" value="Se connecter"></a>');
                echo ('<br><br>');
                echo ('<a href="creerCompte.php"><input type="button" value="Créer un compte"></a>');
                echo ('<br>');
            }
            else
            {
                echo ('Bienvenue '.$_SESSION['pseudo'].' / '.$_SESSION['nom'].' '.$_SESSION['prenom']);
                echo ('<br><br>');
                echo ('<a href="deconnexion.php"><input type="button" value="Se deconnecter" onclick="return validationDeco()"></a>');
                echo ('<br><br>');
                echo ('<a href="creerSujet.php"><input type="button" value="Créer un sujet""></a>');
            }
        ?>

        <br><br>
        Liste des sujets : 
        <br><br>

        <table>
                <tr>
                    <td>
                        ID sujet
                    </td>
                    <td>
                        Titre
                    </td>
                    <td>
                        Pseudo Redacteur
                    </td>
                    <td>
                        Date de création
                    </td>
                </tr>
                <?php
                    //Affichage des sujets 

                    //On recupere uniquement les attributs necessaires ainsi que le pseudo du redacteur
                    $sujetList = $objPdo->query('SELECT idSujet, titreSujet, dateSujet, pseudo 
                                                 FROM sujet s, redacteur r
                                                 WHERE s.idRedacteur = r.idRedacteur 
                                                 ORDER BY dateSujet DESC');

                    foreach ($sujetList as $sujet) 
                    {
                        //Permet de convertir la date format SQL (YYYY-MM-DD) en un format européen (DD/MM/YYYY)
                        $dateSujet = date('d/m/Y à h:i:s', strtotime($sujet['dateSujet']));

                        echo ('<tr>');
                        echo ('<td>Sujet numéro '.$sujet['idSujet'].'</td>');
                        echo ('<td>'.$sujet['titreSujet'].'</td>');
                        echo ('<td>Par '.$sujet['pseudo'].'</td>');
                        echo ('<td>Créé le '.$dateSujet.'</td>');
                        echo ('<td><a href="discussion.php?idSujet='.$sujet['idSujet'].'"><input type="button" value="Acceder"></a></td>');
                        echo ('</tr>');
                    }
                ?>
        </table>  
    </body>
</html>