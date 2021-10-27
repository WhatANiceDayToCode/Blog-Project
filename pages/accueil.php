<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accueil</title>
        <script language="javascript" type="text/javascript">
            function valideSuppr() 
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
            $message = "";
            $connecte = false;

            if (array_key_exists('connection', $_SESSION) && $_SESSION['connection']) 
            {
                $message = "Connecté";
                $connecte = true;
            }
        ?>
    </head>
    <body>
        <?php
            if (!$connecte) 
            {
                echo('<a href="login.php">Se connecter</a><br>');
                echo('<a href="creerCompte.php">Creer un compte</a><br>');
            }
            else
            {
                echo ('Bienvenue '.$_SESSION['pseudo'].' / '.$_SESSION['nom'].' '.$_SESSION['prenom']);
                echo ('<br><br>');
                echo ('<a href="deconnexion.php"><input type="button" value="Se deconnecter" onclick="return valideSuppr()"></a>');
            }
        ?>

        <br><br><br><br>
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
                </tr>
                <?php
                    //Affichage des sujets 

                    $sujetList = $objPdo->query('SELECT * FROM sujet');

                    foreach ($sujetList as $sujet) 
                    {
                        $redacteurSujet = $objPdo->query('SELECT * FROM redacteur WHERE idRedacteur = '.$sujet['idRedacteur']);
                        $redacteurSujet = $redacteurSujet->fetch();

                        echo ('<tr>');
                        echo ('<td>Sujet numéro '.$sujet['idSujet'].'</td>');
                        echo ('<td>'.$sujet['titreSujet'].'</td>');
                        echo ('<td>Par '.$redacteurSujet['pseudo'].'</td>');
                        echo ('<td><a href="discussion.php'.$sujet['idSujet'].'"><input type="button" value="Acceder"></a></td>');
                        echo ('</tr>');
                    }
                ?>
        </table>   
    </body>
</html>