<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <link rel="stylesheet" href="assets/css/header.css" />
        <link rel="stylesheet" href="assets/css/footer.css" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <?php include 'includeFilesPhp/header.php'; ?>
                <section class="col-12">
                    <!--Section carousel pour exposer des réponses aux besoins de chaque utilisateurs
                    Le but étant de les rediriger soit vers la map de l'application, soit sur un formulaire d'inscription pour la version titre pro
                    Une bannière pour la publicité sera réservée pour la version finale-->
                    <aside id="carousel" class="carousel slide full-width" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel" data-slide-to="1" class="active"></li>
                            <li data-target="#carousel" data-slide-to="2" class="active"></li>
                            <li data-target="#carousel" data-slide-to="3" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                            <!--Slide proposant un lien de l'application sans avoir besoin de s'inscrire, disponible à tous, première slide par défaut-->
                            <div class="carousel-item active"><img class="d-block w-100" src="assets/img/mapCarousel.png" alt="first slide" width="100%" height="300" />
                                <div id="textmap" class="carousel-caption"><p class="carouselText">Envie d'un concert ?<br /><a href="#" id="atextmap">Je consulte la carte !</a></p></div>
                            </div>
                            <!--Slide proposant aux internautes recherchant une inscription pour suivre leur groupe préféré une inscription-->
                            <div class="carousel-item"><img class="d-block w-100" src="assets/img/proCarousel.jpg" alt="second slide" width="100%" height="300" />
                                <div id="textpro" class="carousel-caption"><p class="carouselText">Vous recherchez des musiciens pour assurer vos soirées ?<br /><a href="secondPage/" id="atextpro">inscrivez-vous et trouvez le groupe idéal !</a></p></div>
                            </div>
                            <!--Slide proposant aux groupes de musiques ou artistes en solo de s'inscrire pour trouver des dates plus facilement-->
                            <div class="carousel-item" ><img class="d-block w-100" src="assets/img/musicienCarousel.jpeg" alt="third slide" width="100%" height="300" />
                                <div id="textmusicien" class="carousel-caption"><p class="carouselText">Faites-vous connaître et trouvez des dates de concerts<br /><a href="#form_groupe_hptxt" id="atextmusicien">Commencez votre tournée !</a></p></div>
                            </div>
                            <!--Slide proposant aux gérants de bars, organisateurs de festival ou autre de rechercher des musiciens pour leur soirée-->
                            <div class="carousel-item"><img class="d-block w-100" src="assets/img/publicCarousel.jpg" alt="fourth slide" width="100%" height="300" />
                                <div id="textpublic" class="carousel-caption"><p class="carouselText">Vous pouvez suivre vos groupes préférés dans leurs représentations<br /><a href="#form_public_hptxt" id="atextpublic">Il suffit de vous inscrire !</a></p></div>
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
                    <!--Sélection Pour l'inscription-->
                    <aside id="choices">
                        <h1 id="research">Je recherche</h1>
                        <div id="status" class="col-12">
                            <!--Nouvelle ligne bootstrap pour gérer l'affichage des rond bleus pour l'inscription
                            qui seront alignés pour les grans écrans et en colone pour les petits écran de type smartphone-->
                            <div class="row">
                                <!--Lien pour inscription d'un utilisateur public-->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <a href="secondPage/signPage.php"><img src="assets/img/partyResearch.png" alt="Je recherche une soirée" class="research" /></a>
                                </div>
                                <!--Lien pour inscription d'un utilisateur professionnel de type bar ou festival-->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">                
                                    <a href="#form_pro_hptxt"><img src="assets/img/groupResearch.png" alt="Je recherche un groupe de musique" class="research" /></a>
                                </div>
                                <!--Lien inscription d'un utilisateur de type groupe de musique-->
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <a href="#form_groupe_hptxt"><img src="assets/img/concertResearch.png" alt="Je recherche une date de concert" class="research" /></a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </section>
                <?php include'includeFilesPhp/footer.php'; ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="assets/jq/JQLab.js"></script>
    </body>
</html>
