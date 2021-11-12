<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creation de Compte</title>
        <!-- Feuilles de style -->
        <link rel="stylesheet" href="./style.css">
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">
        
        <?php
            session_start();
            include_once("../connexion/connexion.php");
            $message = "";
            $valide = true;

            if (array_key_exists('nom',$_POST) && array_key_exists('prenom',$_POST) && array_key_exists('mail',$_POST)
                && array_key_exists('pseudo',$_POST) && array_key_exists('password', $_POST)) 
            {
                if (trim($_POST['nom']) != "" && trim($_POST['prenom']) != "" && trim($_POST['mail'])!= "" 
                    && trim($_POST['pseudo']) != "" && trim($_POST['password']) != "") 
                {
                    //recuperation des info pour les mettres dans des variables
                    $nom = strip_tags(trim($_POST['nom']));
                    $prenom = strip_tags(trim($_POST['prenom']));
                    $mail = strip_tags(trim($_POST['mail']));
                    $pseudo = strip_tags(trim($_POST['pseudo']));
                    $password = strip_tags(trim($_POST['password']));
                    
                    $select_stmt = $objPdo->prepare('SELECT * FROM redacteur WHERE (pseudo = ? OR adresseMail = ?)');

                    $select_stmt->bindValue(1, $pseudo, PDO::PARAM_STR);
                    $select_stmt->bindValue(2, $mail, PDO::PARAM_STR);
                    $select_stmt->execute();
    
                    $value = $select_stmt->fetchAll();
    
                    //Si value = null, ca veux dire que la requete n'a renvoyé aucun resultat, ce qui veux dire que ce pseudo n'existe pas
                    if($value == null) 
                    {
                        $insert_stmt = $objPdo->prepare('INSERT INTO redacteur (nom, prenom, adresseMail, pseudo, motDePasse) VALUES ( ? , ? , ? , ? , ?)');
                        $insert_stmt->bindValue(1, $nom, PDO::PARAM_STR);
                        $insert_stmt->bindValue(2, $prenom, PDO::PARAM_STR);
                        $insert_stmt->bindValue(3, $mail, PDO::PARAM_STR);
                        $insert_stmt->bindValue(4, $mail, PDO::PARAM_STR);
                        $insert_stmt->bindValue(5, $password, PDO::PARAM_STR);
                        
                        $insert_stmt->execute();
                        
                        $_SESSION['connection'] = true;
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['nom'] = $nom;
                        $_SESSION['prenom'] = $prenom;

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
        <!-- Accueil -->
        <div class="logo"> 
            <a href="./accueil.php">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI3LjAyIDI3LjAyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KCTxwYXRoIHN0eWxlPSIiIGQ9Ik0zLjY3NCwyNC44NzZjMCwwLTAuMDI0LDAuNjA0LDAuNTY2LDAuNjA0YzAuNzM0LDAsNi44MTEtMC4wMDgsNi44MTEtMC4wMDhsMC4wMS01LjU4MSAgIGMwLDAtMC4wOTYtMC45MiwwLjc5Ny0wLjkyaDIuODI2YzEuMDU2LDAsMC45OTEsMC45MiwwLjk5MSwwLjkybC0wLjAxMiw1LjU2M2MwLDAsNS43NjIsMCw2LjY2NywwICAgYzAuNzQ5LDAsMC43MTUtMC43NTIsMC43MTUtMC43NTJWMTQuNDEzbC05LjM5Ni04LjM1OGwtOS45NzUsOC4zNThDMy42NzQsMTQuNDEzLDMuNjc0LDI0Ljg3NiwzLjY3NCwyNC44NzZ6IiBmaWxsPSIjZmZmZmZmIiBkYXRhLW9yaWdpbmFsPSIjMDMwMTA0Ij48L3BhdGg+Cgk8cGF0aCBzdHlsZT0iIiBkPSJNMCwxMy42MzVjMCwwLDAuODQ3LDEuNTYxLDIuNjk0LDBsMTEuMDM4LTkuMzM4bDEwLjM0OSw5LjI4YzIuMTM4LDEuNTQyLDIuOTM5LDAsMi45MzksMCAgIEwxMy43MzIsMS41NEwwLDEzLjYzNXoiIGZpbGw9IiNmZmZmZmYiIGRhdGEtb3JpZ2luYWw9IiMwMzAxMDQiPjwvcGF0aD4KCTxwb2x5Z29uIHN0eWxlPSIiIHBvaW50cz0iMjMuODMsNC4yNzUgMjEuMTY4LDQuMjc1IDIxLjE3OSw3LjUwMyAyMy44Myw5Ljc1MiAgIiBmaWxsPSIjZmZmZmZmIiBkYXRhLW9yaWdpbmFsPSIjMDMwMTA0Ij48L3BvbHlnb24+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPGcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPC9nPgo8ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8L2c+CjxnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjwvZz4KPC9nPjwvc3ZnPg==" alt="Accueil" />
            </a>
        </div>
        <div class="sect_inc">
            <form action="" method="post">
                <?php
                    echo ('<div class="title">Créer un Compte</div> <hr>');
                    
                    echo ('<div class ="all_input">');
                    
                        echo ('<input class="input" type="text" placeholder="Nom" name="nom"');
                        if (!$valide) 
                        {
                            echo(' value = "'.trim($_POST['nom']).'"');
                        }
                        echo ('>');
                        
                        echo ('<input class="input" type="text" placeholder="Prénom" name="prenom"');
                        if (!$valide) 
                        {
                            echo(' value = "'.trim($_POST['prenom']).'"');
                        }
                        echo ('>');
                        
                        echo ('<input class="input" type="email" placeholder="Email" name="mail"');
                        if (!$valide) 
                        {
                            echo(' value = "'.trim($_POST['mail']).'"');
                        }
                        echo ('>');
                        
                        echo ('<input class="input" type="text" placeholder="Pseudo" name="pseudo"');
                        if (!$valide) 
                        {
                            echo(' value = "'.trim($_POST['pseudo']).'"');
                        }
                        echo ('>');
                    
                        echo ('<input class="input" type="password" placeholder="Mot de Passe" name="password"');
                        if (!$valide) 
                        {
                            echo(' value = "'.trim($_POST['password']).'"');
                        }
                        echo ('>');

                        if ($message != "") 
                        {
                            echo ("<div class='message'>" . $message . "</div>");
                        }

                        echo ('<button type="submit">Valider</button>');
                    echo ('</div>');              
                ?>    
            </form>
            <hr>
            <div class="bloc_bottom">
                <div>
                    Vous possedez déjà un compte ?
                    <a href="login.php"><button type="button">Se connecter</button></a>
                </div>
                <a href="accueil.php">Retour à l'accueil</a> 
            </div>
        </div>
    </body>
</html>