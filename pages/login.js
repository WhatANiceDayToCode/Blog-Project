function checkComplete() 
{
    var form = document.querySelector("#formConnection");
    var message = "";

    pseudo = form.pseudo.value.trim();
    password = form.password.value.trim();

    if (pseudo == "") 
    {
        message += "Pseudo non saisit \n";    
    }
    if (password == "") 
    {
        message += "Mot de passe non saisit \n";    
    }
    


    if (message != "") 
    {
        alert(message);

        return false;
    }
    else
    {
        return true;
    }
}