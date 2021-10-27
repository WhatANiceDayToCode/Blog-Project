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
    
            function getAllSujet()
            {
                include('../connexion/connexion.php'); 
                // Si n'est pas present, la fonction ne detecteras pas la variable $objPd
                // il est donc necessaire de re importer ce script, peu d'influence car utilisé peu de fois sur cette page
                // Mais permettras de le copier coller pour les autres
                
                return ($objPdo->query('SELECT * FROM sujet'));
            }
            
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
                $redacteur = $_SESSION['redacteur'];

                echo $message.'<br>';
                echo ('Bienvenue '.$redacteur['pseudo'].' / '.$redacteur['nom'].' '.$redacteur['prenom']);
                echo ('<br><br>');
                echo ('<a href="deconnexion.php"><input type="button" value="Se deconnecter" onclick="return valideSuppr()"></a>');
            }



            //test affichage tout les sujets
            $sujetList = getAllSujet();

            foreach ($sujetList as $sujet) 
            {
                echo('<br>'.$sujet['idRedacteur'].' '.$sujet['titreSujet'].' '.$sujet['texteSujet'].'<br>');
            }

        ?>
    </body>
    
</html>