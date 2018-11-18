<?php
include_once'config.php';
include_once'controllers/proRegisterCtrl.php';
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
            <section id="section" class="col-12 text-center">
                <form id="form-data" class="<?= (isset($_POST['submit']) && count($errorList) == 0) ? 'invisible' : 'form' ?> offset-xl-2 offset-lg-2 offset-md-2 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 form-group text-center" action="#" method="POST">                
                    <div id="firstBlock">
                        <h2>Vos informations de compte</h2>
                        <div class="row">
                            <!--Champs pseudo-->
                            <div class="col-6">
                                <label for="pseudo">Pseudo: <span class="red">*</span> </label>
                                <input type="text" id="pseudo" name="pseudo" class="form-control text-center" maxlength="20" <?= (isset($pseudo)) ? 'value="' . $pseudo . '"' : ' '; ?> />                            
                                <p class="red"><?= (isset($errorList['pseudo'])) ? $errorList['pseudo'] : ' ' ?></p>
                            </div>
                            <!--Champs adresse de messagerie-->
                            <div class="col-6">
                                <label for="mail">Email: <span class="red">*</span> </label>
                                <input type="mail" id="mail" name="mail" class="form-control text-center" maxlength="30" <?= (isset($mail)) ? 'value="' . $mail . '"' : ' '; ?> />
                                <p class="red"><?= (isset($errorList['mail'])) ? $errorList['mail'] : ' ' ?></p>
                            </div>
                            <!--Champs mot de passe-->
                            <div class="col-6">
                                <label for="pass">Mot de passe: <span class="red">*</span> </label>
                                <input type="password" id="pass" name="pass" placeholder="Ecrivez un mot de passe" class="form-control text-center" maxlength="20" <?= (isset($pass1)) ? 'value="' . $pass1 . '"' : ' '; ?> />                            
                                <p class="red"><?= (isset($errorList['pass'])) ? $errorList['pass'] : ' ' ?></p>
                            </div>
                            <!--Champs répétition du mot de passe-->
                            <div class="col-6">
                                <label for="passRepeat">Mot de passe: <span class="red">*</span> </label>
                                <input type="password" id="passRepeat" name="passRepeat" placeholder="Réécrivez le mot de passe" class="form-control text-center" maxlength="20" <?= (isset($pass2)) ? 'value="' . $pass2 . '"' : ' '; ?> />                            
                                <p class="red"><?= (isset($errorList['passRepeat'])) ? $errorList['passRepeat'] : ' ' ?></p>
                            </div>
                        </div>
                    </div>
                    <div id="secondBlock">
                        <h2>Vos informations personnelles</h2>
                        <div class="row">
                            <!--Champs nom de famille-->
                            <div class="col-6">
                                <label for="lastname">Nom: <span class="red">*</span> </label>
                                <input type="text" id="lastname" name="lastname" class="form-control text-center" maxlength="15" <?= (isset($lastname)) ? 'value="' . $lastname . '"' : ' '; ?> />                            
                                <p class="red"><?= (isset($errorList['lastname'])) ? $errorList['lastname'] : ' ' ?></p>
                            </div>
                            <!--Champs prénom-->
                            <div class="col-6">
                                <label for="firstname">Prénom: <span class="red">*</span> </label>
                                <input type="text" id="firstname" name="firstname" class="form-control text-center" maxlength="15" <?= (isset($firstname)) ? 'value="' . $firstname . '"' : ' '; ?> />                           
                                <p class="red"><?= (isset($errorList['firstname'])) ? $errorList['firstname'] : ' ' ?></p>
                            </div>
                            <!--Champs date de naissance-->
                            <div class="col-6">
                                <label for="birthDate">Date de naissance: <span class="red">*</span></label>
                                <input type="date" id="birthDate" name="birthDate" class="form-control text-center" <?= (isset($birthDate)) ? 'value="' . $birthDate . '"' : ' '; ?> />                           
                                <p class="red"><?= (isset($errorList['birthDate'])) ? $errorList['birthDate'] : ' ' ?></p>
                            </div>
                            <!--Champs numéro de téléphone-->
                            <div class="col-6">
                                <label for="phoneNumber">Numéro de téléphone: <span class="red">*</span></label>
                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control text-center" maxlength="10" <?= (isset($phoneNumber)) ? 'value="' . $phoneNumber . '"' : ' '; ?> />                                                        
                                <p class="red"><?= (isset($errorList['phoneNumber'])) ? $errorList['phoneNumber'] : ' ' ?></p>
                            </div>
                        </div>
                    </div>
                    <div id="thirdBlock">
                        <h2>Votre adresse</h2>
                        <div class="row">
                            <!--Champs adresse-->
                            <div class="col-12">
                                <label for="address">Adresse: <span class="red">*</span> </label>
                                <input type="text" id="adress" name="address" class="form-control text-center" maxlength="100" <?= (isset($address)) ? 'value="' . $address . '"' : ' '; ?> />
                                <p class="red"><?= (isset($errorList['address'])) ? $errorList['address'] : ' ' ?></p>
                            </div>
                            <!--Champs code postal-->
                            <div class="col-6">
                                <label for="postalCode">Code postal: <span class="red">*</span> </label>
                                <input type="text" name="postalCode" id="postalCode" class="form-control" <?= (isset($_POST['postalCode'])) ? 'value="' . $_POST['postalCode'] . '"' : ' '; ?> />
                                <p class="red"><?= (isset($errorList['postalCode'])) ? $errorList['postalCode'] : ' ' ?></p>
                            </div>
                            <!--Champs Ville-->
                            <div class="col-6">
                                <label for="city">Ville: <span class="red">*</span> </label>
                                <select name="city" id="citySelect" class="form-control">
                                    <option name="0" value="0">Votre code postal</option>
                                </select>
                                <p class="red"><?= (isset($errorList['city'])) ? $errorList['city'] : ' ' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="submit">
                        <input type="submit" name="submit" value="Je valide mon inscription !" />
                    </div>
                </form>
                <div id="result" class="<?= (isset($_POST['submit']) && count($errorList) == 0) ? 'blockForm' : 'invisible' ?> offset-xl-4 offset-lg-2 offset-md-2 col-xl-4 col-lg-8 col-md-8 col-sm-12 col-xs-12 form-group text-center">
                    <h2 class="green">Vous êtes bien inscrit(e) !</h2>
                    <p>Retournez à l'<a href="index.php"> accueil</a> pour vous connecter</p>
                </div>
            </section>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
    <script src="assets/js/registerForm.js"></script>
</body>
</html>