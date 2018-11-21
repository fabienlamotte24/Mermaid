<?php
include_once'config.php';
include_once'controllers/connectCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" />       
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rationale" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <div class="container-fluid">
            <header>
                <!--Ligne du logo Mermaid-->
                <div class="homeBlock text-center">
                    <h1 class="homeTitle m-0 p-0"><a href="index.php" id="logo">Mermaid</a></h1>
                </div>
                <!--Block de selection entre inscription et connexion-->
                <div class="welcome row">
                    <a href="#" id="signHome" class="col-6 text-right p-4">
                        <div>
                            <!--Cliquer sur le lien de INSCRIPTION affichera la div signBlock-->
                            <h1 class="titleWelcome">INSCRIPTION</h1>
                        </div>
                    </a>
                    <a href="#" id="connectHome" class="col-6 text-left p-4">
                        <div>
                            <!--Cliquer sur le lien de CONNEXION affichera la div connectBlock-->
                            <h1 class="titleWelcome">CONNEXION</h1>
                        </div>
                    </a>
                </div>
                <!--Section connectBlock, qui affiche les champs identifiant, mot de passe et le bouton de connexion-->
                <div class="connectBlock pt-3 col-12 ">
                    <form id="connectForm" method="POST" class="text-center offset-xl-4 offset-lg-4 offset-md-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12" action="#">
                        <!--Section d'Identifiant de l'utilisateur-->
                        <div id="user" class="col-12">
                            <img src="../assets/img/icoUser.png" id="icoUser" title="icone identifiant" alt="icone identifiant" />
                            <input type="text" name="pseudoConnect" id="pseudoConnect" placeholder="Identifiant" maxlength="30" style="border: hidden; border: 0" />
                            <abbr><a href="forget.php?forget=login" class="forgot">Oublié ?</a></abbr>
                        </div>
                        <!--Section de Mot de passe de l'utilisateur-->
                        <div id="Pass" class="col-12">
                            <img src="../assets/img/icoPass.png" id="icoPass" title="icone Mot de passe" alt="icone Mot de passe" />
                            <input type="password" name="passConnect" id="passConnect" placeholder="Mot de passe" maxlength="30" style="border: hidden; border: 0" />
                            <abbr><a href="forget.php?forget=pass" class="forgot">Oublié ?</a></abbr>
                        </div>
                        <!--Section de Validation d'entrée de login et de mot de passe pour accéder au site-->
                        <div id="connexion" class="col-12">
                            <input type="submit" name="connexion" value="connexion" />
                        </div>
                    </form>
                    <!--Ligne de retour en arrière-->
                    <div class="row">
                        <div class="col-12 text-center pt-2 pb-0 mb-0">
                            <i class="fas fa-chevron-circle-up fa-2x backHome"></i>
                        </div>
                    </div>
                </div>
                <!--Cette ligne apparaîtra si la connexion a échoué, elle gère les erreurs-->
                <?php if (isset($errorConnectList['pseudoConnect']) || isset($errorConnectList['passConnect']) || isset($errorConnectList['connexion'])) { ?>
                    <div class="row errorConnect">
                        <div class="col-12 text-center">
                            <p><?= (isset($errorConnectList['pseudoConnect']))? $errorConnectList['pseudoConnect'] : ' ' ?></p>
                            <p><?= (isset($errorConnectList['passConnect']))? $errorConnectList['passConnect'] : ' ' ?></p>
                            <p><?= (isset($errorConnectList['connexion']))? $errorConnectList['connexion'] : ' '?></p>
                        </div>
                    </div>
                <?php } ?>
                <!--Section signBlock, qui affiche les trois types de formulaire possible pour chaque type d'utilisateur-->
                <div class="signBlock">
                    <div class="row p-0 m-0">
                        <div class="col-12 text-center">
                            <h1 class="iAm">Je suis...</h1>
                        </div>
                    </div>
                    <div class="row">
                        <!--Ligne de choix "festivalier(Public)"-->
                        <div class="col-4 text-center mt-2">
                            <a href="publicRegister.php" class="icoLink">
                                <img src="assets/img/public.png" title="Je suis un festivalier" alt="Je suis un festivalier" width="70" height="70" class="rounded-circle" />
                                <h2>Un festivalier</h2>
                                <p class="sentence font-italic">-- Je recherche un concert pour passer -- <br />-- une bonne soirée--</p>
                            </a>
                        </div>
                        <!--Ligne de choix "chef d'établissement(Pro)"-->
                        <div class="col-4 text-center mt-2">
                            <a href="proRegister.php" class="icoLink">
                                <img src="assets/img/bar.png" title="Je suis un chef d'établissement" alt="Je suis un chef d'établissement" width="70" height="70" class="rounded-circle" />
                                <h2>Un chef d'établissement</h2>
                                <p class="sentence font-italic">-- Je recherche un groupe de musique --</p>
                            </a>
                        </div>
                        <!--Ligne de choix "Musicien(Musician)"-->
                        <div class="col-4 text-center mt-2" >
                            <a href="musicianRegister.php" class="icoLink">
                                <img src="assets/img/guitare.png" title="Je suis un musicien" alt="Je suis un musicien" width="70" height="70" class="rounded-circle" />
                                <h2>Un musicien</h2>
                                <p class="sentence font-italic">-- Je recherche une date de concert --</p>
                            </a>
                        </div>
                    </div>
                    <!--Ligne de retour en arrière-->
                    <div class="row">
                        <div class="col-12 text-center pt-2 pb-0 mb-0">
                            <i class="fas fa-chevron-circle-up fa-2x backHome"></i>
                        </div>
                    </div>
                </div>
            </header>
            <section class="offset-xl-2 offset-lg-2 offset-md-2 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <!--Carousel de présentation du site-->
                <aside id="carousel" class="carousel slide full-width mt-5" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel" data-slide-to="1" class="active"></li>
                        <li data-target="#carousel" data-slide-to="2" class="active"></li>
                    </ol>
                    <div class="carousel-inner">
                        <!--Slide proposant aux internautes recherchant une inscription pour suivre leur groupe préféré une inscription-->
                        <div class="carousel-item active"><img class="d-block w-100" src="assets/img/proCarousel.jpg" alt="second slide" width="100%" height="300" />
                            <div id="textpro" class="carousel-caption"><p class="carouselText">Vous recherchez des musiciens pour assurer vos soirées ?<br /><a href="proRegister.php" id="atextpro">inscrivez-vous et trouvez le groupe idéal !</a></p></div>
                        </div>
                        <!--Slide proposant aux groupes de musiques ou artistes en solo de s'inscrire pour trouver des dates plus facilement-->
                        <div class="carousel-item" ><img class="d-block w-100" src="assets/img/musicienCarousel.jpeg" alt="third slide" width="100%" height="300" />
                            <div id="textmusicien" class="carousel-caption"><p class="carouselText">Faites-vous connaître et trouvez des dates de concerts<br /><a href="musicianRegister.php" id="atextmusicien">Commencez votre tournée !</a></p></div>
                        </div>
                        <!--Slide proposant aux gérants de bars, organisateurs de festival ou autre de rechercher des musiciens pour leur soirée-->
                        <div class="carousel-item"><img class="d-block w-100" src="assets/img/publicCarousel.jpg" alt="fourth slide" width="100%" height="300" />
                            <div id="textpublic" class="carousel-caption"><p class="carouselText">Vous pouvez suivre vos groupes préférés dans leurs représentations<br /><a href="publicRegister.php" id="atextpublic">Il suffit de vous inscrire !</a></p></div>
                        </div>
                    </div>
                    <!--Section pour les flêches permettant de passer d'une slide à une autre-->
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </aside>
            </section>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/home.js"></script>
</body>
</html>
