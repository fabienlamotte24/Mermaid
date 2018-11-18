<?php

if (isset($_SESSION['id'])) {
//==================================================================Affichage des messages dont l'utilisateur est le destinataire==================================================
    $showMyMessages = NEW messages();
    $showMyMessages->id_15968k4_users = intval($_SESSION['id']);
    $myMessages = $showMyMessages->messageReceived();
//=====================================================================Affichage du message selon l'idMessage de l'url==================================================
    $showMessageSelected = NEW messages();
    $showMessageSelected->id = intval($_GET['id']);
    $message = $showMessageSelected->showMessageSelected();
//================================================================Compte du nombre de message dont l'utilisateur est le destinataire==================================================
    $countOfMessages = NEW messages();
    $countOfMessages->id_15968k4_users = intval($_SESSION['id']);
    $numberOfMessages = $countOfMessages->countMessages();
//==============================================================================Compte du nombre de notification==================================================
//instanciation de l'object notifications, avec pour méthode le compte du nombre de notifications
    $notif = NEW notifications();
    $notif->id_15968k4_users = $_SESSION['id'];
    $checkNotif = $notif->countNotification();
}