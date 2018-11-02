<?php

//Liste de tableaux vide pour gerer les erreurs et les validations de formulaire
$errorList = array();
$success = array();
//======================================================================Changement de l'adresse postale====================
//Regex pour le changement d'adresse
$regAddress = '/^[A-Za-z0-9\-\_.ôîûêéèçà\' ]+$/';
$regCity = '/^[0-9]+$/';
$regPostalCode = '/^[0-9]+$/';
//Appel ajax pour créer une liste de ville dans la liste déroulante newCity
//en ayant seulement besoin d'écrire le code postal
if (isset($_POST['newPostalSearch'])) {
//J'appelle le fichier config.php, qui détient tout mes modèles
    include'../config.php';
//J'utilise l'objet cities
    $postal = NEW cities();
//Je capture la valeur du champs dans l'attribut postalCode de ma méthode en le protégeant du code malveillant
    $postal->postalCode = htmlspecialchars($_POST['newPostalSearch']);
//J'utilise la méthode postalCodeList pour lister les villes correspondantes via le code postal entré
    $postalResearch = $postal->postalCodeList();
//Je conserve les résultats en les affichant en JSON pour mon AJAX
    echo json_encode($postalResearch);
} else {
//Condition pour vérifier les entrées des champs
    if (isset($_POST['validateNewAddress'])) {
//On appel l'objet users
        $changeAddress = NEW users();
//Si le champs "adresse" n'est pas vide...
        if (!empty($_POST['newAddress'])) {
//...on vérifie sa validité...
            if (preg_match($regAddress, $_POST['newAddress'])) {
//...puis on garde sa valeur en variable, protégée avec htmlspecialchars
                $newAddress = htmlspecialchars($_POST['newAddress']);
                $changeAddress->address = $newAddress;
            } else {
//...Sinon erreur de validité
                $errorList['validateNewAdress'] = 'Adresse invalide';
            }
        } else {
//...Sinon erreur d'entrée de valeur
            $errorList['validateNewAdress'] = 'Adresse non remplie';
        }
//Si les champs "code postal" et "ville" ne sont pas vide...
        if (!empty($_POST['newPostalCode']) && $_POST['newCitySelect'] != 0) {
//...et qu'ils sont valides
            if (preg_match($regPostalCode, $_POST['newPostalCode']) && preg_match($regCity, $_POST['newCitySelect'])) {
//On garde la valeur de la ville en integer pour l'incorporer dans idCities de l'objet users
                $newCity = htmlspecialchars($_POST['newCitySelect']);
                $idCity = intval($newCity);
                $postalCode = htmlspecialchars($_POST['newPostalCode']);
                $changeAddress->idCities = $idCity;
            } else {
//...Sinon erreur de validité
                $errorList['validateNewAdress'] = 'Un ou deux des champs sont invalides !';
            }
        } else {
//...Sinon erreur d'entrée de valeur
            $errorList['validateNewAdress'] = 'Un ou deux des champs sont vides !';
        }
//Si le formulaire n'as aucune erreur...
        if (count($errorList) == 0) {
//...L'attribut id de la classe user prends en valeur la variable de sessions "id"
            $changeAddress->id = $_SESSION['id'];
//...si la requête aboutit
            if ($changeAddress->changeAddress()) {
//On change les valeurs des variables de session
                $_SESSION['address'] = $changeAddress->address;
                $_SESSION['idCities'] = $idCity;
                $_SESSION['postalCode'] = $postalCode;
//Puis on affiche un message de réussite de changement d'adresse
                $success['validateNewAdress'] = 'Adresse changée avec succès !';
            } else {
//Sinon erreur de la requête
                $errorList['validateNewAdress'] = 'L\'enregistrement a échoué !';
            }
//..Sinon erreur de formulaire
        } else {
            $errorList['validateNewAdress'] = 'Veuillez vérifier les champs du formulaire !';
        }
    }
//====================================================================Changement de l'adresse de messagerie=================
//Pas de regex pour l'adresse de messagerie
//la fonction filter var saura vérifier lui même la validité de l'adresse Email
    $mail = '';
//Si on appuie sur le boutton de validation du changement d'adresse email
    if (isset($_POST['validateNewEmail'])) {
//Si le champs n'est pas vide...
        if (!empty($_POST['newEmail'])) {
//...on vérifie sa validité
            if (filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL)) {
//...On instancie l'objet users, qui servira à la vérification d'une potentielle adresse email déjà existante
                $mailVerify = NEW users;
//...On prends en variable la valeur de l'email rentré
                $mail = htmlspecialchars($_POST['newEmail']);
//...On stock la variable dans l'attribut de l'objet
                $mailVerify->mail = $mail;
//...notSameEmail() vérifie que l'adresse de messagerie n'est pas déjà utilisée
                $check = $mailVerify->notSameEmail();
//...Si tout est bon, on passe à l'étape d'enregistrement
                if ($check == 0) {
//...On instancie l'objet users, pour effectuer la rentrée de la nouvelle adresse email
                    $email = NEW users();
//...On donne à l'attribut "id" de l'objet la variable de session "id"
                    $email->id = $_SESSION['id'];
//...On donne à l'attribut "mail" de l'objet la variable stockée du champs
                    $email->mail = $mail;
//Si l'enregistrement est valide, la requête aboutit
                    if ($email->changeEmail()) {
//...On affiche un message de réussite de changement de l'email
                        $success['newEmail'] = 'Adresse de messagerie changée avec succès !';
//...On change la variable de session la valeur stockée du champs
                        $_SESSION['mail'] = $mail;
                    } else {
//...Sinon erreur de la requête
                        $errorList['newEmail'] = 'le changement d\'adresse a échoué';
                    }
                } else {
//...Sinon erreur: l'adresse est déjà utilisée
                    $errorList['newEmail'] = 'Cette adresse de messagerie est déjà utilisée';
                }
            } else {
//...Sinon erreur de validité
                $errorList['newEmail'] = 'L\'adresse de messagerie rentrée n\'est pas valide';
            }
        } else {
//...Sinon erreur de valeur d'entrée
            $errorList['newEmail'] = 'Le champs est vide';
        }
    }
