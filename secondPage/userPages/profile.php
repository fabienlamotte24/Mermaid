<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/profileCtrl.php';
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
                <div class="row text-center">
                    <div class="profil col-12">
                        <h1 class="text-center">VOTRE PROFIL</h1>
                    </div>
                </div>
                <div class="row profilContent">
                    <div class="profilBlock offset-1 col-xl-3 col-lg-3 col-md-3 col-sm-10 col-xs-10 mt-3">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <img src="../../assets/img/lapin.jpg" class="rounded-circle" width="70" height="70" />
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center p-3">
                                <h1 class="profilePseudo"><?= $_SESSION['pseudo'] ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center p-1">
                                <?php if($_SESSION['presentation'] != ''){?>
                                <p class="changePresentation"><?=$_SESSION['presentation']?><br />
                                <a href="#">Changer</a><p>
                                <?php } else {?>
                                <p class="changePresentation">Vous pouvez ajouter <a href="#">ici</a> une présentation !</p>
                                <?php } ?>
                                <form action="#" method="POST" class="showPresentation form-group">
                                    <textarea name="presentation" maxlength="300" placeholder="300 caractères maximum..."></textarea>
                                    <input type="submit" name="changePresentation" value="accepter" />
                                    <span class="red"><?= (isset($errorList['presentation'])) ? $errorList['presentation'] : '';?></span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="profilBlock offset-1 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-10 mt-3 text-center">
                        <div class="photo">
                            <h2>Vos photos</h2>
                            <p>Aucune photo...</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="profilBlock offset-1 col-10 text-center mt-3" id="concertBlock">
                        <div class="concert">
                            <h2>Vos concerts</h2>
                            <p>hum... Il semble vous ne vous êtes inscrit à aucun concert se déroulant prochainement<br />
                                N'hésitez pas à consulter <a href="#">la carte</a> pour trouver des concerts près de chez vous !</p>
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
        <script>
        $(document).ready(function(){
            $('.changePresentation').click(function(){
               $('.showPresentation').show();
               $('.changePresentation').hide();
            });
        });
        </script>
    </body>
</html>
