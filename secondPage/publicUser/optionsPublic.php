<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/publicCtrl.php';
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
                <div  id="optionBoard" class="offset-xl-2 offset-lg-2 offset-md-2 offset-sm-2 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>MES OPTIONS</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center" id="showDetails">
                            <h2>Vos informations de compte</h2>
                            <ul class="p-0 m-0">
                                <li><span class="bold">Nom:</span> <?=$_SESSION['lastname']?></li>
                                <li><span class="bold">Prénom:</span> <?=$_SESSION['firstname']?></li>
                                <li><span class="bold">Identifiant:</span> <?=$_SESSION['pseudo']?></li>
                                <li><span class="bold">Numéro de téléphone:</span> <?=$_SESSION['phoneNumber']?></li>
                                <li><span class="bold">Date de naissance:</span> <?=$_SESSION['birthDate']?></li>
                                <li><span class="bold">Votre adresse postale:</span> <?=$_SESSION['address'] . ', ' . $_SESSION['city'] . ' (' . $_SESSION['postalCode'] . ')'?></li>
                                <li><span class="bold">Votre adresse de messagerie:</span> <?=$_SESSION['mail']?></li>
                            </ul>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center" id="passChanging">
                            <h2>Mot de passe</h2>
                            <p>Désirez-vous changer votre mot de passe ?<br /><a href="../../forget.php"> Mot de passe oublié ?</a></p>
                            <form class="form-group" action="#" method="POST">
                                <label for="actualPass">Votre mot de passe actuel: </label>
                                <input type="password" class="form-control passwords" id="actualPass" name="actualPass" />
                                <label for="newPass">Votre nouveau mot de passe</label>
                                <input type="password" class="form-control passwords" id="newPass" name="newPass" />
                                <input type="submit" class="form-control" name="submitPass" id="submitPass" value="Je change mon mot de passe" /> 
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>

UPDATE `15968k4_users`
SET `password` = :password;