<?php
//==========================================================================Ajax==========================================================================
if(isset($_POST['notifToRemove'])){
    include'../config.php';
}
//==========================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
//==========================================================================Affichage des notifications==================================================
$showNotif = NEw notifications();
$showNotif->id_15968k4_users = intval($_SESSION['id']);
$myNotifs = $showNotif->showNotif();
//==========================================================================Suppression des notifications==================================================
