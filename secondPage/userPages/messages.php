<?php
session_start();
include'../../config.php';
include'../../controllers/connectCtrl.php';
include'../../controllers/messagesCtrl.php';
include'../../controllers/navCtrl.php';
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />  
        <link href="https://fonts.googleapis.com/css?family=Rationale" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
            <section>
                <div class="row">
                    <div id="messageBlockOptions" class="borderBlock mt-3 offset-xl-1 offset-lg-1 offset-md-1 offset-sm-1 col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-12">
                        <div id="selectButtons" class="messageBlockSelect mt-3 mb-3 pt-3 pb-1">
                            <div class="row p-0 m-0">
                                <!--section selection/option de la messagerie-->
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                    <ul class="listMessageSelect p-0 ml-2">
                                        <a href="messages.php" class="linkMessages"><li class="li pl-2 pr-5" id="newMessage">Nouveau message</li></a>
                                        <a href="#" class="linkMessages"><li class="li pl-2 pr-5" id="reception">Boite de réception <span class="red">(<?= $numberOfUnreadenMessages ?>)</span></li></a>
                                        <a href="#" class="linkMessages"><li class="li pl-2 pr-5" id="messageSent">Messages envoyés</li></a>
                                    </ul>
                                </div>
                                <!--Section messages envoyés-->
                                <div id="messagesSentBox" class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 p-0 m-0 ml-xl-5 m-1">
                                    <h1 class="text-center">Messages envoyés</h1>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <button type="submit" name="deleteAllSent" class="btn btn-secondary mb-2">Tout supprimer</button>
                                        <button type="submit" name="DeleteSelectionSent" class="btn btn-secondary mb-2">Supprimer la sélection</button>
                                        <?= (isset($errorList['deleteAllSent'])) ? '<p class="validateRemove red">' . $errorList['deleteAllSent'] . '</p>' : ' ' ?>
                                        <?= (isset($errorList['DeleteSelectionSent'])) ? '<p class="validateRemove red">' . $errorList['DeleteSelectionSent'] . '</p>' : ' ' ?>
                                        <?= (isset($success['DeleteSelectionSent'])) ? '<p class="validateRemove green">' . $success['DeleteSelectionSent'] . '</p>' : ' ' ?>
                                        <?= (isset($success['deleteAllSent'])) ? '<p class="validateRemove green">' . $success['deleteAllSent'] . '</p>' : ' ' ?>
                                        <div class="row messages">
                                            <div class="col-12">
                                                <!--Condition pour gérer si l'utilisateur a envoyé ou non des messages à d'autres utilisateurs-->
                                                <?php if ($countSent == 0) { ?>
                                                    <p>Votre boite d'envoi est vide !</p>
                                                <?php } else { ?>
                                                    <!--Si c'est le cas, on utilise foreach pour afficher tout les messages-->
                                                    <?php foreach ($messagesSent as $messagesISent) { ?>
                                                        <div class="row border mt-3">
                                                            <div class="col-12 d-flex">
                                                                <div class="col-1 pt-3">
                                                                    <input name="removeMessage[]" type="checkbox" value="<?= $messagesISent->id ?>">
                                                                </div>
                                                                <a href="messages.php?idSent=<?= $messagesISent->id ?>" class="col-8 linkMessages mt-3">
                                                                    <h2>Envoyé à <?= $messagesISent->pseudo ?></h2>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <p>Le <?= $messagesISent->date ?> à <?= $messagesISent->hour ?> ~ <?= $messagesISent->title ?></p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="col-2 mb-3">
                                                                    <form action="#" method="POST">
                                                                        <!--On récupère en hidden l'id du message à supprimer-->
                                                                        <input type="hidden" name="idToRemove" value="<?= $messagesISent->id ?>" />
                                                                        <!--Boutton de validation qui supprime le message-->
                                                                        <button type="submit" name="submitRemoveMessageSent" title="Supprimer" class="pr-1 pl-1 mt-3" id="removeMessage"><i class="fas fa-times fa-2x"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                </div>
                                <!--Section boite de réception-->
                                <div id="receptionBox" class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 p-0 m-0 ml-xl-5 m-1">
                                    <h1 class="text-center">Boite de réception</h1>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <button type="submit" name="deleteAllReceived" class="btn btn-secondary">Tout supprimer</button>
                                        <button type="submit" name="deleteSelectionReceived" class="btn btn-secondary">Supprimer la sélection</button>
                                        <?= (isset($errorList['deleteAllReceived'])) ? '<p class="validateRemove red">' . $errorList['deleteAllReceived'] . '</p>' : ' ' ?>
                                        <?= (isset($errorList['deleteSelectionReceived'])) ? '<p class="validateRemove red">' . $errorList['deleteSelectionReceived'] . '</p>' : ' ' ?>
                                        <?= (isset($success['deleteSelectionReceived'])) ? '<p class="validateRemove green">' . $success['deleteSelectionReceived'] . '</p>' : ' ' ?>
                                        <?= (isset($success['deleteAllReceived'])) ? '<p class="validateRemove green">' . $success['deleteAllReceived'] . '</p>' : ' ' ?>
                                        <div class="row messages">
                                            <div class="col-12">
                                                <!--Condition pour connaître si l'utilisateur a reçu des messages de la part d'autres utilisateur-->
                                                <?php if ($numberOfMessages == 0) { ?>
                                                    <p>Votre boite de réception est vide</p>
                                                <?php } else { ?>
                                                    <!--Si c'est le cas, on les affiche tous avec un foreach-->
                                                    <?php foreach ($myMessages as $messages) { ?>
                                                        <div class="row <?= ($messages->readen == 0) ? 'border border-danger' : 'border' ?> mt-3">
                                                            <div class="col-12 d-flex">
                                                                <div class="col-2 mt-4">
                                                                    <input name="removeMessageReceived[]" type="checkbox" value="<?= $messages->id ?>">
                                                                </div>
                                                                <a href="messages.php?idReceived=<?= $messages->id ?>" class="messageReading col-8 pt-3 mt-1" idMessage="<?= $messages->id ?>">
                                                                    <h2><?= $messages->pseudo ?></h2>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <p>Le <?= $messages->date ?> à <?= $messages->hour ?> ~ <?= $messages->title ?></p>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="col-2 pl-xl-5  mt-4">
                                                                    <form action="messages.php" method="POST">
                                                                        <!--On récupère en hidden l'id du message à supprimer-->
                                                                        <input type="hidden" name="idToRemove" value="<?= $messages->id ?>" />
                                                                        <!--Boutton de validation qui supprime le message-->
                                                                        <button type="submit" name="submitRemoveMessageReceived" title="Supprimer" class="pr-1 pl-1 mb-2" id="removeMessage"><i class="fas fa-times fa-2x"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--Block d'affichage du message sélectionné, soit depuis la boite de réception, soit depuis les messages envoyés-->
                        <?php if ((isset($_GET['idSent']) && isset($successSentUrl) && $countSent != 0) || (isset($_GET['idReceived']) && isset($successReceivedUrl) && $numberOfMessages != 0)) { ?>
                            <div id="messageSelected" class="messageBlockSelect row p-3 mt-3 mb-3 pt-3 pb-1">
                                <div class="col-12">
                                    <h1><span class="bold"><?= $messageUrl->pseudo ?></span>: <?= $messageUrl->title ?></h1>
                                    <div class="row border">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-8 col-xs-12">
                                            <p>le <?= $dateUrl ?> à <?= $messageUrl->hour ?><br />
                                            <?= $messageUrl->content ?></p>
                                        </div>
                                        <?php if (isset($_GET['idSent'])) { ?>
                                            <!--Gestion des bouttons au message sélectionné depuis les messages envoyés-->
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center d-flex black">
                                                <form action="messages.php" method="POST">
                                                    <!--On récupère en hidden les informations du l'utilisateur à qui on souhaite renvoyer le mail-->
                                                    <input type="hidden" name="idUser" value="<?= $messageUrl->id_15968k4_users ?>" />
                                                    <input type="hidden" name="title" value="<?= $messageUrl->title ?>" />
                                                    <input type="hidden" name="content" value="<?= $messageUrl->content ?>" />
                                                    <input type="hidden" name="idToRemove" value="<?= $messageUrl->id ?>" />
                                                    <!--Boutton de validation qui renvoi le message-->
                                                    <button type="submit" name="reSendMessageSubmit" title="Renvoyer" class="mt-2" id="reSendButton"><i class="fas fa-envelope-square fa-2x"></i></button>
                                                    <!--Boutton de validation qui supprime le message-->
                                                    <button type="submit" name="submitRemoveMessageSent" title="Supprimer" class="mt-2" id="removeMessage"><i class="fas fa-times fa-2x"></i></button>
                                                </form>
                                            </div>
                                            <?php
                                        }
                                        if (isset($_GET['idReceived'])) {
                                            ?>
                                            <!--Gestion des boutton au message sélectionné depuis la boite de réception-->
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center d-flex text-center black">
                                                <div class="mt-2">
                                                <button type="submit" name="submitMessageAnswer" title="Répondre" id="answerMessage"><i class="fas fa-envelope-square fa-2x"></i></button>
                                                </div>
                                                <form action="messages.php" method="POST">
                                                    <input type="hidden" name="idToRemove" value="<?= $messageUrl->id ?>" />
                                                    <!--Boutton de validation qui supprime le message-->
                                                    <button type="submit" name="submitRemoveMessageReceived" title="Supprimer" class="mt-2" id="removeMessage"><i class="fas fa-times fa-2x"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <!--Liste des erreurs ou réussite de formulaire possible à afficher en dessous du block-->
                                        <p class="red pValidation"><?= (isset($errorList['idUsers'])) ? $errorList['idUsers'] : '' ?></p>
                                        <p class="red pValidation"><?= (isset($errorList['title'])) ? $errorList['title'] : '' ?></p>
                                        <p class="red pValidation"><?= (isset($errorList['content'])) ? $errorList['content'] : '' ?></p>
                                        <p class="red pValidation"><?= (isset($errorList['reSendMessageSubmit'])) ? $errorList['reSendMessageSubmit'] : '' ?></p>
                                        <p class="green pValidation"><?= (isset($success['reSendMessageSubmit'])) ? $success['reSendMessageSubmit'] : '' ?></p>
                                    </div>
                                </div>
                                <!--Block de réponse au message sélectionné-->
                                <div id="messageAnswer" class="messageBlockSelect row p-3 mt-3 mb-3 pt-3 pb-1">
                                    <div class="col-12">
                                        <form action="#" method="POST" class="form-group col-12">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h1>Réponse au message de <span class="bold"><?= $messageUrl->pseudo ?></span></h1>
                                                        <!--Liste des erreurs ou réussite de formulaire possible à afficher en dessous du titre du block-->
                                                        <p class="red pValidation"><?= (isset($errorList['receiver'])) ? $errorList['receiver'] : '' ?></p>
                                                        <p class="red pValidation"><?= (isset($errorList['titleOfNewMessage'])) ? $errorList['titleOfNewMessage'] : '' ?></p>
                                                        <p class="red pValidation"><?= (isset($errorList['newMessage'])) ? $errorList['newMessage'] : '' ?></p>
                                                        <p class="red pValidation"><?= (isset($errorList['sendMessageSubmit'])) ? $errorList['sendMessageSubmit'] : '' ?></p>
                                                        <p class="green pValidation"><?= (isset($success['sendMessageSubmit'])) ? $success['sendMessageSubmit'] : '' ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-2">
                                                    <!--Champs du destinataire du message-->
                                                    <input type="text" name="receiver" class="form-control col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-6" value="<?= $messageUrl->pseudo ?>" placeholder="destinataire" />
                                                    <!--input en hidden pour récupérer l'id du destinataire-->
                                                    <input type="hidden" name="idReceiver" class="form-control col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-6" value="<?= $messageUrl->id_15968k4_users ?>" placeholder="destinataire" />
                                                    <!--Champs de objet du message-->
                                                    <input type="text" name="titleOfNewMessage" class="form-control" placeholder="titre de votre message" />
                                                    <!--Champs d'écriture du contenu du message-->
                                                    <textarea name="newMessage" class="form-control" placeholder="Bonjour,..."></textarea>
                                                </div>
                                                <!--Boutton de validation qui envoi le message (Réponse au message sélectionné)-->
                                                <input type="submit" name="sendMessageSubmit" class="float-right mt-1 mr-3" value="envoyer message" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <!--Block de nouveau message-->
                            <div id="newMessageBlock" class="messageBlockSelect row p-3 mt-3 mb-3 pt-3 pb-1">
                                <form action="#" method="POST" class="form-group col-12">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <h1>Nouveau message</h1>
                                                <!--Liste des erreurs ou réussite de formulaire possible à afficher sous le titre du block-->
                                                <p class="red pValidation"><?= (isset($errorList['receiver'])) ? $errorList['receiver'] : '' ?></p>
                                                <p class="red pValidation"><?= (isset($errorList['titleOfNewMessage'])) ? $errorList['titleOfNewMessage'] : '' ?></p>
                                                <p class="red pValidation"><?= (isset($errorList['newMessage'])) ? $errorList['newMessage'] : '' ?></p>
                                                <p class="red pValidation"><?= (isset($errorList['sendMessageSubmit'])) ? $errorList['sendMessageSubmit'] : '' ?></p>
                                                <p class="green pValidation"><?= (isset($success['sendMessageSubmit'])) ? $success['sendMessageSubmit'] : '' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12 p-2">
                                            <!--Champs du destinataire-->
                                            <input type="text" name="receiver" class="form-control col-xl-2 col-lg-2 col-md-4 col-sm-4 col-xs-6" placeholder="destinataire" />
                                            <!--Champs de l'objet du message-->
                                            <input type="text" name="titleOfNewMessage" class="form-control" placeholder="titre de votre message" />
                                            <!--Champs textarea pour y écrire le contenu du message-->
                                            <textarea name="newMessage" class="form-control" placeholder="Bonjour,..."></textarea>
                                        </div>
                                        <!--Boutton de validation qui envoi le message-->
                                        <input type="submit" name="sendMessageSubmit" class="float-right mt-1 mr-3" value="envoyer message" />
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
            </section>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="../../assets/js/messages.js"></script>
        <script src="../../assets/js/nav.js"></script>
    </body>
</html>