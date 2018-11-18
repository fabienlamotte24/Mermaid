<?php
session_start();
include'../../config.php';
include'../../controllers/messagesCtrl.php';
include'../../controllers/connectCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
        <link rel="stylesheet" href="../../assets/css/navOnline.css" />
        <link rel="stylesheet" href="../../assets/css/messages.css" />
        <title>Mermaid</title>
    </head>
    <body>
        <div class="container-fluid">
            <header class="row">
                <?php include'../navOnline.php' ?>
            </header>
            <section class="row">
                <div id="messageBlockOptions" class="borderBlock mt-3 offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-3 col-lg-3 col-md-3 col-sm-10 col-xs-12">
                    <div id="selectButtons" class="messageBlockSelect mt-3 mb-3 pt-3 pb-1">
                        <h1 class="text-center">Messagerie</h1>
                        <ul class="listMessageSelect pl-3 pr-3">
                            <li class="pl-2" id="reception">Boite de réception (<?= $numberOfMessages ?>)</li>
                            <li class="pl-2" id="messageSend">Messages envoyés</li>
                            <li class="pl-2" id="newMessage">Nouveau message</li>
                        </ul>
                    </div>
                </div>
                <div id="messageBlockSelect" class="borderBlock mt-3 offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-6 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <div id="selectButtons" class="messageBlockSelect mt-3 mb-3 pt-3 pb-1">
                        <h1 class="text-center">Boite de réception</h1>
                        <div class="row messages">
                            <div class="col-12">
                                <?php if ($numberOfMessages == 0) { ?>
                                    <p>Vous n'avez pas encore reçus de message</p>
                                <?php
                                } else { ?>
                                    <?php foreach ($myMessages as $messages) { ?>
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2>Message de <?=$messages->pseudo?></h2>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <p>Le <?=$messages->date?> à <?=$messages->hour?> ~ <?=$messages->title?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/options.js"></script>
    </body>
</html>