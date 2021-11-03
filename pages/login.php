<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Feuilles de style -->
    <link rel="stylesheet" href="./login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">

    <?php
    session_start();
    include_once("../connexion/connexion.php");
    $message = "";
    $redacteur = null;

    if (array_key_exists('pseudo', $_POST) && array_key_exists('password', $_POST)) {
        if ($_POST['pseudo'] != "" && $_POST['password'] != "") {
            $select_stmt = $objPdo->prepare('SELECT * FROM redacteur WHERE (pseudo = ? OR adresseMail = ?) AND motDePasse = ?');

            $select_stmt->bindValue(1, trim($_POST['pseudo']), PDO::PARAM_STR);
            $select_stmt->bindValue(2, trim($_POST['pseudo']), PDO::PARAM_STR);
            $select_stmt->bindValue(3, trim($_POST['password']), PDO::PARAM_STR);
            $select_stmt->execute();

            $value = $select_stmt->fetchAll();

            //Si value != null, ca veux dire que la requete a renvoyé un resultat donc que le redacteur existe
            if ($value != null) {
                $redacteur = $value[0];

                $_SESSION['connection'] = true;
                $_SESSION['pseudo'] =  trim($redacteur['pseudo']);
                $_SESSION['nom'] =  trim($redacteur['nom']);
                $_SESSION['prenom'] =  trim($redacteur['prenom']);

                //redirection vers l'ancienne page 
                header('Location:' . $_SESSION["provenance"]);
            } else {
                $message = "Veuillez verifier votre pseudo et/ou votre mot de passe";
            }
        } else {
            $message = "Veuillez saisir votre identifiant et votre mot de passe";
        }
    }
    ?>
</head>

<body>
    <div class="connexion">
        <form method="POST" action="">
            Pour pouvoir poster des sujets et répondre aux sujets presents, merci de saisir vos identifiants :
            <br>
            <hr>
            <br>
            <input class="input" type="text" size="30" name="pseudo" placeholder="Pseudo ou Email"><br>
            <br>
            <input class="input" type="password" size="30" name="password" placeholder="Mot de Passe"><br><br>

            <?php
            if ($message != "") {
                echo ("<div class='message'>" . $message . "</div>");
                echo ("<br>");
            }
            ?>

            <input class="button" type="submit" value="Valider" onclick="return checkComplete()"><br><br>
        </form>
        <hr>
        <br>
        Vous n'avez pas encore de compte ?
        <a href="creactionCompte.php"> Créez en un !</a><br>
        <a href="accueil.php">Retour à l'accueil</a>
    </div>

</body>

</html>