<?php
session_start();
include_once'../../config.php';
include_once'../../controllers/connectCtrl.php';
include_once'../../controllers/discoverCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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
                        <h1 class="text-center">RECHERCHE DE MEMBRE</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="blockResearch offset-2 col-8">
                        <form action="#" method="POST" class="form-group text-center">
                            <label for="userResearch">Sélectionnez votre recherche: </label>
                            <select name="userResearch" id="userResearch" class="form-control text-center">
                                <option name="0" value="0" selected disabled>Votre recherche</option>
                                <option name="Musicien" value="Musicien">Musicien</option>
                                <option name="Band" value="Band">Groupe de musique</option>
                                <option name="Professionnel" value="Professionnel">Professionnel</option>
                            </select>
                            <input type="submit" name="submitResearch" class="btn btn-primary mt-3" value="Rechercher" />
                        </form>
                    </div>
                </div>
                <?php
                if (isset($_POST['userResearch'])) {
                    if ($_POST['userResearch'] == 'Musicien') {
                        ?>
                        <div class="row">
                            <div class="titleResearch offset-4 col-4 p-0 pt-1">
                                <div class="row m-0 p-0">
                                    <div class="col-12 text-center m-0 p-0">
                                        <h1 class="musicianResearchTitle">Musiciens</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!--Affichage du résultat si l'utilisateur recherche des musiciens-->
        <?php foreach ($showAllMusicians as $musician) { ?>
                            <div class="row">
                                <div class="blockResearch offset-1 col-10 p-0 ">
                                    <div class="row p-0 m-0">
                                        <div class="col-12 d-flex p-0 pl-2 mt-3 mb-3"> 
                                            <div class="row p-0 m-0 ">
                                                <div class="col-12 p-0 m-0">                                            
                                                    <a href="#?<?= $musician->id ?>" class="linkResearch"><img src="../../assets/img/userPictures/avatars/<?= ($musician->profilPicture != ' ') ? $musician->profilPicture : 'icoUser.png' ?>" class="rounded-circle" width="70" height="70" /></a>
                                                </div>
                                            </div>
                                            <div class="row p-0 m-0 pl-2">
                                                <div class="col-12 p-0 m-0">
                                                    <a href="#?<?= $musician->id ?>" class="linkResearch"><h1><?= $musician->pseudo ?></h1></a>
                                                    <p><span class="placeMusician">Lieu: <?=$musician->city?> (<?=$musician->postalCode?>)</span><br />
                                                    <?=$musician->address?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                }
//          Affichage du résultat si l'utilisateur recherche des groupes de musique
            } else if ($_POST['userResearch'] == 'Band') {
                ?>
                <div class="row">
                    <div class="titleResearch offset-4 col-4 p-0 pt-1">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h1 class="musicianResearchTitle">Groupe de musique</h1>
                            </div>
                        </div>
                    </div>
                </div>
            
        <?php foreach ($showAllBands as $band) {
            ?>
                    <div class = "row">
                        <div class = "blockResearch offset-1 col-10 pl-1">
                            <div class = "row m-0 p-0">
                                <div class = "col-12 d-flex p-0 m-0 mt-3 mb-3">
                                    <div class="row m-0 p-0">
                                        <div class="col-12 m-0 p-0">                                            
                                            <a href="#?<?= $band->id ?>" class="linkResearch"><img src="../../assets/img/bandPictures/avatars/<?= ($band->bandPicture != ' ') ? $band->bandPicture : 'icoUser.png' ?>" class="rounded-circle" width="70" height="70" /></a>
                                        </div>
                                    </div>
                                    <div class="row p-0 m-0">
                                        <div class="col-12 p-0 pl-1 m-0">         
                                            <a href="#?<?= $band->id ?>" class="linkResearch"><h1><?= $band->bandName ?></h1></a>
                                            <p>Présentation: <?= $band->bandDescription ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
//          Affichage du résultat si l'utilisateur recherche des entreprises
            } else if ($_POST['userResearch'] == 'Professionnel') {
                ?>
                <div class="row">
                    <div class="titleResearch offset-4 col-4 p-0 pt-1">
                        <div class="row p-0 m-0">
                            <div class="col-12 text-center p-0 m-0">
                                <h1 class="musicianResearchTitle">Entreprise qui recrutent</h1>
                            </div>
                        </div>
                    </div>
                </div>
        <?php foreach ($showAllCompany as $company) {
            ?>
                    <div class="row">
                        <div class="blockResearch offset-1 col-10 p-0 pt-1">
                            <div class="row m-0 p-0">
                                <div class="col-12 d-flex m-0 p-0 pl-2 mt-3 mb-3">
                                    <div class="row m-0 p-0">
                                        <div class="col-12 m-0 p-0">               
                                            <a href="#?<?= $company->id ?>" class="linkResearch"><img src="../../assets/img/proPictures/avatars/<?= ($company->companyPicture != ' ') ? $company->companyPicture : 'icoUser.png' ?>" class="rounded-circle" width="70" height="70" /></a>                                                                                 
                                        </div>
                                    </div>
                                    <div class="row m-0 p-0 pl-3">
                                        <div class="col-12 m-0 p-0">
                                            <a href="#?<?= $company->id ?>" class="linkResearch"><h1><?= $company->companyName ?></h1></a>
                                            <p><span class="placeCompany">Lieu: <?= $company->city ?> (<?= $company->postalCode ?>)</span><br />
            <?= $company->address ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../../assets/js/profile.js"></script>
</body>
</html>