<?php

class establishmentInResearch extends database {

    //Liste des attributs
    public $id;
    public $research;
    public $id_15968k4_establishment;
    public $dateCreation;
    public $dateExpiration;

    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }

    /**
     * Méthode servant à connaître le status de l'établissement (0 = Pas en recherche / 1 En recherche)
     */
    public function establishmentStatus() {
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_establishmentInResearch` '
                . 'WHERE `id_15968k4_establishment` = :id_15968k4_establishment';
        $check = $this->db->prepare($query);
        $check->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        if ($check->execute()) {
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        } else {
            $bool = FALSE;
        }
        return $bool;
    }

    /**
     * Méthode servant à l'ajout d'une annonce pour une entreprise
     */
    public function addResearch() {
        $query = 'INSERT INTO `15968k4_establishmentInResearch`(`research`, `id_15968k4_establishment`, `dateCreation`, `dateExpiration`) '
                . 'VALUES(:research, :id_15968k4_establishment, :dateCreation, :dateExpiration)';
        $result = $this->db->prepare($query);
        $result->bindValue(':research', $this->research, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        $result->bindValue(':dateCreation', $this->dateCreation, PDO::PARAM_STR);
        $result->bindValue(':dateExpiration', $this->dateExpiration, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Méthode pour supprimer l'annonce
     */
    public function removeResearch() {
        $query = 'DELETE FROM `15968k4_establishmentInResearch` '
                . 'WHERE `id_15968k4_establishment` = :id_15968k4_establishment';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Méthode servant au changement de la recherche de l'annonce 
     */
    public function changeAnnounce() {
        $query = 'UPDATE `15968k4_establishmentInResearch` '
                . 'SET `research` = :research, '
                . '`dateCreation` = :dateCreation, '
                . '`dateExpiration` = :dateExpiration '
                . 'WHERE `id_15968k4_establishment` = :id_15968k4_establishment';
        $result = $this->db->prepare($query);
        $result->bindValue(':research', $this->research, PDO::PARAM_STR);
        $result->bindValue(':dateCreation', $this->dateCreation, PDO::PARAM_STR);
        $result->bindValue(':dateExpiration', $this->dateExpiration, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_establishment', $this->id_15968k4_establishment, PDO::PARAM_INT);
        return $result->execute();
    }

}
