<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/profileCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="../../assets/css/navOnline.css" />
        <link rel="stylesheet" href="../../assets/css/public.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <?php include'../navOnline.php' ?>
            </div>
            <section>
                <div class="row text-center">
                    <div class="profil col-12">
                        <h1 class="text-center">VOTRE PROFIL</h1>
                    </div>
                </div>
                <div class="row profilContent">
                    <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 offset-md-1 offset-sm-1 col-xl-3 col-lg-3 col-lg-3 col-md-10 col-sm-10 col-xs-12 mt-3">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php if ($_SESSION['profilPicture'] == '') { ?>
                                    <img src="../../assets/img/icoUser.png" class="rounded-circle icoUser" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                                <?php } else { ?>
                                    <img src="../../assets/img/userPictures/avatars/<?= $_SESSION['profilPicture'] ?>" class="rounded-circle icoUser" width="70" height="70" alt="Photo de profil" title="Photo de profil" />
                                <?php } ?>
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center p-3">
                                <h1 class="profilePseudo"><?= $_SESSION['pseudo'] ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center p-1">
                                <?php if ($_SESSION['presentation'] != '') { ?>
                                    <p class="changePresentation"><?= $_SESSION['presentation'] ?><br />
                                        <a href="#">Changer</a><p>
                                    <?php } else { ?>
                                    <p class="changePresentation">Vous pouvez ajouter <a href="#">ici</a> une présentation !</p>
                                <?php } ?>
                                <form action="#" method="POST" class="showPresentation form-group">
                                    <textarea name="presentation" maxlength="300" placeholder="300 caractères maximum..."></textarea>
                                    <input type="submit" name="changePresentation" value="accepter" />
                                    <span class="red"><?= (isset($errorList['presentation'])) ? $errorList['presentation'] : ''; ?></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 offset-md-1 offset-sm-1 col-xl-6 col-lg-6 col-lg-6 col-md-10 col-sm-10 mt-3 text-center">
                        <div class="photo">
                            <h2>Vos photos</h2>
                            <p class="addPhotoLink">Ajouter des photos</p>
                            <span class="red"><?= (isset($errorList['submitFile'])) ? $errorList['submitFile'] : '' ?></span>
                            <span class="green"><?= (isset($success['submitFile'])) ? $success['submitFile'] : '' ?></span>
                            <div class="row"id="photos">
                                <div class="col-12 d-flex justify-content-center" >
                                    <?php foreach ($displayPhotos as $photos) { ?>
                                        <div class="col-3 text-center m-2 p-0">
                                            <img src="../../assets/img/userPictures/<?= $photos->userPhotos ?>" alt="photos" title="photos" width="100%" height="100%">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <form action="#" id="formPhoto" method="POST" enctype="multipart/form-data" class="form-group col-12 text-center p-0 m-0">
                            <div class="row p-0 m-0">
                                <div class="col-12 text-center p-0 m-0">
                                    <?php if (isset($_SESSION['profilPicture']) && $_SESSION['profilPicture'] != '') { ?>
                                        <img src="../../assets/img/userPictures/icoUser.png" class="rounded-circle icoUser" width="70" height="70" />
                                    <?php } else { ?>
                                        <img src="../../assets/img/userPictures/avatars/<?= $showAllContent->profilPicture ?>" class="rounded-circle" width="70" height="70" />
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row p-0 m-0">
                                <div class="col-12 text-center p-0 m-0">
                                    <input type="file" name="newFile" class="p-0 m-0" /><br />
                                    <input type="submit" name="submitFile" class="p-0 m-0" value="J'envoie mon image" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 offset-md-1 offset-sm-1 col-xl-10 col-lg-10 col-lg-10 col-md-10 col-xs-12 col-sm-10 text-center mt-3" id="concertBlock">
                <div class="concert">
                    <h2>Vos concerts</h2>
                    <p>hum... Il semble vous ne vous êtes inscrit à aucun concert se déroulant prochainement<br />
                        N'hésitez pas à consulter <a href="#">la carte</a> pour trouver des concerts près de chez vous !</p>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../../assets/js/profile.js"></script>
        </body>
        </html>
