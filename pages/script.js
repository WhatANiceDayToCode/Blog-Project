function validationDeco() {
    if (confirm("Êtes vous sur de vouloir vous déconnecter ?")) {
        return true;
    } else {
        return false;
    }
}

function validationSuppr() {
    if (confirm("Êtes vous sur de vouloir supprimer cet élément ?")) {
        return true;
    } else {
        return false;
    }
}