//===================================================================Changement de la présentation utilisateur================
//Pas de regex pour la présentation.
//Initialisation de la valeur
    $present = '';
//Si on appuie sur le boutton de validation de la présentation
    if (isset($_POST['changePresentation'])) {
//...Et que le champs n'est pas vide
        if (!empty($_POST['presentation'])) {
//...On instancie l'objet users, pour effectuer la méthode de changement de présentation
            $presentSentence = NEW users();
//...On donne à l'attribut de l'objet "id" la variable de session "id"
            $presentSentence->id = $_SESSION['id'];
//...On stock la valeur du champs dans la variable $present
            $present = htmlspecialchars($_POST['presentation']);
//...On donne à l'attribut de l'objet "presentation" la variable contenant la valeur stockée du champ presentationn
            $presentSentence->presentation = $present;
//Si la requête aboutie
            if ($presentSentence->changePresentation()) {
//...On change la variable de session par la valeur stockée dans la variable $present
                $_SESSION['presentation'] = $present;
            }
        } else {
//...Sinon erreur d'entrée de valeur
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
//Si on appuie sur le boutton de validation de changement de mot de passe
    if (isset($_POST['submitPass'])) {
//Si le champs de newPass1 n'est pas vide
        if (!empty($_POST['newPass1'])) {
//...On vérifie sa validité
            if (preg_match($regPass, $_POST['newPass1'])) {
//...Puis on stock la valeur rentrée dans la variable $password1
                $password1 = htmlspecialchars($_POST['newPass1']);
            } else {
//...Sinon erreur de validité
                $errorList['newPass1'] = 'Le mot de passe possède des caractères interdits !';
            }
        } else {
//...Sinon erreur d'entrée de valeur
            $errorList['newPass1'] = 'Le champs "nouveau mot de passe" est vide';
        }
//Si le champs de newPass2 n'est pas vide
        if (!empty($_POST['newPass2'])) {
//...On vérifie sa validité
            if (preg_match($regPass, $_POST['newPass2'])) {
//...Puis on stock la valeur rentrée dans la variable $password2
                $password2 = htmlspecialchars($_POST['newPass2']);
            } else {
//...Sinon erreur de validité
                $errorList['newPass2'] = 'Le mot de passe possède des caractères interdits !';
            }
        } else {
//...Sinon erreur d'entrée de valeur
            $errorList['newPass2'] = 'Le champs "réécriture de mot de passe" est vide';
        }
//Si le champs de mot de passe actuel n'est pas vide et que le formulaire ne retourne aucune erreur
        if (!empty($_POST['actualPass']) && count($errorList) == 0) {
//On instancie l'objet user, avec une methode permettant le changement du mot de passe
            $passChange = NEW users();
//On stock la valeur du champs dans la variable $passToChange
            $passToChange = htmlspecialchars($_POST['actualPass']);
//Si le mot de passe actuel correspond au mot de passe contenu dans la variable de session
            if (password_verify($passToChange, $_SESSION['password'])) {
//...On s'assure que les deux mots de passe précédents sont identique
                if ($password1 === $password2) {
//...Puis on garde en valeur la variable de session dans l'attribut de l'objet "id"
                    $passChange->id = $_SESSION['id'];
//...On hash le mot de passe, que l'on stock dans l'attribut de l'objet
                    $passChange->password = password_hash($password1, PASSWORD_DEFAULT);
//Si la requête aboutie
                    if (!$passChange->changePass()) {
//erreur de la requête
                        $errorList['submitPass'] = 'Erreur de changement';
                    } else {
//...On change la variable de session par le mot de passe souhaité
                        $_SESSION['password'] = $password1;
                        $success['submitPass'] = 'Mot de passe changé avec succès !';
                    }
                } else {
//...Sinon erreur de concordance des deux mots de passe
                    $errorList['submitPass'] = 'Les deux mot de passe ne concordent pas !';
                }
            } else {
//...Sinon erreur de mot de passe
                $errorList['submitPass'] = 'Le mot de passe saisie est incorrect';
            }
        } else {
//...Sinon erreur d'entrée de valeur
            $errorList['submitPass'] = 'Votre mot de passe actuel est nécessaire !';
        }
    }
//====================================================================Changement du numéro de téléphone===============================
//Regex du numéro de téléphone
    $regPhone = '/^(06|07){1}[0-9]{8}$/';
//Condition pour vérifier la valeur rentré du champs de changement du numéro de téléphone
//Lorsque l'on clique de le bouton de validation
    if (isset($_POST['validateNewPhoneNumber'])) {
//...On vérifie que le champs n'est pas vide
        if (!empty($_POST['newPhoneNumber'])) {
//Si la valeur rentrée est conforme avec la régex
            if (preg_match($regPhone, $_POST['newPhoneNumber'])) {
//...Enfin, on stocke la valeur en variable et on applique la méthode changeNumberPhone
                $newPhoneNumber = htmlspecialchars($_POST['newPhoneNumber']);
//...On instancie l'objet user, avec une methode permettant le changement du numéro de téléphone
                $phoneNumber = NEW users();
//...On donne la valeur de la variable pour la stocker dans l'attribut de l'objet "phoneNumber"
                $phoneNumber->phoneNumber = $newPhoneNumber;
//...On donne la valeur de la variable de session à l'attribut de l'objet "id"
                $phoneNumber->id = $_SESSION['id'];
//Si la requête aboutie
                if ($phoneNumber->changeNumberPhone()) {
//On envoi un message de réussite de validation
                    $success['newPhoneNumber'] = 'Numéro de téléphone changé avec succès !';
                } else {
//...Sinon erreur de requête
                    $errorList['newPhoneNumber'] = 'Le changement du numéro de téléphone a échoué';
                }
            } else {
//...Sinon erreur de validité
                $errorList['newPhoneNumber'] = 'Le numéro entré n\'est pas valide !';
            }
        } else {
//...Sinon erreur de rentrée de valeur
            $errorList['newPhoneNumber'] = 'Veuillez entrer un numéro de téléphone !';
        }
    }
//======================================================================Suppression du compte====================================================
//Condition si l'on appuie sur le boutton supprimer
    if (isset($_POST['removeUser'])) {
//On appel l'objet users
        $remove = NEW users();
//On donne à l'attribut id la variable de session
        $remove->id = $_SESSION['id'];
        if ($remove->removeUser()) {
//On vide les variables de session
            session_unset();
//...On détruit la session
            session_destroy();
//...Puis on redirige vers l'accueil
            header('location:../../index.php');
        }
    }
//Si on appuie sur annuler
    if (isset($_POST['cancelRemove'])) {
//On rafraichie la même page, rien ne se passe
        header('location:optionsPublic.php');
    }
//==============================================================Affichage des informations de compte===================================
//On instancie l'objet user permettant l'affichage des informations
    $stockAllContent = NEW users();
//On gère l'affichage des informations de l'utilisateur
    $stockAllContent->id = $_SESSION['id'];
//On appel la méthode pour afficher les valeurs
    $showAllContent = $stockAllContent->showCompleteUserContent();
}