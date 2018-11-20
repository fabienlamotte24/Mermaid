<?php
$errorList = array();
$success = array();
//================================================================================Création de l'entreprise====================================================================
$regCompanyName = '/^[A-Za-z0-9\'\-\_ôîûêâéèàù ]+$/';
$regSiretNumber1 = '/^[0-9]{3}$/';
$regSiretNumber2 = '/^[0-9]{5}+$/';
$regCity = '/^[A-Za-z \-]+$/';
$regPostalCode = '/^[0-9]+$/';
$regAddress = '/^[A-Za-z0-9\-\_.ôîûêéèçà\' ]+$/';
$siret1 = ' ';
$siret2 = ' ';
$siret3 = ' ';
$siret4 = ' ';
$address = ' ';
$city = ' ';
$postalCode = ' ';
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
if (isset($_POST['submitCompany'])) {
    /**
     * Vérification du champs du nom du compte entreprise
     */
    if (!empty($_POST['company'])) {
        if (preg_match($regCompanyName, $_POST['company'])) {
            $company = htmlspecialchars($_POST['company']);
        } else {
            //...Message d'erreur
            $errorList['company'] = 'Votre saisie contient des caractères interdits !';
        }
    } else {
        //...Message d'erreur
        $errorList['company'] = 'Ce champs est vide !';
    }
    /**
     * Vérification du numéro de siret
     */
    if (!empty($_POST['siretNumber1'])) {
        if (preg_match($regSiretNumber1, $_POST['siretNumber1'])) {
            $siret1 = htmlspecialchars($_POST['siretNumber1']);
        } else {
            //...Message d'erreur
            $errorList['siret'] = 'Le premier champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        //...Message d'erreur
        $errorList['siret'] = 'Le premier champs du numéro de siret est vide !';
    }
    if (!empty($_POST['siretNumber2'])) {
        if (preg_match($regSiretNumber1, $_POST['siretNumber2'])) {
            $siret2 = htmlspecialchars($_POST['siretNumber2']);
        } else {
            //...Message d'erreur
            $errorList['siret'] = 'Le second champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        //...Message d'erreur
        $errorList['siret'] = 'Le second champs du numéro de siret est vide !';
    }
    if (!empty($_POST['siretNumber3'])) {
        if (preg_match($regSiretNumber1, $_POST['siretNumber3'])) {
            $siret3 = htmlspecialchars($_POST['siretNumber3']);
        } else {
            //...Message d'erreur
            $errorList['siret'] = 'Le troisième champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        //...Message d'erreur
        $errorList['siret'] = 'Le troisième champs du numéro de siret est vide !';
    }
    if (!empty($_POST['siretNumber4'])) {
        if (preg_match($regSiretNumber2, $_POST['siretNumber4'])) {
            $siret4 = htmlspecialchars($_POST['siretNumber4']);
            $siret = $siret1 . $siret2 . $siret3 . $siret4;
            //Vérification pour savoir si le numéro de siret n'est pas encore utilisé
            $countSiret = NEW establishment();
            $countSiret->siretNumber = $siret;
            $check = $countSiret->countSiret();
            //Si le numéro de siret n'est pas encore utilisé
            if($check == 0){
                //On le stock dans une variable pour l'utiliser lors de l'enregistrement
                $finalSiret = $siret;
            } else {
                $errorList['siret'] = 'Le numéro de siret n\'est pas disponible !';
            }
        } else {
            //...Message d'erreur
            $errorList['siret'] = 'Le quatrième champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        //...Message d'erreur
        $errorList['siret'] = 'Vérifiez vos numéro de siret !';
    }
    /**
     * vérification de l'envoi de fichier
     */
    if (!empty($_FILES['photo']) && ($_FILES['photo']['error'] == 0) && (count($errorList) == 0)) {
        //Vérification de la taille du fichier
        if ($_FILES['photo']['size'] <= 2000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'png');
            $informationsFile = pathinfo($_FILES['photo']['name']);
            $extension_upload = $informationsFile['extension'];
            //On test son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_SESSION['id'] . '.' . $extension_upload;
                $link = '../../assets/img/proPictures/avatars/' . $name;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $link) && count($errorList) == 0) {
                    $companyPicture = $name;
                } else {
                    //...Message d'erreur
                    $errorList['photo'] = 'Echec de l\'envoie du fichier !';
                }
            } else {
                //...Message d'erreur
                $errorList['photo'] = 'Format du fichier non conforme !';
            }
        } else {
            //...Message d'erreur
            $errorList['photo'] = 'Fichier trop lourd !';
        }
    } else {
        //...Message d'erreur
        $errorList['photo'] = 'Veuillez choisir un fichier !';
    }
    /**
     * Vérification de l'adresse
     */
    if (!empty($_POST['address'])) {
        if (preg_match($regAddress, $_POST['address'])) {
            $address = htmlspecialchars($_POST['address']);
        } else {
            $errorList['address'] = 'Votre adresse contient des caractère interdits !';
        }
    } else {
        $errorList['address'] = 'Veuillez entrer une adresse !';
    }
    /**
     * Vérification du code postal
     */
    if (!empty($_POST['postalCode'])) {
        if (preg_match($regPostalCode, $_POST['postalCode'])) {
            $postalCode = htmlspecialchars($_POST['postalCode']);
        } else {
            $errorList['postalCode'] = 'Veuillez entrer un code postal valide !';
        }
    } else {
        $errorList['postalCode'] = 'Veuillez entrer un code postal !';
    }
    /**
     * Vérification de la ville
     */
    if (!empty($_POST['city']) && isset($_POST['city'])) {
        if (preg_match($regCity, $_POST['city'])) {
            $city = htmlspecialchars($_POST['city']);
        } else {
            $errorList['city'] = 'La ville renseignée est invalide !';
        }
    } else {
        $errorList['city'] = 'Veuillez renseigner une ville !';
    }
    if(count($errorList) == 0){
        //On instancie l'objet establishment, avec pour méthode l'enregistrement d'un établissement
        $companyRegisting = NEW establishment();
        $companyRegisting->companyName = $company;
        $companyRegisting->siretNumber = $finalSiret;
        $companyRegisting->id_15968k4_users = intval($_SESSION['id']);
        $companyRegisting->companyPicture = $companyPicture;
        $companyRegisting->addressCompany = $address;
        $companyRegisting->postalCode = $postalCode;
        $companyRegisting->city = $city;
        if(!$companyRegisting->addCompany()){
            $errorList['submitCompany'] = 'Erreur dans l\'enregistrement de votre établissement !';
        } else {
            header('location:profile.php');
        }
    } else{
        $errorList['submitCompany'] = 'Votre formulaire contient des erreurs !';
    }
}