<?php
    try
    {
        $dbname = "db_blog";
        $username = "root";
        $password = "";

        $objPdo = new PDO('mysql:host=localhost;port=3306;dbname='.$dbname, $username, $password);
    }
    catch( Exception $exception )
    {
        die($exception->getMessage());
    }
?>