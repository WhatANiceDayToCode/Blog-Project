<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <!-- Feuilles de style -->
        <link rel="stylesheet" href="./style.css">
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">

        <?php
            session_start();
            include_once("../connexion/connexion.php");
            $message = "";
            $redacteur = null;

            if (array_key_exists('pseudo', $_POST) && array_key_exists('password', $_POST)) 
            {
                if (trim($_POST['pseudo']) != "" && trim($_POST['password']) != "") 
                {
                    $pseudo = strip_tags(trim($_POST['pseudo']));

                    $select_stmt = $objPdo->prepare('SELECT * FROM redacteur WHERE (pseudo = ? OR adresseMail = ?) AND motDePasse = ?');

                    $select_stmt->bindValue(1, $pseudo, PDO::PARAM_STR);
                    $select_stmt->bindValue(2, $pseudo, PDO::PARAM_STR);
                    $select_stmt->bindValue(3, strip_tags(trim($_POST['password'])), PDO::PARAM_STR);
                    $select_stmt->execute();

                    $value = $select_stmt->fetchAll();

                    //Si value != null, ca veux dire que la requete a renvoyé un resultat donc que le redacteur existe
                    if ($value != null) 
                    {
                        $redacteur = $value[0];

                        $_SESSION['connection'] = true;
                        $_SESSION['pseudo'] =  trim($redacteur['pseudo']);
                        $_SESSION['nom'] =  trim($redacteur['nom']);
                        $_SESSION['prenom'] =  trim($redacteur['prenom']);

                        //redirection vers l'ancienne page 
                        header('Location:' . $_SESSION["provenance"]);
                    } 
                    else 
                    {
                        $message = "Veuillez verifier votre pseudo et/ou votre mot de passe";
                    }
                } 
                else 
                {
                    $message = "Veuillez saisir votre identifiant et votre mot de passe";
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
            <div class="title">
                Connexion
            </div>
            <form method="POST" action="">
                <div class="subTitle">
                    Pour pouvoir poster des sujets ou répondre aux sujets présents
                </div>
                <hr>
                <div class="all_input">
                    <input class="input" type="text" size="30" name="pseudo" placeholder="Pseudo ou Email">
                    <input class="input" type="password" size="30" name="password" placeholder="Mot de Passe">
                    
                    <?php
                        if ($message != "") 
                        {
                            echo ("<div class='message'>" . $message . "</div>");
                        }
                    ?>

                    <button type="submit">Valider</button>
                </div>
            </form>
            <hr>
            <div class="bloc_bottom">
                <div>
                    Vous n'avez pas encore de compte ?
                    <a href="creerCompte.php"><button type="button">Créer un compte</button></a>
                </div>
                <a href="accueil.php">Retour à l'accueil</a>
            </div>
        </div>
    </body>
</html>