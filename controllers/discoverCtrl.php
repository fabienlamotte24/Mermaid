<?php
$errorList = array();
$success = array();
//==============================================================================Compte du nombre de notification==================================================
$notif = NEW notifications();
$notif->id_15968k4_users = intval($_SESSION['id']);
$checkNotif = $notif->countNotification();
//============================================================================== Gestion de la recherche ==================================================
$musician = '';
$company = '';
$band = '';
if(isset($_POST['submitResearch'])){
    if(isset($_POST['userResearch']) && $_POST['userResearch'] == 'Musicien'){
        $musician = NEW users();
        $showAllMusicians = $musician->showAllMusicians();
    } else if(isset($_POST['userResearch']) && $_POST['userResearch'] == 'Band'){
        $band = NEW band();
        $showAllBands = $band->showAllBand();
    } else if(isset($_POST['userResearch']) && $_POST['userResearch'] == 'Professionnel'){
        $company = NEW establishment();
        $showAllCompany = $company->showAllCompany();
    } else {
        $errorList['userResearch'] = 'La recherche n\'a renvoyé aucun résultat';
    }
}