function validationDeco() {
    if (confirm("Etes vous sur de vouloir vous déconnecter ?")) {
        return true;
    } else {
        return false;
    }
}

function validationSuppr() {
    if (confirm("Êtes vous sur de vouloir supprimer cet élèment ?")) {
        return true;
    } else {
        return false;
    }
}