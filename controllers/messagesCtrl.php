<?php

//Création de tableau d'erreur
$errorList = array();
$success = array();
//=========================================================================================ajax==================================================
if (isset($_POST['idToRead'])) {
    include'../config.php';
    //On instancie l'objet messagesReceived, avec pour méthode le changement de unreaden à readen (0 à 1) pour marquer le message comme lu
    $idToRead = htmlspecialchars(intval($_POST['idToRead']));
    $changeToReaden = NEW messagesReceived();
    $changeToReaden->readen = 1;
    $changeToReaden->id = $idToRead;
    $changeToReaden->messageReaden();
}
//Création de tableau d'erreur pour la gestion de paramètre url
//==================================================================Liste des id où l'utilisateur est le destinataire des messages==================================================
//On vérifie l'existance de la variable de session 'id'
if (isset($_GET['idReceived'])) {
    $id = htmlspecialchars(intval($_GET['idReceived']));
    $listIdMessagesReceived = NEW messagesReceived();
    $listIdMessagesReceived->idReceiver = intval($_SESSION['id']);
    $checkListReceived = $listIdMessagesReceived->listIdReceivedMessagesUrl();
    $errorReceivedUrl = array();
    $successReceivedUrl = array();
    foreach ($checkListReceived as $idReceived) {
        //Si l'url équivaut à l'un des id des groupes de musique créé par l'utilisateur
        if ($id == $idReceived->id) {
            //On affecte à $successUrl la valeur true
            $successReceivedUrl['url'] = true;
        } else {
            $errorReceivedUrl['url'] = false;
        }
    }
    if (count($successReceivedUrl) == 0) {
        header('location:error404.php');
    }
}
//==================================================================Liste des id où l'utilisateur est l'émetteur des messages==================================================
$listIdMessagesSent = NEW messagesTransmitted();
$listIdMessagesSent->idTransmitter = intval($_SESSION['id']);
$checkListSent = $listIdMessagesSent->listIdSentMessagesUrl();
//On vérifie l'existance de la variable de session 'id'
if (isset($_GET['idSent'])) {
    $id = htmlspecialchars(intval($_GET['idSent']));
    $errorSentUrl = array();
    $successSentUrl = array();
    foreach ($checkListSent as $idSent) {
        //Si l'url équivaut à l'un des id des groupes de musique créé par l'utilisateur
        if ($id == $idSent->id) {
            //On affecte à $successUrl la valeur true
            $successSentUrl['url'] = true;
        } else {
            $errorSentUrl['url'] = false;
        }
    }
    if (count($successSentUrl) == 0) {
        header('location:error404.php');
    }
}

