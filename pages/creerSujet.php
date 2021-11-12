<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Sujet</title>
    <!-- Feuilles de style -->
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">

    <?php
        session_start();
        include_once("../connexion/connexion.php");
        $message = "";
        $connecte = $_SESSION['connection'];
        $valide = true;

        if ($connecte && array_key_exists('titre', $_POST) && array_key_exists('texteSujet', $_POST)) 
        {
            if ($_POST['titre'] != "" && $_POST['texteSujet'] != "") 
            {
                $message = '';

                // Recuperer l'ID du redacteur
                $select_stmt = $objPdo->prepare('SELECT idRedacteur FROM redacteur WHERE pseudo = ?');
                $select_stmt->bindValue(1, trim($_SESSION['pseudo']), PDO::PARAM_STR);
                $select_stmt->execute();
                $idRedacteur = $select_stmt->fetch()['idRedacteur'];

                // Inserer la reponse dans la BD
                $insert_stmt = $objPdo->prepare("INSERT INTO sujet (idRedacteur,titreSujet,texteSujet,dateSujet) VALUES(? ,? ,? ,CURRENT_TIMESTAMP())");
                $insert_stmt->bindValue(1, $idRedacteur, PDO::PARAM_INT);
                $insert_stmt->bindValue(2, strip_tags(trim($_POST['titre']),'<br>'), PDO::PARAM_STR);
                $insert_stmt->bindValue(3, trim($_POST['texteSujet']), PDO::PARAM_STR);
                $insert_stmt->execute();

                header('Location:' . $_SESSION['provenance']);
            } 
            else 
            {
                $valide = false;
                $message = "Merci de bien saisir tout les champs afin de pouvoir créer le sujet";
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
                echo ('<div class="title">Création d\'un sujet</div> ');
                echo ('<div class="subTitle"> Si possible veuillez vérifier que le sujet n\'a pas déjà été abordé avant de créer le sujet</div><hr>');

                echo ('<div class="all_input">');
                echo ('<input class="input" type="text" placeholder="Titre" name="titre"');
                if (!$valide) 
                {
                    echo (' value = "' . $_POST['titre'] . '"');
                }
                echo ('>');

                echo ('<textarea class="area input" type="text" placeholder="Texte du Sujet" name="texteSujet" minlength="5" maxlength="200" rows="10" cols="100">');
                if (!$valide) 
                {
                    echo ($_POST['texteSujet']);
                }
                echo ('</textarea>');

                if ($message != "") 
                {
                    echo ("<div class='message'>" . $message . "</div>");
                }
            ?>
            <button type="submit">Valider</button>
        </form>
        <a href="accueil.php">Retour à l'accueil</a>
    </div>
</body>

</html>