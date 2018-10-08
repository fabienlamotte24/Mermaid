<?php include '../controller/emailValidating.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/header.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <title>Mermaid</title>
  </head>
  <body>
    <!--Page de multi-formulaire: Public, Professionnel, et Musiciens-->
    <div class="container-fluid">
      <div class="row">
          <!--Incorporation de l'En-tête grâce à header.php-->
          <?php include '../includeFilesPhp/header.php'; ?>
          <section>
              <!--Formulaire public: Ceux qui recherche une soirée autour de chez eux-->
              <div class="col-12">
                <form method="POST" action="#" id="publicForm" class="form-group">
                    <label for="pseudo">Votre pseudo</label>
                      <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="pseudonyme" />
                </form>
              </div>
          </section>
          <!--Incorporation du footer contenant les liens d'aide à la compréhension de l'utilisation du site-->
          <?php include'../includeFilesPhp/footer.php';?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="../assets/jq/JQLab.js"></script>
  </body>
</html>
