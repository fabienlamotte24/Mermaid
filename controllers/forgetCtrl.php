<?php
//Listing des tableaux destinées aux erreurs et validation de formulaire
$errorList = array();
$success = array();
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
                        . '<b">identifiant: ' . $userFound->pseudo . '.</b><br />'
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
function Genere_Password($size) {
    // Initialisation des caractères utilisables
    $password = 0;
    $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

    for ($i = 0; $i < $size; $i++) {
        $password .= ($i % 2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
    }

    return $password;
}

if (isset($_POST['submitPassChange'])) {
    if (!empty($_POST['submitPassChange'])) {
        //On instancie l'objet users, avec pour méthode la vérification que l'adresse existe
        $email = NEW users();
        $mail = $_POST['email'];
        $email->mail = $mail;
        $check = $email->notSameEmail();
        //Si elle existe bel et bien
        if ($check == 1) {
            //On instancie l'objet user, avec pour méthode la recherche d'information sur l'utilisateur du mail renseigné
            $findId = NEW users();
            $findId->mail = $mail;
            //Si la requête aboutie
            if ($findId->findUserByEmail()) {
                //On crée l'objet $idFound, pour exploiter le tableau créée de cette manière
                $idFound = $findId->findUserByEmail();
                //Je crée un mot de passe généré aléatoirement
                $newPassword = Genere_Password(15);
                //On instancie maintenant l'objet users, avec pour méthode le changement du mot de passe                
                $changePass = NEW users();
                $changePass->id = intval($idFound->id);
                $changePass->password = password_hash($newPassword, PASSWORD_DEFAULT);
                //Si le mot de passe est correctement changé
                if ($changePass->changePass()) {

                    $mailSender = 'mermaid@hotmail.fr';
                    /**
                     * Création de l'email !!
                     */
                    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
                        $passage_ligne = "\r\n";
                    } else {
                        $passage_ligne = "\n";
                    }
                    //Création du contenu du message en version texte
                    $message_txt = 'Vous avez demandé un mail de modification de mot de passe.' . $passage_ligne;
                    $message_txt = 'Voici donc un nouveau mot de passe spécialement généré pour vous:' . $passage_ligne;
                    $message_txt = ' ' . $newPassword . ' ' . $passage_ligne;
                    $message_txt .= 'En vous souhaitant une excellente visite lors de votre prochaine connexion !' . $passage_ligne;
                    $message_txt .= 'Cordialement, ' . $passage_ligne;
                    $message_txt .= 'L\'équipe Mermaid ! ' . $passage_ligne;
                    //Création du contenu du message en version html
                    $message_html = '<html><head></head><body><h1>Changement de votre mot de passe</h1>'
                            . '<p style="text-align:center">Vous avez demandé un mail de modification de mot de passe.<br />'
                            . 'Voici donc un nouveau mot de passe spécialement généré pour vous:<br /><b>' . $newPassword . '</b> ' . $passage_ligne .'.<br />'
                            . 'Connectez-vous maintenant pour modifier à nouveau votre mot de passe !</p>'
                            . '<p>Cordialement, <br />'
                            . 'L\'équipe Mermaid !</p></body></html>';
                    //Création du boundary
                    $boundary = "-----=" . md5(rand());
                    //Création du sujet
                    $subject = 'MERMAID : Récupération de votre mot de passe';
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
                    //si l'envoi de l'email passe
                    if (mail($mail, $subject, $messageToSend, $header)) {
                        //On affiche un message de validation d'envoi du mail
                        $success['submitPassChange'] = 'Envoi réussi ! Rendez-vous dans votre boite mail pour modifier votre mot de passe !';
                    } else {
                        $errorList['submitPassChange'] = 'L\'envoi du mail a échoué';
                    }
                } else {
                    $errorList[''] = 'Erreur dans le changement du mot de passe !';
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