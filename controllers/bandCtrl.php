<?php

//Création de tableaux vide pour gérer soit les erreurs soit les réussites de formulaire
$errorList = array();
$success = array();
//==========================================================Vérification si l'utilisateur a déjà créé un groupe(suite à la fin)============================================
//Instanciation de l'objet band avec la méthode de vérification de groupe créé
$haveGroupCreated = NEW band();
$haveGroupCreated->idCreator = intval($_SESSION['id']);
$checkGroupCreated = $haveGroupCreated->haveGroup();
//=================================================================Création d'un groupe de musique=========================================================
//Regex pour la création de groupe
$regBandName = '/^[A-Za-z0-9ôîûêâé\'\-èà ]+$/';
//Initialisation de variable
if (isset($_POST['validateBand'])) {
    if (!empty($_POST['bandName'])) {
        if (preg_match($regBandName, $_POST['bandName'])) {
            //Instanciation de l'objet band, avec methode pour vérifier si le nom n'est pas déjà pris
            $isAlreadyUsed = NEW band();
            $bandName = htmlspecialchars($_POST['bandName']);
            $isAlreadyUsed->bandName = $bandName;
            //Appel de la méthode
            $check = $isAlreadyUsed->notSameBandName();
            //Si != 0, alors le nom est déjà pris
            if ($check != 0) {
                $errorList['bandName'] = 'Ce nom de groupe est déjà pris !';
            }
        } else {
            $errorList['bandName'] = 'Ce nom est invalide !';
        }
    } else {
        $errorList['bandName'] = 'Veuillez entrer un nom pour votre groupe !';
    }
    if (!empty($_POST['bandDescription'])) {
        $description = htmlspecialchars($_POST['bandDescription']);
    } else {
        $errorList['bandDescription'] = 'Une description de votre groupe est demandée !';
    }
    //Si le formulaire ne contient aucune erreur
    if (count($errorList) == 0) {
        //On instancie l'objet band, avec pour méthode la création de groupe de musique
        $createBand = NEW band();
        $createBand->bandName = $bandName;
        $createBand->bandDescription = $description;
        $createBand->idCreator = intval($_SESSION['id']);
        //Condition pour vérifier si la requête a bien été exécutée
        if ($createBand->createBand() && count($errorList) == 0) {
            //On instancie l'objet band, avec pour méthode la recherche de l'id du groupe
            $findId = NEW band();
            $findId->idCreator = intval($_SESSION['id']);
            $idFound = $findId->idFind();
            $idInteger = intval($idFound->id);
            //Si la requête passe...
            if (is_integer($idInteger) && count($errorList) == 0) {
                //On instancie l'objet members, avec pour méthode l'ajout d'un membre (ici le créateur du groupe)
                $addCreatorToMembers = NEW members();
                $addCreatorToMembers->idBand = $idInteger;
                $addCreatorToMembers->idUser = intval($_SESSION['id']);
                $addCreatorToMembers->addMember();
            } else {
                //...Message d'erreur
                $errorList['validateBand'] = 'Erreur dans la création du groupe !';
            }
        } else {
            //...Message d'erreur
            $errorList['validateBand'] = 'Erreur dans la création du groupe !';
        }
    }
}
//======================================================================Gestion de la suppression du groupe==================================================================================
//Lorsque l'on appuie sur le boutton de validation
if (isset($_POST['removeBand'])) {
    //On instancie l'objet band, avec pour méthode la recherche de l'id du groupe en question à supprimer
    $findId = NEW band();
    $findId->idCreator = intval($_SESSION['id']);
    //Si la requête passe...
    if ($findId->idFind()) {
        //...On instancie l'objet members, avec pour méthode la suppression des membres du groupe à supprimer
        $removeMembers = NEW members();
        $idGroup = $findId->idFind();
        $removeMembers->id = intval($idGroup->id);
        //...Si la requête passe
        if ($removeMembers->groupRemove()) {
            //On instancie l'objet band, avec pour méthode la suppression du groupe
            $removeBand = NEW band();
            $removeBand->id = intval($idGroup->id);
            //...Si la requête ne passe pas
            if (!$removeBand->removeBand()) {
                //...Message d'erreur
                $errorList['bandRemove'] = 'La suppression du groupe a échouée';
            }
        } else {
            //...Message d'erreur
            $errorList['bandRemove'] = 'L\'étape de suppression des membres du groupe a échouée';
        }
    } else {
        //...Message d'erreur
        $errorList['bandRemove'] = 'La recherche de l\'identification du groupe n\'a pas été effectué !';
    }
}
//=========================================================================Modification de photo de groupe==========================================================================
$name = '';
if (isset($_POST['submitGroupPhoto'])) {
    if (!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        if ($_FILES['photo']['size'] <= 1000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'gif', 'png');
            $informationsFile = pathinfo($_FILES['photo']['name']);
            $extension_upload = $informationsFile['extension'];
            //On test son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_FILES['photo']['name'];
                $link = '../../assets/img/groupPictures/avatars/' . $name;
                //On vérifie qu'il a bien été téléchargé
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $link)) {
                    chmod($link, 0777);
                    $pictures = NEW band();
                    $pictures->bandPicture = $name;
                    $pictures->idCreator = intval($_SESSION['id']);
                    if ($pictures->modifyPhoto()) {
                        header('locate:profile.php');
                    } else {
                        $errorList['submitFile'] = 'Erreur dans l\'ajout de la photo !';
                    }
                } else {
                    $errorList['submitFile'] = 'Erreur du téléchargement !';
                }
            } else {
                $errorList['submitFile'] = 'Erreur dans le format de votre fichier !';
            }
        } else {
            $errorList['submitFile'] = 'Taille supérieure à la taille autorisée pour votre fichier !';
        }
    } else {
        $errorList['submitFile'] = 'Veuillez choisir un fichier !';
    }
}
////============================================================Gestion d'affichage du groupé créé par l'utilisateur===========================================
//Instanciation de l'objet band, avec pour méthode l'affichage du détail de groupe
$groupCreated = NEW band();
$groupCreated->idCreator = intval($_SESSION['id']);
$showGroupCreated = $groupCreated->showGroupCreated();
//==============================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
