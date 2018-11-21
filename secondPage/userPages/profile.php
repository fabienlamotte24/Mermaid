<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include'../../controllers/navCtrl.php';
include_once'../../controllers/profileCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">      
        <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">        
        <link rel="stylesheet" href="../../assets/css/profile.css" />
        <link rel="stylesheet" href="../../assets/css/navOnline.css" />
        <title>Mermaid</title>
    </head>
    <?php if ($_SESSION['idType'] == 1) { ?>
        <body id="publicBackground">
        <?php } else if ($_SESSION['idType'] == 2) { ?>
        <body id="proBackground">
        <?php } else { ?>
        <body id="musicianBackground">
        <?php } ?>
        <!------------------------------------------------------------Profil pour entreprise----------------------------------------------------->
        <?php if (isset($_SESSION['idType']) && $_SESSION['idType'] == 2) { ?>
            <div class="container-fluid">
                <div class="row">
                    <?php include'../navOnline.php' ?>
                </div>
                <section>
                    <!--Ligne d'affichage de photo de l'utilisateur-->
                    <div class="row photoBlock">
                        <div class="col-12">
                            <div class="col-12 mt-3 mb-2 carousel slide owl-carousel owl-theme" id="carousel" data-ride="carousel">
                                <!--Première slide du carousel permettant l'affichage de la fenêtre modale
                                elle sert à l'ajout de photo-->
                                <div class="text-center mt-1">
                                    <a href="profile.php" title="Ajouter des photos" id="addPhoto" class="text-center" data-target="#myModal" data-toggle="modal">
                                        <i class="fas fa-plus-circle fa-3x"></i>
                                        <p>Ajoutez une photo</p>
                                    </a>
                                </div>
                                <?php foreach ($displayPhotos as $photos) { ?>
                                    <div class="text-center">
                                        <a href="../../assets/img/userPictures/<?= $photos->userPhotos ?>" id="photo">
                                            <img src="../../assets/img/userPictures/<?= $photos->userPhotos ?>" id="photoGalery" class="item" width="50" height="70" idphoto="<?= $photos->id ?>" />                                               
                                        </a>
                                        <i class="remove far fa-times-circle fixed-top fa-1x"></i>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!--Fenêtre modale d'ajout de photo-->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h2>Ajoutez une photo dans votre galery</h2>
                                </div>
                                <div class="modal-body p-3">
                                    <form action="profile.php" id="formPhoto" method="POST" enctype="multipart/form-data" class="form-group col-12 text-center border p-3">
                                        <label for="newFile">Sélectionnez la photo à ajouter: </label>
                                        <p>Formats autorisés: JPG, JPEG, PNG</p>
                                        <div class="custom-file col-12 text-center p-0 m-0">
                                            <label for="newFile" class="custom-file-label">Votre photo</label>
                                            <input type="file" name="newFile" class="p-0 m-0 custom-file-input" /><br />
                                            <input type="submit" name="submitFile" class="btn btn-primary mt-1 mb-1" value="J'envoie mon image" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Affichage du message d'erreur ou de réussite de l'ajout de la photo-->
                    <?php if (isset($errorList['submitFile'])) { ?>
                        <p class="red"><?= $errorList['submitFile'] ?></p>
                        <?php
                    }
                    if (isset($success['submitFile'])) {
                        ?>
                        <p class="green"><?= $success['submitFile'] ?></p>
                    <?php } ?>
                    <!--Affichage des informations du compte-->
                    <div class="row">
                        <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 offset-md-1 offset-sm-1 col-xl-3 col-lg-3 col-lg-3 col-md-10 col-sm-10 col-xs-12 mt-3 h-100">
                            <a href="options.php" class="row linkOptions profilBlockContent p-3">
                                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2 text-center">
                                    <?php if ($_SESSION['profilPicture'] == ' ') { ?>
                                        <img src="../../assets/img/icoUser.png" class="rounded-circle icoUser border p-0 m-0" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                                    <?php } else { ?>
                                        <img src="../../assets/img/userPictures/avatars/<?= $_SESSION['profilPicture'] ?>" class="rounded-circle icoUser" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                                    <?php } ?>
                                </div>
                                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-4 text-center">
                                    <h1 class="profilePseudo"><?= $_SESSION['pseudo'] ?></h1>
                                </div>
                            </a>
                        </div>
                        <div class="profilBlock offset-md-1 offset-sm-1 col-xl-6 col-lg-6 col-md-10 col-sm-10 col-xs-12 mt-3 pb-2 h-100">
                            <div class="row profilBlockContent p-3 pb-3">
                                <div class="col-12 text-center mb-2">
                                    <h1>Vos contrats en cours</h1>
                                    <p>Cette fonctionnalité sera disponible dans la prochaine version de Mermaid !</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="establishmentBlock offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-3 col-lg-10 col-md-10 col-sm-10 col-xs-12 mt-4 p-2 h-100">
                            <div class="establishmentContent col-12 text-center border pt-5">
                                <a href="registerEstablishments.php" class="addCompanyLink">
                                    <i class="fas fa-beer fa-5x addCompany pt-3"></i>
                                    <?php if ($company == 0) { ?>
                                        <p class="mb-5">Ajoutez un établissement</p>
                                    <?php } else { ?>
                                        <p class="mb-5">Vous possédez d'autres établissement ?<br />
                                            Inscrivez les pour dynamiser vos soirées !</p>
                                    <?php } ?>
                                </a>
                            </div>
                        </div>
                        <div class="establishmentBlock offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-6 col-lg-10 col-md-10 col-sm-10 col-xs-12 mt-4 p-2 h-100">
                            <div class="establishmentContent h-100">
                                <p>D'autre fonctionnalités viendront remplir votre profil dans les nouvelles versions de Mermaid</p>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 blockEstablishement">
                        <?php foreach ($showEstablishments as $companies) { ?>
                            <div class="establishmentBlock col-xl-4 col-lg-4 col-md-4 col-xl-4 col-xl-4 mt-3 h-100" id="<?= $companies->id ?>">
                                <div class="establishmentContent col-12 text-center border p-0 pt-3 h-100">
                                    <div class="row mt-2">
                                        <div class="col-12 text-center">
                                            <a href="myCompanies.php?id=<?= $companies->id ?>" class="text-center row TitleEstablishment">
                                                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <img src="../../assets/img/proPictures/avatars/<?= $companies->companyPicture ?>" class="rounded-circle" width="70" height="70" title="Photo de mon entreprise" alt="Photo de mon entreprise" />                                            
                                                </div>
                                                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 text-center">
                                                    <h1><?= $companies->companyName ?></h1>
                                                    <p>Siret n°<?= $companies->siretNumber ?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <p>Adresse: <?= $companies->addressCompany ?> <?= $companies->city ?>(<?= $companies->postalCode ?>)<br />
                                                Contrat terminé: 0<br />
                                                Contrat en cours: 0</p>
                                        </div>
                                    </div>
                                    <?php
                                    //On instancie l'objet establishmentInResearch, avec pour méthode le compte d'annonce créées
                                    $inResearch = NEW establishmentInResearch();
                                    $inResearch->id_15968k4_establishment = $companies->id;
                                    $checkStatus = $inResearch->establishmentStatus();
                                    if ($checkStatus == 0) {
                                        ?>
                                        <a href="#" data-toggle="modal" class="researchOption" data-target="#company<?= $companies->id ?>">
                                            <div class="row backRed m-0 p-0">
                                                <div class="col-12 m-0 p-0">
                                                    <p class="sentenceStatus mt-3">Vous n'êtes pas en recherche</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="#" data-toggle="modal" class="researchOption" data-target="#company<?= $companies->id ?>change">
                                            <div class="row backGreen m-0 p-0">
                                                <div class="col-12 m-0 p-0">
                                                    <p class="sentenceStatus mt-3">Vous êtes en recherche</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                                <!--Fenêtre modale d'ajout d'annonce-->
                                <div class="modal fade" id="company<?= $companies->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h1>Annonce de votre établissement: <?= $companies->companyName ?></h1>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h2>Votre annonce</h2>
                                                <p class="text-center"><span class="red">*</span>Vous ne pouvez publier qu'une annonce à la fois<br />
                                                    N'hésitez pas changer votre annonce ou votre rôle selon vos envies !<br />
                                                    (Une annonce dure exactement 1 semaine)</p>
                                                <!--Formulaire d'annonce-->
                                                <form action="#" method="POST" class="form-group text-center">
                                                    <!--Champs textarea-->
                                                    <input type="hidden" name="companyId" value="<?= $companies->id ?>" id="<?= $companies->id ?>" />
                                                    <textarea name="announceCompany" id="announceCompany" class="form-control">Bonjour, ...</textarea>
                                                    <!--Bouttons de validation ou d'annulation-->
                                                    <button type="submit"  name="addCompanyResearch" value="<?= $companies->id ?>" class="btn btn-primary btn-lg">Publier mon annonce</button>
                                                    <button type="submit"  name="cancelRemove" class="btn btn-danger btn-lg">Annuler</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fenêtre modale de changement d'annonce-->
                                <div class="modal fade" id="company<?= $companies->id ?>change" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h1 class="text-center">Annonce de votre établissement: <?= $companies->companyName ?></h1>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h2 class="text-center">Voulez vous poster une annonce de recherche ?</h2>
                                                <p><span class="red">*</span> Le temps d'expiration sera reporté à 1 semaine dès que votre annonce sera changée !</p>
                                                <!--Formulaire d'annonce-->
                                                <form action="#" method="POST" class="form-group">
                                                    <!--Champs textarea-->
                                                    <label for="announceChanged">Mon annonce: </label>
                                                    <input type="hidden" name="companyId" value="<?= $companies->id ?>" id="<?= $companies->id ?>" />
                                                    <textarea name="announceChanged" id="announceChanged" class="form-control"><?= $companies->research ?></textarea>
                                                    <!--Bouttons de validation ou d'annulation-->
                                                    <button type="submit"  name="changeCompanyResearch" class="btn btn-primary btn-lg">Changer mon annonce</button>
                                                    <button type="submit"  name="removeCompanyResearch" class="btn btn-danger btn-lg">Supprimer l'annonce</button>
                                                    <button type="submit"  name="cancel" class="btn btn-secondary btn-lg">Annuler</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
            </div>
        </div>
    </div>
    </div>
    </section>
    </div>
    <!--------------------------------------------------------------------------Profil pour Musicien----------------------------------------------------->
<?php } else if (isset($_SESSION['idType']) && $_SESSION['idType'] == 3) { ?>
    <div class="container-fluid">
        <div class="row">
            <?php include'../navOnline.php' ?>
        </div>
        <section>
            <!--Ligne d'affichage de photo de l'utilisateur-->
            <div class="row photoBlock">
                <div class="col-12">
                    <div class="col-12 mt-3 mb-2 carousel slide owl-carousel owl-theme" id="carousel" data-ride="carousel">
                        <!--Première slide du carousel permettant l'affichage de la fenêtre modale
                        elle sert à l'ajout de photo-->
                        <div class="text-center mt-1">
                            <a href="profile.php" title="Ajouter des photos" id="addPhoto" class="text-center" data-target="#myModal" data-toggle="modal">
                                <i class="fas fa-plus-circle fa-3x"></i>
                                <p>Ajoutez une photo</p>
                            </a>
                        </div>
                        <?php foreach ($displayPhotos as $photos) { ?>
                            <div class="text-center">
                                <a href="../../assets/img/userPictures/<?= $photos->userPhotos ?>" id="photo">
                                    <img src="../../assets/img/userPictures/<?= $photos->userPhotos ?>" id="photoGalery" class="item" width="50" height="70" idphoto="<?= $photos->id ?>" />                                               
                                </a>
                                <i class="remove far fa-times-circle fixed-top fa-1x"></i>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!--Fenêtre modale d'ajout de photo-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2>Ajoutez une photo dans votre galery</h2>
                        </div>
                        <div class="modal-body p-3">
                            <form action="profile.php" id="formPhoto" method="POST" enctype="multipart/form-data" class="form-group col-12 text-center border p-3">
                                <label for="newFile">Sélectionnez la photo à ajouter: </label>
                                <p>Formats autorisés: JPG, JPEG, PNG</p>
                                <div class="custom-file col-12 text-center p-0 m-0">
                                    <label for="newFile" class="custom-file-label">Votre photo</label>
                                    <input type="file" name="newFile" class="p-0 m-0 custom-file-input" /><br />
                                    <input type="submit" name="submitFile" class="btn btn-primary mt-1 mb-1" value="J'envoie mon image" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Affichage du message d'erreur ou de réussite de l'ajout de la photo-->
            <?php if (isset($errorList['submitFile'])) { ?>
                <p class="red"><?= $errorList['submitFile'] ?></p>
                <?php
            }
            if (isset($success['submitFile'])) {
                ?>
                <p class="green"><?= $success['submitFile'] ?></p>
            <?php } ?>
            <!--Affichage des informations de compte-->
            <div class="row">
                <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-3 col-lg-3 col-lg-3 col-md-10 col-sm-10 col-xs-12 mt-5 h-100">
                    <div class="row profilBlockContent p-3 h-100">
                        <div class="col-12 text-center m-0 p-0 text-center">
                            <!--Vignette de présentation du musicien-->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="text-center">
                                        <a href="options.php" class="linkOptions" title="Cliquez pour accéder aux options"><h1 class="text-center"><?= $_SESSION['pseudo'] ?></h1></a>
                                    </div>
                                </div>
                                <div class="col-3 justify-content-center">
                                    <div class="row ml-md-1">
                                        <a href="options.php" title="Mes options">
                                            <div class="borderPicture1 rounded-circle ">
                                                <div class="borderPicture2 rounded-circle">
                                                    <div class="borderPicture3 rounded-circle">
                                                        <img src="../../assets/img/userPictures/avatars/<?= (isset($_SESSION['profilPicture']) && $_SESSION['profilPicture'] != 0) ? $_SESSION['profilPicture'] : 'icoUser.png' ?>" height="100" width="70" class="rounded-circle" alt="photo de profil" title="photo de profil" />
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-12 m-0 p-0">
                                            <?php if ($choice == 0) { ?>
                                                <!--Formulaire d'ajout de rôle si l'utilisateur n'a pas encore choisis-->
                                                <div class="row text-center">
                                                    <div class="col-12">
                                                        <form method="POST" action="#" class="form-group ml-4">
                                                            <label for="instrument">Vous êtes:</label>
                                                            <select name="instrument" id="instrument" class="form-control">
                                                                <option name="0" value="0" selected disabled>Choisissez un instrument</option>
                                                                <?php foreach ($showInstrument as $allInstrument) { ?>
                                                                    <option name="<?= $allInstrument->id ?>" value="<?= $allInstrument->id ?>" ><?= $allInstrument->instrument ?></option>
                                                                <?php } ?>
                                                                <input type="submit" class="form-control btn btn-primary" name="submitInstrumentChoice" />
                                                                <span class="red"><?= (isset($errorList['instrument'])) ? $errorList['instrument'] : '' ?></span>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <!--Div qui affiche le rôle du musicien-->
                                                <div class="showRoleOfMusician row mt-2 ml-3">
                                                    <div class="d-flex col-xl-8">  
                                                        <img src="../../assets/img/instruments/<?= $role->id_15968k4_typeInstrument ?>.png" title="rôle du musicien" alt="rôle du musicien" class="rounded-circle ml-xl-3 border text-center" width="50" height="50" /> 
                                                        <p class="mt-3"><?= $role->instrument ?></p>   
                                                        <!--Lien de modification de role-->
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <p class="ml-md-4">Cliquez <span class="linkChangeInstrument blue">ici</span> pour changer de rôle</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Affichage d'erreur ou de validation du formulaire de modification de role-->
                                                <span class="red"><?= (isset($errorList['newInstrument'])) ? $errorList['newInstrument'] : ' ' ?></span>
                                                <div class="row changeInstrument">
                                                    <form method="POST" action="#" class="form-group text-center ml-5">
                                                        <label for="newInstrument">Vous êtes:</label>
                                                        <select name="newInstrument" id="newInstrument" class="form-control ">
                                                            <option name="0" value="0" selected disabled>Choisissez un instrument</option>
                                                            <?php foreach ($showInstrument as $allInstrument) { ?>
                                                                <option name="<?= $allInstrument->id ?>" value="<?= $allInstrument->id ?>"><?= $allInstrument->instrument ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="submit" class="form-control btn btn-primary" name="submitChangeInstrumentChoice" />
                                                        <span class="red"><?= (isset($errorList['instrument'])) ? $errorList['instrument'] : '' ?></span>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Div d'affichage du status de recherche de l'utilisateur-->
                            <div class="musicianInResearch">
                                <div>
                                    <p class="red"><?= (isset($errorList['announce'])) ? $errorList['announce'] : ' ' ?></p>
                                    <p class="green"><?= (isset($success['announce'])) ? $success['announce'] : ' ' ?></p>
                                    <?php if ($musicianStatus == 0 || $dateExpiration < date('Y-m-d H:i:s')) { ?>
                                        <a href="#" data-toggle="modal" class="researchOption" data-target="#addStatusModal">
                                            <div class="row backRed m-0 p-0">
                                                <div class="col-12 m-0 p-0">
                                                    <p class="sentenceStatus mt-3">Aucune annonce en cours</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="#" data-toggle="modal" class="researchOption" data-target="#changeStatusModal">
                                            <div class="row backGreen m-0 p-0">
                                                <div class="col-12 m-0 p-0">
                                                    <p class="sentenceStatus mt-3">vous avez une annonce en cours</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--Fenêtre modale de création d'annonce-->
                            <div class="modal fade" id="addStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1>Voulez vous poster une annonce de recherche ?</h1>
                                        </div>
                                        <div class="modal-body">
                                            <h2>Votre annonce</h2>
                                            <p class="text-center"><span class="red">*</span>Vous ne pouvez publier qu'une annonce à la fois<br />
                                                N'hésitez pas changer votre annonce ou votre rôle selon vos envies !<br />
                                                (Une annonce dure exactement 1 semaine)</p>
                                            <!--Formulaire d'annonce-->
                                            <form action="#" method="POST" class="form-group">
                                                <!--Champs textarea-->
                                                <textarea name="announce" id="announce" class="form-control">Bonjour, ...</textarea>
                                                <!--Bouttons de validation ou d'annulation-->
                                                <button type="submit"  name="addResearch" class="btn btn-primary btn-lg">Publier mon annonce</button>
                                                <button type="submit"  name="cancelRemove" class="btn btn-danger btn-lg">Annuler</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fenêtre modale de changement de l'annonce-->
                            <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1>Souhaitez vous changer votre annonce de recherche ?</h1>
                                        </div>
                                        <div class="modal-body">
                                            <p><span class="red">*</span> Le temps d'expiration sera reporté à 1 semaine par rapport à votre changement d'annonce !</p>
                                            <!--Formulaire d'annonce-->
                                            <form action="#" method="POST" class="form-group">
                                                <!--Champs textarea-->
                                                <label for="announceChanged">Mon annonce: </label>
                                                <textarea name="announceChanged" id="announceChanged" class="form-control"><?= $showResearch->research ?></textarea>
                                                <!--Bouttons de validation ou d'annulation-->
                                                <button type="submit"  name="changeResearch" class="btn btn-primary btn-lg">Changer mon annonce</button>
                                                <button type="submit"  name="remove" class="btn btn-danger btn-lg">Supprimer l'annonce</button>
                                                <button type="submit"  name="cancel" class="btn btn-secondary btn-lg">Annuler</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">
                    <!--Block d'affichage des contrats-->
                    <div id="contractDisplay" class="profilBlock offset-sm-1 col-xl-12 col-lg-12 col-md-10 col-sm-10 col-xs-12">
                        <div class="row profilBlockContent">
                            <div class="col-12 text-center">
                                <h1>Vos contrats en cours</h1>
                                <p>Cette fonctionnalité est prévue dans la prochaine version de Mermaid !</p>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Div d'ajout de groupe de l'utilisateur-->
                    <div class="bandBlock offset-sm-1 col-xl-3 col-lg-3 col-md-10 col-sm-10 col-xs-12">
                        <a href="registerBand.php" class="addBandLink ">
                            <div class="bandContent col-12 text-center border">
                                <i class="fas fa-music fa-5x addBand mt-5 mb-2 "></i>
                                <?php if ($checkBand == 0) { ?>
                                    <p class="mb-5">Créez votre premier groupe !</p>
                                <?php } else { ?>
                                    <p class="mb-5">Ajoutez d'autres groupes</p>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                    <div class="bandBlock offset-sm-1 col-xl-7 col-lg-7 col-md-10 col-sm-10 col-xs-12">
                        <div class="bandContent h-100 text-center pt-3">
                            <p>D'autres fonctionalité arrivent dans la prochaine version de Mermaid</p>
                        </div>
                    </div>
                </div>
                <div class="row text-center col-12">
                    <?php foreach ($allMyBands as $bands) { ?>
                        <div class="col-4">
                            <div class="bandBlock mt-3" id="<?= $bands->id ?>">
                                <div class="bandContent">
                                    <div class="row mt-2 text-center">
                                        <div class="col-12 text-center">
                                            <a href="myBand.php?id=<?= $bands->id ?>" class="col-12 text-center Titleband">
                                                <img src="../../assets/img/bandPictures/avatars/<?= $bands->bandPicture ?>" class="rounded-circle" width="40" height="40" title="Photo de mon groupe de musique" alt="Photo de mon groupe de musique"/>   
                                                <h1 class="bandName"><?= $bands->bandName ?></h1>     
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Contrat terminé: 0<br />
                                                Contrat en cours: 0</p>
                                        </div>
                                    </div>
                                    <?php
                                    $countAnnounce = NEW bandInResearch();
                                    $countAnnounce->id_15968k4_band = $bands->id;
                                    $checkBandAnnounce = $countAnnounce->countAnnounce();
                                    if ($checkBandAnnounce == 0) {
                                        ?>
                                        <a href="#" data-toggle="modal" class="researchOption" data-target="#band<?= $bands->id ?>">
                                            <div class="row backRed m-0 p-0">
                                                <div class="col-12 m-0 p-0">
                                                    <p class="sentenceStatus mt-3">Aucune annonce en cours</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="#" data-toggle="modal" class="researchOption" data-target="#bandChange<?= $bands->id ?>">
                                            <div class="row backGreen m-0 p-0">
                                                <div class="col-12 m-0 p-0">
                                                    <p class="sentenceStatus mt-3">Vous avez une annonce en cours</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--Fenêtre modale d'ajout d'annonce-->
                        <div class="modal fade" id="band<?= $bands->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h1>Annonce de votre groupe de musique: <?= $bands->bandName ?></h1>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h2>Votre annonce</h2>
                                        <p class="text-center"><span class="red">*</span>Vous ne pouvez publier qu'une annonce à la fois<br />
                                            N'hésitez pas changer votre annonce ou votre rôle selon vos envies !<br />
                                            (Une annonce dure exactement 1 semaine)</p>
                                        <!--Formulaire d'annonce-->
                                        <form action="#" method="POST" class="form-group text-center">
                                            <!--Champs textarea-->
                                            <input type="hidden" name="bandId" value="<?= $bands->id ?>" id="<?= $bands->id ?>" />
                                            <textarea name="announceBand" id="announceBand" class="form-control">Bonjour, ...</textarea>
                                            <!--Bouttons de validation ou d'annulation-->
                                            <button type="submit"  name="addBandResearch" value="<?= $bands->id ?>" class="btn btn-primary btn-lg">Publier mon annonce</button>
                                            <button type="submit"  name="cancelRemove" class="btn btn-danger btn-lg">Annuler</button>
                                            <p class="red"><?= (isset($errorList['announceBand'])) ? $errorList['announceBand'] : '' ?></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fenêtre modale de changement d'annonce-->
                        <div class="modal fade" id="bandChange<?= $bands->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h1 class="text-center">Annonce de votre groupe de musique: <?= $bands->bandName ?></h1>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h2 class="text-center">Voulez vous poster une annonce de recherche ?</h2>
                                        <p><span class="red">*</span> Le temps d'expiration sera reporté à 1 semaine dès que votre annonce sera changée !</p>
                                        <!--Formulaire d'annonce-->
                                        <form action="#" method="POST" class="form-group">
                                            <!--Champs textarea-->
                                            <input type="hidden" name="bandId" value="<?= $bands->id ?>" id="<?= $bands->id ?>" />
                                            <label for="announceBandChanged">Mon annonce: </label>
                                            <textarea name="announceBandChanged" id="announceBandChanged" class="form-control"><?= $bands->research ?></textarea>
                                            <!--Bouttons de validation ou d'annulation-->
                                            <button type="submit"  name="changeBandResearch" class="btn btn-primary btn-lg">Changer mon annonce</button>
                                            <button type="submit"  name="removeBandResearch" class="btn btn-danger btn-lg">Supprimer l'annonce</button>
                                            <button type="submit"  name="cancel" class="btn btn-secondary btn-lg">Annuler</button>
                                            <p class="red"><?= (isset($errorList['changeBandResearch'])) ? $errorList['changeBandResearch'] : '' ?></p>
                                            <p class="red"><?= (isset($errorList['removeBandResearch'])) ? $errorList['removeBandResearch'] : '' ?></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        </section>
    </div>
<?php } ?>
<!--------------------------------------------------------------Profil pour les festivaliers-------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_SESSION['idType']) && $_SESSION['idType'] == 1) { ?>
    <div class="container-fluid">
        <div class="row">
            <?php include'../navOnline.php' ?>
        </div>
        <section>
            <!--Ligne d'affichage de photo de l'utilisateur-->
            <div class="row photoBlock">
                <div class="col-12">
                    <div class="col-12 mt-3 mb-2 carousel slide owl-carousel owl-theme" id="carousel" data-ride="carousel">
                        <!--Première slide du carousel permettant l'affichage de la fenêtre modale
                        elle sert à l'ajout de photo-->
                        <div class="text-center mt-1">
                            <a href="profile.php" title="Ajouter des photos" id="addPhoto" class="text-center" data-target="#myModal" data-toggle="modal">
                                <i class="fas fa-plus-circle fa-3x"></i>
                                <p>Ajoutez une photo</p>
                            </a>
                        </div>
                        <?php foreach ($displayPhotos as $photos) { ?>
                            <div class="text-center">
                                <a href="../../assets/img/userPictures/<?= $photos->userPhotos ?>" id="photo">
                                    <img src="../../assets/img/userPictures/<?= $photos->userPhotos ?>" id="photoGalery" class="item" width="50" height="70" idphoto="<?= $photos->id ?>" />                                               
                                </a>
                                <i class="remove far fa-times-circle fixed-top fa-1x"></i>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!--Fenêtre modale d'ajout de photo-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2>Ajoutez une photo dans votre galery</h2>
                        </div>
                        <div class="modal-body p-3">
                            <form action="profile.php" id="formPhoto" method="POST" enctype="multipart/form-data" class="form-group col-12 text-center border p-3">
                                <label for="newFile">Sélectionnez la photo à ajouter: </label>
                                <p>Formats autorisés: JPG, JPEG, PNG</p>
                                <div class="custom-file col-12 text-center p-0 m-0">
                                    <label for="newFile" class="custom-file-label">Votre photo</label>
                                    <input type="file" name="newFile" class="p-0 m-0 custom-file-input" /><br />
                                    <input type="submit" name="submitFile" class="btn btn-primary mt-1 mb-1" value="J'envoie mon image" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Affichage du message d'erreur ou de réussite de l'ajout de la photo-->
            <?php if (isset($errorList['submitFile'])) { ?>
                <p class="red"><?= $errorList['submitFile'] ?></p>
                <?php
            }
            if (isset($success['submitFile'])) {
                ?>
                <p class="green"><?= $success['submitFile'] ?></p>
            <?php } ?>
            <div class="row">
                <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 offset-md-1 offset-sm-1 col-xl-3 col-lg-3 col-lg-3 col-md-10 col-sm-10 col-xs-12 mt-3">
                    <div class="row profilBlockContent p-3">
                        <div class="col-12 text-center">
                            <!--Vignette de présentation du musicien-->
                            <a href="options.php" class="linkOptions row p-0 m-0">
                                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 m-0 p-0">
                                    <?php if ($_SESSION['profilPicture'] == ' ') { ?>
                                        <img src="../../assets/img/icoUser.png" class="rounded-circle icoUser border p-0 m-0" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                                    <?php } else { ?>
                                        <img src="../../assets/img/userPictures/avatars/<?= $_SESSION['profilPicture'] ?>" class="rounded-circle icoUser p-0 m-0" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                                    <?php } ?>
                                </div>
                                <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-xs-12 ml-2 text-center">
                                    <h1 class="profilePseudo mt-3"><?= $_SESSION['pseudo'] ?></h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="publications mt-3 offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <div class="row">
                        <h1>Publications de vos groupes préférés</h1>
                    </div>
                    <div class="row">
                        <p>Cette fonctionnalité arrivera dans la prochaine version de Mermaid</p>
                    </div>
                </div>
                <div class="myConcert text-center mt-3 offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <div class="row">
                        <h1>Les concerts où vous participez</h1>
                    </div>
                    <div class="row">
                        <p>Cette fonctionnalité arrivera dans a prochaine version de Mermaid</p>
                    </div>
                </div>
        </section>
    </div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="../../assets/js/profile.js"></script>
<script src="../../assets/js/nav.js"></script>
</body>
</html>