<?php
/**
 * Création de la classe 123U_sers
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
    public function connexion(){
        $state = FALSE;
        $query = 'SELECT `id`, `pseudo`, `password`,`mail`, `lastname`, `firstname`, `phoneNumber`, `birthDate`, `address`, `presentation`, `id_15968k4_type`, `id_15968k4_cities` FROM `15968k4_users` WHERE `pseudo` = :pseudo';        
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
                $this->presentation = $selectResult->presentation;
                $this->idType = $selectResult->idType;
                $this->idCities = $selectResult->idCities;
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
        $query = 'INSERT INTO `15968k4_users`(`pseudo`, `password`, `mail`, `lastname`, `firstname`, `phoneNumber`, `birthDate`, `address`, `presentation`, `id_15968k4_Type`, `id_15968k4_Cities`) '
                . 'VALUES(:pseudo, :password, :mail, :lastname, :firstname, :phoneNumber, :birthDate, :address, :presentation, :id_15968k4_Type, :id_15968k4_Cities)';
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
        $addUser->bindValue(':presentation', $this->presentation, PDO::PARAM_STR);
        $addUser->bindValue(':id_15968k4_Type', $this->idType, PDO::PARAM_INT);
        $addUser->bindValue(':id_15968k4_Cities', $this->idCities, PDO::PARAM_INT);
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
        $query = 'SELECT COUNT(`mail`) AS `count` FROM `15968k4_users` WHERE `mail` = :mail';
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
     * Création de la méthode magique destructeur
     */
    public function __destruct() {
        ;
    }

}

?>
