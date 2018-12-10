<?php
include_once'config.php';
include_once'controllers/publicRegisterCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />        
        <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/form/styleForm.css" />
    </head>
    <body>
        <div class="container-fluid">
            <header>
                <div class="homeBlock text-center col-12">
                    <h1 class="homeTitle m-0 p-0"><a href="index.php" id="logo">Mermaid</a></h1>
                </div>
            </header>
            <div class="row">
                <section id="section" class="col-12 text-center">
                    <form id="form-data" class="<?= (isset($_POST['submit']) && count($errorList) == 0) ? 'invisible' : 'form' ?> offset-xl-2 offset-lg-2 offset-md-2 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 form-group text-center" action="#" method="POST">                                          
                        <div id="firstBlock">
                            <h2>Vos informations de compte</h2>
                            <!--Champs pseudo-->
                            <div class="row">
                                <div class="col-6">
                                    <label for="pseudo">Pseudo: <span class="red">*</span> </label>
                                    <input type="text" id="pseudo" name="pseudo" class="form-control text-center" maxlength="20" <?= (isset($_POST['pseudo'])) ? 'value="' . $_POST['pseudo'] . '"' : ''; ?> />                            
                                    <p class="red"><?= (isset($errorList['pseudo'])) ? $errorList['pseudo'] : '' ?></p>
                                </div>
                                <!--Champs adresse de messagerie-->
                                <div class="col-6">
                                    <label for="mail">Email: <span class="red">*</span> </label>
                                    <input type="mail" id="mail" name="mail" class="form-control text-center" maxlength="30" <?= (isset($_POST['mail'])) ? 'value="' . $_POST['mail'] . '"' : ''; ?> />
                                    <p class="red"><?= (isset($errorList['mail'])) ? $errorList['mail'] : '' ?></p>
                                </div>
                                <!--Champs mot de passe-->
                                <div class="col-6">
                                    <label for="pass">Mot de passe: <span class="red">*</span> </label>
                                    <input type="password" id="pass" name="pass" placeholder="Mot de passe" class="form-control text-center" maxlength="20" />                            
                                    <p class="red"><?= (isset($errorList['pass'])) ? $errorList['pass'] : '' ?></p>
                                </div>
                                <!--Champs répétition du mot de passe-->
                                <div class="col-6">
                                    <label for="passRepeat">Mot de passe: <span class="red">*</span> </label>
                                    <input type="password" id="passRepeat" name="passRepeat" placeholder="Réécrivez le mot de passe" class="form-control text-center" maxlength="20" />                            
                                    <p class="red"><?= (isset($errorList['passRepeat'])) ? $errorList['passRepeat'] : '' ?></p>
                                </div>
                                <div class="col-6">
                                    <!--Champs numéro de téléphone-->
                                    <label for="phoneNumber">Votre numéro de téléphone: <span class="red">*</span> </label>
                                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" maxlength="10" value="<?=(isset($_POST['phoneNumber']))? $_POST['phoneNumber'] : ''?>" />
                                    <p class="red"><?= (isset($errorList['phoneNumber'])) ? $errorList['phoneNumber'] : '' ?></p>
                                </div>
                                <div class="col-6">
                                    <!--Champs date de naissance-->
                                    <label for="birthDate">Votre date de naissance: <span class="red">*</span> </label>
                                    <input type="date" name="birthDate" id="birthDate" class="form-control" value="<?=(isset($_POST['birthDate']))? $_POST['birthDate'] : ''?>" />
                                    <p class="red"><?= (isset($errorList['birthDate'])) ? $errorList['birthDate'] : '' ?></p>
                                </div>
                            </div>
                        </div>
                        <!--Boutton de validation-->
                        <div class="submit">
                            <input type="submit" name="submit" value="Je valide mon inscription !" />
                        </div>
                    </form>
                    <div id="result" class="<?= (isset($success['submit']) && $success['submit'] == TRUE) ? 'blockForm' : 'invisible' ?> offset-xl-4 offset-lg-2 offset-md-2 col-xl-4 col-lg-8 col-md-8 col-sm-12 col-xs-12 form-group text-center">
                        <h2 class="green">Vous êtes bien inscrit(e) !</h2>
                        <p>Retournez à l'<a href="index.php"> accueil</a> pour vous connecter</p>
                    </div>
                </section>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="assets/js/form.js"></script>
    </body>
</html>