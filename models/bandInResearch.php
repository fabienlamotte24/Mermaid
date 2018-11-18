<?php
class bandInResearch extends database {
    public $id;
    public $research;
    public $id_15968k4_band;
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
     * Méthode servant au compte d'annonce créé par le groupe de musique de l'utilisateur
     */
    public function countAnnounce(){
        $bool = FALSE;
        $query = 'SELECT COUNT(`id`) AS `count` FROM `15968k4_bandInResearch` '
                . 'WHERE `id_15968k4_band` = :id_15968k4_band';
        $check = $this->db->prepare($query);
        $check->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        if($check->execute()){
            $result = $check->fetch(PDO::FETCH_OBJ);
            $bool = $result->count;
        }
        return $bool;
    }
    /**
     * Méthode servant à l'ajout d'une annonce pour un musicien
     */
    public function addResearch() {
        $query = 'INSERT INTO `15968k4_bandInResearch`(`research`, `id_15968k4_band`, `dateCreation`, `dateExpiration`) '
                . 'VALUES(:research, :id_15968k4_band, :dateCreation, :dateExpiration)';
        $result = $this->db->prepare($query);
        $result->bindValue(':research', $this->research, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        $result->bindValue(':dateCreation', $this->dateCreation, PDO::PARAM_STR);
        $result->bindValue(':dateExpiration', $this->dateExpiration, PDO::PARAM_STR);
        return $result->execute();
    }
    /**
     * Méthode pour supprimer l'annonce
     */
    public function removeResearch() {
        $query = 'DELETE FROM `15968k4_bandInResearch` '
                . 'WHERE `id_15968k4_band` = :id_15968k4_band';
        $result = $this->db->prepare($query);
        $result->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        return $result->execute();
    }
    /**
     * Méthode servant au changement de la recherche de l'annonce 
     */
    public function changeAnnounce() {
        $query = 'UPDATE `15968k4_bandInResearch` '
                . 'SET `research` = :research, '
                . '`dateCreation` = :dateCreation, '
                . '`dateExpiration` = :dateExpiration '
                . 'WHERE `id_15968k4_band` = :id_15968k4_band';
        $result = $this->db->prepare($query);
        $result->bindValue(':research', $this->research, PDO::PARAM_STR);
        $result->bindValue(':dateCreation', $this->dateCreation, PDO::PARAM_STR);
        $result->bindValue(':dateExpiration', $this->dateExpiration, PDO::PARAM_STR);
        $result->bindValue(':id_15968k4_band', $this->id_15968k4_band, PDO::PARAM_INT);
        return $result->execute();
    }
}

