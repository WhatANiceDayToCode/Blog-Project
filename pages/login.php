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
            $valide = false;
            $redacteur = null;

            if (array_key_exists('pseudo',$_POST) && $_POST['pseudo'] != "" && array_key_exists('password',$_POST) && $_POST['password'] != "") 
            {
                $insert_stmt = $objPdo->prepare('SELECT * FROM redacteur WHERE pseudo = ? and motDePasse = ?');

                $insert_stmt->bindValue(1, trim($_POST['pseudo']), PDO::PARAM_STR);
                $insert_stmt->bindValue(2, trim($_POST['password']), PDO::PARAM_STR);
                $insert_stmt->execute();

                $value = $insert_stmt->fetchAll();

                //Si value != null, ca veux dire que la requete a renvoyé un resultat donc que le redacteur existe
                if($value != null) 
                {
                    $redacteur = $value[0];

                    $_SESSION['connection'] = true;
                    $_SESSION['pseudo'] =  trim($_POST['pseudo']);

                    //redirection vers l'ancienne page 
                    //header('Location:'.$_SESSION["provenance"]);
                }
                else
                {
                    $message = "Veuillez verifier votre pseudo et/ou votre mot de passe";
                }
            }
            else
            {
                $message = "Veuillez saisir votre pseudo et votre mot de passe";
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
        <form method="POST" action="">
            Pour pouvoir poster des sujets et répondre au sujet present, merci de saisir vos identifiants : 
            <br><br>
            Pseudo : <br>
            <input type="text" size="30" name="pseudo"><br>
            Mot de passe :<br>
            <input type="password" size="30" name="password"><br><br>

            <input type="submit" value ="Connecter">
        </form>
    </body>
</html>