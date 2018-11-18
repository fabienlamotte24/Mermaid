<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/registerBandCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />     
        <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="../../assets/css/owl.carousel.css" />
        <link rel="stylesheet" href="../../assets/css/owl.theme.default.css" />
        <link rel="stylesheet" href="../../assets/css/navOnline.css" />
        <link rel="stylesheet" href="../../assets/css/public.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <style>
            body{
                background-image:url('../../assets/img/musicianForm.jpeg');
                background-size:cover;
                background-repeat: no-repeat;
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <?php include'../navOnline.php' ?>
            </div>
            <section>
                <div class="row">
                    <div class="companyBlock offset-xl-3 offset-lg-3 offset-md-3 offset-sm-1 col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                        <form action="#" method="POST" class="offset-1 col-10 form-group text-center" enctype="multipart/form-data">
                            <h2>Création de votre groupe de musique</h2>
                            <!--Champs de nom de groupe-->
                            <label for="bandName">Nom de votre groupe de musique: </label>
                            <input type="text" name="bandName" id="bandName" value="<?= (isset($_POST['bandName'])) ? $_POST['bandName'] : '' ?>" maxlength="50" class="form-control text-center" />
                            <p class="red"><?= (isset($errorList['bandName'])) ? $errorList['bandName'] : '' ?></p>
                            <hr>
                            <!--Champs de description du groupe-->
                            <label for="bandDescription">Parlez-nous de votre groupe à l'aide d'une courte description: </label>
                            <textarea name="bandDescription" id="bandDescription" class="form-control"><?= (isset($_POST['bandDescription'])) ? $_POST['bandDescription'] : '' ?></textarea>
                            <p class="red"><?= (isset($errorList['bandDescription'])) ? $errorList['bandDescription'] : '' ?></p>
                            <hr>
                            <!--Champs d'envoi de photo de profil-->
                            <label for="bandPicture">Téléchargez une photo de profil: </label>
                            <input type="file" name="bandPicture" id="bandPicture" class="form-control" />
                            <p class="red"><?= (isset($errorList['bandPicture'])) ? $errorList['bandPicture'] : '' ?></p>
                            <hr>
                            <!--Boutton de validation-->
                            <input type="submit" name="submitBand" value="Je crée mon groupe de musique" />
                            <p class="red"><?= (isset($errorList['submitBand'])) ? $errorList['submitBand'] : '' ?></p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/owl.carousel.js"></script>
        <script src="../../assets/js/profile.js"></script>
    </body>
</html>
