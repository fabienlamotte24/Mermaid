<?php include '../controller/emailValidating.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <title>Mermaid</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/css/header.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <link rel="stylesheet" href="../assets/css/stylePresentation.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
          <!--Incorporation de l'En-tête grâce à header.php-->
          <?php include '../includeFilesPhp/header.php'; ?>
          <section class="offset-xl-1 offset-lg-1 offset-md-1 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
            <div id="publicPresent" class="col-12 d-flex justify-content-center">
                <div class="textPresent col-12">
                    <h1>Mermaid, le site phare des amoureux de la musique !</h1>
                    <p><span class="aboard">All aboard !</span><br />
                    Un site pour vous retrouver autour d'un bon concert, pour le plaisir de la rencontre et la découverte de nouveaux groupes Français et d'autres origines dans le secteur géographique de votre choix !<br />
                    Soutenez-les à travers leur tournée, notez les ou profitez simplement d'un moment de convivialité intense auprès d'inconnus ou de vos amis !</p>
                </div>
            </div>
              <hr>
            <div id="musicianPresent" class="col-12 d-flex justify-content-center">
                <div class="textPresent col-12">
                    <h1>Vivre de sa passion !</h1>
                    <p>Mermaid souhaite réaliser avec vous le rêve de chacun: vivre de sa passion !<br />
                    C'est l'un des objectifs premiers de notre projet. Animez votre public, partagez votre contenu, trouvez des dates et organisez vos tournées !</p>
                </div>
            </div>
          </section>
          <!--Incorporation du footer, contenant les liens d'aide à la compréhension du site-->
          <?php include '../includeFilesPhp/footer.php'; ?>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="../assets/jq/JQLab.js"></script>
  </body>
</html>
