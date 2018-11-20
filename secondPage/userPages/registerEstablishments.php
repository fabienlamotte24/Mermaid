<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include'../../controllers/navCtrl.php';
include_once'../../controllers/registerEstablishmentCtrl.php';
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
                            <h2>Création de votre établissement</h2>
                            <!--Champs de nom d'entreprise-->
                            <label for="company">Nom de votre établissement: </label>
                            <input type="text" name="company" id="company" value="<?= (isset($_POST['company'])) ? $_POST['company'] : '' ?>" maxlength="50" class="form-control text-center" />
                            <p class="red"><?= (isset($errorList['company'])) ? $errorList['company'] : '' ?></p>
                            <hr>
                            <!--Champs de numéro de siret-->
                            <label for="siretNumber1">Numéro de siret: </label><br />
                            <input type="text" name="siretNumber1" maxlength="3" size="3" value="<?= (isset($_POST['siretNumber1'])) ? $_POST['siretNumber1'] : '' ?>" id="siretNumber1" class="text-center" />
                            <input type="text" name="siretNumber2" maxlength="3" size="3" value="<?= (isset($_POST['siretNumber2'])) ? $_POST['siretNumber2'] : '' ?>" class="text-center" />
                            <input type="text" name="siretNumber3" maxlength="3" size="3" value="<?= (isset($_POST['siretNumber3'])) ? $_POST['siretNumber3'] : '' ?>" class="text-center" />
                            <input type="text" name="siretNumber4" maxlength="5" size="5" value="<?= (isset($_POST['siretNumber4'])) ? $_POST['siretNumber4'] : '' ?>" class="text-center" />
                            <p class="red"><?= (isset($errorList['siret'])) ? $errorList['siret'] : '' ?></p>
                            <hr>
                            <!--Champs d'envoi de fichier-->
                            <label for="photo">Téléchargez une photo de profil: </label>
                            <input type="file" name="photo" id="photo" class="form-control" />
                            <p class="red"><?= (isset($errorList['photo'])) ? $errorList['photo'] : '' ?></p>
                            <hr>
                            <!--Champs d'adresse-->
                            <label for="address">Adresse: </label>
                            <input type="text" name="address" id="address" class="form-control" value="<?=(isset($_POST['address'])) ? $_POST['address'] : ' '?>" />
                            <p class="red"><?= (isset($errorList['address'])) ? $errorList['address'] : '' ?></p>
                            <hr>
                            <!--Champs de code postal-->
                            <label for="postalCode">Code postal: </label>
                            <input type="text" name="postalCode" id="postalCode" class="form-control" value="<?=(isset($_POST['postalCode'])) ? $_POST['postalCode'] : ''?>" />                            
                            <p class="red"><?= (isset($errorList['postalCode'])) ? $errorList['postalCode'] : '' ?></p>
                            <hr>
                            <!--Champs de ville-->
                            <label for="city">Ville: </label>
                            <select name="city" id="citySelect" class="form-control">
                                <option name="0" value="0">Renseignez d'abord votre code postal</option>
                            </select>
                            <p class="red"><?= (isset($errorList['citySelect'])) ? $errorList['citySelect'] : '' ?></p>
                            <!--Boutton de validation-->
                            <input type="submit" name="submitCompany" class="btn btn-success" value="J'inscris mon établissement" />
                            <p class="red"><?= (isset($errorList['submitCompany'])) ? $errorList['submitCompany'] : '' ?></p>
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
        <script>

//Affichage des villes à l'aide du code postal
            $(function () {
                $('#postalCode').bind('input', function () {
                    $.post('../../controllers/registerEstablishmentCtrl.php', {
                        postalSearch: $('#postalCode').val()
                    }, function (cities) {
                        if (cities !== '') {
                            $('#citySelect').empty();
                            $('#citySelect').append('<option selected disabled name="0" value="0">Votre ville</option>');
                            $.each(cities, function (cityKey, city) {
                                $('#citySelect').append('<option value="' + city.city + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                            });
                        }
                    },
                            'JSON');
                });
                $('#citySelect').change(function () {
                    $('#postalCode').val($('#citySelect option:selected').attr('zipcode'));
                });
            });
        </script>
        <script src="../../assets/js/nav.js"></script>
    </body>
</html>
