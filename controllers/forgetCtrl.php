<?php
//Listing des tableaux destinées aux erreurs et validation de formulaire
$errorList = array();
$success = array();
//==============================================================Gestion du changement de mot de passe=======================================
//regex de mot de passe
$regPass = '/^[A-Za-z0-9çôîûêéèçà\-\'#@&!%$*]+$/';
//Initialisation de valeur
$pass1 = '';
$pass2 = '';
//Condition lorsque l'on appuie sur le bouton de validation
if (isset($_POST['submitPassModify'])) {
    //Si le premier champs n'est pas vide
    if (!empty($_POST['password'])) {
        //...On vérifie sa validité
        if (preg_match($regPass, $_POST['password'])) {
            //On stock la valeur dans la variable dans $pass1
            $pass1 = htmlspecialchars($_POST['password']);
        } else {
            //...Sinon erreur de validité
            $errorList['password'] = 'Veuillez entrer un mot de passe valide';
        }
    } else {
        //...Sinon erreur d'entrée de valeur
        $errorList['password'] = 'Veuillez écrire un mot de passe';
    }
    //Si le second champs n'est pas vide
    if (!empty($_POST['passwordVerify'])) {
        //On stock la valeur dans la variable $pas2
        $pass2 = htmlspecialchars($_POST['passwordVerify']);
    } else {
        //...Sinon erreur d'entrée de valeur
        $errorList['passwordVerify'] = 'Veuillez écrire un mot de passe';
    }
    //S'il n'y a pas d'erreur dans le formulaire
    if (count($errorList) == 0) {
        //...On vérifie que les deux variables ont la même valeur
        if ($pass1 == $pass2) {
            //...On instancie l'objet users, en utilisant la méthode de changement de mot de passe
            $changePass = NEW users();
            //On donne a l'attribut "id" de l'objet le parametre d'url id
            $changePass->id = $_GET['id'];
            //On donne a l'attribut "password" de l'objet la valeur de la variable $pass1 en le hashant
            $changePass->password = password_hash($pass1, PASSWORD_DEFAULT);
            //...Si la requête aboutie
            if ($changePass->changePass()) {
                //...On affiche un message de validation réussie
                $success['submitPassModify'] = 'Mot de passe changé avec succès !';
            } else {
                //...Sinon erreur de requête
                $errorList['submitPassModify'] = 'Le changement de mot de passe a échoué';
            }
        } else {
            //...Sinon erreur de correspondance de mot de passe
            $errorList['submitPassModify'] = 'Les mots de passe ne sont pas identique';
        }
    } else {
        //...Sinon erreur d'entrée de valeur
        $errorList['submitPassModify'] = 'Un ou deux des champs ne sont pas remplis !';
    }
}
//===============================================================Gestion lorsque l'on oublie son identifiant===============================
//Initialisation de la variable
$mail = '';
$subject = '';
$mailSender = '';
//Création du mail 
$messageToSend = '';
$message_txt = '';
$message_html = '';
//Si on appuie sur le boutton de validation
if (isset($_POST['submitUserSearch'])) {
    //Si le champs n'est pas vide
    if (!empty($_POST['email'])) {
        //...On instancie l'objet user, avec une methode permettant de voir si l'adresse existe dans la base de donnée
        $email = NEW users();
        //On donne la valeur du champ à une variable $mail
        $mail = $_POST['email'];
        //...On donne à l'attribut de l'objet user la valeur du champs rentré
        $email->mail = $mail;
        //On utilise la méthode notSameEmail(), cette fois dans le but de vérifier si l'adresse email existe bien dans la base de donnée
        $check = $email->notSameEmail();
        //Si l'adresse existe en base de donnée
        if ($check == 1) {
            //...On instancie l'objet users, avec une methode servant à retrouver l'identifiant de l'utilisateur suivant l'adresse mail qu'il a rentré
            $findUser = NEW users();
            //On attribue a valeur de la variable $mail à l'attribut de l'objet "mail"
            $findUser->mail = $mail;
            //Appel de la méthode qui vient chercher l'utilisateur
            if ($findUser->findUserByEmail()) {
                $userFound = $findUser->findUserByEmail();
                $mailSender = 'mermaid@hotmail.fr';
                /**
                 * Création de l'email !!
                 */
                //Condition qui sert à gérer la norme des sauts de lignes des serveurs qui recoivent les e-mails
                if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
                    $passage_ligne = "\r\n";
                } else {

                    $passage_ligne = "\n";
                }
                //Création du contenu du message en version texte
                $message_txt = 'Vous avez lancé un mail de récupération de l\'identifiant de votre compte' . $passage_ligne;
                $message_txt .= 'identifiant: ' . $userFound->pseudo . ' ' . $passage_ligne;
                $message_txt .= 'En vous souhaitant une excellente visite lors de votre prochaine connexion !' . $passage_ligne;
                $message_txt .= 'Cordialement, ' . $passage_ligne;
                $message_txt .= 'L\'équipe Mermaid ! ' . $passage_ligne;
                //Création du contenu du message en version html
                $message_html = '<html><head></head><body><h1>Récupération de votre identifiant</h2>'
                        . '<p style="text-align:center">Vous avez lancé un mail de récupération de l\'identifiant de votre compte.<br />'
                        . '<span style="font-weight:bold">identifiant: ' . $userFound->pseudo . '.</span><br />'
                        . 'En vous souhaitant une excellente visite lors de votre prochaine connexion !</p>'
                        . '<p>Cordialement, <br />'
                        . 'L\'équipe Mermaid !</p></body></html>';
                //Création du boundary
                $boundary = "-----=" . md5(rand());
                //Création du sujet
                $subject = 'MERMAID : Récupération de votre identifiant';
                //Création du header de mon mail
                $header = "From: \"Mermaid\"<mermaid@hotmail.fr>" . $passage_ligne;
                $header .= "Reply-to: \"Mermaid\" <mermaid@hotmail.fr>" . $passage_ligne;
                $header .= "MIME-Version: 1.0" . $passage_ligne;
                /**
                 * J'ai choisi d'utiliser ce content type car je souhaite envoyer mon mail en mode texte et html
                 */
                $header .= "Content-Type: multipart/mixed;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
                //Création du message
                $messageToSend = $passage_ligne . "--" . $boundary . $passage_ligne;
                $messageToSend .= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
                $messageToSend .= $passage_ligne . "--" . $boundary . $passage_ligne;
                //Ajout du message au format texte
                $messageToSend .= "Content-Type: text/plain; charset=\"utf8\"" . $passage_ligne;
                $messageToSend .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
                $messageToSend .= $passage_ligne . $message_txt . $passage_ligne;
                //==============================
                $messageToSend .= $passage_ligne . "--" . $boundary . $passage_ligne;
                //Ajout du message au format html
                $messageToSend .= "Content-Type: text/html; charset=\"utf8\"" . $passage_ligne;
                $messageToSend .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
                $messageToSend .= $passage_ligne . $message_html . $passage_ligne;
                $messageToSend .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
                //Condition de l'envoi de l'email
                if (mail($mail, $subject, $messageToSend, $header)) {
                    $success['submitUserSearch'] = 'Envoi réussi ! Rendez-vous dans votre boite mail pour récupérer votre identifiant !';
                } else {
                    $errorList['submitUserSearch'] = 'L\'envoi du mail a échoué';
                }
            } else {
                $errorList['submitUserSearch'] = 'La recher de l\'utilisateur a échoué';
            }
        } else {
            $errorList['submitUserSearch'] = 'Cette adresse de messagerie ne correspond à aucun compte existant !';
        }
    } else {
        //...Sinon erreur de rentrée de valeur du champs
        $errorList['submitUserSearch'] = 'Veuillez entrer une adresse de messagerie';
    }
}
//============================================================Gestion de l'oubli de mot de passe===========================================
if (isset($_POST['submitPassChange'])) {
    if (!empty($_POST['submitPassChange'])) {
        //...On instancie l'objet user, avec une methode permettant de voir si l'adresse existe dans la base de donnée
        $email = NEW users();
        //On donne la valeur du champ à une variable $mail
        $mail = $_POST['email'];
        //...On donne à l'attribut de l'objet user la valeur du champs rentré
        $email->mail = $mail;
        //On utilise la méthode notSameEmail(), cette fois dans le but de vérifier si l'adresse email existe bien dans la base de donnée
        $check = $email->notSameEmail();
        //Si l'adresse existe en base de donnée
        if ($check == 1) {
            //...On instancie l'objet users, avec une methode servant à retrouver l'identifiant de l'utilisateur suivant l'adresse mail qu'il a rentré
            $findId = NEW users();
            //On attribue a valeur de la variable $mail à l'attribut de l'objet "mail"
            $findId->mail = $mail;
            if ($findId->findUserByEmail()) {
                $idFound = $findId->findUserByEmail();
                $mailSender = 'mermaid@hotmail.fr';
                /**
                 * Création de l'email !!
                 */
                //Condition qui sert à gérer la norme des sauts de lignes des serveurs qui recoivent les e-mails
                if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
                    $passage_ligne = "\r\n";
                } else {
                    $passage_ligne = "\n";
                }
                //Création du contenu du message en version texte
                $message_txt = 'Vous avez demandé un mail de modification de mot de passe.' . $passage_ligne;
                $message_txt .= 'Nous vous invitons à vous rendre à cette adresse afin de changer votre mot de passe:' . $passage_ligne;
                $message_txt .= '<a href="http://mermaid/forget.php?forget=changePass&id=' . $idFound->id . '&mail=' . $idfound->mail . '">Changement de mot de passe</a>' . $passage_ligne;
                $message_txt .= 'En vous souhaitant une excellente visite lors de votre prochaine connexion !' . $passage_ligne;
                $message_txt .= 'Cordialement, ' . $passage_ligne;
                $message_txt .= 'L\'équipe Mermaid ! ' . $passage_ligne;
                //Création du contenu du message en version html
                $message_html = '<html><head></head><body><h1>Changement de votre mot de passe</h1>'
                        . '<p style="text-align:center">Vous avez demandé un mail de modification de mot de passe.<br />'
                        . 'Nous vous invitons à vous rendre à cette adresse afin de changer votre mot de passe:<br />'
                        . '<a href="http://mermaid/forget.php?forget=changePass&id=' . $idFound->id . '">Changement de mot de passe</a><br />'
                        . 'En vous souhaitant une excellente visite lors de votre prochaine connexion !</p>'
                        . '<p>Cordialement, <br />'
                        . 'L\'équipe Mermaid !</p></body></html>';
                //Création du boundary
                $boundary = "-----=" . md5(rand());
                //Création du sujet
                $subject = 'MERMAID : Récupération de votre identifiant';
                //Création du header de mon mail
                $header = "From: \"Mermaid\"<mermaid@hotmail.fr>" . $passage_ligne;
                $header .= "Reply-to: \"Mermaid\" <mermaid@hotmail.fr>" . $passage_ligne;
                $header .= "MIME-Version: 1.0" . $passage_ligne;
                /**
                 * J'ai choisi d'utiliser ce content type car je souhaite envoyer mon mail en mode texte et html
                 */
                $header .= "Content-Type: multipart/mixed;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
                //Création du message
                $messageToSend = $passage_ligne . "--" . $boundary . $passage_ligne;
                $messageToSend .= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;
                $messageToSend .= $passage_ligne . "--" . $boundary . $passage_ligne;
                //Ajout du message au format texte
                $messageToSend .= "Content-Type: text/plain; charset=\"utf8\"" . $passage_ligne;
                $messageToSend .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
                $messageToSend .= $passage_ligne . $message_txt . $passage_ligne;
                //==============================
                $messageToSend .= $passage_ligne . "--" . $boundary . $passage_ligne;
                //Ajout du message au format html
                $messageToSend .= "Content-Type: text/html; charset=\"utf8\"" . $passage_ligne;
                $messageToSend .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
                $messageToSend .= $passage_ligne . $message_html . $passage_ligne;
                $messageToSend .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
                //Condition de l'envoi de l'email
                if (mail($mail, $subject, $messageToSend, $header)) {
                    $success['submitPassChange'] = 'Envoi réussi ! Rendez-vous dans votre boite mail pour modifier votre mot de passe !';
                } else {
                    $errorList['submitPassChange'] = 'L\'envoi du mail a échoué';
                }
            } else {
                $errorList['submitPassChange'] = 'La recherche de l\'utilisateur a échoué';
            }
        } else {
            $errorList['submitPassChange'] = 'Cette adresse de messagerie ne correspond à aucun compte existant !';
        }
    } else {
        $errorList['submitPassChange'] = 'Veuillez renseigner votre adresse de messagerie';
    }
}