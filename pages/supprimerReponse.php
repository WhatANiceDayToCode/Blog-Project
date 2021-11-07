<?php
    include_once('../connexion/connexion.php');
    session_start();
    $idReponse = $_GET['idReponse'];
    
    $delete_stmt = $objPdo->prepare('DELETE 
                                     FROM reponse
                                     WHERE idReponse = ?');
    
    $delete_stmt->bindValue(1, trim($idReponse), PDO::PARAM_INT);

    $delete_stmt->execute();

    header('Location:'.$_SESSION['provenance']);
?>