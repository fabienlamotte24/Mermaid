<?php

/** ===== Utilisation de fonction spécifiques =====
 * 
 * htmlspecialchars annule les caractères spéciaux pouvant intégrer des contenus de type script = Protection contre les hackers
 * trim annule les espace en début et fin de chaîne = Evite les erreurs de validité avec les regex
 * 
 * ====== Utilisation de fonction spécifiques =====
 */
//Liste des regex
$regPseudo = '/^[A-Za-z0-9\-\_.ôîûêéèçà\']+$/';
$regName = '/^[A-Za-zçôîûêéèçà\-\']+$/';
$regPhone = '/^(06|07){1}[0-9]{8}$/';
$regBirth = '/^(([0]{1}[1-9]{1})|([1-2]{1}[0-9]{1})|([3]{1}[0-2]{1}))|\/(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))\/'
        . '([1]{1}[9]{1}[\d]{1}[\d]{1})|([2]{1}[0]{1}[0|1]{1}[\d]{1})$/';
$regAddress = '/^[A-Za-z0-9\-\_\.ôîûêéèçà\'\,\° ]+$/';
$regPass = '/^[A-Za-z0-9çôîûêéèçà\-\'#@&!%$*]+$/';
$regCity = '/^[0-9]+$/';
$regPostalCode = '/^[0-9]+$/';
//Initialisation des variables
$pseudo = '';
$password = '';
$mail = '';
$lastname = '';
$firstname = '';
$phoneNumber = '';
$birthDate = '';
$address = '';
//$idType et $idCities sont des clés étrangères de type "integer", je les initialise donc avec la valeur 0
$idType = 0;
$idCities = 0;
//Création de tableaux vide, gérant les erreurs et validation de formulaire
$errorList = array();
$success = array();
/**
 * ===========================================================================Ajax================================================================
 */
if (isset($_POST['postalSearch'])) {
    //J'appelle le fichier config.php, qui détient tout mes modèles
    include'../config.php';
    //J'utilise l'objet cities
    $postal = NEW cities();
    //Je capture la valeur du champs dans l'attribut postalCode de ma méthode en le protégeant du code malveillant
    $postal->postalCode = htmlspecialchars($_POST['postalSearch']);
    //J'utilise la méthode postalCodeList pour lister les villes correspondantes via le code postal entré
    $postalResearch = $postal->postalCodeList();
    //Je conserve les résultats en les affichant en JSON pour mon AJAX
    echo json_encode($postalResearch);
}
/**
 * ======================================================================Vérification de formulaire==================================================
 */
