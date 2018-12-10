<?php
/** ===== Utilisation de fonction spécifiques =====
 * 
 * htmlspecialchars annule les caractères spéciaux pouvant intégrer des contenus de type script = protection contre les hackers
 * trim annule les espace en début et fin de chaîne = il évite les erreurs de validité avec les regex
 * 
 * ====== Utilisation de fonction spécifiques =====
 */
//Liste des regex
$regPseudo = '/^[A-Za-z0-9\-\_.ôîûêéèçà\']+$/';
$regName = '/^[A-Za-zçôîûêéèçà\-\']+$/';
$regPhone = '/^(06|07){1}[0-9]{8}$/';
$regBirth = '/^(([0]{1}[1-9]{1})|([1-2]{1}[0-9]{1})|([3]{1}[0-2]{1}))|\/(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))\/([1]{1}[9]{1}[\d]{1}[\d]{1})|([2]{1}[0]{1}[0|1]{1}[\d]{1})$/';
$regAddress = '/^[A-Za-z0-9\-\_.ôîûêéèçà\'\°\, ]+$/';
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
//Création de plusieurs tableau pour gérer les erreurs ou la validation du formulaire
$errorList = array();
$success = array();
/**
 * =================================================================Ajax===========================================================================
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
 * ===========================================================Vérification du formulaire===========================================================
 */
