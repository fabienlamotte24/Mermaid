<?php
session_start();
include'../../config.php';
include'../../controllers/optionsCtrl.php';
include'../../controllers/navCtrl.php';
include'../../controllers/connectCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />   
        <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" 
              integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="../../assets/css/navOnline.css" />
        <link rel="stylesheet" href="../../assets/css/options.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="row">
                <?php include'../navOnline.php' ?>
            </nav>
            <section class="row">
                <div class="offset-1 col-10 board mt-5 p-0">
                    <h1 class="text-center m-2 titleBoard">Vos options de compte</h1>
                    <div class="row contentBoard">
                        <div class="col-12 m-0 p-0">
                            <!--Block de photo de profil-->
                            <div class="row profilePhoto">
                                <div class="col-12 text-center">
                                    <h2><?= $showAllContent->pseudo ?></h2>
                                    <!--Je ne demande le nom et le prénom qu'au professionnel et aux musicien
                                    Les utilisateurs festivalier n'ont pas de nom ni prénom à afficher-->
                                    <?php if ($_SESSION['idType'] != 1) { ?>
                                        <p>(<?= $showAllContent->lastname . ' ' . $showAllContent->firstname ?>)</p>
                                    <?php } ?>
                                    <img src="../../assets/img/userPictures/avatars/<?= (isset($showAllContent->profilPicture) && 
                                            $showAllContent->profilPicture != 0) ? $showAllContent->profilPicture : 'icoUser.png' ?>" 
                                            class="rounded-circle" width="70" height="70" />
                                    <!--Formulaire de changement de photo de profil-->
                                    <div class="form-group offset-xl-3 offset-lg-3 offset-md-2 offset-sm-2 col-xl-6 col-lg-6 col-md-8 
                                         col-sm-8 col-xs-12">
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            <div class="custom-file">
                                                <!--Champs de photo de profil-->
                                                <label for="newFile" class="custom-file-label">Sélectionner votre photo</label>
                                                <input type="file" name="newFile" id="newFile" class="custom-file-input form-control p-0 m-0" />
                                            </div>
                                            <input type="submit" name="submitFile" class="form-control btn btn-primary" value="changer 
                                                   ma photo de profil" /> 
                                        </form>
                                        <a href="#" data-toggle="modal" data-target="#removeAccountModal">
                                            <button type="submit" name="removeAccount" class="form-control btn btn-danger">Supprimer mon compte
                                            </button> 
                                        </a>
                                    </div>
                                    <!--Fenêtre modale de suppression de compte-->
                                    <div class="modal fade" id="removeAccountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1>Voulez-vous vraiment supprimer votre compte ?</h1>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center grey"><span class="red">*</span>Vous ne pouvez pas supprimer un compte tant 
                                                    que celui-ci est lié à au moins 1 contrat en cours !</p>
                                                    <!--Formulaire d'annonce pour la suppression du compte de l'utilisateur-->
                                                    <form action="#" method="POST" class="form-group">
                                                        <button type="submit"  name="confirmRemove" class="btn btn-danger btn-lg">Supprimer</button>
                                                        <button type="submit"  name="cancelRemove" class="btn btn-primary btn-lg">Annuler</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--Block d'informations personnelles-->
                            <div class="row personnalInformation">
                                <div class="offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-5 col-lg-5 col-md-5 col-sm-10 col-xs-12 
                                     text-center">
                                    <h2>Adresse de messagerie</h2>
                                    <!--Block de changement d'adresse de messagerie-->
                                    <form action="#" method="POST" class="form-group">
                                        <!--Champs d'adresse de messagerie-->
                                        <label for="mail">Adresse de messagerie: </label>
                                        <input type="mail" name="mail" id="mail" class="form-control text-center" 
                                               value="<?= $showAllContent->mail ?>" />
                                        <p class="red"><?= (isset($errorList['mail'])) ? $errorList['mail'] : '' ?></p>
                                        <!--Boutton de validation-->
                                        <input type="submit" name="changeEmail" class="form-control btn btn-primary" value="changer mon adresse de messagerie" />
                                    </form>
                                    <p class="red"><?= (isset($errorList['emailNotChanged'])) ? $errorList['emailNotChanged'] : '' 
                                        ?></p>
                                    <p class="green"><?= (isset($success['emailChanged'])) ? $success['emailChanged'] : '' 
                                        ?></p>
                                    <h2>Vos informations personnelles</h2>
                                    <p class="red"><?= (isset($errorList['changeUserInformations'])) ? $errorList['changeUserInformations'] : '' 
                                        ?></p>
                                    <p class="green"><?= (isset($success['changeUserInformations'])) ? $success['changeUserInformations'] : '' 
                                        ?></p>
                                    <!--Formulaire de changement d'information-->
                                    <form action="#" method="POST" class="form-group">
                                        <!--Champs de numéro de téléphone-->
                                        <label for="phoneNumber">Numéro de téléphone: </label>
                                        <input type="text" name="phoneNumber" id="phoneNumber" class="form-control text-center" 
                                               value="<?= $showAllContent->phoneNumber ?>" />
                                        <p class="red"><?= (isset($errorList['phoneNumber'])) ? $errorList['phoneNumber'] : '' ?></p>
                                        <!--Champs de addresse-->
                                        <label for="address">Addresse postale: </label>
                                        <input type="text" name="address" id="address" class="form-control text-center" 
                                               value="<?= $showAllContent->address ?>" />
                                        <p class="red"><?= (isset($errorList['address'])) ? $errorList['address'] : '' ?></p>
                                        <div class="row">
                                            <!--Champs de code postal-->
                                            <div class="col-6">
                                                <label for="newPostalCode">Code postale: </label>
                                                <input type="text" name="newPostalCode" id="newPostalCode" class="form-control text-center" 
                                                       value="<?= $showAllContent->postalCode ?>" />
                                                <p class="red"><?= (isset($errorList['newPostalCode'])) ? $errorList['newPostalCode'] : '' ?></p>
                                            </div>
                                            <!--Champs de ville-->
                                            <div class="col-6">
                                                <label for="newCitySelect">Ville: </label>
                                                <select name="newCitySelect" id="newCitySelect" class="form-control">
                                                    <option name="<?= $showAllContent->id_15968k4_cities ?>" 
                                                            value="<?= $showAllContent->id_15968k4_cities ?>" 
                                                            selected><?= $showAllContent->city ?></option>
                                                </select>
                                            </div>
                                            <p class="red"><?= (isset($errorList['newCitySelect'])) ? $errorList['newCitySelect'] : '' ?></p>
                                        </div>
                                        <!--Boutton de validation-->
                                        <input type="submit" name="changeUserInformations" class="form-control btn btn-primary" 
                                               value="Changer mes informations" />
                                    </form>
                                </div>
                                <!--Changement de mot de passe-->
                                <div class="offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-4 col-lg-4 col-md-4 col-sm-10 
                                     col-xs-12 text-center">
                                    <h2>Changement de votre mot de passe</h2>
                                    <p class="red"><?= (isset($errorList['testPass'])) ? $errorList['testPass'] : '' ?></p>
                                    <p class="green"><?= (isset($success['changePass'])) ? $success['changePass'] : '' ?></p>
                                    <form action="#" method="POST" class="form-group pt-2">
                                        <!--Champs de mot de passe actuel-->
                                        <label for="actualPass">Votre mot de passe actuel: </label>
                                        <input type="password" name="actualPass" id="actualPass" class="form-control" />
                                        <p class="red"><?= (isset($errorList['actualPass'])) ? $errorList['actualPass'] : '' ?></p>
                                        <!--Champs de mot de nouveau mot de passe-->
                                        <label for="pass1">Nouveau de passe: </label>
                                        <input type="password" name="pass1" id="pass1" class="form-control" />
                                        <p class="red"><?= (isset($errorList['pass1'])) ? $errorList['pass1'] : '' ?></p>
                                        <!--Champs de mot de réécriture du nouveau mot de passe-->
                                        <label for="pass2">Réécrivez votre mot de passe: </label>
                                        <input type="password" name="pass2" id="pass2" class="form-control" />
                                        <p class="red"><?= (isset($errorList['pass2'])) ? $errorList['pass2'] : '' ?></p>
                                        <!--Boutton de validation-->
                                        <input type="submit" name="changePass" class="form-control btn btn-primary" 
                                               value="changer mon mot de passe" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/options.js"></script>
        <script src="../../assets/js/nav.js"></script>
    </body>
</html>