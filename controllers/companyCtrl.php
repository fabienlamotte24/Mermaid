<?php

$errorList = array();
$success = array();
//================================================================================Création du copte entreprise====================================================================
$regCompanyName = '/^[A-Za-z0-9\'\-\_ôîûêâéèàù ]+$/';
$regSiretNumber1 = '/^[0-9]{3}$/';
$regSiretNumber2 = '/^[0-9]{5}+$/';
$siret1 = '';
$siret2 = '';
$siret3 = '';
$siret4 = '';
if (isset($_POST['submitCompany'])) {
    //Vérification du champs du nom du compte entreprise
    if (!empty($_POST['company'])) {
        if (preg_match($regCompanyName, $_POST['company'])) {
            $company = htmlspecialchars($_POST['company']);
        } else {
            $errorList['company'] = 'Votre saisie contient des caractères interdits !';
        }
    } else {
        $errorList['company'] = 'Ce champs est vide !';
    }
    //Vérification du numéro de siret
    if (!empty($_POST['siretNumber1'])) {
        if (preg_match($regSiretNumber1, $_POST['siretNumber1'])) {
            $siret1 = htmlspecialchars($_POST['siretNumber1']);
        } else {
            $errorList['submitCompany'] = 'Le premier champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        $errorList['submitCompany'] = 'Le premier champs du numéro de siret est vide !';
    }
    if (!empty($_POST['siretNumber2'])) {
        if (preg_match($regSiretNumber1, $_POST['siretNumber2'])) {
            $siret2 = htmlspecialchars($_POST['siretNumber2']);
        } else {
            $errorList['submitCompany'] = 'Le second champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        $errorList['submitCompany'] = 'Le second champs du numéro de siret est vide !';
    }
    if (!empty($_POST['siretNumber3'])) {
        if (preg_match($regSiretNumber1, $_POST['siretNumber3'])) {
            $siret3 = htmlspecialchars($_POST['siretNumber3']);
        } else {
            $errorList['submitCompany'] = 'Le troisième champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        $errorList['submitCompany'] = 'Le troisième champs du numéro de siret est vide !';
    }
    if (!empty($_POST['siretNumber4'])) {
        if (preg_match($regSiretNumber2, $_POST['siretNumber4'])) {
            $siret4 = htmlspecialchars($_POST['siretNumber4']);
        } else {
            $errorList['submitCompany'] = 'Le quatrième champs du numéro de siret contient des caractères interdits !';
        }
    } else {
        $errorList['submitCompany'] = 'Le quatrième champs du numéro de siret est vide !';
    }
    //vérification de l'envoi de fichier
    if (!empty($_FILES['photo']) && ($_FILES['photo']['error'] == 0) && (count($errorList) == 0)) {
        //Vérification de la taille du fichier
        if ($_FILES['photo']['size'] <= 1000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'gif', 'png');
            $informationsFile = pathinfo($_FILES['photo']['name']);
            $extension_upload = $informationsFile['extension'];
            //On test son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_SESSION['id'] . '.' . $extension_upload;
                $link = '../../assets/img/proPictures/avatar/' . $name;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $link) && count($errorList) == 0) {
                    chmod($link, 0777);
                    $addCompany = NEW establishment();
                    $addCompany->companyName = $company;
                    $addCompany->siretNumber = $siret1 . $siret2 . $siret3 . $siret4;
                    $addCompany->id_15968k4_users = intval($_SESSION['id']);
                    $addCompany->companyPicture = $name;
                    $addCompany->addCompany();
                } else {
                    $errorList['photo'] = 'Echec de l\'envoie du fichier !';
                }
            } else {
                $errorList['photo'] = 'Format du fichier non conforme !';
            }
        } else {
            $errorList['photo'] = 'Fichier trop lourd !';
        }
    } else {
        $errorList['photo'] = 'Veuillez choisir un fichier !';
    }
}
//==============================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
//===========================================================================Vérification existence d'une entreprise==================================================
$isGetCompany = NEW establishment();
$isGetCompany->id_15968k4_users = $_SESSION['id'];
$companyCheck = $isGetCompany->isGetCompany();
//===============================================================================Changement du nom de l'entreprise=================================================================
if (isset($_POST['changeCompanyName'])) {
    if (!empty($_POST['companyName'])) {
        if (preg_match($regCompanyName, $_POST['companyName'])) {
            $changeCompanyName = NEW establishment();
            $changeCompanyName->companyName = htmlspecialchars($_POST['companyName']);
            $changeCompanyName->id_15968k4_users = intval($_SESSION['id']);
            if ($changeCompanyName->changeNameCompany()) {
                $success['changeCompanyName'] = 'Nom changé avec succès';
            } else {
                $errorList['changeCompanyName'] = 'Erreur dans le changement de votre nom d\'entreprise!';
            }
        } else {
            $errorList['changeCompanyName'] = 'Le champs de changement de nom d\'entreprise contient des caractères interdits par le formulaire !';
        }
    } else {
        $errorList['changeCompanyName'] = 'Le champs de changement de nom d\'entreprise est vide !';
    }
}
//=================================================================================Affichage des informations====================================================================
$showContent = NEW establishment();
$showContent->id_15968k4_users = $_SESSION['id'];
$showEstablishment = $showContent->displayContent();
