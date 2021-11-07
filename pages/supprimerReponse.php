<?php
    include_once('connexion.php');
    session_start();
    $idReponse = $_GET['idReponse'];
    
    $delete_stmt = $objPdo->prepare('DELETE 
                                     FROM reponse
                                     WHERE idReponse = ?');
    
    $delete_stmt->bindValue(1, trim($idSujet), PDO::PARAM_INT);

    $delete_stmt->execute();

    header('Location:'.$_SESSION['provenance']);
?>