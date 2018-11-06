<?php

//Liste de tableaux vide pour gerer les erreurs et les validations de formulaire
$errorList = array();
$success = array();
//======================================================================Changement de l'adresse postale====================
//Regex pour le changement d'adresse
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
    if (isset($_POST['validateNewAddress'])) {
        //On instancie l'objet users, avec pour méthode le changement de l'adresse postale
        $changeAddress = NEW users();
        if (!empty($_POST['newAddress'])) {
            if (preg_match($regAddress, $_POST['newAddress'])) {
                $newAddress = htmlspecialchars($_POST['newAddress']);
                //On garde en attribut address de l'objet users, la valeur de la variable de l'adress postal rentrée
                $changeAddress->address = $newAddress;
            } else {
                $errorList['validateNewAdress'] = 'Adresse invalide';
            }
        } else {
            $errorList['validateNewAdress'] = 'Adresse non remplie';
        }
        if (!empty($_POST['newPostalCode']) && $_POST['newCitySelect'] != 0) {
            if (preg_match($regPostalCode, $_POST['newPostalCode']) && preg_match($regCity, $_POST['newCitySelect'])) {
                $newCity = htmlspecialchars($_POST['newCitySelect']);
                $idCity = intval($newCity);
                $postalCode = htmlspecialchars($_POST['newPostalCode']);
                //On garde en attribut idCities de l'objet users l'id de la ville selectionnée dans le champs de choix de la ville
                $changeAddress->idCities = $idCity;
            } else {
                $errorList['validateNewAdress'] = 'Un ou deux des champs sont invalides !';
            }
        } else {
            $errorList['validateNewAdress'] = 'Un ou deux des champs sont vides !';
        }
        //Si le formulaire ne retourne aucune erreur...
        if (count($errorList) == 0) {
            $changeAddress->id = $_SESSION['id'];
            //On test la requête
            if ($changeAddress->changeAddress()) {
                //On attribut les valeurs des variables dans les valeurs de session pour les afficher directement par la suite
                $_SESSION['address'] = $changeAddress->address;
                $_SESSION['idCities'] = $idCity;
                $_SESSION['postalCode'] = $postalCode;
                $success['validateNewAdress'] = 'Adresse changée avec succès !';
            } else {
                $errorList['validateNewAdress'] = 'L\'enregistrement a échoué !';
            }
        } else {
            $errorList['validateNewAdress'] = 'Veuillez vérifier les champs du formulaire !';
        }
    }
//====================================================================Changement de l'adresse de messagerie=================
//Pas de regex pour l'adresse de messagerie
//la fonction filter var saura vérifier lui même la validité de l'adresse Email
    $mail = '';
    if (isset($_POST['validateNewEmail'])) {
        if (!empty($_POST['newEmail'])) {
            if (filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL)) {
                //On instancie l'objet users, avec pour méthode la vérification que l'email existe
                $mailVerify = NEW users;
                $mail = htmlspecialchars($_POST['newEmail']);
                $mailVerify->mail = $mail;
                $check = $mailVerify->notSameEmail();
                //...Si il existe...
                if ($check == 0) {
                    //...On instancie l'objet user, avec pour méthode le changement de l'adresse email
                    $email = NEW users();
                    $email->id = $_SESSION['id'];
                    $email->mail = $mail;
                    //...Si la requête passe...
                    if ($email->changeEmail()) {
                        //...L'email est changé
                        $success['newEmail'] = 'Adresse de messagerie changée avec succès !';
                        $_SESSION['mail'] = $mail;
                    } else {
                        $errorList['newEmail'] = 'le changement d\'adresse a échoué';
                    }
                } else {
                    $errorList['newEmail'] = 'Cette adresse de messagerie est déjà utilisée';
                }
            } else {
                $errorList['newEmail'] = 'L\'adresse de messagerie rentrée n\'est pas valide';
            }
        } else {
            $errorList['newEmail'] = 'Le champs est vide';
        }
    }
//===================================================================Changement de la présentation utilisateur================
//Pas de regex pour la présentation.
//Initialisation de la valeur
    $present = '';
    if (isset($_POST['changePresentation'])) {
        if (!empty($_POST['presentation'])) {
            //On instancie l'objet user, avec pour méthode le changement de la présentation
            $presentSentence = NEW users();
            $presentSentence->id = $_SESSION['id'];
            $present = htmlspecialchars($_POST['presentation']);
            $presentSentence->presentation = $present;
            //Si la requête passe
            if ($presentSentence->changePresentation()) {
                //...On attribut la valeur présentation à la variable de session
                $_SESSION['presentation'] = $present;
            }
        } else {
            $errorList['presentation'] = 'votre présentation est vide !';
        }
    }
//=========================================================================Changement de mot de passe=======================
//Regex du mot de passe.
    $regPass = '/^[A-Za-z0-9çôîûêéèçà\-\'#@&!%$*]+$/';
