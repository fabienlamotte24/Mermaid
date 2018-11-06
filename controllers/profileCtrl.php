<?php

//===================================================================Changement de la présentation utilisateur================
//Pas de regex pour la présentation.
//Initialisation de la valeur
$present = '';
if (isset($_POST['changePresentation'])) {
    if (!empty($_POST['presentation'])) {
        //On instancie l'objet users, avec pour méthode le changement de la présentation
        $presentSentence = NEW users();
        $presentSentence->id = $_SESSION['id'];
        $present = htmlspecialchars($_POST['presentation']);
        $presentSentence->presentation = $present;
        //Si la requête passe...
        if ($presentSentence->changePresentation()) {
            //...On donne à la variable de session la valeur de la variable $present
            $_SESSION['presentation'] = $present;
        }
    } else {
        $errorList['presentation'] = 'votre présentation est vide !';
    }
}
//======================================================================Ajout d'une photo de profil===================================================================
$name = '';
if (isset($_POST['submitFile'])) {
    //On test si le fichier est bel et bien un fichier
    if (!empty($_FILES['newFile']) && $_FILES['newFile']['error'] == 0) {
        //On test sa taille maximal
        if ($_FILES['newFile']['size'] <= 1000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'gif', 'png');
            $informationsFile = pathinfo($_FILES['newFile']['name']);
            $extension_upload = $informationsFile['extension'];
            //On test son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_FILES['newFile']['name'];
                $link = '../../assets/img/userPictures/' . $name;
                //On vérifie qu'il a bien été téléchargé
                if (move_uploaded_file($_FILES['newFile']['tmp_name'], $link)) {
                    chmod($link, 0777);
                    $double = NEW userPhotos();
                    $double->id_15968k4_users = intval($_SESSION['id']);
                    $double->userPhotos = $name;
                    $check = $double->alreadyUsedPhoto();
                    if ($check == 0) {
                        $pictures = NEW userPhotos();
                        $pictures->userPhotos = $name;
                        $pictures->id_15968k4_users = intval($_SESSION['id']);
                        if($pictures->addPhotos()){
                        header('locate:profile.php');
                        } else {
                            $errorList['submitFile'] = 'Erreur dans l\'ajout de la photo !';
                        }
                    } else {
                        $errorList['submitFile'] = 'Cette image existe déjà !';
                    }
                } else {
                    $errorList['submitFile'] = 'Le téléchargement du fichier a échoué';
                }
            } else {
                $errorList['submitFile'] = 'Le fichier n\'est pas du bon format';
            }
        } else {
            $errorList['submitFile'] = 'La taille du fichier est supérieur à la taille autorisée';
        }
    } else {
        $errorList['submitFile'] = 'Merci d\'envoyer un fichier';
    }
}
//==============================================================================Affichage des photos==================================================
$showGalery = NEW userPhotos();
$showGalery->id_15968k4_users = intval($_SESSION['id']);
$displayPhotos = $showGalery->showPhotos();
//==============================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
