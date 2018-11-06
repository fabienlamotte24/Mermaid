<?php

/**
 * Création de la classe members
 */
class members extends database {
    public $id;
    public $idBand;
    public $idUser;
    
    /**
     * Création de la méthode magique constructeur
     */
    public function __construct() {
        parent::__construct();
        $this->dbConnect();
    }
    
    /**
     * Méthode servant à l'ajout d'un membre
     */
    public function addMember(){
        $query = 'INSERT INTO `15968k4_members`(`id_15968k4_band`, `id_15968k4_users`) '
                . 'VALUES(:idBand, :idUser)';
        $addMember = $this->db->prepare($query);
        $addMember->bindValue(':idBand', $this->idBand, PDO::PARAM_INT);
        $addMember->bindValue(':idUser', $this->idUser, PDO::PARAM_INT);
        return $addMember->execute();
    }
    /**
     * Méthode servant de complément à la suppression de groupe
     */
    public function groupRemove(){
        $query = 'DELETE FROM `15968k4_members` '
                . 'WHERE `id_15968k4_band` = :id';
        $groupRemove = $this->db->prepare($query);
        $groupRemove->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $groupRemove->execute();
    }
}