//Initialisation des variables
    $password1 = '';
    $password2 = '';
    $passToChange = '';
    if (isset($_POST['submitPass'])) {
        if (!empty($_POST['newPass1'])) {
            if (preg_match($regPass, $_POST['newPass1'])) {
                //...On garde dans une variable la valeur du premier mot de passe rentré
                $password1 = htmlspecialchars($_POST['newPass1']);
            } else {
                $errorList['newPass1'] = 'Le mot de passe possède des caractères interdits !';
            }
        } else {
            $errorList['newPass1'] = 'Le champs "nouveau mot de passe" est vide';
        }
        if (!empty($_POST['newPass2'])) {
            if (preg_match($regPass, $_POST['newPass2'])) {
                //...On garde dans une variable la valeur du premier mot de passe rentré
                $password2 = htmlspecialchars($_POST['newPass2']);
            } else {
                $errorList['newPass2'] = 'Le mot de passe possède des caractères interdits !';
            }
        } else {
            $errorList['newPass2'] = 'Le champs "réécriture de mot de passe" est vide';
        }
        if (!empty($_POST['actualPass']) && count($errorList) == 0) {
            //On instancie l'objet users, avec pour méthode le changement du mot de passe
            $passChange = NEW users();
            $passToChange = htmlspecialchars($_POST['actualPass']);
            //...On vérifie que le mot de passe rentré correspond au mot de passe de la base de donné pour cet utilisateur
            if (password_verify($passToChange, $_SESSION['password'])) {
                //...On vérifie que les deux mots de passe souhaité sont identiques
                if ($password1 === $password2) {
                    $passChange->id = $_SESSION['id'];
                    $passChange->password = password_hash($password1, PASSWORD_DEFAULT);
                    //Si la requête ne passe pas
                    if (!$passChange->changePass()) {
                        $errorList['submitPass'] = 'Erreur de changement';
                    } else {
                        //...Sinon on garde la valeur dans la variable de session password
                        $_SESSION['password'] = $password1;
                        $success['submitPass'] = 'Mot de passe changé avec succès !';
                    }
                } else {
                    $errorList['submitPass'] = 'Les deux mot de passe ne concordent pas !';
                }
            } else {
                $errorList['submitPass'] = 'Le mot de passe saisie est incorrect';
            }
        } else {
            $errorList['submitPass'] = 'Votre mot de passe actuel est nécessaire !';
        }
    }
//====================================================================Changement du numéro de téléphone===============================
//Regex du numéro de téléphone
    $regPhone = '/^(06|07){1}[0-9]{8}$/';
    if (isset($_POST['validateNewPhoneNumber'])) {
        if (!empty($_POST['newPhoneNumber'])) {
            if (preg_match($regPhone, $_POST['newPhoneNumber'])) {
                $newPhoneNumber = htmlspecialchars($_POST['newPhoneNumber']);
                //On instancie l'objet user, avec pour méthode le changement du numéro de téléphone
                $phoneNumber = NEW users();
                $phoneNumber->phoneNumber = $newPhoneNumber;
                $phoneNumber->id = $_SESSION['id'];
                //Si la requête passe...
                if ($phoneNumber->changeNumberPhone()) {
                    //...On change le numéro de téléphone et affiche le message de confirmation
                    $success['newPhoneNumber'] = 'Numéro de téléphone changé avec succès !';
                } else {
                    $errorList['newPhoneNumber'] = 'Le changement du numéro de téléphone a échoué';
                }
            } else {
                $errorList['newPhoneNumber'] = 'Le numéro entré n\'est pas valide !';
            }
        } else {
            $errorList['newPhoneNumber'] = 'Veuillez entrer un numéro de téléphone !';
        }
    }
//======================================================================Suppression du compte====================================================
//Condition si l'on appuie sur le boutton supprimer
    if (isset($_POST['removeUser'])) {
        //On instancie l'objet user, avec pour méthode la suppression du compte d'utilisateur
        $remove = NEW users();
        $remove->id = $_SESSION['id'];
        //...Si la requête passe 
        if ($remove->removeUser()) {
            //On vide les variables de session
            session_unset();
            //On détruit les variables de session
            session_destroy();
            //...Puis on redirige vers l'accueil avec la demande de connexion
            header('location:../../index.php');
        }
    }
//Si on appuie sur annuler
    if (isset($_POST['cancelRemove'])) {
//On rafraichie la même page, rien ne se passe
        header('location:optionsPublic.php');
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
                    if (move_uploaded_file($_FILES['newFile']['tmp_name'], $link)){
                        chmod($link, 0777);
                        $profilPicture = NEW users();
                        $profilPicture->profilPicture = $name;
                        $profilPicture->id = intval($_SESSION['id']);
                        //On rentre son nom dans la base de donnée
                        if($profilPicture->newProfilePicture()){
                            $success['submitFile'] = 'Enregistrement de l\image réussie !';
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
    $id = $_SESSION['id'];
    $thereIsAPhoto->id = intval($id);
    $photo = $thereIsAPhoto->alreadyUsedPhoto();
//=======================================================================Affichage des informations de compte============================================
//On instancie l'objet user permettant l'affichage des informations
    $stockAllContent = NEW users();
//On gère l'affichage des informations de l'utilisateur
    $stockAllContent->id = $_SESSION['id'];
//On appel la méthode pour afficher les valeurs
    $showAllContent = $stockAllContent->showCompleteUserContent();
}
//==============================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();

