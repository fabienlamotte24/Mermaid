<?php

$errorList = array();
$success = array();
$regBandName = '/^[A-Za-z0-9\'\-\_ôîûêâéèàù ]+$/';
//===============================================================================Création du groupe de musique====================================================================
//Au boutton de validation
if (isset($_POST['submitBand'])) {
    /**
     * On vérifie le champs bandName *Nom du groupe* 
     */
    //On vérifie que le champs n'est pas vide
    if (!empty($_POST['bandName'])) {
        if (preg_match($regBandName, $_POST['bandName'])) {
            $bandName = htmlspecialchars($_POST['bandName']);
            //...On instancie l'objet band, avec pour méthode la vérification que ce nom ne soit pas pris
            $isSame = NEW band();
            $isSame->bandName = $bandName;
            $checkName = $isSame->notSameBandName();
            //...S'il n'est pas pris
            if ($checkName == 0) {
                //...On stock le nom dans la varable $freeBandName
                $freeBandName = $bandName;
            } else {
                $errorList['bandName'] = 'Ce nom appartient déjà à un autre groupe !';
            }
        } else {
            $errorList['bandName'] = 'Le nom rentré n\'est pas valide !';
        }
    } else {
        $errorList['bandName'] = 'Veuillez entrer un nom de groupe !';
    }
    /**
     * On vérifie le champs bandDescription *Description du groupe*
     */
    //On vérifie que le champs n'est pas vide
    if (!empty($_POST['bandDescription'])) {
        $bandDescription = htmlspecialchars($_POST['bandDescription']);
    } else {
        $errorList['bandDescription'] = 'Veuillez nous décrire votre groupe !';
    }
    /**
     * On vérifie le champs bandPicture *Image de profil du groupe*
     */
    //On vérifie que le champs n'est pas vide
    if (!empty($_FILES['bandPicture']) && ($_FILES['bandPicture']['error'] == 0)) {
        //On test la taille du fichier
        if ($_FILES['bandPicture']['size'] <= 2000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'png');
            $informationsFile = pathinfo($_FILES['bandPicture']['name']);
            $extension_upload = $informationsFile['extension'];
            //On test son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_SESSION['id'] . '.' . $extension_upload;
                $link = '../../assets/img/bandPictures/avatars/' . $name;
                //On effectue le téléchargement du fichier dans l'endroit voulu
                if (move_uploaded_file($_FILES['bandPicture']['tmp_name'], $link) && count($errorList) == 0) {
                    $bandPicture = $name;
                } else {
                    $errorList['bandPicture'] = 'Une erreur est survenue lors de l\'envoi du fichier !';
                }
            } else {
                $errorList['bandPicture'] = 'Le fichier n\'est pas du bon format !';
            }
        } else {
            $errorList['bandPicture'] = 'La taille du fichier dépasse la limite autorisée !';
        }
    } else {
        $errorList['bandPicture'] = 'Veuillez sélectionner une photo à télécharger !';
    }
    //On procède à l'enregistrement du groupe si le formulaire ne retourne aucune erreur
    if (count($errorList) == 0) {
        //Puis on instancie l'objet band, avec pour méthode l'enregistrement du groupe
        $createBand = NEW band();
        $createBand->bandName = $bandName;
        $createBand->bandDescription = $bandDescription;
        $createBand->idCreator = intval($_SESSION['id']);
        $createBand->bandPicture = $bandPicture;
        if ($createBand->createBand()) {
            header('location:profile.php');
        } else {
            $errorList['submitBand'] = 'Il y a des erreurs dans votre formulaire !';
        }
    }
}