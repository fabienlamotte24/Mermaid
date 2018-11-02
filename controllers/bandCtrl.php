<?php
//Création de tableaux vide pour gérer soit les erreurs soit les réussites de formulaire
$errorList = array();
$success = array();
//==========================================================Vérification si l'utilisateur a déjà créé un groupe============================================
//Instanciation de l'objet band avec la méthode de vérification de groupe créé
$haveGroupCreated = NEW band();
$haveGroupCreated->id = $_SESSION['id'];
//Appel de la méthode haveGroupe
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
        $createBand->idCreator = $_SESSION['id'];
        //Condition pour vérifier si la requête a bien été exécutée
        if ($createBand->createBand()) {
            $success['validateBand'] = 'Votre groupe a été créé avec succès !';
        } else {
            $errorList['validateBand'] = 'Erreur dans la création de groupe !';
        }
    } else {
        $errorList['validateBand'] = 'Vous avez des erreurs dans vos champs de formulaire !';
    }
}
//============================================================Gestion d'affichage du groupé créé par l'utilisateur===========================================
//Instanciation de l'objet band, avec pour méthode l'affichage du détail de groupe
$groupCreated = NEW band();
$groupCreated->id = $_SESSION['id'];
$showGroupCreated = $groupCreated->showGroupCreated();