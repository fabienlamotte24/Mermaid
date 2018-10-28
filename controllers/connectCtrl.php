<?php

//Initialisation de plusieurs variable au chargement de la page
$pseudo = '';
$password = '';
$connected = FALSE;
$message = '';
$errorList = array();
//Vérification du champs pseudo
if (isset($_POST['pseudo'])) {
    if (!empty($_POST['pseudo'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
    } else {
        $errorList['pseudo'] = 'Entrez votre identifiant';
    }
}
//Vérification du champs mot de passe
if (isset($_POST['pass'])) {
    if (!empty($_POST['pass'])) {
        $password = $_POST['pass'];
    } else {
        $errorList['pass'] = 'Entrez votre mot de passe';
    }
}
//Si le formulaire ne présente aucune erreur
if (isset($_POST['connexion']) && count($errorList) == 0) {
    //J'utilise l'objet users
    $user = NEW users();
    //Je donne à l'attribut pseudo de mon objet la valeur stockée dans la variable $pseudo
    $user->pseudo = $pseudo;
    if ($user->userConnexion()) {
        if (password_verify($password, $user->password)) {
            session_start();
            $_SESSION['pseudo'] = $user->pseudo;
            $_SESSION['mail'] = $user->mail;
            $_SESSION['lastname'] = $user->lastname;
            $_SESSION['firstname'] = $user->firstname;
            $_SESSION['phoneNumber'] = $user->phoneNumber;
            $_SESSION['birthDate'] = $user->birthDate;
            $_SESSION['address'] = $user->address;
            $_SESSION['presentation'] = $user->presentation;
            $_SESSION['idType'] = $user->idType;
            $_SESSION['idCities'] = $user->idCities;
            $_SESSION['address'] = $user->address;
            $_SESSION['city'] = $user->city;
            $_SESSION['postalCode'] = $user->postalCode;
            $_SESSION['password'] = $user->password;
            $connected = TRUE;
            header('location:../secondPage/publicUser/profilPublic.php');
        } else {
            $message = 'Erreur de connexion';
        }
    } else {
        $message = 'Ce compte n\'existe pas';
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