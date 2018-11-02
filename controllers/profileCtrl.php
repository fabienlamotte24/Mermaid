<?php
//===================================================================Changement de la présentation utilisateur================
//Pas de regex pour la présentation.
//Initialisation de la valeur
    $present = '';
//Si on appuie sur le boutton de validation de la présentation
    if (isset($_POST['changePresentation'])) {
//...Et que le champs n'est pas vide
        if (!empty($_POST['presentation'])) {
//...On instancie l'objet users, pour effectuer la méthode de changement de présentation
            $presentSentence = NEW users();
//...On donne à l'attribut de l'objet "id" la variable de session "id"
            $presentSentence->id = $_SESSION['id'];
//...On stock la valeur du champs dans la variable $present
            $present = htmlspecialchars($_POST['presentation']);
//...On donne à l'attribut de l'objet "presentation" la variable contenant la valeur stockée du champ presentationn
            $presentSentence->presentation = $present;
//Si la requête aboutie
            if ($presentSentence->changePresentation()) {
//...On change la variable de session par la valeur stockée dans la variable $present
                $_SESSION['presentation'] = $present;
            }
        } else {
//...Sinon erreur d'entrée de valeur
            $errorList['presentation'] = 'votre présentation est vide !';
        }
    }