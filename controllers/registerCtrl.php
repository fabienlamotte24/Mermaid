<?php
//Liste des regex
include'assets/regexList/regexList.php';
//Initialisation des variables
$pseudo = '';
$password = '';
$mail = '';
$lastname = '';
$firstname = '';
$phoneNumber = '';
$birthDate = '';
$address = '';
$presentation = '';
//$idType et $idCities sont des clés étrangères de type "integer", je les initialise donc avec la valeur 0
$idType = 0;
$idCities = 0;
//Création d'un tableau pour le moment VIDE, pour ensuite gérer les erreurs de formulaire et les afficher dans la vue
$errorList = array();

/**
 * Appel ajax servant à garder en mémoire la valeur rentrée sans recharger la page
 * Elle me sert à lister les villes correspondant au code postal rentré
 * Que j'envoie par la suite à la liste déroulante pour m'assurer d'une meilleure rentrée d'informations
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
//Condition pour vérifier que les deux mots de passe sont identiques
    if (isset($pass1) && isset($pass2)) {
        //On garde en variable $password le premier mot de passe si le deux concordent
        if ($pass1 == $pass2) {
            $password = password_hash($pass1, PASSWORD_DEFAULT);
        } else {
            //Sinon on affiche un message d'erreur
            $errorList['pass'] = 'Les mots de passe ne sont pas identiques !';
        }
    } else {
        $errorList['pass'] = 'L\'un de vos champs \'mot de passe\' n\'a pas été remplis ';
    }
//Condition pour vérifier l'existence de la valeur du champs de présentation
    if (isset($_POST['presentation'])) {
        //La vérification est légère pour ce champs car il n'est pas obligatoire
        //Je décide néanmoins de protéger la valeur avec htmlspecialchars pour contrer le code malveillant
        $presentation = htmlspecialchars($_POST['presentation']);
    }
//Condition pour vérifier l'entrée E-Mail
    if (!empty($_POST['mail'])) {
        //On utilise l'objet users
        $verify = NEW users();
        $verify->mail = $_POST['mail'];
        //notSameEmail() vérifie si l'adresse n'appartient pas déjà à un autre compte
        $check = $verify->notSameEmail();
        if ($check !== '0') {
            $errorList['mail'] = 'Cette adresse de messagerie est déjà prise !';
        } else {
            /**
             * Si ce n'est pas le cas, on entre la valeur rentrée dans le champs dans une variable $mail
             * Nous vérifions bien la validité de l'e-mail avec filter_validate_email
             */
            if (preg_match($regMail, $_POST['mail']) && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $mail = htmlspecialchars($_POST['mail']);
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
            $errorList['address'] = 'La date entrée n\'est pas valide';
        }
    } else {
        $errorList['address'] = "Veuillez entrer une adresse postale";
    }
//Condition pour vérifier l'entrée de la présentation
    if (!empty($_POST['presentation'])) {
        if (preg_match($regPresentation, $_POST['presentation'])) {
            $presentation = htmlspecialchars($_POST['presentation']);
        } else {
            $errorList['presentation'] = 'La présentation entrée n\'est pas valide';
        }
    }
    if(!empty($_POST['city']) && $_POST['city'] != 0 && empty($_POST['postalCode'])){
        
    }
    if($_POST['city'] == 0){
        $errorList['city'] = 'Veuillez sélectionner une ville';
    }
    if (!empty($_POST['city']) && !empty($_POST['postalCode'])) {
        if (preg_match($regCity, $_POST['city']) && preg_match($regPostalCode, $_POST['postalCode'])) {
            $idCities = intval(htmlspecialchars($_POST['city']));
        } else {
            $errorList['city'] = 'Votre ville n\'est pas valide';
        }
    } else {
        $errorList['city'] = 'Veuillez renseigner votre ville';
    }
/**
 * Comme ce controller sert à vérifier la validité des valeurs rentrée dans les champs des trois formulaire
 * je demande la vérification de la valeur du paramètre url form
 * Il possède trois valeurs autorisées: public, pro, et musician
 */
    //Condition si le formulaire utilisé correspond à "public" et si le formulaire n'a retourné aucune erreur
    if (isset($_GET['form']) && ($_GET['form'] === 'public') && count($errorList) == 0) {
        //La valeur de la variable $idType est égale à 1
        $idType = 1;
        //On initialise l'objet users
        $addUser = NEW users();
        //J'attribue aux attributs de mon objet les valeurs stockées dans mes variables après leur vérification
        $addUser->idType = $idType;
        $addUser->pseudo = $pseudo;
        $addUser->password = $password;
        $addUser->mail = $mail;
        $addUser->lastname = $lastname;
        $addUser->firstname = $firstname;
        $addUser->phoneNumber = $phoneNumber;
        $addUser->birthDate = $birthDate;
        $addUser->address = $address;
        $addUser->presentation = $presentation;
        $addUser->idCities = $idCities;
        //...Puis utilise la méthode addUser(), qui me permet d'ajouter un utilisateur dans ma base de donnée
        $addUser->addUser();
    }
    //Condition si le formulaire utilisé correspond à "pro" et si le formulaire n'a retourné aucune erreur
    if (isset($_GET['form']) && ($_GET['form'] === 'pro') && count($errorList) == 0) {
        //La valeur de la variable $idType est égale à 2
        $idType = 2;
        //J'initialise l'objet users
        $addUser = NEW users();
        //J'attribue aux attributs de mon objet les valeurs stockées dans mes variables après leur vérification
        $addUser->idType = $idType;
        $addUser->pseudo = $pseudo;
        $addUser->password = $password;
        $addUser->mail = $mail;
        $addUser->lastname = $lastname;
        $addUser->firstname = $firstname;
        $addUser->phoneNumber = $phoneNumber;
        $addUser->birthDate = $birthDate;
        $addUser->address = $address;
        $addUser->presentation = $presentation;
        $addUser->idCities = $idCities;
        //...Puis utilise la méthode addUser(), qui me permet d'ajouter un utilisateur dans ma base de donnée
        $addUser->addUser();
    }
    //Condition si le formulaire utilisé correspond à "musician" et si le formulaire n'a retourné aucune erreur
    if (isset($_GET['form']) && ($_GET['form'] === 'musician') && count($errorList) == 0) {
        //La valeur de la variable $idType est égale à 3
        $idType = 3;
        //J'initialise l'objet users
        $addUser = NEW users();
        //J'attribue aux attributs de mon objet les valeurs stockées dans mes variables après leur vérification
        $addUser->idType = $idType;
        $addUser->pseudo = $pseudo;
        $addUser->password = $password;
        $addUser->mail = $mail;
        $addUser->lastname = $lastname;
        $addUser->firstname = $firstname;
        $addUser->phoneNumber = $phoneNumber;
        $addUser->birthDate = $birthDate;
        $addUser->address = $address;
        $addUser->presentation = $presentation;
        $addUser->idCities = $idCities;
        //...Puis utilise la méthode addUser(), qui me permet d'ajouter un utilisateur dans ma base de donnée
        $addUser->addUser();
    }
}    