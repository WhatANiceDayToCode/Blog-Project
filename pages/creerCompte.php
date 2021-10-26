<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creation de Compte</title>

        <?php
            session_start();
            include_once("../connexion/connexion.php");
            $message = "";
            $valide = true;

            if (array_key_exists('nom',$_POST) && array_key_exists('prenom',$_POST) && array_key_exists('mail',$_POST)
                && array_key_exists('pseudo',$_POST) && array_key_exists('password', $_POST)) 
            {
                if ($_POST['nom'] != "" && $_POST['prenom'] != "" && $_POST['mail'] != "" && $_POST['pseudo'] != "" && $_POST['password'] != "") 
                {
                    $check_stmt = $objPdo->prepare('SELECT * FROM redacteur WHERE pseudo = ?');

                    $check_stmt->bindValue(1, trim($_POST['pseudo']), PDO::PARAM_STR);
                    $check_stmt->execute();
    
                    $value = $check_stmt->fetchAll();
    
                    //Si value = null, ca veux dire que la requete n'a renvoyé aucun resultat, ce qui veux dire que ce pseudo n'existe pas
                    if($value == null) 
                    {
                        $insert_stmt = $objPdo->prepare('INSERT INTO redacteur (nom, prenom, adresseMail, pseudo, motDePasse) VALUES ( ? , ? , ? , ? , ?)');
                        $insert_stmt->bindValue(1, trim($_POST['nom']), PDO::PARAM_STR);
                        $insert_stmt->bindValue(2, trim($_POST['prenom']), PDO::PARAM_STR);
                        $insert_stmt->bindValue(3, trim($_POST['mail']), PDO::PARAM_STR);
                        $insert_stmt->bindValue(4, trim($_POST['pseudo']), PDO::PARAM_STR);
                        $insert_stmt->bindValue(5, trim($_POST['password']), PDO::PARAM_STR);
                        
                        $insert_stmt->execute();

                        //A Supprimer apres
                        $message = "effectué";
                        
                        $_SESSION['connection'] = true;
                        $_SESSION['pseudo'] =  trim($_POST['pseudo']);
                        $_SESSION['prenom'] =  trim($_POST['prenom']);
                        $_SESSION['nom'] =  trim($_POST['nom']);

                        //redirection vers l'ancienne page 
                        header('Location:'.$_SESSION["provenance"]);
                    }
                    else
                    {
                        $message = "Veuillez verifier votre pseudo et/ou votre mot de passe";
                    }
                }
                else
                {
                    $message = "Veuillez saisir toutes les informations";
                    $valide = false;
                }  
            }
        ?>
    </head>
    <body>
        <?php
            if ($message != "") 
            {
                echo $message;
                echo ("<br><br>");
            }
        ?>
        <form action="" method="post">
            Merci de saisir les informations suivantes : <br><br>
            Nom : 
            <br><input type="text" name="nom" id=""><br>
            Prenom : 
            <br><input type="text" name="prenom" id=""><br>
            Mail : 
            <br><input type="email" name="mail" id=""><br>
            Pseudo : 
            <br><input type="text" name="pseudo" id=""><br>
            Mot de Passe : 
            <br><input type="password" name="password" id=""><br><br>
            <input type="submit" value="Créer"><br><br>
        </form>
        <a href="accueil.php">Retour à l'accueil</a>  
    </body>
</html>