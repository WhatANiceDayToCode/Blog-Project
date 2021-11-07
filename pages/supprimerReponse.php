<?php
    include_once('connexion.php');
    session_start();

    header('Location:'.$_SESSION['provenance']);
?>