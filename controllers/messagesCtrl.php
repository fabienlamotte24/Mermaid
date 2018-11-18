<?php

if (isset($_SESSION['id'])) {
//==================================================================Affichage des messages dont l'utilisateur est le destinataire==================================================
    $showMyMessages = NEW messages();
    $showMyMessages->idReceiver = intval($_SESSION['id']);
    $myMessages = $showMyMessages->messageReceived();
//================================================================Compte du nombre de message dont l'utilisateur est le destinataire==================================================
    $countOfMessages = NEW messages();
    $countOfMessages->idReceiver = intval($_SESSION['id']);
    $numberOfMessages = $countOfMessages->countMessages();
//==============================================================================Compte du nombre de notification==================================================
//instanciation de l'object notifications, avec pour méthode le compte du nombre de notifications
    $notif = NEW notifications();
    $notif->id_15968k4_users = $_SESSION['id'];
    $checkNotif = $notif->countNotification();
}