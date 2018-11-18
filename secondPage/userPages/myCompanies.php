<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/myCompaniesCtrl.php';
if (isset($successUrl['url'])) {
    ?>
    <!DOCTYPE html>
    <html lang="fr" dir="ltr">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />  
            <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
            <link rel="stylesheet" href="../../assets/css/navOnline.css" />
            <link rel="stylesheet" href="../../assets/css/myCompanies.css" />
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
                                <h1 id="titleEstablishment"><?= $establishment->companyName ?></h1>
                                <p>Numéro de siret: N°<span class="bold"><?= $establishment->siretNumber ?></span></p>
                            </div>
                        </div>
                        <!--Affichage des informations avec possibilité de changer les informations-->
                        <div class="establishmentContent row p-0 m-0">
                            <div class="col-12 text-center">
                                <h1>Votre établissement</h1>

                                <!--Liste des messages d'erreur lors de la validation des formulaires-->
                                <p class="red"><?= (isset($errorList['changeEstablishmentContent'])) ? $errorList['changeEstablishmentContent'] : ' ' ?></p>
                                <p class="red"><?= (isset($errorList['addAnnounce'])) ? $errorList['addAnnounce'] : ' ' ?></p>
                                <p class="red"><?= (isset($errorList['changeEstablishmentAnnounce'])) ? $errorList['changeEstablishmentAnnounce'] : ' ' ?></p>

                                <!--Liste des messages de succès lors de la validation des formulaires-->
                                <p class="green"><?= (isset($success['changeEstablishmentContent'])) ? $success['changeEstablishmentContent'] : ' ' ?></p>
                                <p class="green"><?= (isset($success['announce'])) ? $success['announce'] : ' ' ?></p>
                                <p class="green"><?= (isset($success['removeAnnounce'])) ? $success['removeAnnounce'] : ' ' ?></p>
                                <p class="green"><?= (isset($success['addAnnounce'])) ? $success['addAnnounce'] : ' ' ?></p>

                                <!--Formulaire de changement d'informations-->
                                <form action="myCompanies.php?id=<?= $establishment->id ?>" method="POST" enctype="multipart/form-data" class="form-group offset-xl-3 offset-lg-3 offset-md-3 offset-sm-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                    <!--Changement de l'image de profil-->
                                    <img src="../../assets/img/proPictures/avatars/<?= $establishment->companyPicture ?>" class="rounded-circle mb-2" width="70" height="70" title="Photo de profil de l'établissement" alt="Photo de profil de l'établissement" />                                                                
                                    <div class="custom-file">
                                        <label for="photo" class="custom-file-label">Votre photo de profil</label>
                                        <input type="file" name="photo" value="<?= $establishment->companyPicture ?>" class="form-control custom-file-input" id="photo" />
                                    </div>
                                    <p class="red"><?= (isset($errorList['photo'])) ? $errorList['photo'] : ' ' ?></p>

                                    <!--Changement du nom-->
                                    <label for="establishmentName">Nom de votre établissement: </label>
                                    <input type="text" class="form-control" value="<?= $establishment->companyName ?>" name="establishmentName" id="establishmentName" />
                                    <p class="red"><?= (isset($errorList['establishmentName'])) ? $errorList['establishmentName'] : ' ' ?></p>

                                    <!--Changement de l'adresse-->
                                    <label for="address">Votre adresse: </label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?= $establishment->addressCompany ?>" />
                                    <p class="red"><?= (isset($errorList['address'])) ? $errorList['address'] : ' ' ?></p>

                                    <!--Changement du code Postal-->
                                    <label for="postalCode">Votre code postal</label>
                                    <input type="text" name="postalCode" class="form-control" id="postalCode" value="<?= $establishment->postalCode ?>" />
                                    <p class="red"><?= (isset($errorList['postalCode'])) ? $errorList['postalCode'] : ' ' ?></p>

                                    <!--Changement de la ville-->
                                    <label for="city">Votre ville: </label>
                                    <select name="city" id="city" class="form-control">
                                        <option name="<?= $establishment->city ?>" value="<?= $establishment->city ?>" selected><?= $establishment->city ?></option>
                                    </select>
                                    <p class="red"><?= (isset($errorList['city'])) ? $errorList['city'] : ' ' ?></p>

                                    <!--Boutton de validation-->
                                    <input type="submit" name="changeEstablishmentContent" class="form-control" value="Modifier" />

                                </form>
                            </div>
                            <hr>
                            <?php if ($checkStatus != 0) { ?>
                                <div class="col-12 text-center">
                                    <h1>Votre annonce</h1>

                                    <!--Formulaire de changement d'annonce-->
                                    <form action="myCompanies.php?id=<?= $establishment->id ?>" method="POST" class="form-group offset-xl-3 offset-lg-3 offset-md-3 offset-sm-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <!--Champs d'annonce-->
                                        <label for="changeAnnounce">Votre annonce</label>
                                        <textarea name="changeAnnounce" id="changeAnnounce" class="form-control"><?= $establishment->research ?></textarea>
                                        <p class="red"><?= (isset($errorList['changeAnnounce'])) ? $errorList['changeAnnounce'] : ' ' ?></p>

                                        <!--Boutton de validation-->
                                        <input type="submit" name="changeEstablishmentAnnounce" class="form-control" value="Modifier" />

                                        <!--Boutton de suppression-->
                                        <input type="submit" name="removeAnnounce" class="form-control" value="Supprimer" />

                                    </form>
                                </div>
                            <?php } else { ?>
                                <div class="col-12 text-center">
                                    <h1>Votre annonce</h1>
                                    <p>Vous n'avez pas encore ajouté d'annonce, écrivez-en une pour apparaître dans les recherches !</p>

                                    <!--Formulaire de création d'annonce-->
                                    <form action="myCompanies.php?id=<?= $establishment->id ?>" method="POST" class="form-group offset-xl-3 offset-lg-3 offset-md-3 offset-sm-3 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <!--Champs d'annonce-->
                                        <label for="newAnnounce">Votre annonce</label>
                                        <textarea name="newAnnounce" id="newAnnounce" class="form-control"><?= $establishment->research ?></textarea>
                                        <p class="red"><?= (isset($errorList['newAnnounce'])) ? $errorList['newAnnounce'] : ' ' ?></p>

                                        <!--Boutton de validation-->
                                        <input type="submit" name="addAnnounce" class="form-control" value="modifier" />

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
            <script src="../../assets/js/myCompanies.js"></script>
        </body>
    </html>
    <?php
} else {
    header('location:../../index.php');
}
?>