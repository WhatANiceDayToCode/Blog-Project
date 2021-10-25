<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
    
        <?php
            session_start();
            include_once("../connexion/connexion.php");
            $message = "";
            $value = null;
            $valide = false;

            if (array_key_exists('pseudo',$_POST) && array_key_exists('password',$_POST)) 
            {
                    //WHERE pseudo = '.$_POST["pseudo"].' AND motDePasse = '.$_POST["password"]
                    $value = $objPdo->query('SELECT * FROM redacteur');

                    if ($value != null) 
                    {
                        foreach ($value as $row) 
                        {
                            if ($row["pseudo"] == $_POST["pseudo"]) 
                            {
                                if ($row["motDePasse"] == $_POST["password"]) 
                                {
                                    $valide = true;
                                }
                                else 
                                {
                                    $message = "Mot de passe incorrect";
                                }
                            }
                            else 
                            {
                                $message = "Utilisateur inconnu";
                            }
                        }  
                    }
                    else
                    {
                        $message = "Verifier vos identifiant ou votre mot de passe";
                    }

            }
        ?>
    </head>
    <body>
        <?php
            echo $message;
            echo('<br> <br>');
            if ($value != null) 
            {
                foreach ($value as $row) 
                {
                   var_dump($row);
                   echo('<br> <br>');
                }  
            }
            
        ?>
        <form method="POST" action="">
            Pour acceder au reste du site merci de saisir vos données : 
            <br><br>
            Pseudo : <br>
            <input type="text" size="30" name="pseudo"><br>
            Mot de passe :<br>
            <input type="password" size="30" name="password"><br><br>

            <input type="submit" value ="Connecter">
        </form>
    </body>
</html>