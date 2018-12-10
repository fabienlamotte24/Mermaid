<?php

//==========================================================================Ajax==========================================================================
if (isset($_POST['notifToRemove'])) {
    $messageToUpdate = htmlspecialchars($_POST['messageToUpdate']);
    $notifToRemove = htmlspecialchars($_POST['notifToRemove']);
    include'../config.php';
    $messageReaden = NEW messagesReceived();
    $messageReaden->readen = 1;
    $messageReaden->id = intval($messageToUpdate);
    if ($messageReaden->messageReaden()) {
        $removeNotif = NEW notifications();
        $removeNotif->id = intval($notifToRemove);
        $removeNotif->removeNotif();
    }
}
//==========================================================Récupération des informations de messages non lus==================================================
$unreadenMessages = NEW messagesReceived();
$unreadenMessages->idReceiver = intval($_SESSION['id']);
$getInfoUnreadenMessages = $unreadenMessages->showUnreadenMessageReceived();
//==========================================================Ajout de notification des messages non lus==================================================
foreach ($getInfoUnreadenMessages as $unreaden) {
    //On instancie l'objet notification, pour savoir si l'id du message est déjà présent parmis les notifications
    $countIdMessagesFromNotifications = NEW notifications();
    $countIdMessagesFromNotifications->idMessages = intval($unreaden->id);
    $countIdMessages = $countIdMessagesFromNotifications->notifAlreadySent();
    //Si ce n'est pas le cas
    if ($countIdMessages == 0) {
        //on instancie l'objet notification, avec pour méthode l'ajout de la notification
        $addNotification = NEW notifications();
        $addNotification->notifDescription = '<a href="messages.php?idReceived=' . $unreaden->id . '" id="linkNotif">'
                . 'Nouveau message de ' . $unreaden->pseudo . ' '
                . 'le ' . $unreaden->date . ' à ' . $unreaden->hour . '</a>';
        $addNotification->id_15968k4_users = intval($_SESSION['id']);
        $addNotification->idMessages = intval($unreaden->id);
        $addNotification->addNotification();
    }
}
//==========================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
//==========================================================================Affichage des notifications==================================================
$showNotif = NEw notifications();
$showNotif->id_15968k4_users = intval($_SESSION['id']);
$myNotifs = $showNotif->showNotif();