/**
 * Lorsqu'on appuie sur le boutton de validation du formulaire
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
        //Si check vaut 0, alors le pseudo est disponible
        if ($check == 0) {
            //On teste la validité
            if (preg_match($regPseudo, $testPseudo)) {
                //On stocke la valeur de l'entrée dans la variable $pseudo
                $pseudo = $testPseudo;
            }
        } else {
            //Il n'est donc pas disponible
            $errorList['pseudo'] = 'Ce pseudo est déjà pris';
        }
    } else {
        $errorList['pseudo'] = 'Veuillez entrer un pseudo';
    }
    /**
     * Vérification du premier champs de mot de passe
     */
    if (!empty($_POST['pass'])) {
        $testPass = html_entity_decode(trim($_POST['pass']));
        //On teste la validité
        if (preg_match($regPass, $testPass)) {
            //On stocke la valeur de l'entrée dans la variable $pass1
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
        $testPassRepeat = htmlspecialchars(trim(($_POST['passRepeat'])));
        if (preg_match($regPass, $testPassRepeat)) {
            $pass2 = $testPassRepeat;
        } else {
            $errorList['passRepeat'] = 'Le mot de passe n\'est pas valide !';
        }
    } else {
        $errorList['passRepeat'] = 'Veuillez écrire un mot de passe !';
    }
    /**
     * On vérifie que les deux mots de passe soient identiques
     */
    if (isset($pass1) && isset($pass2)) {
        if ($pass1 == $pass2) {
            //On stocke dans la variable $password la valeur de la variable $pass1 hashée
            $password = password_hash($pass1, PASSWORD_DEFAULT);
        } else {
            $errorList['pass'] = 'Les mots de passe ne sont pas identiques !';
        }
    } else {
        $errorList['pass'] = 'L\'un de vos champs \'mot de passe\' n\'a pas été remplis ';
    }
    /**
     * Vérification du champs mail
     */
    if (!empty($_POST['mail'])) {
        $testMail = htmlspecialchars(trim($_POST['mail']));
        //On instancie l'objet users, avec pour méthode la vérification de l'existence de l'adresse mail
        $verify = NEW users();
        $verify->mail = $testMail;
        $check = $verify->notSameEmail();
        //Si check vaut 0, alors l'adresse de messagerie est disponible
        if ($check == 0) {
            //...on teste sa validité
            if (filter_var($testMail, FILTER_VALIDATE_EMAIL)) {
                //...Puis on le stocke dans la variable $mail
                $mail = $testMail;
            } else {
                $errorList['mail'] = 'Votre adresse de messagerie n\'est pa valide';
            }
        } else {
            $errorList['mail'] = 'Cette adresse de messagerie est déjà prise !';
        }
    } else {
        $errorList['mail'] = 'Veuillez entrer une adresse de messagerie !';
    }
/**
 * Vérification du champs lastname
 */
    if (!empty($_POST['lastname'])) {
        $testLastname = htmlspecialchars(trim($_POST['lastname']));
        if (preg_match($regName, $testLastname)) {
            //On stocke la valeur du champs dans la variable $lastname
            $lastname = $testLastname;
        } else {
            $errorList['lastname'] = 'Le nom entré n\'est pas valide';
        }
    } else {
        $errorList['lastname'] = 'Veuillez renseigner votre nom de famille';
    }
/**
 * Vérification du champs firstname
 */
    if (!empty($_POST['firstname'])) {
        $testFirstname = htmlspecialchars(trim($_POST['firstname']));
        if (preg_match($regName, $testFirstname)) {
            //On stocke la valeur du champs dans la variable $firstname
            $firstname = $testFirstname;
        } else {
            $errorList['firstname'] = 'Le prénom entré n\'est pas valide';
        }
    } else {
        $errorList['firstname'] = 'Veuillez renseigner votre prénom';
    }

/**
 * Vérification du champs phoneNumber
 */
    if (!empty($_POST['phoneNumber'])) {
        $testPhoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
        if (preg_match($regPhone, $testPhoneNumber)) {
            //On stocke la valeur du champs dans la variable $phoneNumber
            $phoneNumber = $testPhoneNumber;
        } else {
            $errorList['phoneNumber'] = 'Le numéro entré n\'est pas valide';
        }
    } else {
        $errorList['phoneNumber'] = 'Veuillez entrer un numéro de téléphone';
    }
/**
 * Vérification du champs birthDate
 */
    if (!empty($_POST['birthDate'])) {
        $testBirthDate = htmlspecialchars(trim($_POST['birthDate']));
        if (preg_match($regBirth, $testBirthDate)) {
            //On stocke la valeur du champs dans la variable $birthDate
            $birthDate = $testBirthDate;
        } else {
            $errorList['birthDate'] = 'La date entrée n\'est pas valide';
        }
    } else {
        $errorList['birthDate'] = 'Veuillez entrer une date de naissance';
    }
/**
 * Vérification du champs address
 */
    if (!empty($_POST['address'])) {
        $testAddress = htmlspecialchars(trim($_POST['address']));
        if (preg_match($regAddress, $testAddress)) {
            //On stocke dans la variable $address la valeur du champs
            $address = $testAddress;
        } else {
            $errorList['address'] = 'L\'adresse entrée n\'est pas valide';
        }
    } else {
        $errorList['address'] = "Veuillez entrer une adresse postale";
    }
    /**
     * Vérification du champs postalCode
     * Je ne garde pas sa valeur dans une variable car non nécessaire à l'entrée dans la base de donnée
     * elle est néanmoins utile pour obtenir la ville
     */
    if(empty($_POST['postalCode'])){
        $errorList['postalCode'] = 'Veuillez renseigner un code postal !';
    }
    /**
     * Vérification du champs city et code postal
     */
    if (isset($_POST['city']) && isset($_POST['postalCode'])) {
        $testCity = htmlspecialchars(trim($_POST['city']));
        $testPostalCode = htmlspecialchars(trim($_POST['postalCode']));
        //On test leur validité
        if (preg_match($regCity, $testCity) && preg_match($regPostalCode, $testPostalCode)) {
            $idCities = intval($testCity);
        } else {
            $errorList['cities'] = 'Erreur dans la saise de vos champs "code postal" ou "ville"!';
        }
    } else {
        $errorList['cities'] = "Vos champs ville et code postal sont vides ou mal remplis !";
    }
    /**
     * Affichage de la ville dans le formulaire quand $_POST['city'] existe
     */
    if(isset($_POST['city'])){
        $findCity = NEW cities();
        $findCity->id = intval($_POST['city']);
        $rightCity = $findCity->searchCityById();
    }
//Condition si le formulaire ne contient aucune erreur
    if (count($errorList) == 0) {
//J'initialise l'objet users
        $addUser = NEW users();
//J'attribue aux attributs de mon objet les valeurs stockées dans mes variables après leur vérification
        //idType = 3 car le formulaire rempli les informations du type d'utilisateur = musicien
        $addUser->idType = 3;
        $addUser->profilPicture = ' ';
        $addUser->pseudo = $pseudo;
        $addUser->password = $password;
        $addUser->mail = $mail;
        $addUser->lastname = $lastname;
        $addUser->firstname = $firstname;
        $addUser->phoneNumber = $phoneNumber;
        $addUser->birthDate = $birthDate;
        $addUser->address = $address;
        $addUser->idCities = $idCities;
//...Puis utilise la méthode addUser(), qui me permet d'ajouter un utilisateur dans ma base de donnée
        $addUser->addUser();
    }
}    