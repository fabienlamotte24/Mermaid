<?php

$regInstrument = '/^[0-9]+$/';
//appel ajax pour la suppression de photo de la galery de l'utilisateur
if (isset($_POST['photoGalery'])) {
    include_once'../config.php';
    $photoToRemove = intval(htmlspecialchars($_POST['photoGalery']));
    $remove = NEW userPhotos();
    $remove->id = $photoToRemove;
    $remove->removePhoto();
}
//======================================================================Ajout d'une photo de profil===================================================================
$name = '';
if (isset($_POST['submitFile'])) {
    //On test si le fichier est bel et bien un fichier
    if (!empty($_FILES['newFile']) && $_FILES['newFile']['error'] == 0) {
        //On test sa taille maximal
        if ($_FILES['newFile']['size'] <= 5000000) {
            $enabled_extensions = array('jpg', 'jpeg', 'png');
            $informationsFile = pathinfo($_FILES['newFile']['name']);
            $extension_upload = $informationsFile['extension'];
            //On teste son extension
            if (in_array($extension_upload, $enabled_extensions)) {
                $name = $_FILES['newFile']['name'];
                $link = '../../assets/img/userPictures/' . $name;
                //On vérifie qu'il a bien été téléchargé
                if (move_uploaded_file($_FILES['newFile']['tmp_name'], $link)) {
                    $pictures = NEW userPhotos();
                    $pictures->userPhotos = $name;
                    $pictures->id_15968k4_users = intval($_SESSION['id']);
                    if ($pictures->addPhotos()) {
                        header('locate:profile.php');
                    } else {
                        $errorList['submitFile'] = 'Erreur dans l\'ajout de la photo !';
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
//================================================================Condition pour vérifier s'il a déjà choisi un instrument=====================================================
$ifInstrumentChosen = NEW instrument();
$ifInstrumentChosen->id_15968k4_users = $_SESSION['id'];
$choice = $ifInstrumentChosen->isPlayInstrument();
//Condition d'appuie sur le boutton de validation
if (isset($_POST['submitInstrumentChoice'])) {
    //Si le champs est vide
    if (!empty($_POST['instrument'])) {
        $instrument = htmlspecialchars($_POST['instrument']);
        //On test la validité
        if (preg_match($regInstrument, $instrument)) {
            //On instancie l'objet instrument, avec pour méthode la vérification d'un instrument enregistré pour l'utilisateur
            $ifInstrumentChosen = NEW instrument();
            $ifInstrumentChosen->id_15968k4_users = intval($_SESSION['id']);
            $choice = $ifInstrumentChosen->isPlayInstrument();
            if ($choice == 0) {
                //On instancie l'objet instrument, avec pour méthode l'ajout d'un instrument
                $addInstrument = NEW instrument();
                $addInstrument->id_15968k4_users = intval($_SESSION['id']);
                $addInstrument->id_15968k4_typeInstrument = intval($instrument);
                if ($addInstrument->addInstrumentPlayer()) {
                    header('location:profile.php');
                } else {
                    $errorList['instrument'] = 'L\'enregistrement de l\'instrument a échoué !';
                }
            } else {
                $errorList['instrument'] = 'Vous devez choisir un instrument !';
            }
        } else {
            $errorList['instrument'] = 'Erreur dans le choix de l\'instrument !';
        }
    } else {
        $errorList['instrument'] = 'Vous devez sélectionner un instrument !';
    }
}
//==========================================================================Condition de changement d'instrument====================================
if (isset($_POST['submitChangeInstrumentChoice'])) {
    //Si le champs est vide
    if (!empty($_POST['newInstrument'])) {
        $instrument = htmlspecialchars($_POST['newInstrument']);
        //On test la validité
        if (preg_match($regInstrument, $instrument)) {
            //On instancie l'objet instrument, avec pour méthode l'ajout d'un instrument
            $changeInstrument = NEW instrument();
            $changeInstrument->id_15968k4_users = intval($_SESSION['id']);
            $changeInstrument->id_15968k4_typeInstrument = intval($instrument);
            if ($changeInstrument->changeInstrument()) {
                $success['instrument'] = 'Votre rôle a bien été changé';
            } else {
                $errorList['newInstrument'] = 'L\'enregistrement de l\'instrument a échoué !';
            }
        } else {
            $errorList['newInstrument'] = 'Erreur dans le choix de l\'instrument !';
        }
    } else {
        $errorList['newInstrument'] = 'Vous devez sélectionner un instrument !';
    }
}
//=================================================================Condition d'ajout d'annonce pour le musicien============================================
//Condition d'ajout d'annonce
if (isset($_POST['addResearch'])) {
    //On vérifie le champs d'annonce
    if (!empty($_POST['announce'])) {
        //On instancie l'objet instrument, avec pour méthode la vérification d'un choix de rôle
        $isRoleChosen = NEW instrument();
        $isRoleChosen->id_15968k4_users = intval($_SESSION['id']);
        //On applique la requête à la méthode associée
        $checkRole = $isRoleChosen->isPlayInstrument();
        //Si le musicien n'a pas choisi de rôle
        if ($checkRole != 0) {
            //On instancie l'objet musicianInResearch, avec pour méthode la vérification d'une annonce déjà existante (possiblement périmée
            $status = NEW musicianInResearch();
            $status->id_15968k4_users = intval($_SESSION['id']);
            $musicianStatus = $status->status();
            //Si le musicien n'a pas encore d'annonce
            if ($musicianStatus == 0) {
                //On initialise la variable $date
                $date = "";
                $announce = htmlspecialchars($_POST['announce']);
                //On instancie le même objet, avec pour méthode l'ajout de l'annonce pour le musicien
                $addAnnounce = NEW musicianInResearch();
                //On donne aux attributs de l'objet les valeurs souhaitée
                $addAnnounce->research = $announce;
                $addAnnounce->id_15968k4_users = intval($_SESSION['id']);
                $addAnnounce->dateCreation = date('Y-m-d H:i:s');
                $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
                //Si la requête fonctionne
                if ($addAnnounce->addResearch()) {
                    //On affiche un message de réussite
                    $success['announce'] = 'Annonce créée avec succès';
                } else {
                    $errorList['announce'] = 'Erreur dans l\'enregistrement de l\'annonce';
                }
            } else {
                //On instancie l'objet musicianInResearch, avec pour méthode la suppression de l'annonce périmée
                $removeAnnounce = NEW musicianInResearch();
                $removeAnnounce->id_15968k4_users = intval($_SESSION['id']);
                //On applique la requête à la méthode associée
                if ($removeAnnounce->removeResearch()) {
                    //On initialise la variable $date
                    $date = "";
                    $announce = htmlspecialchars($_POST['announce']);
                    //On instancie le même objet, avec pour méthode l'ajout de l'annonce pour le musicien
                    $addAnnounce = NEW musicianInResearch();
                    //On donne aux attributs de l'objet les valeurs souhaitée
                    $addAnnounce->research = $announce;
                    $addAnnounce->id_15968k4_users = intval($_SESSION['id']);
                    $addAnnounce->dateCreation = date('Y-m-d H:i:s');
                    $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
                    //Si la requête fonctionne
                    if ($addAnnounce->addResearch()) {
                        //On affiche un message de réussite
                        $success['announce'] = 'Annonce créée avec succès';
                    }
                } else {
                    $errorList['announce'] = 'Erreur dans l\'enregistrement de l\'annonce';
                }
            }
        } else {
            $errorList['announce'] = 'Veuillez d\'abord choisir votre rôle !';
        }
    } else {
        $errorList['announce'] = 'Votre champs est vide';
    }
}
//Condition de changement de l'annonce
if (isset($_POST['changeResearch'])) {
    //Sila valeur rentrée n'est pas vide
    if (!empty($_POST['announceChanged'])) {
        $date = "";
        $announce = htmlspecialchars($_POST['announceChanged']);
        //On instancie l'objet musicianInResearch, avec pour méthode le changement de l'annonce
        $addAnnounce = NEW musicianInResearch();
        $addAnnounce->research = $announce;
        $addAnnounce->id_15968k4_users = intval($_SESSION['id']);
        $addAnnounce->dateCreation = date('Y-m-d H:i:s');
        $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
        //Si la requête passe
        if ($addAnnounce->changeAnnounce()) {
            $success['announce'] = 'Annonce changée avec succès';
        } else {
            $errorList['announce'] = 'Un erreur s\'est produite';
        }
    } else {
        $errorList['announce'] = 'Votre champs est vide';
    }
}
//Condition d'annulation de changement
if (isset($_POST['cancel'])) {
    header('location:profile.php');
}
//Condition de suppression de l'annonce pour les musiciens
if (isset($_POST['remove'])) {
    $removeResearch = NEW musicianInResearch();
    $removeResearch->id_15968k4_users = intval($_SESSION['id']);
    if ($removeResearch->removeResearch()) {
        $success['announce'] = 'Annonce bien supprimée';
    } else {
        $errorList['announce'] = 'La suppression a échouée';
    }
}
//==================================================Condition d'ajout d'annonce pour un établissement=================================================
//A la validation
if (isset($_POST['addCompanyResearch'])) {
    if (!empty($_POST['announceCompany'])) {
        //On stocke les valeurs nécessaire aux requêtes dans des variables
        $announce = htmlspecialchars($_POST['announceCompany']);
        $id = htmlspecialchars($_POST['companyId']);
        //On instancie l'objet establishmentInResearch, avec pour méthode le compte d'annonce pour voir s'il n'y en a pas déjà une
        $establishmentStatus = NEW establishmentInResearch();
        $establishmentStatus->id_15968k4_establishment = intval($id);
        $check = $establishmentStatus->establishmentStatus();
        //Si l'établissement n'a pas encore d'annonce
        if ($check == 0) {
            $addEstablishmentAnnounce = NEW establishmentInResearch();
            $addEstablishmentAnnounce->id_15968k4_establishment = intval($id);
            $addEstablishmentAnnounce->research = $announce;
            $addEstablishmentAnnounce->dateCreation = date('Y-m-d H:i:s');
            $addEstablishmentAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
            if ($addEstablishmentAnnounce->addResearch()) {
                $success['addCompanyResearch'] = 'Annonce bien créée';
            } else {
                $errorList['addCompanyResearch'] = 'Erreur dans l\'enregistrement de votre annonce';
            }
        } else {
            //On instancie l'objet establishmentInResearch, avec pour méthode la suppression de l'annonce déjà créé (elle est donc périmée)
            $removeAnnounce = NEW establishmentInResearch();
            $removeAnnounce->id_15968k4_establishment = intval($id);
            //Si la suppression fonctionne
            if ($removeAnnounce->removeResearch()) {
                //On instancie l'objet establishmentInResearch, avec pour méthode l'ajout de l'annonce
                $addEstablishmentAnnounce = NEW establishmentInResearch();
                $addEstablishmentAnnounce->id_15968k4_establishment = intval($id);
                $addEstablishmentAnnounce->research = $announce;
                $addEstablishmentAnnounce->dateCreation = date('Y-m-d H:i:s');
                $addEstablishmentAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
                if ($addEstablishmentAnnounce->addResearch()) {
                    $success['addCompanyResearch'] = 'Annonce bien créée';
                } else {
                    $errorList['addCompanyResearch'] = 'Erreur dans l\'enregistrement de votre annonce';
                }
            } else {
                $errorList['addCompanyResearch'] = 'Erreur dans la suppression de l\'anonce';
            }
        }
    } else {
        $errorList['addCompanyResearch'] = 'Veuillez remplir votre annonce';
    }
}
//Condition de suppression de l'annonce pour les établissements
if (isset($_POST['removeCompanyResearch'])) {
    $id = htmlspecialchars($_POST['companyId']);
    $removeResearch = NEW establishmentInResearch();
    $removeResearch->id_15968k4_establishment = intval($id);
    if ($removeResearch->removeResearch()) {
        $success['announce'] = 'Annonce supprimée avec succès';
    } else {
        $errorList['announce'] = 'La suppression a échouée';
    }
}
//======================================================================Création d'annonce pour les groupes de musique================================
//Au boutton de validation
if (isset($_POST['addBandResearch'])) {
    //Je vérifie que le champs n'est pas vide
    if (!empty($_POST['announceBand'])) {
        //Je stocke la valeur rentrée dans une variable protégée
        $announceBand = htmlspecialchars($_POST['announceBand']);
        $idBand = htmlspecialchars($_POST['bandId']);
        //On instancie l'objet bandInResearch, avec pour méthode la vérification de l'existence d'une annonce pour le groupe de musique
        $countAnnounce = NEW bandInResearch;
        $countAnnounce->id_15968k4_band = $idBand;
        $checkAnounce = $countAnnounce->countAnnounce();
        //Si le groupe de musique n'a pas d'annonce déjà créée
        if ($checkAnounce == 0) {
            //On instancie le même objet, avec pour méthode la création de l'annonce
            $addAnnounce = NEW bandInResearch();
            //On donne aux attribut de l'objet les valeurs des variables protégées
            $addAnnounce->research = $announceBand;
            $addAnnounce->id_15968k4_band = $idBand;
            $addAnnounce->dateCreation = date('Y-m-d H:i:s');
            $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
            //Si la requête s'effectue bien
            if ($addAnnounce->addResearch()) {
                $success['addBandResearch'] = 'Création de l\'annonce réussie !';
            } else {
                $errorList['addBandResearch'] = 'Erreur dans la création de l\annonce !';
            }
        } else {
            //On instancie le même objet, avec pour méthode la suppression de l'annonce périmée
            $removeBandAnnounce = NEW bandInResearch();
            //On donne a l'attribut de l'objet la valeur de la variable protégée
            $removeBandAnnounce->id_15968k4_band = $idBand;
            //Si la suppression fonctionne
            if ($removeBandAnnounce->removeResearch()) {
                //On instancie le même objet, avec pour méthode la création de l'annonce
                $addAnnounce = NEW bandInResearch();
                //On donne aux attribut de l'objet les valeurs des variables protégées
                $addAnnounce->research = $announceBand;
                $addAnnounce->id_15968k4_band = $idBand;
                $addAnnounce->dateCreation = date('Y-m-d H:i:s');
                $addAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
                //Si la requête s'effectue bien
                if ($addAnnounce->addResearch()) {
                    $success['addBandResearch'] = 'Création de l\'annonce réussie !';
                } else {
                    $errorList['announceBand'] = 'Erreur dans l\'ajout de l\'annonce !';
                }
            } else {
                $errorList['announceBand'] = 'Erreur dans la suppression de l\'annonce !';
            }
        }
    } else {
        $errorList['announceBand'] = 'Veuillez entrer une annonce';
    }
}
//Suppression de l'annonce
if (isset($_POST['removeBandResearch'])) {
    $idBand = htmlspecialchars($_POST['bandId']);
    //On instancie le même objet, avec pour méthode la suppression de l'annonce périmée
    $removeBandAnnounce = NEW bandInResearch();
    //On donne a l'attribut de l'objet la valeur de la variable protégée
    $removeBandAnnounce->id_15968k4_band = $idBand;
    //Si la suppression fonctionne
    if ($removeBandAnnounce->removeResearch()) {
        $success['removeBandResearch'] = 'Suppression de l\'annonce';
    } else {
        $errorList['removeBandResearch'] = 'La suppression de l\'annonce a échouée';
    }
}
//Changement de l'annonce 
if (isset($_POST['changeBandResearch'])) {
    //On stocke les valeurs dans des variables protégées
    $announceToChange = htmlspecialchars($_POST['announceBandChanged']);
    $idBand = htmlspecialchars($_POST['bandId']);
    //On instancie l'objet bandInaResearch, avec pour méthode le changement de l'annonce
    $changeAnnounce = NEW bandInResearch();
    //On donne aux attributs de l'objet les valeurs des variables protégées
    $changeAnnounce->research = $announceToChange;
    $changeAnnounce->dateCreation = date('Y-m-d H:i:s');
    $changeAnnounce->dateExpiration = date('Y-m-d H:i:s', strtotime('+1 week'));
    $changeAnnounce->id_15968k4_band = $idBand;
    //On test lea requête de changement d'annonce
    if ($changeAnnounce->changeAnnounce()) {
        //Si elle passe, message de réussite
        $success['changeBandResearch'] = 'Annonce changée avec succès';
    } else {
        //Sinon, message d'erreur
        $errorList['changeBandResearch'] = 'Le changement de l\'annonce a échouée';
    }
}
//============================================================================Compte d'établissement=====================================================
$isGetCompany = NEW establishment();
$isGetCompany->id_15968k4_users = intval($_SESSION['id']);
$company = $isGetCompany->isGetCompany();
//============================================================================Compte de contrat======================================================
$contract = NEW contract();
$contract->id = $_SESSION['id'];
$countContract = $contract->contractCount();
//============================================================================Compte du nombre de photos=================================================
$countPhotos = NEW userPhotos();
$countPhotos->id_15968k4_users = intval($_SESSION['id']);
$numberOfPhotos = $countPhotos->countPhotos();
//==============================================================================Affichage des photos==================================================
$showGalery = NEW userPhotos();
$showGalery->id_15968k4_users = intval($_SESSION['id']);
$displayPhotos = $showGalery->showPhotos();
//==============================================================================Affichage des établissements==================================================
$establishment = NEW establishment();
$establishment->id_15968k4_users = intval($_SESSION['id']);
$showEstablishments = $establishment->showMyCompany();
//================================================================Condition pour Afficher son role=====================================================
$showIsRole = NEW instrument();
$showIsRole->id_15968k4_users = intval($_SESSION['id']);
$role = $showIsRole->showHisRole();
//================================================================Condition pour Afficher le status de recherche du musicien====================================================
$status = NEW musicianInResearch();
$status->id_15968k4_users = intval($_SESSION['id']);
$musicianStatus = $status->status();
//================================================================Affichage de la date d'expiration de la recherche====================================================
$expirationResearch = NEW musicianInResearch();
$expirationResearch->id_15968k4_users = intval($_SESSION['id']);
$dateExpiration = $expirationResearch->expiration();
//================================================================Affichage des informations de la recherche pour le musicien====================================================
$researchContent = NEW musicianInResearch();
$researchContent->id_15968k4_users = intval($_SESSION['id']);
$showResearch = $researchContent->content();
//================================================================Affichage des groupes de musique de l'utilisateur====================================================
$displayMyBands = NEW band();
$displayMyBands->idCreator = intval($_SESSION['id']);
$allMyBands = $displayMyBands->showGroupCreated();
//================================================================Compte du nombre d'annonce par groupe de musique====================================================
$countAnnounce = NEW bandInResearch();
$countAnnounce->id_15968k4_band = 1;
$checkBandAnnounce = $countAnnounce->countAnnounce();
//================================================================Compte du nombre de groupe de musique====================================================
$haveBand = NEW band();
$haveBand->idCreator = intval($_SESSION['id']);
$checkBand = $haveBand->haveGroup();
//============================================================================Affichage des instruments=====================================================
$instrument = NEW typeInstrument();
$showInstrument = $instrument->showListOfInstruments();