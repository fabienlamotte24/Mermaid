<?php


//==============================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
