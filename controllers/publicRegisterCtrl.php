<?php
//Liste des regex
$regPass = '/^[A-Za-z0-9çôîûêéèçà\-\'#@&!%$*]+$/';
$regPseudo = '/^[A-Za-z0-9\-\_.ôîûêéèçà\']+$/';
$regPhone = '/^(06|07){1}[0-9]{8}$/';
$regBirth = '/^(([0]{1}[1-9]{1})|([1-2]{1}[0-9]{1})|([3]{1}[0-2]{1}))|\/(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))\/([1]{1}[9]{1}[\d]{1}[\d]{1})|([2]{1}[0]{1}[0|1]{1}[\d]{1})$/';

//Initialisation des variables
$pseudo = '';
$password = '';
$mail = '';
$phoneNumber = '';
$birthDate = '';

//Initialisation de tableau de gestion des erreurs
$errorList = array();

//Condition de validation de formulaire
if (isset($_POST['submit'])) {
//Condition pour vérifier l'entrée pseudo
    if (!empty($_POST['pseudo'])) {
        //J'utilise l'objet users
        $verify = NEW users();
        //Je capture la valeur du champs dans l'attribut pseudo de ma méthode
        $verify->pseudo = htmlspecialchars($_POST['pseudo']);
        //notSamePseudo() vérifie si le pseudo n'appartient pas déjà à un autre compte
        $check = $verify->notSamePseudo();
        //Si le résultat est différent de 0, c'est qu'il existe déjà une ligne avec le pseudo en question
        if ($check !== '0') {
            //Il n'est donc pas disponible
            $errorList['pseudo'] = 'Ce pseudo est déjà pris';
        } else {
            //S'il n'appartient à personne, j'autorise l'entrée de la valeur du champs dans la variable $pseudo
            if (preg_match($regPseudo, $_POST['pseudo'])) {
                $pseudo = htmlspecialchars($_POST['pseudo']);
            } else {
                $errorList['pseudo'] = 'Le pseudo n\'est pas correct';
            }
        }
    } else {
        $errorList['pseudo'] = 'Veuillez entrer un pseudo';
    }
    /**
     * Pour le mot de passe, j'ai préparé deux champs 
     * pour que l'utilisateur sois bien assuré d'entrer le mot de passe qu'il désire
     * et de réduire les chances d'erreur de connexion par la suite
     */
//Vérification du champs du mot de passe principal
    if (!empty($_POST['pass'])) {
//On limite les caractères utilisables avec une regex
        if (preg_match($regPass, $_POST['pass'])) {
//On le protège toujours du code malveillant avec htmlspecialchars
            $pass1 = htmlspecialchars(trim($_POST['pass']));
        } else {
            $errorList['pass'] = 'Le mot de passe n\'est pas valide !';
        }
    } else {
        $errorList['pass'] = 'Veuillez écrire un mot de passe !';
    }
//Vérification du champs du mot de passe à répéter
    if (!empty($_POST['passRepeat'])) {
        if (preg_match($regPass, $_POST['passRepeat'])) {
            $pass2 = htmlspecialchars(trim($_POST['passRepeat']));
        } else {
            $errorList['passRepeat'] = 'Le mot de passe n\'est pas valide !';
        }
    } else {
        $errorList['passRepeat'] = 'Veuillez écrire un mot de passe !';
    }
    if (isset($pass1) && isset($pass2)) {
        if ($pass1 == $pass2) {
            $password = password_hash($pass1, PASSWORD_DEFAULT);
        } else {
            $errorList['pass'] = 'Les mots de passe ne sont pas identiques !';
        }
    } else {
        $errorList['pass'] = 'L\'un de vos champs \'mot de passe\' n\'a pas été remplis ';
    }
//Condition pour vérifier l'entrée E-Mail
    if (!empty($_POST['mail'])) {
        $verify = NEW users();
        $verify->mail = $_POST['mail'];
        $check = $verify->notSameEmail();
        if ($check !== '0') {
            $errorList['mail'] = 'Cette adresse de messagerie est déjà prise !';
        } else {
            /**
             * Si ce n'est pas le cas, on entre la valeur rentrée dans le champs dans une variable $mail
             * Nous vérifions bien la validité de l'e-mail avec filter_validate_email
             */
            if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $mail = htmlspecialchars($_POST['mail']);
            } else {
                $errorList['mail'] = 'Votre adresse de messagerie n\'est pa valide';
            }
        }
    } else {
        $errorList['mail'] = 'Veuillez entrer une adresse de messagerie !';
    }
//Condition pour vérifier l'entrée du numéro de téléphone
    if (!empty($_POST['phoneNumber'])) {
        if (preg_match($regPhone, $_POST['phoneNumber'])) {
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
        } else {
            $errorList['phoneNumber'] = 'Le numéro entré n\'est pas valide';
        }
    } else {
        $errorList['phoneNumber'] = 'Veuillez entrer un numéro de téléphone';
    }
//Condition pour vérifier l'entrée de l'année de naissance
    if (!empty($_POST['birthDate'])) {
        if (preg_match($regBirth, $_POST['birthDate'])) {
            $birthDate = htmlspecialchars($_POST['birthDate']);
        } else {
            $errorList['birthDate'] = 'La date entrée n\'est pas valide';
        }
    } else {
        $errorList['birthDate'] = 'Veuillez entrer une date de naissance';
    }
//Condition si le formulaire n'a retourné aucune erreur
    if (count($errorList) == 0) {
//On initialise l'objet users
        $addUser = NEW users();
//J'attribue aux attributs de mon objet les valeurs stockées dans mes variables après leur vérification
        $addUser->idType = 1;
        $addUser->profilPicture = ' ';
        $addUser->pseudo = $pseudo;
        $addUser->password = $password;
        $addUser->mail = $mail;
        $addUser->lastname = ' ';
        $addUser->firstname = ' ';
        $addUser->phoneNumber = $phoneNumber;
        $addUser->birthDate = $birthDate;
        $addUser->address = ' ';
        $addUser->presentation = ' ';
        $addUser->idCities = 1;
//...Puis utilise la méthode addUser(), qui me permet d'ajouter un utilisateur dans ma base de donnée
        $addUser->addUser();
    }
}