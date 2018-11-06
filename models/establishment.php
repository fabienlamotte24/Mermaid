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
    public function addCompany(){
        $query = 'INSERT INTO `15968k4_establishment`(`id`, `companyName`, `siretNumber`, `id_15968k4_users`, `companyPicture`) '
                . 'VALUES (:id, :companyName, :siretNumber, :id_15968k4_users, :companyPicture)';
        $addCompany = $this->db->prepare($query);
        $addCompany->bindValue(':id', $this->id, PDO::PARAM_INT);
        $addCompany->bindValue(':companyName', $this->companyName, PDO::PARAM_STR);
        $addCompany->bindValue(':siretNumber', $this->siretNumber, PDO::PARAM_STR);
        $addCompany->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $addCompany->bindValue(':companyPicture', $this->companyPicture, PDO::PARAM_STR);
        return $addCompany->execute();
    }
    /**
     * Méthode de vérification de l'existence d'une entreprise
     */
    public function isGetCompany(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $check = $this->db->prepare($query);
        $check->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($check->execute()){
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        } else {
            $bool = FALSE;
        }
        return $bool;
    }
    /**
     * Méthode d'affichage des informations
     */
    public function displayContent(){
        $query = 'SELECT `id`, `companyName`, `siretNumber`, `companyPicture` FROM `15968k4_establishment` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $showInfo = $this->db->prepare($query);
        $showInfo->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($showInfo->execute()){
            if(is_Object($showInfo)){
                $isObject = $showInfo->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Changement du nom de l'entreprise
     */
    public function changeNameCompany(){
        $query = 'UPDATE `15968k4_establishment` '
                . 'SET `companyName` = :companyName '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $changeName = $this->db->prepare($query);
        $changeName->bindValue(':companyName', $this->companyName, PDO::PARAM_STR);
        $changeName->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $changeName->execute();
    }
}
