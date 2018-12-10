<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include'../../controllers/navCtrl.php';
include_once'../../controllers/bandCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/css/navOnline.css" />
        <link rel="stylesheet" href="../../assets/css/mybands.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <div class="container-fluid">
            <header class="row">
                <?php include'../navOnline.php' ?>
            </header>
            <section class="row">
                <div id="backgroundOptions" class="offset-1 col-10 mt-5 mb-5 p-0">
                    <!--Affichage du nom de l'établissement-->
                    <div id="companyName" class="row white">
                        <div class="col-12 text-center">
                            <h1 id="titleband"><?= $showBand->bandName ?></h1>
                        </div>
                    </div>
                    <!--Affichage des informations avec possibilité de changer les informations-->
                    <div class="bandContent row p-0 m-0 ">
                        <div class="col-12 text-center border">
                            <h1>Votre groupe de musique</h1>

                            <!--Affichage des erreurs si elles existent-->
                            <p class="red"><?= (isset($errorList['changeBandContent'])) ? $errorList['changeBandContent'] : '' ?></p>
                            <p class="red"><?= (isset($errorList['announce'])) ? $errorList['announce'] : '' ?></p>
                            <p class="red"><?= (isset($errorList['removeBand'])) ? $errorList['removeBand'] : ' ' ?></p>
                            <p class="red"><?= (isset($errorList['addAnnounce'])) ? $errorList['addAnnounce'] : ' ' ?></p>
                            <!--Affichage des messages de réussite si ils existent-->
                            <p class="green"><?= (isset($success['changeBandContent'])) ? $success['changeBandContent'] : '' ?></p>
                            <p class="green"><?= (isset($success['removeAnnounce'])) ? $success['removeAnnounce'] : ' ' ?></p>
                            <p class="green"><?= (isset($success['announce'])) ? $success['announce'] : ' ' ?></p>
                            <p class="green"><?= (isset($success['addAnnounce'])) ? $success['addAnnounce'] : ' ' ?></p>

                            <!--Formulaire de changement d'informations-->
                            <form action="myBand.php?id=<?= $showBand->id ?>" method="POST" enctype="multipart/form-data" class="form-group offset-xl-3 offset-lg-3 offset-md-3 offset-sm-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                <!--Changement de l'image de profil-->
                                <img src="../../assets/img/bandPictures/avatars/<?= (isset($showBand->bandPicture) && $showBand->bandPicture != ' ') ? $showBand->bandPicture : ' ' ?>" class="rounded-circle mb-2" width="50" height="50" title="Photo de profil de l'établissement" alt="Photo de profil de l'établissement" />                            
                                <div class="custom-file mb-3">
                                    <label class="custom-file-label" for="photo">Changez votre photo</label>
                                    <input type="file" name="photo" id="photo" class="form-control custom-file-input" />
                                </div>
                                <p class="red"><?= (isset($errorList['photo'])) ? $errorList['photo'] : '' ?></p>

                                <!--Changement du nom-->
                                <label for="bandName">Nom de votre groupe: </label>
                                <input type="text" class="form-control" value="<?= (isset($showBand->bandName) && $showBand->bandName != ' ') ? $showBand->bandName : ' ' ?>" name="bandName" id="bandName" />
                                <p class="red"><?= (isset($errorList['bandName'])) ? $errorList['bandName'] : '' ?></p>

                                <!--Champs de description-->
                                <label for="bandDescription">Description de votre groupe de musique: </label>
                                <textarea name="bandDescription" id="bandDescription" class="form-control" ><?= (isset($showBand->bandDescription) && $showBand->bandDescription != ' ') ? $showBand->bandDescription : ' ' ?></textarea>
                                <p class="red"><?= (isset($errorList['bandDescription'])) ? $errorList['bandDescription'] : '' ?></p>

                                <!--Boutton de validation-->
                                <input type="submit" name="changeBandContent" class="form-control btn btn-primary" value="Modifier" />

                                <!--Boutton de suppression-->
                                <a href="#" data-toggle="modal" class="buttonRemove" data-target="#myModal">
                                    <button class="form-control btn btn-danger">Supprimer mon groupe de musique</button>
                                </a>
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2>Vous demandez la suppression de votre groupe de musique</h2>
                                            </div>
                                            <div class="modal-body">
                                                <h2>Confirmer ?</h2>
                                                <p class="text-center grey"><span class="red">*</span>Vous ne pourrez pas supprimer un groupe qui possède au moins un contrat !</p>
                                                <form action="#" method="POST">
                                                    <button type="submit" name="removeMyBand" class="btn btn-danger btn-lg">Supprimer</button>
                                                    <button type="submit" name="cancelRemove" class="btn btn-primary btn-lg">Annuler</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <?php if ($checkAnnounce != 0) { ?>
                            <div class="col-12 text-center">
                                <h1>Votre annonce</h1>

                                <!--Formulaire de changement d'annonce-->
                                <form action="myBand.php?id=<?= (isset($showBand->id) && $showBand->id != 0) ? $showBand->id : ' ' ?>" method="POST" class="form-group offset-xl-3 offset-lg-3 offset-md-3 offset-sm-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                    <!--Champs d'annonce-->
                                    <label for="announce">Votre annonce</label>
                                    <textarea name="announce" id="announce" class="form-control"><?= (isset($showBand->research) && $showBand->research != ' ') ? $showBand->research : ' ' ?></textarea>

                                    <!--Boutton de validation-->
                                    <input type="submit" name="changeAnnounce" class="form-control btn btn-primary" value="Modifier" />

                                    <!--Boutton de suppression-->
                                    <a href="#" data-toggle="modal" class="buttonRemove" data-target="#removeAnnounce">
                                        <input type="submit" name="removeAnnounce" class="form-control btn btn-danger" value="Supprimer" />
                                    </a>

                                </form>
                            </div>
                            <div class="modal fade" id="removeAnnounce" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h2>Vous demander la suppression de l'annonce</h2>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p>Confirmer ?</p>
                                            <form action="#" method="POST">
                                                <button type="submit" name="removeAnnounce" class="btn btn-danger btn-lg">Supprimer</button>
                                                <button type="submit" name="cancelRemove" class="btn btn-primary btn-lg">Annuler</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-12 text-center">
                                <h1>Votre annonce</h1>
                                <p>Vous n'avez pas encore ajouté d'annonce, écrivez-en une pour apparaître dans les recherches !</p>

                                <!--Formulaire de création d'annonce-->
                                <form action="myBand.php?id=<?= (isset($showBand->id) && $showBand->id != 0) ? $showBand->id : ' ' ?>" method="POST" class="form-group offset-xl-3 offset-lg-3 offset-md-3 offset-sm-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                    <!--Champs d'annonce-->
                                    <label for="newAnnounce">Votre annonce</label>
                                    <textarea name="newAnnounce" id="newAnnounce" class="form-control"><?= $showBand->research ?></textarea>
                                    <span class="red"><?= (isset($errorList['newAnnounce'])) ? $errorList['newAnnounce'] : ' ' ?></span>

                                    <!--Boutton de validation-->
                                    <input type="submit" name="addAnnounce" class="form-control btn btn-primary" value="Créer annonce" />
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/myBand.js"></script>
        <script src="../../assets/js/nav.js"></script>
    </body>
</html>