<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link rel="stylesheet" href="../assets/css/styleForget.css" />
        <link rel="stylesheet" href="../assets/css/header.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!--Incorporation de l'En-tête grâce à header.php-->
                <?php include_once 'includeFilesPhp/header.php'; ?>
                <?php if (!isset($_GET['forget'])) { ?>
                    <section id="selectForget" class="offset-xl-3 col-xl-6 offset-lg-3 col-lg-6 offset-md-3 col-md-6 offset-sm-1 col-sm-9 offset-xs-1 col-xs-9">
                        <h1>Information de compte</h1>
                        <p>Auriez-vous oublié...</p>
                        <hr>
                        <div class="row text-center">
                            <div class="divloginForget col-6">
                                <a href="forget.php?forget=login" class="linkForget text-center">
                                    Votre identifiant ?
                                </a>
                            </div>
                            <div class="col-6 passForget">
                                <a href="forget.php?forget=pass" class="linkForget">
                                    Votre mot de passe ?
                                </a>
                            </div>
                        </div>
                    </section>
                <?php } ?>
                <?php if (isset($_GET['forget']) && ($_GET['forget'] == 'login')) { ?>
                    <section id="userForgetForm" class="offset-xl-3 col-xl-6 offset-lg-3 col-lg-6 offset-md-3 col-md-6 offset-sm-1 col-sm-9 offset-xs-1 col-xs-9">
                        <h1>Récupération de votre identifiant de compte</h1>
                        <hr>
                        <!--Formulaire Pour une récupération d'identifiant-->
                        <form method="POST" action="#" class="form-group">
                            <div class="offset-2 col-8">
                                <!--Champs demandant l'adresse mail de l'utilisateur pour lui envoyer par mail son identifiant-->
                                <label for="email">Votre adresse mail:</label>
                                <input type="email" name="email" id="email" class="form-control justify-content-center" placeholder="mermaid@outlook.fr" />
                            </div>
                            <p>Vous recevrez un mail contenant votre identifiant</p>
                            <hr>
                            <!--Boutton permettant d'envoyer le mail à l'utilisateur si l'adresse mail existe-->
                            <input type="submit" name="submit" class="button" value="Envoyer moi mon identifiant !" />
                        </form>
                    </section>
                    <?php
                }
                if (isset($_GET['forget']) && ($_GET['forget'] == 'pass')) { ?>
                    <section id="passForgetForm"class="offset-xl-3 col-xl-6 offset-lg-3 col-lg-6 offset-md-3 col-md-6 offset-sm-1 col-sm-9 offset-xs-1 col-xs-9">
                        <h1>Récupération de votre Mot de passe</h1>
                        <hr>
                        <!--Formulaire pour une récupération de mot de passe-->
                        <form method="POST" action="#" class="form-group">
                            <div class="offset-2 col-8">
                                <!--Champs d'email pour envoyer un mail de modification de mot de passe-->
                                <label for="email">Votre adresse mail: </label>
                                <input type="email" id="email" class="form-control justify-content-center" name="email" placeholder="mermaid@outlook.fr" />
                            </div>
                            <p>Vous recevrez un mail de modification de mot de passe</p>
                            <hr>
                            <!--Boutton submit pour envoyer un mail à l'utilisateur si l'adresse mail existe-->
                            <input type="submit" name="submit" value="Envoyez moi un message !" id="passMailRescue" name="passMailRescue" />
                        </form>
                    </section>
                <?php } ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="../assets/jq/JQLab.js"></script>
    </body>
</html>