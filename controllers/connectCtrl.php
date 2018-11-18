<?php

//Initialisation de plusieurs variable au chargement de la page
$pseudoConnect = '';
$passwordConnect = '';
$connected = FALSE;
$message = '';
$errorConnectList = array();
//Vérification du champs pseudo
if (isset($_POST['pseudoConnect'])) {
    if (!empty($_POST['pseudoConnect'])) {
        $pseudoConnect = htmlspecialchars($_POST['pseudoConnect']);
    } else {
        $errorConnectList['pseudoConnect'] = 'Entrez votre identifiant';
    }
}
//Vérification du champs mot de passe
if (isset($_POST['passConnect'])) {
    if (!empty($_POST['passConnect'])) {
        $passwordConnect = $_POST['passConnect'];
    } else {
        $errorConnectList['passConnect'] = 'Entrez votre mot de passe';
    }
}
//Si le formulaire ne présente aucune erreur
if (isset($_POST['connexion']) && count($errorConnectList) == 0) {
    //J'utilise l'objet users
    $user = NEW users();
    //Je donne à l'attribut pseudo de mon objet la valeur stockée dans la variable $pseudo
    $user->pseudo = $pseudoConnect;
    if ($user->userConnexion()) {
        if (password_verify($passwordConnect, $user->password)) {
            //On initialise la session
            session_start();
            //On attribue les valeurs des hydratations aux variables de sessions
            $_SESSION['id'] = $user->id;
            $_SESSION['pseudo'] = $user->pseudo;
            $_SESSION['mail'] = $user->mail;
            $_SESSION['lastname'] = $user->lastname;
            $_SESSION['firstname'] = $user->firstname;
            $_SESSION['phoneNumber'] = $user->phoneNumber;
            $_SESSION['birthDate'] = $user->birthDate;
            $_SESSION['address'] = $user->address;
            $_SESSION['idType'] = $user->idType;
            $_SESSION['idCities'] = $user->idCities;
            $_SESSION['address'] = $user->address;
            $_SESSION['password'] = $user->password;
            $_SESSION['profilPicture'] = $user->profilPicture;
            $connected = TRUE;
            header('location:../secondPage/userPages/profile.php');
        } else {
            $errorList['connexion'] = 'Erreur de connexion';
        }
    } else {
        $errorList['connexion'] = 'Ce compte n\'existe pas';
        $connected = FALSE;
    }
}
if (isset($_GET['action'])) {
    //Si on veut se déconnecter
    if ($_GET['action'] === 'disconnect') {
        //On détruit les variables de notre session
        session_unset();
        //destruction de la session
        session_destroy();
        //redirection de la page vers l'index
        header('location:../../index.php');
    }
}