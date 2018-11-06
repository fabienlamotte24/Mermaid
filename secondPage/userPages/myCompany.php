<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/companyCtrl.php';
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
            <section>
                <div class="row">
                    <div class="profil col-12">
                        <h1 class="text-center">MON ENTREPRISE</h1>
                    </div>
                </div>
                <div class="row">
                    <!--On affiche un formulaire d'inscription si l'utilisateur n'as pas encore de compte-entreprise-->
                    <?php if ($companyCheck == 0) { ?>
                        <div class="companyBlock offset-xl-3 offset-lg-3 offset-md-3 offset-sm-1 col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                            <form action="#" method="POST" class="offset-1 col-10 form-group text-center" enctype="multipart/form-data">
                                <h2>Création de votre compte entreprise</h2>
                                <!--Champs de nom d'entreprise-->
                                <label for="company">Nom de votre entreprise: </label>
                                <input type="text" name="company" id="company" value="<?= (isset($_POST['company'])) ? $_POST['company'] : '' ?>" maxlength="50" class="form-control text-center" />
                                <span class="red"><?= (isset($errorList['company'])) ? $errorList['company'] : '' ?></span>
                                <span class="green"><?= (isset($success['company'])) ? $success['company'] : '' ?></span>
                                <hr>
                                <!--Champs de numéro de siret-->
                                <label for="siretNumber1">Numéro de siret: </label><br />
                                <input type="text" name="siretNumber1" maxlength="3" size="3" value="<?= (isset($_POST['siretNumber1'])) ? $_POST['siretNumber1'] : '' ?>" id="siretNumber1" class="text-center" />
                                <input type="text" name="siretNumber2" maxlength="3" size="3" value="<?= (isset($_POST['siretNumber2'])) ? $_POST['siretNumber2'] : '' ?>" class="text-center" />
                                <input type="text" name="siretNumber3" maxlength="3" size="3" value="<?= (isset($_POST['siretNumber3'])) ? $_POST['siretNumber3'] : '' ?>" class="text-center" />
                                <input type="text" name="siretNumber4" maxlength="5" size="5" value="<?= (isset($_POST['siretNumber4'])) ? $_POST['siretNumber4'] : '' ?>" class="text-center" />
                                <hr>
                                <!--Champs d'envoi de fichier-->
                                <label for="photo">Téléchargez une photo de profil: </label>
                                <input type="file" name="photo" id="photo" class="form-control" />
                                <hr>
                                <!--Boutton de validation-->
                                <input type="submit" name="submitCompany" value="Je crée mon compte entreprise" />
                                <span class="red"><?= (isset($errorList['submitCompany'])) ? $errorList['company'] : '' ?></span>
                                <span class="green"><?= (isset($success['submitCompany'])) ? $success['company'] : '' ?></span>
                            </form>
                        </div>
                    <?php } else { ?>
                        <!--On affiche le compte entreprise si l'utilisateur en possède un-->
                        <div class="companyBlock offset-xl-3 offset-lg-3 offset-md-3 offset-sm-1 col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h1>Votre entreprise</h1>
                                    <p><?= $showEstablishment->companyName ?></p>
                                    <img src="../../assets/img/proPictures/avatar/<?= $showEstablishment->companyPicture ?>" class="rounded-circle" width="70" height="70" alt="photo de compte entreprise" title="photo de compte entreprise" />                                    
                                    <span class="red"><?= (isset($errorList['changeCompanyName'])) ? $errorList['changeCompanyName'] : '' ?></span>
                                    <span class="green"><?= (isset($success['changeCompanyName'])) ? $success['changeCompanyName'] : '' ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <!--Présence d'un lien de changement de paramètres-->
                                    <a href="#" id="modalProParametersLink" data-toggle="modal" data-target="#myModal">
                                        Paramètres
                                    </a>
                                    <!--Fenêtre modale permettant d'afficher les paramètres-->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content m-0 p-0">
                                                <div class="modal-header m-0 p-0">
                                                    <h2>Voulez-vous vraiment supprimer votre compte ?</h2>
                                                </div>
                                                <div class="modal-body m-0 p-0 text-center" id="paramModal">
                                                    <!--Liste des paramètres possible-->
                                                    <ul class="m-0 p-0 text-center" id="proParametersList">
                                                        <li class="linkProParameters1">Changer le nom</li>
                                                        <li class="linkProParameters2">changer la photo de profil</li>
                                                        <li class="linkProParameters3">Supprimer le compte</li>
                                                            <p><span class="red">*</span>Vous ne pouvez pas supprimer un compte qui a au moins un contrat en cours !</p>
                                                    </ul>
                                                    <!--Formulaire de changement de nom de compte-->
                                                    <div class="offset-2 col-8" id="changeNameForm">
                                                        <form action="#" method="POST" class="form-group text-center m-0 p-0">
                                                            <label for="companyName">Nouveau nom de votre entreprise: </label>
                                                            <input type="text" name="companyName" class="form-control text-center" id="companyName" />
                                                            <input type="submit" value="changer le nom de mon entreprise" name="changeCompanyName "/>
                                                        </form>
                                                    </div>
                                                    <!--Formulaire de changement de photo de profil d'entreprise-->
                                                    <div class="offset-1 col-10" id="changePhotoForm">
                                                        <form action="#" method="POST" class="form-group text-center m-0 p-0">
                                                            <label for="newPhotoCompany">Télécharger une nouvelle image de profil: </label>
                                                            <input type="file" name="newPhotoCompany" class="form-control text-center" id="companyName" />
                                                            <input type="submit" value="changer l'image de mon entreprise" name="changePhotoCompany "/>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/profile.js"></script>
        <script src="../../assets/js/form.js"></script>
    </body>
</html>
