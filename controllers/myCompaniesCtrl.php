<?php

$regCompanyName = '/^[A-Za-z0-9\'\-\_ôîûêâéèàù ]+$/';
//Créaton de tableau d'erreur pour les formulaires
$errorList = array();
$success = array();
//===================================================Liste des id des établissements dont l'utilisateur est le propriétaire==========================================================================
//Création de tableau d'erreur pour les paramètres d'Url

$errorUrl = array();
$successUrl = array();
//On vérifie l'existence du paramètre de l'url "id=$"
$errorUrl = array();
$successUrl = array();
if (isset($_GET['id'])) {
    $idEstablishment = NEW establishment();
    $idEstablishment->id_15968k4_users = intval($_SESSION['id']);
    $listIdEstablishment = $idEstablishment->showIdEstablishment();
    $id = htmlspecialchars(intval($_GET['id']));
    /**
     * Boucle foreach pour créer une succession de condition
     * visant à vérifier que la valeur de l'url correspond à l'id d'un groupe dont l'utilisateur est propriétaire
     */
    foreach ($listIdEstablishment as $establishment) {
        //Si l'url équivaut à l'un des id des groupes de musique créé par l'utilisateur
        if ($id == $establishment->id) {
            //On affecte à $successUrl la valeur true
            $successUrl['url'] = true;
        } else {
            $errorUrl['url'] = false;
        }
    }
} else {
    header('location:error404.php');
}
//======================================================================Ajax==========================================================================
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
//=========================================================Changement des informations de l'établissement=====================================
//A la validation du formulaire
if (isset($_POST['changeEstablishmentContent'])) {
    /**
     * Vérification de l'entrée de la photo 
     */
    //On test si le fichier est bel et bien un fichier
    if (!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        //On vérifie la taille du fichier
        if ($_FILES['photo']['size'] <= 5000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'png');
            $informationsFile = pathinfo($_FILES['photo']['name']);
            $extension_upload = $informationsFile['extension'];
            //On teste son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_FILES['photo']['name'];
                $link = '../../assets/img/proPictures/avatars/' . $name;
                //On vérifie qu'il a bien été téléchargé
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $link)) {
                    //On stocke la valeur dans une variable protégée
                    $photoName = $name;
                } else {
                    $errorList['photo'] = 'Erreur dans le téléchargement de la photo !';
                }
            } else {
                $errorList['photo'] = 'L\'extension du fichier n\'est pas autorisé !';
            }
        } else {
            $errorList['photo'] = 'La taille du fichier est supérieure à la taille autorisée !';
        }
    } else {
        $errorList['photo'] = 'Veuillez chosisir une photo !';
    }
    /**
     * Vérification de l'entrée du nom de l'établissement
     */
    //On vérifie que le champs n'est pas vide 
    if (!empty($_POST['establishmentName'])) {
        //On teste la validité de la valeur entrée
        if (preg_match($regCompanyName, $_POST['establishmentName'])) {
            //On stocke la valeur dans une variable protégée
            $establishmentName = htmlspecialchars($_POST['establishmentName']);
        } else {
            $errorList['establishmentName'] = 'Le nom entré posède des caractères interdits !';
        }
    } else {
        $errorList['establishmentName'] = 'Vous avez oublié de nommer votre établissement !';
    }
    /**
     * Vérification de l'adresse
     */
    //Si le champs est pas vide
    if (!empty($_POST['address'])) {
        //On stock la valeur dans une variable protégée
        $address = htmlspecialchars($_POST['address']);
    } else {
        $errorList['address'] = 'Vous avez oublié de renseigner l\'adresse !';
    }
    /**
     * Vérification de l'adresse
     */
    if (!empty($_POST['postalCode'])) {
        $postalCode = htmlspecialchars($_POST['postalCode']);
    } else {
        $errorList['postalCode'] = 'Vous avez oublié de renseigner le code postal !';
    }
    /**
     * Vérification de l'adresse
     */
    //Si le champs est pas vide
    if (!empty($_POST['city'])) {
        //On stock la valeur dans une variable protégée
        $city = htmlspecialchars($_POST['city']);
    } else {
        $errorList['city'] = 'Vous avez oublié de renseigner la ville !';
    }
    /**
     * On enregistre si le formulaire n'a retourné aucune erreur
     */
    if (count($errorList) == 0) {
        //On instancie l'objet establishment, avec pour méthode le changement des données
        $changeEstablishmentContent = NEW establishment();
        //On donne aux attributs de l'objet la valeur des variables protégées
        $changeEstablishmentContent->companyPicture = $photoName;
        $changeEstablishmentContent->companyName = $establishmentName;
        $changeEstablishmentContent->addressCompany = $address;
        $changeEstablishmentContent->postalCode = $postalCode;
        $changeEstablishmentContent->city = $city;
        $changeEstablishmentContent->id = intval($_GET['id']);
        //Si la requête passe
        if ($changeEstablishmentContent->changeContent()) {
            //On envoi un message de réussite du formulaire
            $success['changeEstablishmentContent'] = 'Les changements ont bien été enregistrés !';
        } else {
            $errorList['changeEstablishmentContent'] = 'La requête n\a pas aboutie !';
        }
    } else {
        $errorList['changeEstablishmentContent'] = 'Vous avez des erreurs dans votre formulaire !';
    }
}
//==========================================================================Suppression de l'établissement==================================================
if(isset($_POST['removeEstablishment'])){
    $removeEstablishment = NEW establishment();
    $removeEstablishment->id = htmlspecialchars(intval($_GET['id']));
    if($removeEstablishment->removeCompany()){
        header('location:profile.php');
    } else {
        $errorList['removeEstablishment'] = 'Erreur dans la suppression de l\'établissement';
    }
}
//==========================================================================Changement de l'annonce==================================================
if (isset($_POST['changeEstablishmentAnnounce'])) {
    if (!empty($_POST['changeAnnounce'])) {
        //On stocke la valeur dans une variable protégée
        $announce = htmlspecialchars($_POST['changeAnnounce']);
        //On instancie l'objet establishmentInResearch
        $newAnnounce = NEW establishmentInResearch();
        //On donne aux attributs de l'objet les valeurs des variables protégée
        $newAnnounce->research = $announce;
        $newAnnounce->dateCreation = date('Y-m-d H:i:s');
        $newAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
        $newAnnounce->id_15968k4_establishment = intval($_GET['id']);
        //Si la requête passe
        if ($newAnnounce->changeAnnounce()) {
            //On envoi un message de réussite de formulaire
            $success['changeAnnounce'] = 'Annonce changée avec succès';
        } else {
            $errorList['changeAnnounce'] = 'Erreur dans le changement de l\'annonce !';
        }
    } else {
        $errorList['changeAnnounce'] = 'Veuillez écrire une annonce !';
        $errorList['changeEstablishmentAnnounce'] = 'Il y a une erreur dans le formulaire de changement d\'annonce !';
    }
}
//============================================================================Création d'annonce======================================================
if (isset($_POST['addAnnounce'])) {
    if (!empty($_POST['newAnnounce'])) {
        //On stocke la valeur dans une variable protégée
        $newAnnounce = htmlspecialchars($_POST['newAnnounce']);
        //On instancie l'objet establishmentInResearch
        $addAnnounce = NEW establishmentInResearch();
        //On donne aux attributs de l'objet les valeurs des variables protégée
        $addAnnounce->research = $newAnnounce;
        $addAnnounce->dateCreation = date('Y-m-d H:i:s');
        $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
        $addAnnounce->id_15968k4_establishment = intval($_GET['id']);
        //Si la requête passe
        if ($addAnnounce->addResearch()) {
            //On envoi un message de réussite de formulaire
            $success['addAnnounce'] = 'Annonce ajoutée avec succès';
        } else {
            $errorList['newAnnounce'] = 'Erreur dans le changement de l\'annonce !';
        }
    } else {
        $errorList['newAnnounce'] = 'Veuillez écrire une annonce !';
        $errorList['addAnnounce'] = 'Erreur dans le formulaire de création d\'annonce !';
    }
}
//====================================================================Suppression de l'annonce==================================================
//a la validation
if (isset($_POST['removeAnnounce'])) {
    //On instancie l'objet establishmentInResearch, avec pour méthode la suppression de l'annonce
    $removeAnnounce = NEW establishmentInResearch();
    $removeAnnounce->id_15968k4_establishment = intval($_GET['id']);
    if ($removeAnnounce->removeResearch()) {
        $success['removeAnnounce'] = 'Suppression de l\'annonce réussie !';
    } else {
        $errorList['removeAnnounce'] = 'Impossible de supprimer l\'annonce !';
    }
}
if (isset($_SESSION['id'])) {
//==================================================================Liste des etablissements appartenant à l'utilisateur==================================================
    $myIdEtablishment = NEW establishment();
    $myIdEtablishment->id_15968k4_users = intval($_SESSION['id']);
    $myEstablishments = $myIdEtablishment->myCompaniesId();
//=============================================================Affichage des informations de l'établissement en fonction du groupe entré==================================================
    $id = htmlspecialchars(intval($_GET['id']));
    $showEstablishment = NEW establishment();
    $showEstablishment->id = intval($id);
    $establishment = $showEstablishment->showEstablishmentByUrl();
//======================================================================Vérification s'il y a une annonce de créée==================================================
    $status = NEW establishmentInResearch();
    $status->id_15968k4_establishment = intval($_GET['id']);
    $checkStatus = $status->establishmentStatus();
}