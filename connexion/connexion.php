<?php
    try
    {
        $objPdo = new PDO('mysql:host=devbdd.iutmetz.univ-lorraine.fr;port=3306;dbname=nataneli1u_projet_php', 'nataneli1u_appli', 'Xbb8R2D2');
        //$objPdo = new PDO('mysql:host=devbdd.iutmetz.univ-lorraine.fr;port=3306;dbname=XXX', 'XXX', 'XXX');
    }
    catch( Exception $exception )
    {
        die($exception->getMessage());
    }
?>