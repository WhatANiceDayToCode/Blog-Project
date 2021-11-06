<?php
    try
    {
        $dbname = "nataneli1u_projet_php";
        $username = "nataneli1u_appli";
        $password = "Xbb8R2D2";

        $objPdo = new PDO('mysql:host=devbdd.iutmetz.univ-lorraine.fr;port=3306;dbname='.$dbname, $username, $password);
    }
    catch( Exception $exception )
    {
        die($exception->getMessage());
    }
?>