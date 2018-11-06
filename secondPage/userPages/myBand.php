<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/bandCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
            <?php if ($checkGroupCreated == 0) { ?>
                <section>
                    <div class="row">
                        <div class="profil col-12">
                            <h1 class="text-center">MON GROUPE</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bandBlock offset-1 col-10" id="bandBlock">
                            <div class="col-12 text-center">
                                <p>Vous n'avez pas encore créé de groupe</p>
                                <h1>Créer un groupe</h1>
                                <form action="#" method="POST" class="form-group">
                                    <!--Création de groupe-->
                                    <label for="bandName">Nom de votre groupe</label>
                                    <input type="text" name="bandName" id="bandName" class="form-control" />
                                    <p class="red"><?= (isset($errorList['bandName'])) ? $errorList['bandName'] : ' ' ?></p>
                                    <!--Description de votre groupe-->
                                    <label for="bandDescription">Description de votre groupe</label>
                                    <input type="text" name="bandDescription" id="bandDescription" class="form-control" />
                                    <p class="red"><?= (isset($errorList['bandDescription'])) ? $errorList['bandDescription'] : ' ' ?></p>
                                    <!--Boutton de validation du formulaire-->
                                    <input type="submit" name="validateBand" value="Je crée mon groupe" />
                                    <p class="red"><?= (isset($errorList['validateBand'])) ? $errorList['validateBand'] : ' ' ?></p>
                                    <p class="red"><?= (isset($succes['validateBand'])) ? $succes['validateBand'] : ' ' ?></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } else { ?>
                <section>
                    <div class="row">
                        <div class="profil col-12">
                            <h1 class="text-center">MON GROUPE</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bandBlock offset-xl-4 offset-lg-4 offset-md-4 offset-md-4 offset-sm-1 col-xl-4 col-lg-4 col-md-4 col-sm-10 col-xs-12 text-center" id="bandBlock">
                            <!--Bannière de présentation du groupe-->
                            <div class="nameOfBand col-12 text-center">
                                <div class="row" id="groupDescription">
                                    <div class="col-3 text-center">
                                        <?php if ($showGroupCreated->bandPicture == ' ') { ?>
                                            <img src="../../assets/img/icoUser.png" class="rounded-circle" alt="photo du groupe" title="photo du groupe" width="70" height="70" />
                                        <?php } else { ?>
                                            <img src="../../assets/img/groupPictures/avatars/<?= $showGroupCreated->bandPicture ?>" class="rounded-circle" alt="photo du groupe" title="photo du groupe" width="70" height="70" />
                                        <?php } ?>
                                    </div>
                                    <div class="col-9 text-center">
                                        <h1><?= $showGroupCreated->bandName ?></h1>
                                        <p><?= $showGroupCreated->bandDescription ?></p>
                                        <hr>
                                    </div>
                                </div>
                                <!--Sous bannière d'option du groupe-->
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <p><a href="#" class="changePhoto">Ajouter/modifier la page de votre groupe</a></p>
                                        <p><a href="#" class="bandRemove" data-toggle="modal"  data-target="#myModal">Supprimer mon groupe</a></p>
                                        <span class="red"><?= (isset($errorList['submitFile'])) ? $errorList['submitFile'] : '' ?></span>
                                        <span class="green"><?= (isset($success['submitFile'])) ? $success['submitFile'] : '' ?></span>
                                        <!--Formulaire de changement de photo de groupe-->
                                        <form action="#" method="POST" id="formPhoto" class="form-group" enctype="multipart/form-data">
                                            <?php if ($showGroupCreated->bandPicture == ' ') { ?>
                                                <img src="../../assets/img/icoUser.png" class="rounded-circle" alt="photo du groupe" title="photo du groupe" width="70" height="70" />
                                            <?php } else { ?>
                                                <img src="../../assets/img/groupPictures/avatars/<?= $showGroupCreated->bandPicture ?>" class="rounded-circle" alt="photo du groupe" title="photo du groupe" width="70" height="70" />
                                            <?php } ?>
                                            <input type="file" name="photo" class="form-control rounded-circle" />
                                            <input type="submit" name="submitGroupPhoto" value="j'envoie ma photo" />
                                        </form>
                                        <!--Modale de suppression de groupe-->
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h2>Voulez-vous vraiment supprimer votre groupe ?</h2><br />
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="#" method="POST">
                                                            <p><span class="red">*</span>Vous ne pouvez pas supprimer un compte qui a au moins un contrat en cours !</p>
                                                            <button type="submit"  name="removeBand" class="btn btn-danger btn-lg" >Supprimer</button>
                                                            <button type="submit"  name="cancelRemove" class="btn btn-primary btn-lg" >Annuler</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bandBlock offset-1 col-10" id="bandBlock">
                            <div class="row">
                                <div class="bandPhotos col-xl-6 text-center">
                                    <h2>Les photos de votre groupe</h2>
                                    <p>Vous n'avez pas encore ajouté de photo</p>
                                    <a href="#">Ajouter des photos</a>
                                </div>
                                <div class="members col-xl-6 text-center">
                                    <h2>Les membres de votre groupe</h2>
                                    <p>Aucun membre n'a rejoins votre groupe<br />
                                        Cliquez <a href="#">ici</a> pour ajouter des membres</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="bandBlock offset-1 col-10 text-center">
                            <h2>Les groupes dont vous êtes membres</h2>
                            <p>Vous n'avez rejoins aucun groupe<br />
                                Cliquez <a href="#">ici</a> pour voir les groupes que vous pourriez rejoindre</p>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/profile.js"></script>
        <script src="../../assets/js/form.js"></script>
    </body>
</html>