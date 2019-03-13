ecrit('divMessageNom','test');


/*écrit, dans l'élément dont l'id est fourni en premier
paramètre, le message fourni en deuxième paramètre*/
function ecrit(id,message){
    var elt=document.getElementById(id);
    var mess=document.createTextNode(message);
    elt.appendChild(mess);
}

/*supprime l'éventuel contenu de l'élément dont l'id est fourni en paramètre.
Fonction utilisée pour supprimer les messages d'erreurs affichés*/
function viderMessage(id){
	var elt=document.getElementById(id);
	elt.innerHTML='';
}

/*Vérifie le nom, prénom, fonction, la date de naissance, l'adresse mail, le mot de passe et la confirmation du mot de passe 
dans le formulaire de création de compte*/
function verifInscriptionJS(){
    var boolNom=false;
    var boolPrenom=false;
    var boolFonction=false;
    var boolAdresseMail=false;
    var boolDateNaissance=false;
    var boolPwd=false;
    var boolRepeatPwd=false;

    var nom=document.getElementById('nom').value;
    var prenom=document.getElementById('prenom').value;
    var fonction=document.getElementById('fonction').value;
    var adrMail=document.getElementById('adrMail').value;
    var dateNaissance=document.getElementById('dateNaiss').value;
    var pwd=document.getElementById('pwd').value;
    var repeatPwd=document.getElementById('repeatPwd').value;

    viderMessage('divMessageNom');
    viderMessage('divMessagePrenom');
    viderMessage('divMessageFonction');
    viderMessage('divMessageAdrMail');
    viderMessage('divMessageDateNaiss');
    viderMessage('divMessagePwd');
    viderMessage('divMessageRepeatPwd');

    //teste si un nom est bien saisi
    //sinon écrit le message d'erreur sous le champ de saisie du nom
    if(nom==="" || nom===null){
        messageNom="saisissez un nom";
    }else if(/[^a-zA-Z0-9_]/.test(nom)){
        messageNom ="caractères alphanumériques uniquement";
    }else{
        messageNom="";
        boolNom=true;
    }
    ecrit('divMessageNom',messageNom);

    //teste si un prénom est bien saisi
    //sinon écrit le message d'erreur sous le champ de saisie du prénom
    if(prenom==="" || prenom===null){
        messagePrenom="saisissez un prénom";
    }else if(/[^a-zA-Z0-9_]/.test(prenom)){
        messagePrenom ="caractères alphanumériques uniquement";
    }else{
        messagePrenom="";
        boolPrenom=true;
    }
    ecrit('divMessagePrenom',messagePrenom);

    //teste si une fonction est bien saisie
    //sinon écrit le message d'erreur sous le champ de saisie de la fonction
    if(fonction==="" || fonction===null){
        messageFonction="saisissez une fonction";
    }else if(/[^a-zA-Z]/.test(fonction)){
        messageFonction ="caractères alphabétiques uniquement";
    }else{
        messageFonction="";
        boolFonction=true;
    }
    ecrit('divMessageFonction',messageFonction);


    //teste si une adresse mail est bien saisie
    //sinon écrit le message d'erreur sous le champ de saisie de l'adresse
    if(adrMail==="" || adrMail===null ){
        messageAdrMail="saisissez une adresse mail";
    }else{
        messageAdrMail="";
        boolAdrMail=true;
    }
    ecrit('divMessageAdrMail',messageAdrMail);

    //teste si la date de naissance est bien saisie 
    //sinon écrit le message d'erreur sous le champ de saisie de la date de naissance
    if(dateNaiss==="" || dateNaiss===null ){
        messageDateNaiss="saisissez une adresse mail";
    }else{
        messageDateNaiss="";
        boolDateNaiss=true;
    }
    ecrit('divMessageDateNaiss',messageDateNaiss);

    //teste si le mot de passe est bien saisi 
    //sinon écrit le message d'erreur sous le champ de confirmation du mot de passe
    if(pwd==="" || pwd===null){
        pwd="confirmez le mot de passe";
    }else{
        messagePwd="";
        boolPwd=true;
    }
    ecrit('divMessagePwd',messagePwd);

    //teste si la confirmation du mot de passe est bien saisie et égale au mot de passe
    //sinon écrit le message d'erreur sous le champ de confirmation du mot de passe
    if(repeatPwd==="" || repeatPwd===null || repeatPwd!=pwd){
        messagePwd="confirmez le mot de passe";
    }else{
        messageRepeatPwd="";
        boolRepeatPwd=true;
    }
    ecrit('divMessageRepeatPwd',messageRepeatPwd);

   
   
    return (boolNom && boolPrenom && boolFonction && boolAdrMail && boolDateNaiss && boolPwd && boolRepeatPwd);
   

   return false;
}
