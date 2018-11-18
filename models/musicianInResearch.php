<?php

class musicianInResearch extends database {
    public $id;
    public $research;
    public $id_15968k4_users;
    public $dateCreation;
    public $dateExpiration;
    /**
     * Méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    /**
     * Vérification du statut du musicien
     */
    public function status(){
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_musicianInResearch` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if($result->execute()){
            $check = $result->fetch(PDO::FETCH_OBJ);
            $bool = $check->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à l'ajout d'une annonce pour un musicien
     */
    public function addResearch(){
        $query = 'INSERT INTO `15968k4_musicianInResearch`(`research`, `id_15968k4_users`, `dateCreation`, `dateExpiration`) '
                . 'VALUES(:research, :id_15968k4_users, :dateCreation, :dateExpiration)';
        $result = $this->db->prepare($query);
        $result->bindValue(':research', $this->research, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $result->bindValue(':dateCreation', $this->dateCreation, PDO::PARAM_STR);
        $result->bindValue(':dateExpiration', $this->dateExpiration, PDO::PARAM_STR);
        return $result->execute();
    }
    /**
     * Méthode servant à afficher la date d'expiration
     */
    public function expiration(){ 
        $query = 'SELECT `dateExpiration` FROM `15968k4_musicianInResearch` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode servant à afficher toutes les informations
     */
    public function content(){ 
        $query = 'SELECT `dateExpiration`, `dateCreation`, `id_15968k4_users`, `research` FROM `15968k4_musicianInResearch` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        if ($result->execute()) {
            if (is_object($result)) {
                $isObject = $result->fetch(PDO::FETCH_OBJ);
            }
        }
        return $isObject;
    }
    /**
     * Méthode pour supprimer l'annonce
     */
    public function removeResearch(){
        $query = 'DELETE FROM `15968k4_musicianInResearch` '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode de modification de research
     */
    public function changeAnnounce(){
        $query = 'UPDATE `15968k4_musicianInResearch` '
                . 'SET `research` = :research,'
                . '`dateCreation` = :dateCreation,'
                . '`dateExpiration` = :dateExpiration '
                . 'WHERE `id_15968k4_users` = :id_15968k4_users';
        $result = $this->db->prepare($query);
        $result->bindValue(':research', $this->research, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_users', $this->id_15968k4_users, PDO::PARAM_INT);
        $result->bindValue(':dateCreation', $this->dateCreation, PDO::PARAM_STR);
        $result->bindValue(':dateExpiration', $this->dateExpiration, PDO::PARAM_STR);
        return $result->execute();
    }
}
