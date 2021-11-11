<?php
    include_once("../connexion/connexion.php");
    session_start();

    $idSujet = null;
    $connecte = false;

    if (array_key_exists('connection', $_SESSION) && $_SESSION['connection'])
    {
        $connecte = true;

        if (array_key_exists('idSujet', $_GET)) 
        {
            $idSujet = trim($_GET['idSujet']);


            //Si l'on est ici c'est que l'on a cliqué sur le bouton
            if (array_key_exists('supprimer',$_POST) && $_POST['supprimer']="supprimer") 
            {
                //On supprime d'abord toutes les reponses
                $delete_stmt1 = $objPdo->prepare('DELETE 
                                                    FROM reponse 
                                                    WHERE idSujet = ?');
                $delete_stmt1->bindValue(1, $idSujet, PDO::PARAM_INT);
                $delete_stmt1->execute();

                //Puis on supprime le sujet en question
                $delete_stmt2 = $objPdo->prepare('DELETE 
                                                    FROM sujet 
                                                    WHERE idSujet = ?');
                $delete_stmt2->bindValue(1, $idSujet, PDO::PARAM_INT);
                $delete_stmt2->execute();

                header('Location:accueil.php');
            }
        }  
    }
?>