//Lancement des vérifications lorsque l'on appuie sur le bouton de validation du formulaire
if (isset($_POST['submit'])) {
    /**
     * Vérification du pseudo
     */
    if (!empty($_POST['pseudo'])) {
        $testPseudo = htmlspecialchars(trim($_POST['pseudo']));
        //On instancie l'objet users, avec pour méthode la vérification de l'existence du pseudo
        $verify = NEW users();
        $verify->pseudo = $testPseudo;
        //On applique la requête
        $check = $verify->notSamePseudo();
        //Si $check vaut 0, alors le pseudo n'est pas encore pris
        if ($check == 0) {
            //On stocke alors la valeur d'entrée dans la variable pseudo
            if (preg_match($regPseudo, $testPseudo)) {
                $pseudo = $testPseudo;
            } else {
                $errorList['pseudo'] = 'Ce pseudo n\'est pas valide';
            }
        } else {
            $errorList['pseudo'] = 'Ce pseudo est déjà pris';
        }
    } else {
        $errorList['pseudo'] = 'Veuillez entrer un pseudo';
    }
    /**
     * Pour le mot de passe, j'ai préparé deux champs 
     * pour que l'utilisateur sois bien assuré d'entrer le mot de passe qu'il désire
     * et de réduire les chances d'erreur de connexion par la suite
     */
    /**
     * Vérification du premier champs de mot de passe
     */
    if (!empty($_POST['pass'])) {
        $testPass = htmlspecialchars(trim($_POST['pass']));
        if (preg_match($regPass, $testPass)) {
            //On stock la valeur d'entrée dans la variable $pass1
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
        $TestPassRepeat = htmlspecialchars(trim($_POST['passRepeat']));
        if (preg_match($regPass, $TestPassRepeat)) {
            //On stock la valeur d'entrée dans la variable $pass2
            $pass2 = $TestPassRepeat;
        } else {
            $errorList['passRepeat'] = 'Le mot de passe n\'est pas valide !';
        }
    } else {
        $errorList['passRepeat'] = 'Veuillez écrire un mot de passe !';
    }
    /**
     * On vérifie que les deux mots de passe rentrés sont identiques
     */
    if (isset($pass1) && isset($pass2)) {
        if ($pass1 == $pass2) {
            //On stock alors la variable $passe1 une fois hachée dans la variable $password
            $password = password_hash($pass1, PASSWORD_DEFAULT);
        } else {
            $errorList['rightPass'] = 'Les mots de passe ne sont pas identiques !';
        }
    }
    /**
     * Vérification du champs mail
     */
    if (!empty($_POST['mail'])) {
        $testMail = htmlspecialchars(trim($_POST['mail']));
        //On instancie l'objet users, avec pour méthode la vérification de l'existence du mail entré
        $verify = NEW users();
        $verify->mail = $testMail;
        $check = $verify->notSameEmail();
        //Si l'adresse mail n'est pas déjà prise
        if ($check == 0) {
            //...On vérifie sa validité
            if (filter_var($testMail, FILTER_VALIDATE_EMAIL)) {
                //Puis on stocke sa valeur dans la variable $mail
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
            //On stocke sa valeur dans la variable $lastname
            $lastname = $testLastname;
        } else {
            $errorList['lastname'] = 'Le nom entré n\'est pas valide';
        }
    } else {
        $errorList['lastname'] = 'Veuillez renseigner votre nom de famille';
    }
    /**
     * Vérification du champs fistname
     */
    if (!empty($_POST['firstname'])) {
        $testFirstname = htmlspecialchars(trim($_POST['firstname']));
        if (preg_match($regName, $testFirstname)) {
            //On stocke sa valeur dans la variable $firstname
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
            //On stocke sa valeur dans la variable $phoneNumber
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
        $testBirthDate = htmlspecialchars($_POST['birthDate']);
        if (preg_match($regBirth, $testBirthDate)) {
            //On stocke sa valeur dans la variable $birthDate
            $birthDate = htmlspecialchars($testBirthDate);
        } else {
            $errorList['birthDate'] = 'La date entrée n\'est pas valide';
        }
    } else {
        $errorList['birthDate'] = 'Veuillez entrer une date de naissance';
    }
/**
 * Vérification du champs adresse postale
 */
    if (!empty($_POST['address'])) {
        $testAddress = htmlspecialchars(trim($_POST['address']));
        if (preg_match($regAddress, $testAddress)) {
            //On stocke sa valeur dans la variable $address
            $address = $testAddress;
        } else {
            $errorList['address'] = 'L\'adresse entrée n\'est pas valide';
        }
    } else {
        $errorList['address'] = "Veuillez entrer une adresse postale";
    }
    /**
     * Vérification du champs postalCode
     * Puisqu'il n'est pas utile à l'entrée dans ma base de donnée, je ne prends pas en variable sa valeur
     * je traite juste si le champs n'est pas rempli, car il est tout de même nécessaire
     */
    if (empty($_POST['postalCode'])) {
        $errorList['postalCode'] = 'Veuillez entrer un code postal !';
    }
    /**
     * Vérification du code postal et de la ville
     */
    if (isset($_POST['city']) && isset($_POST['postalCode'])) {
        $testCity = htmlspecialchars(trim($_POST['city']));
        $testPostalCode = htmlspecialchars(trim($_POST['postalCode']));
        if (preg_match($regCity, $testCity) && preg_match($regPostalCode, $testPostalCode)) {
            //On stocke en variable la valeur de la ville(city)
            $idCities = intval($testCity);
        } else {
            $errorList['cities'] = 'Vos champs code postal et ville sont vides ou mal remplis !';
        }
    } else {
        $errorList['cities'] = 'Vos champs code postal et ville sont vides ou mal remplis !';
    }
    /**
     * Affichage de la ville dans le formulaire quand $_POST['city'] existe
     */
    if(isset($_POST['city'])){
        $findCity = NEW cities();
        $findCity->id = intval($_POST['city']);
        $rightCity = $findCity->searchCityById();
    }
/**
 * On vérifie que le formulaire ne contient aucune erreur avant de le traiter
 */
    if (count($errorList) == 0) {
        /**
         * Instanciation de l'objet users, avec pour méthode l'enregistrement en base de donnée les variables protégées stockées 
         */
        $addUser = NEW users();
        $addUser->idType = 2;
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
        //Application de la requête
        if($addUser->addUser()){
            $success['submit'] = TRUE;
        } else {
            $errorList['submit'] = 'Une erreur est survenu dans l\'enregistrement de votre profil !';
        }
    }
}    