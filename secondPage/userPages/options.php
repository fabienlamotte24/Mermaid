<?php
session_start();
include'../../config.php';
include'../../controllers/optionsCtrl.php';
include'../../controllers/connectCtrl.php';
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
            <header class="row">
                <?php include'../navOnline.php' ?>
            </header>
            <section class="row">
                <div class="profil col-12">
                    <h1 class="text-center">VOS OPTIONS DE COMPTE</h1>
                </div>
                <div  id="optionBoard" class="offset-xl-2 offset-lg-2 offset-md-2 offset-sm-2 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-12 text-center pt-2">
                            <!--Liste des messages d'erreur ou de validation à afficher en haut de page-->
                            <span class="red"><?= (isset($errorList['newEmail'])) ? $errorList['newEmail'] : '' ?></span>
                            <span class="green"><?= (isset($success['newEmail'])) ? $success['newEmail'] : '' ?></span>
                            <span class="red"><?= (isset($errorList['validateNewAdress'])) ? $errorList['validateNewAdress'] : '' ?></span>
                            <span class="green"><?= (isset($success['validateNewAdress'])) ? $success['validateNewAdress'] : '' ?></span>
                            <span class="red"><?= (isset($errorList['newPhoneNumber'])) ? $errorList['newPhoneNumber'] : '' ?></span>
                            <span class="green"><?= (isset($success['newPhoneNumber'])) ? $success['newPhoneNumber'] : '' ?></span>
                            <span class="red"><?= (isset($errorPassList['submitPass'])) ? $errorPassList['submitPass'] : '' ?></span>
                            <span class="green"><?= (isset($success['submitPass'])) ? $success['submitPass'] : '' ?></span>
                        </div>
                    </div>
                    <div class="row firstBoard">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center" id="showDetails">
                            <h2>Vos informations de compte</h2>
                            <ul class="p-0 m-0">
                                <!--Liste des informations générales du compte-->
                                <li><span class="bold">Nom:</span> <?= $showAllContent->lastname ?></li>
                                <li><span class="bold">Prénom:</span> <?= $showAllContent->firstname ?></li>
                                <li><span class="bold">Identifiant:</span> <?= $showAllContent->pseudo ?></li>
                                <li><span class="bold">Numéro de téléphone:</span> <?= $showAllContent->phoneNumber ?></li>
                                <li><span class="bold">Date de naissance:</span> <?= $showAllContent->birthDate ?></li>
                                <li><span class="bold">Votre adresse postale:</span> <?= $showAllContent->address . ', ' . $showAllContent->city . ' (' . $showAllContent->postalCode . ')' ?></li>
                                <li><span class="bold">Votre adresse de messagerie:</span> <?= $showAllContent->mail ?></li>
                            </ul>
                        </div>
                        <div class="offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center" id="passChanging">
                            <h2>Mot de passe</h2>
                            <p>Désirez-vous changer votre mot de passe ?</p>
                            <form class="form-group" action="#" method="POST">
                                <!--champs de mot de passe actuel
                                vérifié dans publicCtrl.php-->
                                <label for="actualPass">Votre mot de passe actuel: </label>
                                <input type="password" class="form-control passwords text-center" id="actualPass" name="actualPass" />
                                <span class="red"><?= (isset($errorList['actualPass'])) ? $errorList['actualPass'] : '' ?></span> 
                                <!--Champs du nouveau mot de passe à garder-->
                                <label for="newPass1">Votre nouveau mot de passe: </label>
                                <input type="password" class="form-control passwords text-center" id="newPass1" name="newPass1" />
                                <span class="red"><?= (isset($errorList['newPass1'])) ? $errorList['newPass1'] : '' ?></span> 
                                <!--Champs de répétition du nouveau mot de passe
                                Sert à s'assurer que l'utilisateur a bien rentré le mot de passe qu'il souhaitait-->
                                <label for="newPass2">Réécrivez le nouveau mot de passe: </label>
                                <input type="password" class="form-control passwords text-center" id="newPass2" name="newPass2" />
                                <span class="red"><?= (isset($errorList['newPass2'])) ? $errorList['newPass2'] : '' ?></span> 
                                <!--Boutton de validation-->
                                <input type="submit" class="form-control" name="submitPass" id="submitPass" value="Je change mon mot de passe" />
                            </form>
                        </div>
                    </div>
                    <div class="row secondBoard">
                        <div class="col-12 text-center p-0 m-0">
                            <h2>Modifiez vos informations générales</h2>
                            <hr>
                            <ul class="text-center p-0 m-0">
                                <li>
                                    <!--Block de changement d'adresse de messagerie-->
                                    <span class="eMailOptionTitle">Changer l'adresse de messagerie</span>
                                    <form id="eMailOptionForm" action="#" method="POST" class="form-group">
                                        <!--Champs de nouvelle adresse de messagerie-->
                                        <label for="newEmail">Votre nouvelle adresse mail: <span class="red">*</span></label>
                                        <input type="text" id="newEmail" name="newEmail" class="form-control text-center" />
                                        <p><span class="red">*</span>Vous devrez attendre 2 semaines avant de pouvoir changer votre adresse mail à nouveau !<br />
                                        <span class="red">*</span>Vous ne pouvez pas changer votre adresse mail en ayant au moins un contrat en cours !</p>
                                        <!--Boutton de validation-->
                                        <input type="submit" name="validateNewEmail" value="soumettre" />
                                    </form>
                                </li>
                                <li>
                                    <!--Block de changement d'adresse postale-->
                                    <span class="addressOptionTitle">Changer l'adresse Postale</span>
                                    <form id="addressOptionForm" action="#" method="POST" class="form-group">
                                        <!--Champs de nouvelle adresse postale-->
                                        <label for="newAddress">Votre nouvelle adresse postale: </label>
                                        <input type="text" id="newAddress" name="newAddress" class="form-control text-center" />
                                        <!--Champs de nouveau code postal-->
                                        <label for="newPostalCode">Votre nouveau code postal: </label>
                                        <input type="text" id="newPostalCode" name="newPostalCode" maxlength="10" class="form-control text-center" />
                                        <!--Champs de nouvelle ville-->
                                        <label for="newCitySelect">Votre nouvelle ville: </label>
                                        <select name="newCitySelect" id="newCitySelect" class="form-control">
                                            <option name="0" value="0" selected disabled>Renseignez votre code postal</option>
                                        </select>
                                        <!--Boutton de validation-->
                                        <input type="submit" name="validateNewAddress" value="soumettre" />
                                    </form>
                                </li>
                                <li>
                                    <!--block de changement de numéro de téléphone-->
                                    <span class="phoneNumberOptionTitle">Changer de numéro de téléphone</span>
                                    <form id="phoneNumberOptionForm" action="#" method="POST" class="form-group">
                                        <!--Champs de nouveau numéro de téléphone-->
                                        <label for="newPhoneNumber">Votre nouveau numéro de téléphone: </label>
                                        <input type="text" id="newPhoneNumber" name="newPhoneNumber" maxlength="10" class="form-control text-center" />
                                        <!--Boutton de validation-->
                                        <input type="submit" name="validateNewPhoneNumber" value="soumettre" />
                                    </form>
                                </li>
                                <li>
                                    <!--block de suppression de compte-->
                                    <a href="#" class="removeUserOptionTitle" data-toggle="modal" data-target="#myModal">
                                        Supprimer mon compte
                                    </a>
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2>Voulez-vous vraiment supprimer votre compte ?</h2>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="#" method="POST">
                                                        <button type="submit"  name="removeUser" class="btn btn-danger btn-lg" name="cancelRemove">Supprimer</button>
                                                        <button type="submit"  name="cancelRemove" class="btn btn-primary btn-lg" name="cancelRemove">Annuler</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/form.js"></script>
    </body>
</html>