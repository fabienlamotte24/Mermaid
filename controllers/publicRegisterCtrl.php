<?php
/** ===== Utilisation de fonction spécifiques =====
 * 
 * htmlspecialchars annule les caractères spéciaux pouvant intégrer des contenus de type script = Protection contre les hackers
 * trim annule les espace en début et fin de chaîne = Evite les erreurs de validité avec les regex
 * 
 * ====== Utilisation de fonction spécifiques =====
 */
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
//Initialisation de tableau de gestion des erreurs et de validation du formulaire
$errorList = array();
$success = array();
/**
 * ================================================================Validation de formulaire========================================================
 */
if (isset($_POST['submit'])) {
    /**
     * Vérification du pseudo
     */
    if (!empty($_POST['pseudo'])) {
        $testPseudo = htmlspecialchars(trim($_POST['pseudo']));
        //On instancie l'objet users, avec pour méthode la vérification de l'existence du pseudo
        $verify = NEW users();
        $verify->pseudo = $testPseudo;
        $check = $verify->notSamePseudo();
        //Si $check vaut 0, alors le pseudo n'est pas déjà pris
        if ($check == 0) {
            //...On test donc sa validité
            if (preg_match($regPseudo, $testPseudo)) {
                //...Puis on stocke sa valeur dans une variable
                $pseudo = $testPseudo;
            } else {
                $errorList['pseudo'] = 'Le pseudo n\'est pas correct';
            }
        } else {
            $errorList['pseudo'] = 'Ce pseudo est déjà pris';
        }
    } else {
        $errorList['pseudo'] = 'Veuillez entrer un pseudo';
    }
    /**
     * Vérification du premier champs de mot de passe
     */
    if (!empty($_POST['pass'])) {
        $testPass = htmlspecialchars(trim($_POST['pass']));
        if (preg_match($regPass, $testPass)) {
            $pass1 = $testPass;
        } else {
            $errorList['pass'] = 'Le mot de passe n\'est pas valide !';
        }
    } else {
        $errorList['pass'] = 'Veuillez écrire un mot de passe !';
    }
    /**
     * Vérification du second champs de mot de passe
     */
    if (!empty($_POST['passRepeat'])) {
        $passRepeat = htmlspecialchars(trim($_POST['passRepeat']));
        if (preg_match($regPass, $passRepeat)) {
            $pass2 = $passRepeat;
        } else {
            $errorList['passRepeat'] = 'Le mot de passe n\'est pas valide !';
        }
    } else {
        $errorList['passRepeat'] = 'Veuillez écrire un mot de passe !';
    }
    /**
     * On vérifie ensuite que les deux mots de passe soient identiques
     */
    if (isset($pass1) && isset($pass2)) {
        if ($pass1 == $pass2) {
            //On stocke la valeur hashée de la variable $pass1 dans la variable password
            $password = password_hash($pass1, PASSWORD_DEFAULT);
        } else {
            $errorList['rightPass'] = 'Les mots de passe ne sont pas identiques !';
        }
    } else {
        $errorList['rightPass'] = 'L\'un de vos champs \'mot de passe\' n\'a pas été remplis ';
    }
/**
 * Vérification du champs mail
 */
    if (!empty($_POST['mail'])) {
        $testMail = htmlspecialchars(trim($_POST['mail']));
        //On instancie l'objet users, avec pour méthode la vérification de l'existence de l'adresse de messagerie entrée
        $verify = NEW users();
        $verify->mail = $testMail;
        $check = $verify->notSameEmail();
        //Si l'adresse mail n'est pas déjà inscrite dans la base de donnée, elle est donc disponible
        if ($check == 0) {
            //...On teste sa validité
            if (filter_var($testMail, FILTER_VALIDATE_EMAIL)) {
                //Puis on stocke sa valeur dans une variable $mail
                $mail = $testMail;
            } else {
                $errorList['mail'] = 'Votre adresse de messagerie n\'est pas valide';
            }
        } else {
            $errorList['mail'] = 'Cette adresse de messagerie est déjà prise !';
        }
    } else {
        $errorList['mail'] = 'Veuillez entrer une adresse de messagerie !';
    }
/**
 * Vérification du téléphone
 */
    if (!empty($_POST['phoneNumber'])) {
        $testPhoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
        //On teste sa validité
        if (preg_match($regPhone, $testPhoneNumber)) {
            //On stock sa valeur dans la variable $phoneNumber
            $phoneNumber = $testPhoneNumber;
        } else {
            $errorList['phoneNumber'] = 'Le numéro entré n\'est pas valide';
        }
    } else {
        $errorList['phoneNumber'] = 'Veuillez entrer un numéro de téléphone';
    }
/**
 * Vérification de la date de naissance
 */
    if (!empty($_POST['birthDate'])) {
        $testBirthDate = htmlspecialchars(trim($_POST['birthDate']));
        //On test la validité
        if (preg_match($regBirth, $testBirthDate)) {
            //Puis on stocke sa valeur dans la variable $birthDate
            $birthDate = $testBirthDate;
        } else {
            $errorList['birthDate'] = 'La date entrée n\'est pas valide';
        }
    } else {
        $errorList['birthDate'] = 'Veuillez entrer une date de naissance';
    }
    /**
     * On vérifie que le formulaire ne retourne aucune erreur
     */
    if (count($errorList) == 0) {
        //On intancie l'objet users, avec pour méthode l'enregistrement des informations protégées en base de donnée
        $addUser = NEW users();
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
        //On applique la requête
        if($addUser->addUser()){
            $success['submit'] = TRUE;
        } else {
            $errorList['submit'] = 'Une erreur est survenue pendant l\'enregistrement de votre profil';
        }
    }
}