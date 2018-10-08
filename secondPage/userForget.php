<?php include '../controller/emailValidating.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styleForget.css" />
    <link rel="stylesheet" href="../assets/css/header.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <title>Mermaid</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
          <!--Incorporation de l'En-tête grâce à header.php-->
          <?php include '../includeFilesPhp/header.php'; ?>
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
          <!--Incorporation du footer, contenant les liens d'aide à la compréhension de l'utilisation du site-->
          <?php include'../includeFilesPhp/footer.php'; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="../assets/jq/JQLab.js"></script>
  </body>
</html>
