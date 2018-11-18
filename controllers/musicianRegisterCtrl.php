<?php

//Liste des regex
$regPseudo = '/^[A-Za-z0-9\-\_.ôîûêéèçà\']+$/';
$regName = '/^[A-Za-zçôîûêéèçà\-\']+$/';
$regPhone = '/^(06|07){1}[0-9]{8}$/';
$regBirth = '/^(([0]{1}[1-9]{1})|([1-2]{1}[0-9]{1})|([3]{1}[0-2]{1}))|\/(([0]{1}[1-9]{1})|([1]{1}[0-2]{1}))\/([1]{1}[9]{1}[\d]{1}[\d]{1})|([2]{1}[0]{1}[0|1]{1}[\d]{1})$/';
$regAddress = '/^[A-Za-z0-9\-\_.ôîûêéèçà\' ]+$/';
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

//Création d'un tableau pour le moment VIDE, pour ensuite gérer les erreurs de formulaire et les afficher dans la vue
$errorList = array();

/**
 * Appel ajax servant à garder en mémoire la valeur rentrée sans recharger la page
 * Elle me sert à lister les villes correspondant au code postal rentré
 * Que j'envoie par la suite à la liste déroulante pour m'assurer d'une bonne entrée d'informations
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
//Lancement des vérifications lorsque l'on appuie sur le bouton de validation d'un des trois formulaires
if (isset($_POST['submit'])) {
//Condition pour vérifier l'entrée pseudo
    if (!empty($_POST['pseudo'])) {
        //J'utilise l'objet users
        $verify = NEW users();
        //Je capture la valeur du champs dans l'attribut pseudo de ma méthode
        $verify->pseudo = $_POST['pseudo'];
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
    if (isset($_POST['presentation'])) {
//La vérification est légère pour ce champs car il n'est pas obligatoire
//Je décide néanmoins de protéger la valeur avec htmlspecialchars pour contrer le code malveillant
        $presentation = htmlspecialchars($_POST['presentation']);
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
//Condition pour vérifier l'entrée lastname
    if (!empty($_POST['lastname'])) {
        if (preg_match($regName, $_POST['lastname'])) {
            $lastname = htmlspecialchars($_POST['lastname']);
        } else {
            $errorList['lastname'] = 'Le nom entré n\'est pas valide';
        }
    } else {
        $errorList['lastname'] = 'Veuillez renseigner votre nom de famille';
    }
//Condition pour vérifier l'entrée firstname
    if (!empty($_POST['firstname'])) {
        if (preg_match($regName, $_POST['firstname'])) {
            $firstname = htmlspecialchars($_POST['firstname']);
        } else {
            $errorList['firstname'] = 'Le prénom entré n\'est pas valide';
        }
    } else {
        $errorList['firstname'] = 'Veuillez renseigner votre prénom';
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
//Condition pour vérifier l'entrée de l'année de naissance
    if (!empty($_POST['address'])) {
        if (preg_match($regAddress, $_POST['address'])) {
            $address = htmlspecialchars($_POST['address']);
        } else {
            $errorList['address'] = 'L\'adresse entrée n\'est pas valide';
        }
    } else {
        $errorList['address'] = "Veuillez entrer une adresse postale";
    }
    //Condition pour vérifier l'entrée de la ville
    if (isset($_POST['city']) && isset($_POST['postalCode'])) {
        if (preg_match($regCity, $_POST['city']) && preg_match($regPostalCode, $_POST['postalCode'])) {
            $city = htmlspecialchars($_POST['city']);
            $idCities = intval($city);
        } else {
            $errorList['submit'] = 'Erreur dans la saise de vos champs "code postal" ou "ville"!';
        }
    } else {
        $errorList['city'] = "Vos champs ville et code postal sont vides ou mal remplis !";
        $errorList['postalCode'] = "Vos champs ville et code postal sont vides ou mal remplis !";
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