//On vérifie que la variable de session existe
if (isset($_SESSION['id'])) {
//==================================================================Envoi d'un nouveau message==================================================
    if (isset($_POST['sendMessageSubmit'])) {
        /**
         * On vérifie le champs destinataire 
         */
        //On vérifie qu'il n'est pas vide
        if (!empty($_POST['receiver'])) {
            //On instancie l'objet users, avec pour méthode la vérification que le pseudo du destinataire existe
            $checkPseudo = NEW users();
            $checkPseudo->pseudo = htmlspecialchars($_POST['receiver']);
            $check = $checkPseudo->confirmPseudo();
            //La requête passe si le pseudo entré existe bel et bien dans la base de donnée
            if ($check != 0) {
                //On instancie l'objet user, pour récupérer l'id de l'utilisateur destinataire
                $getIdReceiver = NEW users();
                $getIdReceiver->pseudo = htmlspecialchars($_POST['receiver']);
                if ($getIdReceiver->getIdPseudo()) {
                    $idReceiver = $getIdReceiver->getIdPseudo();
                    $rightIdReceiver = $idReceiver->id;
                } else {
                    $errorList['receiver'] = 'Un erreur est survenu dans la recherche du destinataire !';
                }
            } else {
                $errorList['receiver'] = 'Le destinataire renseigné n\'existe pas !';
            }
        } else {
            $errorList['receiver'] = 'Vous n\'avez pas choisis de destinataire pour votre message !';
        }
        /**
         * On vérifie le champs title
         */
        if (!empty($_POST['titleOfNewMessage'])) {
            $title = htmlspecialchars($_POST['titleOfNewMessage']);
        } else {
            $errorList['titleOfNewMessage'] = 'Vous n\'avez pas donné de titre à votre message !';
        }
        /**
         * On vérifie le champs de message
         */
        if (!empty($_POST['newMessage'])) {
            $message = htmlspecialchars($_POST['newMessage']);
        } else {
            $errorList['newMessage'] = 'Veuillez écrire un message !';
        }
        /**
         * On vérifie que le formulaire ne contient aucune erreur
         */
        if (count($errorList) == 0) {
            //On instancie l'objet messagesTransmitted, avec pour méthode la copie du message pour stocker dans les messages envoyés
            $keepMessage = NEW messagesTransmitted();
            //On donne aux attributs de l'objet les valeurs stockées
            $keepMessage->title = $title;
            $keepMessage->idTransmitter = intval($_SESSION['id']);
            $keepMessage->dateHour = date('Y-m-d H:i:s');
            $keepMessage->content = $message;
            $keepMessage->readen = 0;
            $keepMessage->id_15968k4_users = intval($rightIdReceiver);
            //On test la requête
            if ($keepMessage->keepMessage() && count($errorList) == 0) {
                //On instancie l'objet messagesReceived, avec pour méthode l'envoi de message, qui apparaitra dans sa boite de réception
                $sendMessage = NEW messagesReceived();
                //On donne aux attributs de l'objet les valeurs stockées
                $sendMessage->title = $title;
                $sendMessage->idReceiver = intval($rightIdReceiver);
                $sendMessage->dateHour = date('Y-m-d H:i:s');
                $sendMessage->content = $message;
                $sendMessage->readen = 0;
                $sendMessage->id_15968k4_users = intval($_SESSION['id']);
                //On teste la requête
                if ($sendMessage->sendMessage() && count($errorList) == 0) {
                    //on instancie l'objet users, avec pour méthode la recherche du pseudo par id
                    $pseudoSearch = NEW users();
                    $pseudoSearch->id = intval($_SESSION['id']);
                    //On test la requete
                    if ($pseudoSearch->getPseudoId()) {
                        $success['sendMessageSubmit'] = 'Message envoyé avec succès !';
                    } else {
                        $errorList['sendMessageSubmit'] = 'Une erreur est surevenue dans l\'envoi du message !';
                    }
                } else {
                    $errorList['sendMessageSubmit'] = 'Une erreur est surevenue dans l\'envoi du message !';
                }
            } else {
                $errorList['sendMessageSubmit'] = 'Une erreur est surevenue dans la sauvegarde du message !';
            }
        } else {
            $errorList['sendMessageSubmit'] = 'Il y a au moins une erreur dans votre formulaire !';
        }
    }
//==================================================================Renvoi du message envoyé ==================================================
    if (isset($_POST['reSendMessageSubmit'])) {
        /**
         * Vérification du pseudo
         */
        if (isset($_POST['idUser'])) {
            $idUsers = htmlspecialchars($_POST['idUser']);
        } else {
            $errorList['idUser'] = 'Aucun id renseigné !';
        }
        /**
         * Vérification du titre
         */
        if (isset($_POST['title'])) {
            $title = htmlspecialchars($_POST['title']);
        } else {
            $errorList['title'] = 'Aucun titre renseigné !';
        }
        /**
         * Vérification du contenu du message
         */
        if (isset($_POST['content'])) {
            $content = htmlspecialchars($_POST['content']);
        } else {
            $errorList['pseudo'] = 'Aucun contenu renseigné !';
        }
        /**
         * Vérification du formulaire
         */
        if (count($errorList) == 0) {
            //On instancie l'objet messagesTransmitted, avec pour méthode la copie du message envoyé
            $rekeepMessage = NEW messagesTransmitted();
            $rekeepMessage->title = $title;
            $rekeepMessage->idTransmitter = intval($_SESSION['id']);
            $rekeepMessage->dateHour = date('Y-m-d H:i:s');
            $rekeepMessage->content = $content;
            $rekeepMessage->readen = 0;
            $rekeepMessage->id_15968k4_users = $idUsers;
            if ($rekeepMessage->keepMessage() && count($errorList) == 0) {
                //On instancie l'objet avec pour méthode l'envoi du message
                $reSentMessage = NEW messagesReceived();
                $reSentMessage->title = $title;
                $reSentMessage->idReceiver = $idUsers;
                $reSentMessage->dateHour = date('Y-m-d H:i:s');
                $reSentMessage->content = $content;
                $reSentMessage->readen = 0;
                $reSentMessage->id_15968k4_users = intval($_SESSION['id']);
                if ($reSentMessage->sendMessage() && count($errorList) == 0) {
                    $success['reSendMessageSubmit'] = 'Message renvoyé avec succès';
                } else {
                    $errorList['reSendMessageSubmit'] = 'Erreur dans l\'envoi du message !';
                }
            } else {
                $errorList['reSendMessageSubmit'] = 'Erreur dans la sauvegarde du message !';
            }
        } else {
            $errorList['reSendMessageSubmit'] = 'Il y a une erreur !';
        }
    }
//==================================================================Suppression d'un message ==================================================
//Condition si le message est un message envoyé
    if (isset($_POST['submitRemoveMessageSent'])) {
        if (isset($_POST['idToRemove'])) {
            //On instancie l'objet messagesTransmitted
            $removeSent = NEW messagesTransmitted();
            $removeSent->id = htmlspecialchars(intval($_POST['idToRemove']));
            if ($removeSent->removeMessage()) {
                $success['submitRemoveMessageSent'] = 'Message supprimé ave succès !';
            }
        }
    }
//Condition si le message est un message reçu
    if (isset($_POST['submitRemoveMessageReceived'])) {
        if (isset($_POST['idToRemove'])) {
            //On instancie l'objet messagesTransmitted
            $removeSent = NEW messagesReceived();
            $removeSent->id = htmlspecialchars(intval($_POST['idToRemove']));
            if ($removeSent->removeMessage()) {
                $success['submitRemoveMessageSent'] = 'Message supprimé avec succès !';
            }
        }
    }
//===============================================================================Suppression de plusieurs messages envoyés==================================================
    if (isset($_POST['DeleteSelectionSent'])) {
        if (!empty($_POST['removeMessage']) && isset($_POST['removeMessage'])) {
            $removeMessage = $_POST['removeMessage'];
            foreach ($removeMessage as $rm) {
                $removeSelectedMessages = NEW messagesTransmitted();
                $removeSelectedMessages->id = intval($rm);
                if ($removeSelectedMessages->removeMessage()) {
                    $removeNotif = NEW notifications();
                    $removeNotif->idMessages = intval($rm);
                    if ($removeNotif->removeNotifAfterRemoveMessage()) {
                        $success['DeleteSelectionSent'] = 'Sélection supprimée avec succès !';
                    } else {
                        $errorList['DeleteSelectionSent'] = 'Erreur dans la suppression de la notification !';
                    }
                } else {
                    $errorList['DeleteSelectionSent'] = 'Erreur dans la suppression des messages !';
                }
            }
        } else {
            $errorList['DeleteSelectionSent'] = 'Vous devez séléctionner au moins un message !';
        }
    }
//========================================================================Suppression de tout les message envoyés==================================================
    if (isset($_POST['deleteAllSent'])) {
        $removeSent = NEW messagesTransmitted();
        $removeSent->idTransmitter = intval($_SESSION['id']);
        if ($removeSent->deleteAllMessages()) {
            $removeNotif = NEW notifications();
            $removeNotif->id_15968k4_users = intval($_SESSION['id']);
            if ($removeNotif->removeAllNotifications()) {
                $success['DeleteSelectionSent'] = 'Sélection supprimée avec succès !';
            } else {
                $errorList['DeleteSelectionSent'] = 'Erreur dans la suppression des notifications !';
            }
        } else {
            $errorList['deleteAllSent'] = 'Erreur dans la suppression des messages !';
        }
    }
//===============================================================================Suppression de plusieurs messages reçus==================================================
    if (isset($_POST['deleteSelectionReceived'])) {
        if (!empty($_POST['removeMessageReceived']) && isset($_POST['removeMessageReceived'])) {
            $removeMessage = $_POST['removeMessageReceived'];
            foreach ($removeMessage as $rm) {
                $removeSelectedMessages = NEW messagesReceived();
                $removeSelectedMessages->id = intval($rm);
                if ($removeSelectedMessages->removeMessage()) {
                    $removeNotif = NEW notifications();
                    $removeNotif->idMessages = intval($rm);
                    if ($removeNotif->removeNotifAfterRemoveMessage()) {
                        $success['DeleteSelectionSent'] = 'Sélection supprimée avec succès !';
                    } else {
                        $errorList['DeleteSelectionSent'] = 'Erreur dans la suppression de la notification !';
                    }
                } else {
                    $errorList['deleteSelectionReceived'] = 'Erreur dans la suppression des messages !';
                }
            }
        } else {
            $errorList['deleteSelectionReceived'] = 'Vous devez séléctionner au moins un message !';
        }
    }
//========================================================================Suppression de tout les message reçus==================================================
    if (isset($_POST['deleteAllReceived'])) {
        $removeSent = NEW messagesReceived();
        $removeSent->idReceiver = intval($_SESSION['id']);
        if ($removeSent->deleteAllMessages()) {
            $removeNotif = NEW notifications();
            $removeNotif->id_15968k4_users = intval($_SESSION['id']);
            if ($removeNotif->removeAllNotifications()) {
                $success['DeleteSelectionSent'] = 'Sélection supprimée avec succès !';
            } else {
                $errorList['DeleteSelectionSent'] = 'Erreur dans la suppression des notifications !';
            }
        } else {
            $errorList['deleteAllReceived'] = 'Erreur dans la suppression des messages !';
        }
    }
//==================================================================Compte du nombre de messages dont l'utilisateur est l'émetteur ==================================================
    $countMessagesSent = NEW messagesTransmitted();
    $countMessagesSent->idTransmitter = intval($_SESSION['id']);
    $countSent = $countMessagesSent->countSentMessages();
//==================================================================Affichage des messages dont l'utilisateur est l'émmeteur ==================================================
    $showMessageSent = NEW messagesTransmitted();
    $showMessageSent->idTransmitter = intval($_SESSION['id']);
    $messagesSent = $showMessageSent->showMessagesSent();
//================================================================Compte du nombre de message dont l'utilisateur est le destinataire==================================================
    $countOfMessages = NEW messagesReceived();
    $countOfMessages->idReceiver = intval($_SESSION['id']);
    $numberOfMessages = $countOfMessages->countMessagesReceived();
//================================================================Compte du nombre de message non lus dont l'utilisateur est le destinataire==================================================
    $countOfUnreadenMessages = NEW messagesReceived();
    $countOfUnreadenMessages->idReceiver = intval($_SESSION['id']);
    $numberOfUnreadenMessages = $countOfUnreadenMessages->countUnreadenMessagesReceived();
//==================================================================Affichage des messages dont l'utilisateur est le destinataire==================================================
    $showMyMessages = NEW messagesReceived();
    $showMyMessages->idReceiver = intval($_SESSION['id']);
    $myMessages = $showMyMessages->messageReceived();
//=====================================================================Affichage du message selon l'id de l'url==================================================
    if (isset($_GET['idReceived']) && $numberOfMessages != 0) {
        $showMessageSelected = NEW messagesReceived();
        $showMessageSelected->id = intval($_GET['idReceived']);
        $messageUrl = $showMessageSelected->showMessageSelected();
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        $dateUrl = strftime('%A %d %B %Y', strtotime($messageUrl->date));
    }
    if (isset($_GET['idSent']) && $messagesSent != 0) {
        $showMessageSelected = NEW messagesTransmitted();
        $showMessageSelected->id = intval($_GET['idSent']);
        $messageUrl = $showMessageSelected->showMessageSelected();
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        $dateUrl = strftime('%A %d %B %Y', strtotime($messageUrl->date));
    }
}