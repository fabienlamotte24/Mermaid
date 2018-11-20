<?php

//Liste de tableaux vide pour gerer les erreurs et les validations de formulaire
$errorList = array();
$success = array();
//======================================================================Changement de l'adresse postale====================
$regAddress = '/^[A-Za-z0-9\-\_.ôîûêéèçà\' ]+$/';
$regCity = '/^[0-9]+$/';
$regPostalCode = '/^[0-9]+$/';
//Appel ajax pour afficher les villes du code postal rentré
if (isset($_POST['newPostalSearch'])) {
    include'../config.php';
    //On instancie l'objet cities, avec pour méthode la recherche des villes par code postal
    $postal = NEW cities();
    $postal->postalCode = htmlspecialchars($_POST['newPostalSearch']);
    $postalResearch = $postal->postalCodeList();
    echo json_encode($postalResearch);
} else {
//=======================================================================Changement des informations personnelles========================================
    if (isset($_POST['changeUserInformations'])) {
        /**
         * Vérification de l'adresse de messagerie
         */
        if (!empty($_POST['mail'])) {
            /**
             * Nous faisons une vérification: si l'adresse mail entrée n'existe pas déjà
             */
            $mail = htmlspecialchars($_POST['mail']);
            //On instancie l'objet user, avec pour méthode la vérification de l'existence du mail entré
            $mailAlreadyUsed = NEW users();
            $mailAlreadyUsed->mail = $mail;
            //On applique la requête associée
            $checkMail = $mailAlreadyUsed->notSameEmail();
            //Si $checkMail == 0, alors l'adresse n'est pas encore utilisé, on peut alors l'enregistrer
            if ($checkMail == 0) {
                //On garde la valeur dans une autre variable pour l'enregistrer par la suite
                $mailConfirm = $mail;
            } else {
                $errorList['mail'] = 'Cette adresse de messagerie est déjà prise !';
            }
        } else {
            $errorList['mail'] = 'Veuillez entrer une adresse de messagerie !';
        }
        /**
         * Vérification du numéro de téléphone
         */
        if (!empty($_POST['phoneNumber'])) {
            //regex pour le numéro de téléphone
            $regPhone = '/^(06|07){1}[0-9]{8}$/';
            $phoneNumber = htmlspecialchars($_POST['phoneNumber']);
            if (preg_match($regPhone, $phoneNumber)) {
                $phoneNumberConfirm = $phoneNumber;
            } else {
                $errorList['phoneNumber'] = 'Le numéro de téléphone rentré n\'est pas valide !';
            }
        } else {
            $errorList['phoneNumber'] = 'Veuillez entrer un numéro de téléphone !';
        }
        /**
         * Vérification de l'adresse postale
         */
        if (!empty($_POST['address'])) {
            $address = htmlspecialchars($_POST['address']);
        } else {
            $errorList['address'] = 'Veuillez entrer une adresse !';
        }
        /**
         * Vérification du code postal
         */
        if (!empty($_POST['newPostalCode'])) {
            //Regex pour le code postal
            $regPostalCode = '/^[0-9]+$/';
            $postalCode = htmlspecialchars($_POST['newPostalCode']);
            if (preg_match($regPostalCode, $postalCode)) {
                $postalCodeConfirm = $postalCode;
            } else {
                $errorList['newPostalCode'] = 'Le code postal entré n\'est pas valide !';
            }
        } else {
            $errorList['newPostalCode'] = 'Veuillez entrer un code postal !';
        }
        /**
         * Vérification de la ville
         */
        if (!empty($_POST['newCitySelect'])) {
            $city = htmlspecialchars(intval($_POST['newCitySelect']));
        } else {
            $errorList['newCitySelect'] = 'Veuillez sélectionner une ville !';
        }
        /**
         * Si le formulaire ne contient aucune erreur, nous procédons à l'enregistrement des données rentrée
         */
        if (count($errorList) == 0) {
            //On instancie l'objet users, avec pour méthode le changement des informations
            $change = NEW users();
            $change->mail = $mailConfirm;
            $change->phoneNumber = $phoneNumberConfirm;
            $change->address = $address;
            $change->id_15968k4_Cities = intval($city);
            $change->id = intval($_SESSION['id']);
            if ($change->changeContentsOfAccount()) {
                $success['changeUserInformations'] = 'Informations changées avec succès';
                $_SESSION['mail'] = $mailConfirm;
                $_SESSION['phoneNumber'] = $phoneNumberConfirm;
                $_SESSION['address'] = $address;
                $_SESSION['id_15968k4_Cities'] = $city;
            } else {
                $errorList['changeUserInformations'] = 'Une erreur est survenue dans le changement des informations !';
            }
        } else {
            $errorList['changeUserInformations'] = 'Votre formulaire contient des erreurs !';
        }
    }
//=========================================================================Changement du mot de passe=================================================================
    if (isset($_POST['changePass'])) {
        //On initialise les variables
        $pass1 = '';
        $pass2 = '';
        $passToKeep = '';
        /**
         * Vérification du mot de passe actuel
         */
        if (!empty($_POST['actualPass'])) {
            //Regex pour le mot de passe
            $actualPass = htmlspecialchars($_POST['actualPass']);
            //On instancie l'objet users, avec pour méthode la vérification du mot de passe
            $isCorrectPass = NEW users();
            $isCorrectPass->id = intval($_SESSION['id']);
            //On applique la requête associée
            $goodPass = $isCorrectPass->isCorrectPass();
            if (password_verify($actualPass, $goodPass->password)) {
                $success['actualPass'] = 'Le mot de passe est correct !';
            } else {
                $errorList['actualPass'] = 'Le mot de passe est incorrect !';
            }
        } else {
            $errorList['actualPass'] = 'Ce champs est vide !';
        }
        /**
         * Vérification du premier mot de passe entré
         */
        if (!empty($_POST['pass1'])) {
            //Regex pour le mot de passe
            $regPass = '/^[A-Za-z0-9çôîûêéèçà\-\'#@&!%$*]+$/';
            $pass1 = htmlspecialchars($_POST['pass1']);
            if(preg_match($regPass, $_POST['pass1'])){
                $pass1 = htmlspecialchars($_POST['pass1']);
            } else {
                $errorList['pass1'] = 'Le mot de passe rentré contient des caractères interdits !';
            }
        } else {
            $errorList['pass1'] = 'Veuillez entrer un mot de passe !';
        }
        /**
         * Vérification du second mot de passe
         */
        if(!empty($_POST['pass2'])){
            $pass2 = htmlspecialchars($_POST['pass2']);
        } else {
            $errorList['pass2'] = 'Veuillez réécrire votre mot de passe !';
        }
        /**
         * On vérifie que les deux mots de passe concordent
         */
        if($pass1 == $pass2){
            $passToKeep = $pass1;
        }
        /**
         * On vérifie si le formulaire ne retourne aucune erreur
         */
        if(count($errorList) == 0){
            //On instancie l'objet users, avec pour méthode le changement de mot de passe
            $changePass = NEW users();
            $changePass->password = password_hash($passToKeep, PASSWORD_DEFAULT);
            $changePass->id = intval($_SESSION['id']);
            if($changePass->changePass()){
                $success['changePass'] = 'Mot de passe changé avec succès !';
                $_SESSION['password'] = password_hash($passToKeep, PASSWORD_DEFAULT);
            } else {
                $errorList['changePass'] = 'Erreur dans le changement de mot de passe !';
            }
        } else {
            $errorList['changePass'] = 'Il y a des erreurs dans votre formulaire !';
        }
    }
//=========================================================================enregistrement de la photo=================================================================
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
                    $name = $_SESSION['id'] . '.' . $extension_upload;
                    $link = '../../assets/img/userPictures/avatars/' . $name;
                    //On vérifie qu'il a bien été téléchargé
                    if (move_uploaded_file($_FILES['newFile']['tmp_name'], $link)) {
                        $profilPicture = NEW users();
                        $profilPicture->profilPicture = $name;
                        $profilPicture->id = intval($_SESSION['id']);
                        //On rentre son nom dans la base de donnée
                        if ($profilPicture->newProfilePicture()) {
                            $success['submitFile'] = 'Enregistrement de l\'image réussie !';
                            $_SESSION['profilPicture'] = $name;
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
//=====================================================================Vérification existence d'une photo===========================================
    $thereIsAPhoto = NEW userPhotos();
    $thereIsAPhoto->id = intval($_SESSION['id']);
    $photo = $thereIsAPhoto->alreadyUsedPhoto();
//=======================================================================Affichage des informations de compte============================================
//On instancie l'objet user permettant l'affichage des informations
    $stockAllContent = NEW users();
//On gère l'affichage des informations de l'utilisateur
    $stockAllContent->id = intval($_SESSION['id']);
//On appel la méthode pour afficher les valeurs
    $showAllContent = $stockAllContent->showCompleteUserContent();
}
//=========================================================================Suppression du compte==================================================
if(isset($_POST['confirmRemove'])){
    $removeUser = NEW users();
    $removeUser->id = intval($_SESSION['id']);
    if($removeUser->removeUser()){
        //On vide les valeurs des variables de session
        session_unset();
        //destruction de la session
        session_destroy();
        //On redirige vers l'index.php
        header('location:../../index.php');
    } else {
        $errorList['confirmRemove'] = 'Erreur dans la suppression de votre compte';
    }
}
