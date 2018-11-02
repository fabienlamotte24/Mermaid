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
                <section class="row">
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
                </section>
            <?php } else { ?>
                <section class="row">
                    <div class="bandBlock offset-1 col-10" id="bandBlock">
                        <div class="row">
                            <div class="nameOfBand col-6 text-center">
                                <h1><?= $showGroupCreated->bandName ?></h1>
                                <p><?= $showGroupCreated->bandDescription ?></p>
                                <p><span class="bandRemove">Supprimer mon groupe</span><span class="red">*</span><br />
                                <span class="red">*</span>Vous ne pouvez pas supprimer un compte qui a au moins un contrat en cours !</p>
                            </div>
                            <div class="bandPhotos col-6 text-center">
                                <h2>Les photos de votre groupe</h2>
                                <p>Vous n'avez pas encore ajouté de photo</p>
                                <a href="#">Ajouter des photos</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="members col-12 text-center">
                                <h2>Les membres de votre groupe</h2>
                                <p>Aucun membre n'a rejoins votre groupe<br />
                                    Cliquez <a href="#">ici</a> pour ajouter des membres</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="otherGroups col-12 text-center">
                                <h2>Les groupes dont vous êtes membres</h2>
                                <p>Vous n'avez rejoins aucun groupe<br />
                                    Cliquez <a href="#">ici</a> pour voir les groupes que vous pourriez rejoindre</p>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    <?php } ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>