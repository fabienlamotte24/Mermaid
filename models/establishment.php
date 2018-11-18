<?php

/**
 * Création de la classe members
 */
class establishment extends database {

    public $id;
    public $companyName;
    public $siretNumber;
    public $id_15968k4_users;
    public $companyPicture;
    public $addressCompany;
    public $postalCode;
    public $city;

    /**
     * Méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }

    /**
     * méthode de création d'une entreprise
     */
    public function addCompany() {
        $query = 'INSERT INTO `15968k4_establishment`(`companyName`, `siretNumber`, `id_15968k4_users`, `companyPicture`, `addressCompany`, `postalCode`, `city`) '
                . 'VALUES (:companyName, :siretNumber, :id_15968k4_users, :companyPicture, :addressCompany, :postalCode, :city)';
        $addCompany = $this->db->prepare($query);
        $addCompany->bindValue(':companyName', $this->companyName, PDO::PARAM_STR);
        $addCompany->bindValue(':siretNumber', $this->siretNumber, PDO::PARAM_STR);
        $addCompany->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $addCompany->bindValue(':companyPicture', $this->companyPicture, PDO::PARAM_STR);
        $addCompany->bindValue(':addressCompany', $this->addressCompany, PDO::PARAM_STR);
        $addCompany->bindValue(':postalCode', $this->postalCode, PDO::PARAM_STR);
        $addCompany->bindValue(':city', $this->city, PDO::PARAM_STR);
        return $addCompany->execute();
    }

    /**
     * Méthode de vérification de l'existence d'une entreprise
     */
    public function isGetCompany() {
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $check = $this->db->prepare($query);
        $check->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        } else {
            $bool = FALSE;
        }
        return $bool;
    }

    /**
     * Méthode servant à savoir si le numéro de siret est déjà utilisé
     */
    public function countSiret() {
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_establishment` '
                . 'WHERE `siretNumber` = :siret';
        $check = $this->db->prepare($query);
        $check->bindValue(':siret', $this->siretNumber, PDO::PARAM_STR);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        } else {
            $bool = FALSE;
        }
        return $bool;
    }

    /**
     * Changement du nom de l'entreprise
     */
    public function changeNameCompany() {
        $query = 'UPDATE `15968k4_establishment` '
                . 'SET `companyName` = :companyName '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $changeName = $this->db->prepare($query);
        $changeName->bindValue(':companyName', $this->companyName, PDO::PARAM_STR);
        $changeName->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $changeName->execute();
    }

    /**
     * Changement de la photo de profil
     */
    public function changePhoto() {
        $query = 'UPDATE `15968k4_establishment` '
                . 'SET `companyPicture` = :companyPicture '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $ChangePhoto = $this->db->prepare($query);
        $ChangePhoto->bindValue(':companyPicture', $this->companyPicture, PDO::PARAM_STR);
        $ChangePhoto->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $ChangePhoto->execute();
    }

    /**
     * Suppression du compte-entreprise
     */
    public function removeCompany() {
        $query = 'DELETE FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $RemoveCompany = $this->db->prepare($query);
        $RemoveCompany->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $RemoveCompany->execute();
    }

    /**
     * Recherche de l'id du compte entreprise
     */
    public function searchId() {
        $query = 'SELECT `id` FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $searchId = $this->db->prepare($query);
        $searchId->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($searchId->execute()) {
            if (is_object($searchId)) {
                $isObject = $searchId->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }

    /**
     * Méthode servant à lister les entreprises de l'utilisateur
     */
    public function showMyCompany() {
        $query = 'SELECT `es`.`id`, `es`.`companyName`, `es`.`siretNumber`, `es`.`id_15968k4_users`, `es`.`companyPicture`, `es`.`addressCompany`, `es`.`postalCode`, `es`.`city`, `res`.`research`
                FROM `15968k4_establishment` AS `es` 
                LEFT JOIN `15968k4_establishmentInResearch` AS `res`
                ON `es`.`id` = `res`.`id_15968k4_establishment`
                WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }

    /**
     * Méthode servant à lister toutes les entreprises
     */
    public function showAllCompany() {
        $query = "SELECT `id`, `companyName`, `siretNumber`, `id_15968k4_users`, `companyPicture`, `addressCompany`, `postalCode`, `city` "
                . "FROM `15968k4_establishment`";
        $showAll = $this->db->query($query);
        if ($showAll->execute()) {
            if (is_object($showAll)) {
                $isObject = $showAll->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }

    /*
     * Méthode servant à lister les informations en fonction de l'url donné
     */

    public function showEstablishmentByUrl() {
        $query = 'SELECT `es`.`id`, `es`.`companyName`, `es`.`siretNumber`, `es`.`id_15968k4_users`, `es`.`companyPicture`, `es`.`addressCompany`, `es`.`postalCode`, `es`.`city`, `res`.`research`, `res`.`dateCreation`, `res`.`dateExpiration`
                FROM `15968k4_establishment` AS `es`
                LEFT JOIN `15968k4_establishmentInResearch` AS `res`
                ON `es`.`id` = `res`.`id_15968k4_establishment`
                WHERE `es`.`id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à lister les id des établissements dont l'utilisateur est le propriétaire
     */
    public function showIdEstablishment(){
        $query = 'SELECT `id` FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetchAll(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à lister les etablissements appartenant à l'utilisateur
     */
    public function myCompaniesId(){
        $query = 'SELECT `id` FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($result->execute()){
            if(is_object($result)){
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode de changement de la photo
     */
    public function changeContent(){
        $query = 'UPDATE `15968k4_establishment` '
                . 'SET `companyPicture` = :companyPicture,'
                . '`companyName` = :companyName, '
                . '`addressCompany` = :addressCompany, '
                . '`postalCode` = :postalCode, '
                . '`city` = :city '
                . 'WHERE `id` = :id';
        $result = $this->db->prepare($query);
        $result->bindValue(':companyPicture', $this->companyPicture, PDO::PARAM_STR);
        $result->bindValue(':companyName', $this->companyName, PDO::PARAM_STR);
        $result->bindValue(':addressCompany', $this->addressCompany, PDO::PARAM_STR);
        $result->bindValue(':postalCode', $this->postalCode, PDO::PARAM_STR);
        $result->bindValue(':city', $this->city, PDO::PARAM_STR);
        $result->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $result->execute();
        
    }
}
