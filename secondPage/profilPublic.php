<?php
include_once'../config.php';
include_once'../controllers/publicCtrl.php';
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
                <?php include'navOnline.php' ?>
            </div>
            <section>
                <div class="row">
                    <h1 class="title col-12 text-center">MON PROFIL</h1>
                    <hr class="blockTitle">
                </div>
                <div class="row">
                    <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 mt-3">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <img src="../assets/img/lapin.jpg" class="rounded-circle" width="70" height="70" />
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <h1 class="profileName">Lapin chaloupé</h1>
                                <p>La vie est une carotte... ET CROC !</p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12 text-center">
                                <h1>Amis</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <img src="../assets/img/icoUser.png" class="rounded-circle friendsPicture" alt="amis" title="amis" width="35" height="35" />
                                <img src="../assets/img/icoUser.png" class="rounded-circle friendsPicture" alt="amis" title="amis" width="35" height="35" />
                                <img src="../assets/img/icoUser.png" class="rounded-circle friendsPicture" alt="amis" title="amis" width="35" height="35" />
                                <img src="../assets/img/icoUser.png" class="rounded-circle friendsPicture" alt="amis" title="amis" width="35" height="35" />
                                <img src="../assets/img/icoUser.png" class="rounded-circle friendsPicture" alt="amis" title="amis" width="35" height="35" />
                            </div>
                        </div>
                    </div>
                    <div class="profilBlock offset-xl-1 offset-lg-1 offset-md-1  text-center col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
                        <div class="photo">
                            <h2>Vos photos</h1>
                                <p>Aucune photo...</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="profilBlock offset-1 col-10 text-center mt-3" id="concertBlock">
                        <div class="concert">
                            <h2>Vos concerts</h1>
                                <p>hum... Il semble que vous n'avez suivis aucun concert se déroulant prochainement<br />
                                    N'hésitez pas à consulter <a href="#">la carte</a> pour trouver des concerts près de chez vous !</p>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
