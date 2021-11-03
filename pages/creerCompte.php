<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creation de Compte</title>
        <!-- Feuilles de style -->
        <link rel="stylesheet" href="./style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">
        
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
                    $select_stmt = $objPdo->prepare('SELECT * FROM redacteur WHERE (pseudo = ? OR adresseMail = ?)');

                    $select_stmt->bindValue(1, trim($_POST['pseudo']), PDO::PARAM_STR);
                    $select_stmt->bindValue(2, trim($_POST['mail']), PDO::PARAM_STR);
                    $select_stmt->execute();
    
                    $value = $select_stmt->fetchAll();
    
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
                        $_SESSION['nom'] =  trim($_POST['nom']);
                        $_SESSION['prenom'] =  trim($_POST['prenom']);

                        //redirection vers l'ancienne page 
                        header('Location:'.$_SESSION["provenance"]);
                    }
                    else
                    {
                        $message = "Ce pseudo ou cet Email existe déjà";
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
        <div class="sect_inc">
        <form action="" method="post">
            <?php
                echo ('<div class="title">Créer un Compte</div> <br><hr><br>');
                // echo ('Nom : ');
                echo ('<input class="input" type="text" placeholder="Nom" name="nom"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['nom'].'"');
                }
                echo ('><br>');
                // echo ('Prenom :');
                echo ('<br><input class="input" type="text" placeholder="Prénom" name="prenom"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['prenom'].'"');
                }
                echo ('><br>');
                // echo ('Mail :');
                echo ('<br><input class="input" type="email" placeholder="Email" name="mail"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['mail'].'"');
                }
                echo ('><br>');
                // echo ('Pseudo : ');
                echo ('<br><input class="input" type="text" placeholder="Pseudo" name="pseudo"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['pseudo'].'"');
                }
                echo ('><br>');
                // echo ('Mot de Passe : ');
                echo ('<br><input class="input" type="password" placeholder="Mot de Passe" name="password"');
                if (!$valide) 
                {
                    echo(' value = "'.$_POST['password'].'"');
                }
                echo ('><br><br>');               
            ?>    
            <input class="button" type="submit" value="Valider"><br><br>
        </form>
        <hr>
        <br>
        Vous possedez déjà un compte ?
        <a href="login.php"> Se connecter </a><br>
        <a href="accueil.php">Retour à l'accueil</a>  
        </div>
    </body>
</html>