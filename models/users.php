<?php

/**
 * Création de la classe users
 */
class users extends database {

    //Listing des attributs de la classe
    public $id;
    public $pseudo;
    public $password;
    public $mail;
    public $lastname;
    public $firstname;
    public $phoneNumber;
    public $birthDate;
    public $address;
    public $presentation;
    public $idType;
    public $idCities;
    public $profilPicture;

    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }

    /**
     * Méthode permettant la connexion de l'utilisateur
     */
    public function userConnexion() {
        $state = FALSE;
        $query = 'SELECT `us`.`id`, `us`.`pseudo`, `us`.`password`, `us`.`mail`, `us`.`lastname`, `us`.`firstname`, `us`.`phoneNumber`, DATE_FORMAT(`us`.`birthDate`, \'%m-%d-%Y\') AS `birthDate`, `us`.`address`, `us`.`id_15968k4_type`, `us`.`id_15968k4_cities`, `us`.`profilPicture`, `ci`.city, `ci`.`postalCode` '
                . 'FROM `15968k4_users` AS `us` '
                . 'LEFT JOIN `15968k4_cities` AS `ci` '
                . 'ON `us`.`id_15968k4_cities` = `ci`.`id` '
                . 'WHERE `us`.`pseudo` = :pseudo ';
        $result = $this->db->prepare($query);
        $result->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        if ($result->execute()) { //On vérifie que la requête s'est bien exécutée
            $selectResult = $result->fetch(PDO::FETCH_OBJ);
            if (is_object($selectResult)) { //On vérifie que l'on a bien trouvé un utilisateur
                // On hydrate
                $this->id = $selectResult->id;
                $this->pseudo = $selectResult->pseudo;
                $this->password = $selectResult->password;
                $this->mail = $selectResult->mail;
                $this->lastname = $selectResult->lastname;
                $this->firstname = $selectResult->firstname;
                $this->phoneNumber = $selectResult->phoneNumber;
                $this->birthDate = $selectResult->birthDate;
                $this->address = $selectResult->address;
                $this->idType = $selectResult->id_15968k4_type;
                $this->idCities = $selectResult->id_15968k4_cities;
                $this->city = $selectResult->city;
                $this->postalCode = $selectResult->postalCode;
                $this->profilPicture = $selectResult->profilPicture;
                $state = true;
            }
        }
        return $state;
    }

    /**
     * Méthode qui sert à inscrire les utilisateurs
     */
    public function addUser() {
        //Mise en forme de la requête
        $query = 'INSERT INTO `15968k4_users`(`pseudo`, `password`, `mail`, `lastname`, `firstname`, `phoneNumber`, `birthDate`, `address`, `id_15968k4_Type`, `id_15968k4_Cities`, `profilPicture`) '
                . 'VALUES(:pseudo, :password, :mail, :lastname, :firstname, :phoneNumber, :birthDate, :address, :id_15968k4_Type, :id_15968k4_Cities, :profilPicture)';
        //Préparation de la requête
        $addUser = $this->db->prepare($query);
        //Listing des marqueurs nominatifs pour récupérer les valeurs
        $addUser->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        $addUser->bindValue(':password', $this->password, PDO::PARAM_STR);
        $addUser->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $addUser->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $addUser->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $addUser->bindValue(':phoneNumber', $this->phoneNumber, PDO::PARAM_STR);
        $addUser->bindValue(':birthDate', $this->birthDate, PDO::PARAM_STR);
        $addUser->bindValue(':address', $this->address, PDO::PARAM_STR);
        $addUser->bindValue(':id_15968k4_Type', $this->idType, PDO::PARAM_INT);
        $addUser->bindValue(':id_15968k4_Cities', $this->idCities, PDO::PARAM_INT);
        $addUser->bindValue(':profilPicture', $this->profilPicture, PDO::PARAM_STR);
        //Lancement de la requête préparée
        return $addUser->execute();
    }

    /**
     * Méthode qui sert à indiquer un message d'erreur lors de doublon de pseudo
     */
    public function notSamePseudo() {
        $bool = FALSE;
        //Mise en forme de la requête
        $query = 'SELECT COUNT(`pseudo`) AS `count` FROM `15968k4_users` WHERE `pseudo` = :pseudo';
        //Préparation de la requête
        $check = $this->db->prepare($query);
        //On prépare un marqueur nominatif qui capturera l'entrée du champ
        $check->bindValue(':pseudo', $this->pseudo, PDO::PARAM_STR);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }

    /**
     * Méthode qui sert à gérer les doublons d'adresse de messagerie
     */
    public function notSameEmail() {
        //Mise en forme de la requête
        $query = 'SELECT COUNT(`mail`) AS `count` FROM `15968k4_users` '
                . 'WHERE `mail` = :mail';
        //Intégration de la requête dans une préparation 
        $check = $this->db->prepare($query);
        //On prépare un marqueur nominatif qui capturera l'entrée du champ
        $check->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        } else {
            $bool = FALSE;
        }
        return $bool;
    }

    /**
     * Méthode servant à la modification du mot de passe
     */
    public function changePass() {
        $query = 'UPDATE `15968k4_users`
                  SET `password` = :password
                  WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':password', $this->password, PDO::PARAM_STR);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode servant au changement des informations du compte
     */
    public function changeContentsOfAccount(){
        $query = 'UPDATE `15968k4_users` '
                . 'SET `mail` = :mail, '
                . '`phoneNumber` = :phoneNumber, '
                . '`address` = :address, '
                . '`id_15968k4_Cities` = :id_15968k4_Cities '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $result->bindValue(':phoneNumber', $this->phoneNumber, PDO::PARAM_STR);
        $result->bindValue(':address', $this->address, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_Cities', $this->id_15968k4_Cities, PDO::PARAM_INT);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Méthode servant à afficher les informations de l'utilisateur
     */
    public function showCompleteUserContent() {
        $query = 'SELECT `us`.`id`, `us`.`pseudo`, `us`.`password`, `us`.`mail`, `us`.`lastname`, `us`.`firstname`, `us`.`phoneNumber`, DATE_FORMAT(`us`.`birthDate`, \'%m-%d-%Y\') AS `birthDate`, `us`.`address`, `us`.`id_15968k4_type`, `us`.`id_15968k4_cities`,`us`.`profilPicture`, `ci`.city, `ci`.`postalCode` '
                . 'FROM `15968k4_users` AS `us` '
                . 'LEFT JOIN `15968k4_cities` AS `ci` '
                . 'ON `us`.`id_15968k4_cities` = `ci`.`id` '
                . 'WHERE `us`.`id` = :id ';
        $getAllDetails = $this->db->prepare($query);
        $getAllDetails->bindValue(':id', $this->id, PDO::PARAM_INT);
        if ($getAllDetails->execute()) {
            if (is_object($getAllDetails)) {
                $result = $getAllDetails->fetch(PDO::FETCH_OBJ);
            }
        }
        return $result;
    }
    /**
     * Méthode servant à lister toutes les entreprises
     */
    public function showAllMusicians() {
        $query = "SELECT `us`.`id`, `us`.`pseudo`, `us`.`presentation`, `us`.`profilPicture`, `us`.`address`, `ci`.`postalCode`, `ci`.`city` "
                . "FROM `15968k4_users` AS `us` "
                . "INNER JOIN `15968k4_cities` AS `ci`"
                . "ON `us`.`id_15968k4_cities` = `ci`.`id`"
                . "WHERE `us`.`id_15968k4_Type` = 3";
        $showAll = $this->db->query($query);
        if ($showAll->execute()) {
            if (is_object($showAll)) {
                $isObject = $showAll->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à la suppression de compte
     */
    public function removeUser(){
        $query = 'DELETE FROM `15968k4_users` '
                . 'WHERE `id` = :id';
        $remove = $this->db->prepare($query);
        $remove->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $remove->execute();
    }
    /**
     * Méthode servant à retrouver l'identifiant de l'utilisateur à partir de son email
     */
    public function findUserByEmail(){
        $query = 'SELECT `id`, `pseudo` FROM `15968k4_users` '
                . 'WHERE `mail` = :mail';
        $findUser = $this->db->prepare($query);
        $findUser->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $findUser->execute();
        if(is_object($findUser)){
            $isObjectResult = $findUser->fetch(PDO::FETCH_OBJ);
        }
        return $isObjectResult;
    }
    /**
     * Méthode servant à l'ajout d'une photo de profil
     */
    public function newProfilePicture(){
        $query = 'UPDATE `15968k4_users` '
                . 'SET `profilPicture` = :profilPicture '
                . 'WHERE `id` = :id';
        $newProfilePicture = $this->db->prepare($query);
        $newProfilePicture->bindValue(':profilPicture', $this->profilPicture, PDO::PARAM_STR);
        $newProfilePicture->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $newProfilePicture->execute();
    }
    /**
     * Vérification du mot de passe
     */
    public function isCorrectPass(){
        $query = 'SELECT `password` FROM `15968k4_users` '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        $result->execute();
        if(is_object($result)){
            $isObjectResult = $result->fetch(PDO::FETCH_OBJ);
        }
        return $isObjectResult;
    }
    /**
     * Création de la méthode magique destructeur
     */
    public function __destruct() {
        ;
    }
    
}
?>

