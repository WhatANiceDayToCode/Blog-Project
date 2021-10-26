<?php           
    // A supprimer une fois le bouton mis en place
    session_start();
    session_destroy();

    header('Location:'.$_SESSION['provenance']);
?>  