<?php

$regBandName = '/^[A-Za-z0-9\'\-\_ôîûêâéèàù ]+$/';
$id = htmlspecialchars(intval($_GET['id']));
//Création de tableaux d'erreur pour l'url
$errorUrl = array();
$successUrl = array();
//Création de tableaux d'erreur pour les formulaires
$errorList = array();
$success = array();
//==================================================================== Liste des id des groupes de l'utilisateur ==================================================
$idBandOfUser = NEW band();
$idBandOfUser->idCreator = intval($_SESSION['id']);
$showMyBands = $idBandOfUser->listBandId();
$ifIdBands = '';
//On vérifie l'existence du paramètre de l'url "id=$"
if (isset($_GET['id'])) {
    /**
     * Boucle foreach pour créer une succession de condition
     * visant à vérifier que la valeur de l'url correspond à l'id d'un groupe dont l'utilisateur est propriétaire
     */
    foreach ($showMyBands as $idBands) {
        //Si l'url équivaut à l'un des id des groupes de musique créé par l'utilisateur
        if ($id == $idBands->id) {
            //On affecte à $successUrl la valeur true
            $successUrl['url'] = true;
        } else {
            $errorUrl['url'] = false;
        }
    }
    if(count($successUrl) == 0 ){
        header('location:error404.php');
    }
} 
//==================================================================== Changement des informations du groupe ==================================================
if (isset($_POST['changeBandContent'])) {
    /**
     * Vérification du nom du groupe
     */
    if (!empty($_POST['bandName'])) {
        //On stocke la valeur entrée dans une variable protégée
        $newBandName = htmlspecialchars($_POST['bandName']);
        //On teste sa validité
        if (preg_match($regBandName, $newBandName)) {
            //Puis on la garde dans une nouvelle variable qui servira pour la rentrée finale
            $bandNameConfirmed = $newBandName;
        } else {
            $errorList['bandName'] = 'Le nom entré comporte des caractères interdits !';
        }
    } else {
        $errorList['bandName'] = 'Veuillez entrer un nom de groupe à changer !';
    }
    /**
     * Vérification de la nouvelle photo de profil
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
                $name = $_GET['id'] . '.' . $extension_upload;
                $link = '../../assets/img/bandPictures/avatars/' . $name;
                //On vérifie qu'il a bien été téléchargé
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $link)) {
                    //On stocke la valeur dans une variable protégée
                    $photoNameConfirmed = $name;
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
     * Vérification de la description du groupe de musique
     */
    if (!empty($_POST['bandDescription'])) {
        $newBandDescription = htmlspecialchars($_POST['bandDescription']);
    } else {
        $errorList['bandDescription'] = 'Veuillez entrer une description à changer !';
    }
    /*
     * Vérification si le formulaire contient une erreur avant de tenter l'enregistrement
     */
    //Si le formulaire ne contient aucune erreur
    if (count($errorList) == 0) {
        //On instancie l'objet band, avec pour méthode le changement des informations du groupe de musique
        $changeBandInformations = NEW band();
        //On donne aux attributs de l'objet les valeurs des variables protégées
        $changeBandInformations->bandName = $bandNameConfirmed;
        $changeBandInformations->bandDescription = $newBandDescription;
        $changeBandInformations->id = htmlspecialchars(intval($_GET['id']));
        $changeBandInformations->bandPicture = $photoNameConfirmed;
        //On test la requête
        if ($changeBandInformations->changeAllDetailsBand()) {
            //On affiche un message de réussite si elle est correctement passée
            $success['changeBandContent'] = 'Changement des informations réussies!';
        } else {
            $errorList['changeBandContent'] = 'Un erreur est survenue !';
        }
    } else {
        $errorList['changeBandContent'] = 'Il y a au moins une erreur dans votre formulaire !';
    }
}
//==================================================================== Changement de l'annonce ==================================================
if (isset($_POST['changeAnnounce'])) {
    /**
     * Vérification du champs de l'annonce
     */
    if (!empty($_POST['announce'])) {
        //On stocke la valeur rentréée dans une variable protégée
        $announce = htmlspecialchars(trim($_POST['announce']));
        //On instancie l'objet bandin Research, avec pour méthode le changement de l'annonce
        $changeAnnounce = NEW bandInResearch();
        //On donne aux attributs de l'objet les valeurs des variables protégées
        $changeAnnounce->research = $announce;
        $changeAnnounce->id_15968k4_band = htmlspecialchars(intval($_GET['id']));
        $changeAnnounce->dateCreation = date('Y-m-d H:i:s');
        $changeAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
        //On test la requête de changement de l'annonce
        if ($changeAnnounce->changeAnnounce()) {
            //On affiche le message de réussite
            $success['announce'] = 'Annonce changée avec succès !';
        } else {
            $errorList['announce'] = 'Un erreur est survenue dans le changement de l\'annonce !';
        }
    } else {
        $errorList['announce'] = 'Veuillez écrire une annonce pour votre recherche !';
    }
}
//==================================================================== Création de l'annonce ==================================================
if(isset($_POST['addAnnounce'])){
    if(!empty($_POST['newAnnounce'])){
        $announceCreated = htmlspecialchars($_POST['newAnnounce']);
        $addAnnounce = NEW bandInResearch();
        $addAnnounce->research = $announceCreated;
        $addAnnounce->id_15968k4_band = intval($_GET['id']);
        $addAnnounce->dateCreation = date('Y-m-d H:i:s');
        $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
        if($addAnnounce->addResearch()){
            $success['addAnnounce'] = 'Annonce créée avec succès';
        }
    } else {
        $errorList['newAnnounce'] = 'Votre annonce est vide !';
        $errorList['addAnnounce'] = 'Une erreur est présente dans votre formulaire !';
    }
}

//==================================================================== Suppression de l'annonce ==================================================
if (isset($_POST['removeAnnounce'])) {
    //On instancie l'objet bandInResearch, avec pour méthode la suppression de l'annonce
    $removeAnnounce = NEW bandInResearch();
    $removeAnnounce->id_15968k4_band = intval($_GET['id']);
    //On teste la requête
    if ($removeAnnounce->removeResearch()) {
        //...Si elle passe, on affiche un message de réussite 
        $success['removeAnnounce'] = 'Votre annonce a bien été supprimée';
    } else {
        $errorList['removeAnnounce'] = 'Une erreur est survenue lors de la suppression de votre annonce';
    }
}
//==================================================================== suppression du groupe de musique ==================================================
if (isset($_POST['removeMyBand'])) {
    //On instancie l'objet band, avec pour méthode la suppression du groupe
    $removeBand = NEW band();
    $removeBand->id = intval($_GET['id']);
    //Si la requête passe
    if($removeBand->removeBand()){
        //On redirige vers la page de profile
        header('location:profile.php');
    } else {
        $errorList['removeBand'] = 'Une erreur est survenue lors de la suppression de votre groupe de musique !';
    }
}
//==================================================================== Compte du nombre d'annonce ==================================================
$isGetAnnounce = NEW bandInResearch();
$isGetAnnounce->id_15968k4_band = htmlspecialchars(intval($_GET['id']));
$checkAnnounce = $isGetAnnounce->countAnnounce();
//==================================================================== Affichage du groupe par url ==================================================
$showBandUrl = NEW band();
$showBandUrl->id = htmlspecialchars(intval($_GET['id']));
$showBand = $showBandUrl->showGroupByUrl();
//==================================================================== Compte du nombre de notification ==================================================
//Instanciation de l'objet notifications, avec pour méthode le compte du nombres de notification
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
